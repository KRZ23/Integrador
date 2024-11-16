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
    

    
}
?>