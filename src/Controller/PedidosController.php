<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../models/conexion.php';

class PedidoController {
    private $modelo;

    public function __construct() {
        $this->modelo = new Conexion(); // Asegúrate de que este modelo esté implementado correctamente
    }

    public function obtenerPedidos() {
        try {
            $pedidos = $this->modelo->obtenerPedidos();
            echo json_encode([
                'success' => true,
                'data' => $pedidos
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function actualizarEstadoPedido($idPedido, $nuevoEstado) {
        try {
            $resultado = $this->modelo->actualizarEstadoPedido($idPedido, $nuevoEstado);
            if ($resultado) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Estado del pedido actualizado correctamente'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'No se pudo actualizar el estado del pedido'
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}

$controller = new PedidoController();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['action'] === 'fetch') {
    $controller->obtenerPedidos();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $idPedido = $data['idPedido'] ?? null;
    $nuevoEstado = $data['nuevoEstado'] ?? null;

    if ($idPedido && $nuevoEstado) {
        $controller->actualizarEstadoPedido($idPedido, $nuevoEstado);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Faltan datos para actualizar el estado del pedido'
        ]);
    }
}
