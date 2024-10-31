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
    $id_cliente = $user['id_usufructuario'];
    $nombre=$user['nombre_usufructuario'];
    $apellido=$user['apellido_usufructuario	'];
    $dni=$user['dni_usufructuario'];
    $rol = $user['id_rol'];
    $correo = $user['correo_usufructuario'];
    $password = $user['contrasena'];
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
            require(''); // Aún no se crea la vista del cliente
            break;
        case 'Jefe':
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
