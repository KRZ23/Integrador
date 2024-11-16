<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('../models/conexion.php'); // Archivo de conexión

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['username']; // Cambiado para coincidir con el formulario
    $password = $_POST['password'];

    $con = new Conexion();

    // Buscar usuario en la base de datos
    $buscarUsuario = $con->getUser($usuario, $password);

    if (!empty($buscarUsuario)) {
        // Si el usuario existe, iniciar sesión
        session_start();
        $user = $buscarUsuario[0]; // Extraer el primer resultado
        $_SESSION['id_usuario'] = $user['id_usuario'];
        $_SESSION['nombre_usuario'] = $user['nombre_usuario'];
        $_SESSION['rol'] = $user['id_rol'];

        // Redirigir según el rol
        switch ($user['id_rol']) {
            case 1: // Rol Administrador
                header("Location: ../views/VentasView.php");
                break;
            case 2: // Rol Vendedor
                header("Location: ../Views/sellerDashboard.php");
                break;
            case 3: // Rol Cliente
                header("Location: ../Views/customerDashboard.php");
                break;
            default:
                echo "Rol no reconocido.";
                break;
        }
    } else {
        // Si no se encontró el usuario, mostrar error
        echo '
            <script>
                alert("Usuario o contraseña incorrectos.");
                window.location.href = "../index.php";
            </script>
        ';
    }
}
?>