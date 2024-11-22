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
        // Instanciamos el modelo (clase Conexion)
        $this->modelo = new Conexion();
    }

    // Método para obtener pedidos
    public function obtenerPedidos()
    {
        try {
            // Llamamos al método del modelo
            $pedidos = $this->modelo->obtenerPedidos();

            // Verificamos si hay resultados
            if (!empty($pedidos)) {
                // Retornamos los pedidos como JSON
                echo json_encode([
                    'status' => 'success',
                    'data' => $pedidos
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'No hay pedidos disponibles'
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    // Método para actualizar el estado de un pedido
    public function actualizarEstadoPedido($idPedido, $nuevoEstado)
    {
        try {
            // Llamamos al método del modelo
            $resultado = $this->modelo->actualizarEstadoPedido($idPedido, $nuevoEstado);

            // Verificamos si se actualizó correctamente
            if ($resultado) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Estado del pedido actualizado correctamente'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'No se pudo actualizar el estado del pedido'
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}

// Lógica para manejar las solicitudes (como endpoint)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Instanciamos el controlador
    $controller = new PedidoController();

    // Llamamos al método para obtener pedidos
    $controller->obtenerPedidos();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Instanciamos el controlador
    $controller = new PedidoController();

    // Capturamos los datos enviados por POST
    $data = json_decode(file_get_contents('p../views/DashBoardView.php'), true);
    $idPedido = $data['id_pedido'] ?? null;
    $nuevoEstado = $data['nuevo_estado'] ?? null;

    // Validamos los datos antes de llamar al método
    if ($idPedido && $nuevoEstado) {
        $controller->actualizarEstadoPedido($idPedido, $nuevoEstado);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Faltan datos para actualizar el estado del pedido'
        ]);
    }
}