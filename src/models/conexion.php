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
                    id_categoria,
                    stock
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

    public function agregarProducto($nombre, $descripcion, $precio, $imagen, $categoria, $stock)
    {
        try {
            $query = "INSERT INTO bd_piedradeagua.productos 
                    (nombre_producto, descripcion_producto, precio_producto, imagen, id_categoria, stock)
                    VALUES (:nombre, :descripcion, :precio, :imagen, :categoria, :stock)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':imagen', $imagen);
            $stmt->bindParam(':categoria', $categoria);
            $stmt->bindParam(':stock', $stock);
            $stmt->execute();

            return true; // Indica éxito
        } catch (PDOException $e) {
            error_log("Error en agregarProducto: " . $e->getMessage());
            return false; // Indica error
        }
    }

    public function obtenerPedidos()
    {
        try {
            $sql = "
        SELECT 
            u.nombre_usuario AS usuario,
            u.correo_usuario as correo,
            p.id_pedido,
            pr.nombre_producto,
            p.desc_pedido,
            pp.cantidad_pedido,
            p.estado_material,
            p.fecha_pedido
        FROM bd_piedradeagua.pedido p
        LEFT JOIN bd_piedradeagua.usuario u ON p.id_usuario = u.id_usuario
        LEFT JOIN bd_piedradeagua.pedido_productos pp ON p.id_pedido = pp.id_pedido
        LEFT JOIN bd_piedradeagua.productos pr ON pp.id_producto = pr.id_producto
        ORDER BY p.fecha_pedido DESC;
        ";

            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener pedidos: " . $e->getMessage());
            throw new Exception("Error al obtener pedidos de la base de datos.");
        }
    }

    public function obtenerProductoPorId($idProducto) {
        $sql = "SELECT * FROM bd_piedradeagua.productos WHERE id_producto = :id_producto";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_producto', $idProducto);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function actualizarProducto($idProducto, $nombre, $descripcion, $precio, $categoria, $stock, $imagenPath = null)
    {
        try {
            $sql = "UPDATE bd_pieradeagua.productos SET
            nombre_producto = :nombre,
            descripcion_producto = :descripcion,
            precio_producto = :precio,
            id_categoria = :categoria,
            stock = :stock,
            imagen = :imagen
            WHERE id_producto = :id_producto";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':categoria', $categoria);
            $stmt->bindParam(':stock', $stock);
            $stmt->bindParam(':imagen', $imagenPath);
            $stmt->bindParam(':id_producto', $idProducto);

            $stmt->execute();

            return ['success' => true, 'message' => 'Producto actualizado correctamente'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    // Método para eliminar un producto
    public function eliminarProducto($idProducto)
    {
        try {
            $sql = "DELETE FROM bd_piedradeagua.productos WHERE id_producto = :id_producto";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_producto', $idProducto);
            $stmt->execute();

            return ['success' => true, 'message' => 'Producto eliminado correctamente'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
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

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':estado', $nuevoEstado, PDO::PARAM_STR);
            $stmt->bindParam(':id_pedido', $idPedido, PDO::PARAM_INT);

            $stmt->execute();


            if ($stmt->rowCount() === 0) {
                return false;
            }

            return true;
        } catch (PDOException $e) {
            error_log("Error al actualizar el estado del pedido: " . $e->getMessage());
            throw new Exception("Error al actualizar el estado del pedido.");
        }
    }

    public function mostrarUsuarios()
    {
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


    public function insertarPedidoConProductos($idUsuario, $fechaPedido, $estadoMaterial, $descPedido, $productos)
    {
        try {
            // Validar que los datos requeridos estén presentes
            if (empty($idUsuario) || empty($fechaPedido) || empty($estadoMaterial) || empty($descPedido) || empty($productos)) {
                throw new Exception("Todos los campos son obligatorios y debe haber al menos un producto.");
            }

            // Usar la conexión preexistente
            $conexion = $this->conn; // Usar la conexión ya definida
            $conexion->beginTransaction();

            // Construir la consulta dinámica para insertar el pedido y los productos
            $sqlPedido = "WITH nuevo_pedido AS (
                INSERT INTO bd_piedradeagua.pedido (
                    id_usuario, fecha_pedido, estado_material, desc_pedido
                ) VALUES (
                    :id_usuario, :fecha_pedido, :estado_material, :desc_pedido
                )
                RETURNING id_pedido
            )
            INSERT INTO bd_piedradeagua.pedido_productos (
                id_pedido, id_producto, cantidad_pedido
            )
            VALUES " . implode(',', array_map(function ($producto, $index) {
                return "((SELECT id_pedido FROM nuevo_pedido), :id_producto_{$index}, :cantidad_{$index})";
            }, $productos, array_keys($productos)));

            // Preparar la consulta
            $stmt = $conexion->prepare($sqlPedido);

            // Vincular los parámetros del pedido
            $stmt->bindParam(':id_usuario', $idUsuario, PDO::PARAM_INT);
            $stmt->bindParam(':fecha_pedido', $fechaPedido, PDO::PARAM_STR);
            $stmt->bindParam(':estado_material', $estadoMaterial, PDO::PARAM_STR);
            $stmt->bindParam(':desc_pedido', $descPedido, PDO::PARAM_STR);

            // Vincular los parámetros dinámicos para los productos
            foreach ($productos as $index => $producto) {
                $stmt->bindParam(":id_producto_{$index}", $producto['id_producto'], PDO::PARAM_INT);
                $stmt->bindParam(":cantidad_{$index}", $producto['cantidad'], PDO::PARAM_INT);
            }

            // Ejecutar la consulta
            $stmt->execute();

            // Confirmar la transacción
            $conexion->commit();

            // Retornar éxito
            return [
                'success' => true,
                'message' => 'Pedido y productos insertados correctamente.'
            ];
        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            if (isset($conexion)) {
                $conexion->rollBack();
            }

            // Retornar el error
            return [
                'success' => false,
                'message' => 'Error al insertar el pedido: ' . $e->getMessage()
            ];
        }
    }
}
