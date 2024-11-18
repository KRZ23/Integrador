<?php
class Conexion {
    private $conn;

    public function __construct() {
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
    public function getUser($usuario) {
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
    public function registerUser($nombre, $apellido, $dni, $correo, $password, $id_rol) {
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

    public function getProductos() {
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
}
?>