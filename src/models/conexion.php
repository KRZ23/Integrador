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
        $query = $this->con->query("SELECT * FROM usuarios WHERE correo='" . $usuario . "' AND contrasena='" . $password . "'"); //Sentancia para buscar los usuarios en la base de datos


        $retorno = [];

        $i = 0;
        while ($fila = $query->fetch_assoc()) {

            $retorno[$i] = $fila;
            $i++;
        }
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
	//or die ('Could not connect to the database server' . mysqli_connect_error());
//$con->close();