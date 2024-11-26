<?php
require_once '../models/conexion.php';

class ProductosController {
    public function obtenerProductos() {
        try {
            // Crear instancia de la conexión
            $conexion = new Conexion();

            // Obtener los productos
            $productos = $conexion->getProductos();

            // Verificar si hay productos
            if (!$productos || count($productos) === 0) {
                http_response_code(404); // Código de no encontrado
                echo json_encode(['mensaje' => 'No se encontraron productos disponibles.']);
                return;
            }

            // Devolver los productos en formato JSON
            header('Content-Type: application/json');
            echo json_encode($productos);
        } catch (Exception $e) {
            // En caso de error, devolver mensaje con error
            http_response_code(500); // Código de error del servidor
            echo json_encode(['error' => 'Error al obtener los productos', 'mensaje' => $e->getMessage()]);
        }
    }
}

// Instanciar el controlador y llamar al método
$controller = new ProductosController();
$controller->obtenerProductos();
?>
