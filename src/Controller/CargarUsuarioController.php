<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../models/conexion.php'; // Asegúrate de que esta ruta sea correcta

class UsuariosController {
    // Método para obtener los usuarios desde el modelo
    public function fetchUsuarios() {
        try {
            $usuarioModel = new Conexion(); // Instancia del modelo
            $usuarios = $usuarioModel->mostrarUsuarios(); // Consulta usuarios

            if (empty($usuarios)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'No se encontraron usuarios'
                ]);
            } else {
                echo json_encode([
                    'success' => true,
                    'data' => $usuarios
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error al obtener usuarios: ' . $e->getMessage()
            ]);
        }
    }
}

// Control de acciones
if (isset($_GET['action']) && $_GET['action'] === 'fetchUsuarios') {
    $controller = new UsuariosController();
    $controller->fetchUsuarios();
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Acción no válida'
    ]);
}
?>
