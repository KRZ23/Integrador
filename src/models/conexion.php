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

    public function getUser($usuario, $password) {
        $stmt = $this->conn->prepare("
            SELECT * 
            FROM bd_piedradeagua.usuario 
            WHERE correo_usuario = :usuario 
            AND contrasena_usuario = :password
        ");
    
        $stmt->bindParam(":usuario", $usuario, PDO::PARAM_STR);
        $stmt->bindParam(":password", $password, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registerUser($nombre, $apellido, $dni, $correo, $password, $id_rol) {
        try {
            $stmt = $this->conn->prepare("
                INSERT INTO bd_piedradeagua.usuario (nombre_usuario, apellido_usuario, dni_usuario, correo_usuario, contrasena_usuario, id_rol) 
                VALUES (:nombre, :apellido, :dni, :correo, :password, :rol)
            ");
    
            // Vincular parámetros
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindParam(":apellido", $apellido, PDO::PARAM_STR);
            $stmt->bindParam(":dni", $dni, PDO::PARAM_STR);
            $stmt->bindParam(":correo", $correo, PDO::PARAM_STR);
            $stmt->bindParam(":password", $password, PDO::PARAM_STR);
            $stmt->bindParam(":rol", $id_rol, PDO::PARAM_INT);
    
            // Ejecutar la consulta
            if ($stmt->execute()) {
                return "Usuario registrado con éxito";
            } else {
                return "Error al registrar el usuario";
            }
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    
}
?>