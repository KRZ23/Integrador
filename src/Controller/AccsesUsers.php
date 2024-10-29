<?php
require('../models/conexion.php');

//Evaluar si existe una conexción
if(!isset($_SESSION)){
    session_start();
}

$usuario = $_GET['usuario'];
$password = $_GET['password'];

$con = new conexion();

//Para buscar el usuario en la base de datos
$buscarUsuario = $con->getUser($usuario,$password);

foreach($buscarUsuario as $user){
    $id_cliente = $user['nombre_cliente'];
    $correo = $user['correo_cliente'];
    $rol = $user['id_rol'];
    $password = $user['contrasena'];
    $edad =$user['edad'];
}
