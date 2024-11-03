<?php

class conexion
{
    private $user;
    private $password;
    private $server;
    private $database;
    private $con;

    public function __construct()
    {
        $user = 'root';
        $password = ''; //por definir
        $server = 'localhost';
        $database = 'bd_piedradeagua'; //por definir 
        $this->con = new mysqli($server, $user, $password, $database);
    }

    public function getUser($usuario, $password)
    {
        // Preparar la consulta para evitar inyecciones SQL
        $stmt = $this->con->prepare("SELECT * FROM cliente WHERE correo_cliente = ? AND contrasena_cliente = ?");
        $stmt->bind_param("ss", $usuario, $password); // "ss" indica que los parámetros son strings
    
        $stmt->execute(); // Ejecutar la consulta
    
        $result = $stmt->get_result(); // Obtener el resultado de la consulta
        $retorno = [];
    
        while ($fila = $result->fetch_assoc()) {
            $retorno[] = $fila;
        }
    
        $stmt->close(); // Cerrar la declaración preparada
        return $retorno;
    }
}

//$host="localhost";
//$port=3306;
//$socket="";
//$user="root";
//$password="";
//$dbname="bd_piedradeagua";

//$con = new mysqli($host, $user, $password, $dbname, $port, $socket)
//	or die ('Could not connect to the database server' . mysqli_connect_error());
//$con->close();
