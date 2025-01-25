<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../models/conexion.php';

class VehiculoController
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new Conexion();
    }

    public function mostrarVehiculos()
    {
        try {
            // Llama al modelo para obtener la lista de vehículos
            $vehiculos = $this->modelo->obtenerVehiculos();

            // Devuelve los vehículos en formato JSON
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'data' => $vehiculos]);
        } catch (Exception $e) {
            // Maneja errores y envía una respuesta JSON de error
            header('Content-Type: application/json', true, 500);
            echo json_encode(['success' => false, 'message' => 'Error al obtener los vehículos', 'error' => $e->getMessage()]);
        }
    }
}
$controlador = new VehiculoController();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controlador->mostrarVehiculos();
}
