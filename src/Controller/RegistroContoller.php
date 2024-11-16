<?php
require_once "../models/conexion.php";

class RegisterController {
    private $model;

    public function __construct() {
        $this->model = new Conexion();
    }

    public function register($nombre, $apellido, $dni, $correo, $password) {
        // Validaciones básicas
        if (empty($nombre) || empty($apellido) || empty($dni) || empty($correo) || empty($password)) {
            return "Todos los campos son obligatorios";
        }

        // Validación de formato de correo
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            return "Correo no válido";
        }

        // Verificación de DNI
        if (!preg_match("/^[0-9]{8}$/", $dni)) {
            return "DNI inválido";
        }

        // Encriptar la contraseña antes de enviarla al modelo
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Asignar el rol de ventas (id_rol = 1) por defecto
        $id_rol = 1;

        // Registrar el usuario
        $response = $this->model->registerUser($nombre, $apellido, $dni, $correo, $hashedPassword, $id_rol);

        // Verificar la respuesta y redirigir si es exitosa
        if ($response === "Usuario registrado con éxito") {
            header('Location: ../views/LoginView.php'); // Redirigir al login si el registro es exitoso
            exit();
        } else {
            return $response;
        }
    }
}

// Comprobar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $dni = $_POST['dni'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    $controller = new RegisterController();
    $response = $controller->register($nombre, $apellido, $dni, $correo, $password);

    echo $response;
}
?>


