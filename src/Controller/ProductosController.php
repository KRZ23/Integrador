<?php
require_once '../models/conexion.php';

class ProductosController
{
    private $modelo;

    public function __construct()
    {
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
    public function procesarImagen($archivoImagen)
    {
        try {
            // Validar que se haya enviado una imagen
            if (!isset($archivoImagen) || $archivoImagen['error'] !== UPLOAD_ERR_OK) {
                return ['error' => 'No se pudo cargar la imagen.'];
            }

            // Validar extensión permitida
            $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'webp'];
            $infoArchivo = pathinfo($archivoImagen['name']);
            $extension = strtolower($infoArchivo['extension']);

            if (!in_array($extension, $extensionesPermitidas)) {
                return ['error' => 'Formato no permitido. Solo JPG, PNG y WEBP.'];
            }

            // Validar tamaño máximo (2MB)
            $tamanoMaximo = 2 * 1024 * 1024;
            if ($archivoImagen['size'] > $tamanoMaximo) {
                return ['error' => 'El archivo excede los 2MB.'];
            }

            // Generar un nombre único para la imagen
            $nombreUnico = uniqid('producto_', true) . '.' . $extension;
            $carpetaDestino = __DIR__ . '/../views/img/FotosProducto/';
            $rutaCompleta = $carpetaDestino . $nombreUnico;

            // Mover la imagen a la carpeta
            if (!move_uploaded_file($archivoImagen['tmp_name'], $rutaCompleta)) {
                return ['error' => 'Error al mover la imagen.'];
            }

            // Retornar la ruta relativa
            $rutaRelativa = '/src/views/img/FotosProducto/' . $nombreUnico;
            return ['ruta' => $rutaRelativa];
        } catch (Exception $e) {
            return ['error' => 'Error al procesar la imagen: ' . $e->getMessage()];
        }
    }

    public function agregarProducto($datos, $archivoImagen)
    {
        try {
            // Validar que todos los datos requeridos estén presentes
            if (!isset($datos['nombre'], $datos['descripcion'], $datos['precio'], $datos['categoria'], $datos['stock'])) {
                echo json_encode(["error" => "Faltan datos obligatorios."]);
                return;
            }

            // Procesar la imagen
            $imagenSubida = $this->procesarImagen($archivoImagen);
            if (isset($imagenSubida['error'])) {
                echo json_encode($imagenSubida);
                return;
            }

            // Guardar en la base de datos
            $resultado = $this->modelo->agregarProducto(
                $datos['nombre'],
                $datos['descripcion'],
                $datos['precio'],
                $imagenSubida['ruta'],
                $datos['categoria'],
                $datos['stock']
            );

            if ($resultado) {
                echo json_encode(["success" => "Producto agregado correctamente."]);
            } else {
                echo json_encode(["error" => "Error al guardar en la base de datos."]);
            }
        } catch (Exception $e) {
            echo json_encode(["error" => "Error: " . $e->getMessage()]);
        }
    }
}

$controller = new ProductosController();

if ($_GET['action'] === 'agregar') {
    $controller->agregarProducto($_POST, $_FILES['imagen']);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller = new ProductosController();
    $controller->obtenerProductos();
}
