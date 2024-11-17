<?php
require_once '../models/conexion.php';

class ProductosController {
    public function obtenerProductos() {
        $conexion = new Conexion();
        $productos = $conexion->getProductos();

        // Devolver los productos en formato JSON
        header('Content-Type: application/json');
        echo json_encode($productos);
    }
}

// Instanciar el controlador y llamar al método
$controller = new ProductosController();
$controller->obtenerProductos();
?>