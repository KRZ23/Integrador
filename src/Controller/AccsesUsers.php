<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('../models/conexion.php'); // Archivo de conexión

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['username'];
    $password = $_POST['password'];

    $con = new Conexion();
    $buscarUsuario = $con->getUser($usuario); // Obtenemos los datos del usuario por su correo

    if ($buscarUsuario) {
        // Verificar el hash de la contraseña
        if (password_verify($password, $buscarUsuario['contrasena_usuario'])) {
            // Si la contraseña coincide, iniciar sesión
            session_start();
            $_SESSION['id_usuario'] = $buscarUsuario['id_usuario'];
            $_SESSION['nombre_usuario'] = $buscarUsuario['nombre_usuario'];
            $_SESSION['rol'] = $buscarUsuario['id_rol'];

            // Redirigir según el rol
            switch ($buscarUsuario['id_rol']) {
                case 1: // Rol cliente
                    header("Location: ../views/VentasView.php");
                    break;
                case 2: // Rol administrador
                    header("Location: ../views/DashBoarView.php");
                    break;
                case 3: // Conductor
                    header("Location: ../views/");
                    break;
                case 4: // Seguridad
                    header("Location: ../views/SeguridadView.php");
                    break;
                default:
                    echo "Rol no reconocido.";
                    break;
            }
        } else {
            // Contraseña incorrecta
            echo '
                <script>
                    alert("Usuario o contraseña incorrectos.");
                    window.location.href = "../views/LoginView.php";
                </script>
            ';
        }
    } else {
        // Usuario no encontrado
        echo '
            <script>
                alert("Usuario o contraseña incorrectos.");
                window.location.href = "../views/LoginView.php";
            </script>
        ';
    }
}
