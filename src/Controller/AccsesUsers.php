<?php
require('../models/conexion.php');

$usuario = $_GET['usuario'];
$password = $_GET['password'];

$con = new conexion();
//Para buscar el usuario en la base de datos
$buscarUsuario = $con->getUser($usuario,$password);