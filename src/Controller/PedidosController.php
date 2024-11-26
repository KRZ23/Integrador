<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../models/conexion.php';

class PedidoController {
    private $modelo;

    public function __construct() {
        $this->modelo = new Conexion(); 
    }

    public function obtenerPedidos() {
        try {
            $pedidos = $this->modelo->obtenerPedidos();
            if (empty($pedidos)) {
                throw new Exception("No se encontraron pedidos.");
            }
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
    public function agregarPedido($data)
    {
        // Validar los datos recibidos
        if (!isset($data['id_usuario'], $data['estado_material'], $data['descripcion'], $data['id_material'], $data['cantidad_pedido'],$data['fecha_pedido'])) {
            return ["error" => "Datos insuficientes para crear un pedido."];
        }

        // Llama al modelo para agregar el pedido
        $resultado = $this->modelo->AgregarPedidoConMaterial(
            $data['id_usuario'],
            $data['estado_material'],
            $data['descripcion'],
            $data['id_material'],
            $data['cantidad_pedido'],
            $data['fecha_pedido']
        );

        if ($resultado) {
            return ["success" => "Pedido creado correctamente."];
        } else {
            return ["error" => "Error al crear el pedido."];
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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'insertarPedido') {
    header('Content-Type: application/json');
    try {
        $data = json_decode(file_get_contents('php://input'), true);

        $material = $data['material'];
        $estado = $data['estado'];
        $descripcion = $data['descripcion'];
        $nombreCliente = $data['nombreCliente'];
        $correoCliente = $data['correoCliente'];
        $cantidad = $data['cantidad'];

        // Validaciones adicionales aquí

        $pedidoModel = new Conexion(); // Asegúrate de tener esta clase
        $pedidoModel->AgregarPedidoConMaterial($material, $estado, $descripcion, $nombreCliente, $correoCliente, $cantidad);

        echo json_encode(['success' => true, 'message' => 'Pedido insertado correctamente.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}
