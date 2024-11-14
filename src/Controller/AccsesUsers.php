<?php
require('../models/conexion.php');
require('Constanst.php');

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
    $id_cliente = $user['id_usuario'];
    $nombre=$user['nombre_usuario'];
    $apellido=$user['apellido_usuario	'];
    $dni=$user['dni_usuario'];
    $rol = $user['id_rol'];
    $correo = $user['correo_usuario'];
    $password = $user['contrasena_usuario'];
}

if (empty($searchUser)) {
    echo '
        <script language="javascript">
            alert("Usuario o Contraseña incorrectos, por favor intenta de nuevo");
            self.location = "/index.php";
        </script>   
    ';
} else {
    switch ($rol) {
        case 'Cliente':
            require('../views/VentasView.php');
            break;
        case 'Jefe':
            $urlViews = URL_VIEWS;
            require(''); // Aún no se crea la vista del jefe
            break;
        case 'Carguero':
            require(''); // Aún no se crea la vista del carguero
            break;
        case 'Seguridad':
            require(''); // Aún no se crea la vista del seguridad
            break;
        default:
            // Manejo de rol no reconocido
            echo '<script>alert("Rol no reconocido"); self.location = "/index.php";</script>';
            break;
    }
}
