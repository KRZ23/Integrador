<?php
require_once '../models/conexion.php';

class ProductosController
{
    private $modelo;

    public function __construct() {
        $this->modelo = new Conexion(); 
    }

    public function obtenerProductos()
    {
        try {
            // Obtener los productos
            $productos = $this->modelo->getProductos();

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

    // public function agregarProducto() {
    //     try {
    //         // Obtener datos enviados por POST
    //         $data = json_decode(file_get_contents('php://input'), true);

    //         $nombre = $data['nombre'] ?? '';
    //         $descripcion = $data['descripcion'] ?? '';
    //         $precio = $data['precio'] ?? 0;
    //         $imagen = $data['imagen'] ?? '';
    //         $categoria = $data['categoria'] ?? '';
    //         $stock = $data['stock'] ?? 0;

    //         // Validar datos mínimos
    //         if (empty($nombre) || empty($precio) || empty($categoria)) {
    //             http_response_code(400); // Código de solicitud incorrecta
    //             echo json_encode(['mensaje' => 'Faltan datos obligatorios']);
    //             return;
    //         }

    //         // Insertar el producto en la base de datos
    //         $resultado = $this->modelo->agregarProducto($nombre, $descripcion, $precio, $imagen, $categoria, $stock);

    //         if ($resultado) {
    //             http_response_code(201); // Código de recurso creado
    //             echo json_encode(['mensaje' => 'Producto agregado correctamente']);
    //         } else {
    //             http_response_code(500); // Código de error del servidor
    //             echo json_encode(['mensaje' => 'Error al agregar el producto']);
    //         }
    //     } catch (Exception $e) {
    //         http_response_code(500);
    //         echo json_encode(['mensaje' => 'Error en el servidor', 'error' => $e->getMessage()]);
    //     }
    // }
    // public function obtenerProductoPorId($idProducto)
    // {
    //     try {
    //         // Validar ID del producto
    //         if (!is_numeric($idProducto) || $idProducto <= 0) {
    //             http_response_code(400); // Código de solicitud incorrecta
    //             echo json_encode(['error' => 'ID de producto inválido.']);
    //             return;
    //         }

    //         // Obtener producto desde el modelo
    //         $productos = $this->modelo->obtenerProductoPorId($idProducto);

    //         // Verificar si el producto existe
    //         if (!$productos) {
    //             http_response_code(404); // Código de no encontrado
    //             echo json_encode(['mensaje' => 'Producto no encontrado.']);
    //             return;
    //         }

    //         // Devolver el producto en formato JSON
    //         header('Content-Type: application/json');
    //         echo json_encode($productos);
    //     } catch (Exception $e) {
    //         // Manejo de errores
    //         http_response_code(500); // Código de error del servidor
    //         echo json_encode(['error' => 'Error al obtener el producto', 'mensaje' => $e->getMessage()]);
    //     }
    // }
}

// // Lógica para manejar las solicitudes
// if ($_SERVER['REQUEST_METHOD'] === 'GET') {
//     $controller = new ProductosController();

//     if (isset($_GET['id_producto'])) {
//         $controller->obtenerProductoPorId($_GET['id_producto']);
//     } else {
//         $controller->obtenerProductos();
//     }
// }
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller = new ProductosController();
    $controller->obtenerProductos();
}

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $controller = new ProductosController();
//     $controller->agregarProducto();
// }
// Instanciar el controlador y llamar al método
// $controller = new ProductosController();
// $controller->obtenerProductos();
// $controller->obtenerProductoPorId($idProducto);
