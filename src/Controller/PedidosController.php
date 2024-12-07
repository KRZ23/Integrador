<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../models/conexion.php';

class PedidoController
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new Conexion();
    }

    public function obtenerPedidos()
    {
        try {
            $pedidos = $this->modelo->obtenerPedidos();
            echo json_encode([
                'success' => true,
                'pedidos' => $pedidos
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error al obtener los pedidos: ' . $e->getMessage()
            ]);
        }
    }


    public function actualizarEstadoPedido($idPedido, $nuevoEstado)
    {
        try {
            $resultado = $this->modelo->actualizarEstadoPedido($idPedido, $nuevoEstado);

            echo json_encode([
                'success' => $resultado,
                'message' => $resultado
                    ? 'Estado del pedido actualizado correctamente.'
                    : 'No se encontró el pedido o el estado no cambió.'
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error al actualizar el estado del pedido: ' . $e->getMessage()
            ]);
        }
    }

    public function agregarPedido() {
        try {
            $data = json_decode(file_get_contents("php://input"), true);

            $idUsuario = $data['usuario'] ?? null;
            $fechaPedido = $data['fecha_pedido'] ?? null;
            $estadoMaterial = $data['estado_material'] ?? 'Pendiente'; // Estado predeterminado
            $descPedido = $data['desc_pedido'] ?? null;
            $idProducto = $data['producto'] ?? null;
            $cantidad = $data['cantidad'] ?? null;

            if (!$idUsuario || !$fechaPedido || !$descPedido || !$idProducto || !$cantidad) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Todos los campos son obligatorios.'
                ]);
                return;
            }

            $pedidoModel = new Conexion();
            $pedidoModel->insertarPedidoConProductos($idUsuario, $fechaPedido, $estadoMaterial, $descPedido, $idProducto, $cantidad);

            echo json_encode([
                'success' => true,
                'message' => 'Pedido agregado exitosamente.'
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}

if ($_GET['action'] === 'agregar') {
    $controller->agregarPedido($_POST);
}
$controller = new PedidoController();
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'] ?? null; // Uso de null coalescing operator
    if ($action === 'fetch') {
        $controller->obtenerPedidos();
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Accion no valida en la solicitud GET.'
        ]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $idPedido = $data['idPedido'] ?? null;
    $nuevoEstado = $data['nuevoEstado'] ?? null;

    if ($idPedido && $nuevoEstado) {
        try {
            $resultado = $controller->actualizarEstadoPedido($idPedido, $nuevoEstado);

            if ($resultado) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Estado del pedido actualizado correctamente'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'No se pudo actualizar el estado del pedido. Verifique el ID del pedido.'
                ]);
            }
        } catch (Exception $e) {
            // Capturamos cualquier error que ocurra durante la actualización
            echo json_encode([
                'success' => false,
                'message' => 'Error al actualizar el estado del pedido: ' . $e->getMessage()
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Faltan datos para actualizar el estado del pedido'
        ]);
    }
}
