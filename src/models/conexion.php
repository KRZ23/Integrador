<?php
class Conexion
{
    private $conn;

    public function __construct()
    {
        $host = "localhost";
        $port = 5432;
        $dbname = "bd_piedradeagua";
        $username = "postgres";
        $password = "pw23112004";

        try {
            $this->conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exp) {
            echo "No se pudo conectar a la base de datos: " . $exp->getMessage();
        }
    }

    // Obtener usuario por correo
    public function getUser($usuario)
    {
        $stmt = $this->conn->prepare("
            SELECT * 
            FROM bd_piedradeagua.usuario 
            WHERE correo_usuario = :usuario
        ");
        $stmt->bindParam(":usuario", $usuario, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna solo un registro
    }

    // Registrar usuario
    public function registerUser($nombre, $apellido, $dni, $correo, $password, $id_rol)
    {
        try {
            $stmt = $this->conn->prepare("
                INSERT INTO bd_piedradeagua.usuario (nombre_usuario, apellido_usuario, dni_usuario, correo_usuario, contrasena_usuario, id_rol) 
                VALUES (:nombre, :apellido, :dni, :correo, :password, :rol)
            ");
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindParam(":apellido", $apellido, PDO::PARAM_STR);
            $stmt->bindParam(":dni", $dni, PDO::PARAM_STR);
            $stmt->bindParam(":correo", $correo, PDO::PARAM_STR);
            $stmt->bindParam(":password", $password, PDO::PARAM_STR);
            $stmt->bindParam(":rol", $id_rol, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return "Usuario registrado con éxito";
            } else {
                return "Error al registrar el usuario";
            }
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function getProductos()
    {
        try {
            // Preparar la consulta SQL
            $stmt = $this->conn->prepare("
                SELECT
                    id_producto, 
                    nombre_producto, 
                    descripcion_producto, 
                    precio_producto, 
                    imagen, 
                    id_categoria 
                FROM bd_piedradeagua.productos
            ");

            // Ejecutar la consulta
            $stmt->execute();

            // Retornar los productos como un array asociativo
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Registrar el error o devolver un array vacío
            error_log("Error en getProductos: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerPedidos()
    {
        try {
            $sql = "
            SELECT 
                pedido.id_pedido,
                pedido.fecha_pedido,
                pedido.estado_material,
                pedido.desc_pedido,
                usuario.nombre_usuario,
                usuario.apellido_usuario,
                usuario.correo_usuario,
                material.id_material,
                material.nombre_material,
                material_pedido.cantidad_pedido
            FROM 
                bd_piedradeagua.pedido
            LEFT JOIN 
                bd_piedradeagua.material_pedido ON pedido.id_pedido = material_pedido.id_pedido
            LEFT JOIN 
                bd_piedradeagua.material ON material_pedido.id_material = material.id_material
            LEFT JOIN 
                bd_piedradeagua.usuario ON pedido.id_usuario = usuario.id_usuario
        ";

            // Usamos $this->conn para la conexión
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            // Devolvemos los resultados como un array asociativo
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Captura de errores
            error_log("Error al obtener pedidos: " . $e->getMessage());
            throw new Exception("Error al obtener pedidos");
        }
    }

    public function actualizarEstadoPedido($idPedido, $nuevoEstado)
    {
        try {
            $sql = "
            UPDATE bd_piedradeagua.pedido
            SET estado_material = :estado
            WHERE id_pedido = :id_pedido
        ";

            // Usamos $this->conn para la conexión
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':estado', $nuevoEstado, PDO::PARAM_STR);
            $stmt->bindParam(':id_pedido', $idPedido, PDO::PARAM_INT);

            // Ejecutamos la consulta y retornamos si se afectaron filas
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            // Captura de errores
            error_log("Error al actualizar el estado del pedido: " . $e->getMessage());
            throw new Exception("Error al actualizar el estado del pedido");
        }
    }

    public function AgregarPedidoConMaterial($id_usuario, $estado_material, $descripcion, $id_material, $cantidad_pedido)
    {
        try {
            // Inicia una transacción
            $this->conn->beginTransaction();
    
            // Consulta con cláusula WITH
            $sql = "
                WITH nuevo_pedido AS (
                    INSERT INTO bd_piedradeagua.pedido (
                        id_usuario, 
                        fecha_pedido, 
                        estado_material, 
                        desc_pedido
                    ) VALUES (
                        :id_usuario, 
                        NOW(), 
                        :estado_material, 
                        :descripcion
                    )
                    RETURNING id_pedido
                )
                INSERT INTO bd_piedradeagua.material_pedido (
                    id_material, 
                    id_pedido, 
                    cantidad_pedido
                )
                VALUES (
                    :id_material, 
                    (SELECT id_pedido FROM nuevo_pedido), 
                    :cantidad_pedido
                );
            ";
    
            // Prepara la consulta
            $stmt = $this->conn->prepare($sql);
    
            // Enlaza los parámetros
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->bindParam(':estado_material', $estado_material, PDO::PARAM_STR);
            $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
            $stmt->bindParam(':id_material', $id_material, PDO::PARAM_INT);
            $stmt->bindParam(':cantidad_pedido', $cantidad_pedido, PDO::PARAM_INT);
    
            // Ejecuta la consulta
            $stmt->execute();
    
            // Confirma la transacción
            $this->conn->commit();
    
            return true; // Operación exitosa
        } catch (PDOException $e) {
            // En caso de error, deshace la transacción
            $this->conn->rollBack();
            echo "Error: " . $e->getMessage();
            return false; // Operación fallida
        }
    }

    public function mostrarUsuarios() {
        try {
            // Consulta SQL parametrizada
            $sql = "SELECT id_usuario, nombre_usuario, dni_usuario, id_rol, correo_usuario 
                    FROM bd_piedradeagua.usuario 
                    ORDER BY id_usuario ASC";
    
            // Preparar la consulta
            $stmt = $this->conn->prepare($sql);
    
            // Ejecutar la consulta
            $stmt->execute();
    
            // Retornar los resultados como un arreglo asociativo
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Manejo de errores
            throw new Exception("Error al mostrar usuarios: " . $e->getMessage());
        }
    }
}