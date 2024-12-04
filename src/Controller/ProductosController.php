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
    public function procesarImagen($archivoImagen) {
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

    public function agregarProducto($datos, $archivoImagen) {
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

// Instanciar y ejecutar según acción
$controller = new ProductosController();

if ($_GET['action'] === 'agregar') {
    $controller->agregarProducto($_POST, $_FILES['imagen']);
}
    // public function agregarProducto($datos, $archivoImagen) {
    //     try {
    //         if (!isset($datos['nombre'], $datos['descripcion'], $datos['precio'], $datos['categoria'], $datos['stock'])) {
    //             echo json_encode(["error" => "Faltan datos obligatorios para agregar el producto."]);
    //             return;
    //         }
    
    //         $imagenSubida = $this->procesarImagen($archivoImagen);
    //         if (isset($imagenSubida['error'])) {
    //             echo json_encode($imagenSubida); // Devolver errores de validación
    //             return;
    //         }
    
    //         $resultado = $this->modelo->agregarProducto(
    //             $datos['nombre'],
    //             $datos['descripcion'],
    //             $datos['precio'],
    //             $imagenSubida['ruta'],
    //             $datos['categoria'],
    //             $datos['stock']
    //         );
    
    //         if ($resultado) {
    //             echo json_encode(["success" => "Producto agregado correctamente."]);
    //         } else {
    //             echo json_encode(["error" => "Error al agregar el producto en la base de datos."]);
    //         }
    //     } catch (Exception $e) {
    //         error_log("Error en agregarProducto: " . $e->getMessage());
    //         echo json_encode(["error" => "Ocurrió un error al agregar el producto."]);
    //     }
    // }

    // private function procesarImagen($archivoImagen) {
    //     $carpetaDestino = '../views/img/FotosProducto/';
    //     $extensionesPermitidas = ['png', 'jpg', 'jpeg', 'webp'];
    //     $tamañoMaximo = 2 * 1024 * 1024; // 2 MB

    //     // Validar si se subió un archivo
    //     if (!isset($archivoImagen) || $archivoImagen['error'] !== UPLOAD_ERR_OK) {
    //         return ["error" => "No se pudo subir la imagen."];
    //     }

    //     // Validar el tamaño del archivo
    //     if ($archivoImagen['size'] > $tamañoMaximo) {
    //         return ["error" => "La imagen excede el tamaño máximo permitido de 2 MB."];
    //     }

    //     // Validar la extensión del archivo
    //     $extension = strtolower(pathinfo($archivoImagen['name'], PATHINFO_EXTENSION));
    //     if (!in_array($extension, $extensionesPermitidas)) {
    //         return ["error" => "Formato de imagen no permitido. Solo se aceptan PNG, JPG y WEBP."];
    //     }

    //     // Validar el contenido MIME del archivo
    //     $tipoMime = mime_content_type($archivoImagen['tmp_name']);
    //     if (!in_array($tipoMime, ['image/png', 'image/jpeg', 'image/webp'])) {
    //         return ["error" => "El archivo no es una imagen válida."];
    //     }

    //     // Generar un nombre único para la imagen
    //     $nombreArchivo = uniqid('producto_') . '.' . $extension;

    //     // Mover el archivo al destino
    //     if (!move_uploaded_file($archivoImagen['tmp_name'], $carpetaDestino . $nombreArchivo)) {
    //         return ["error" => "Error al guardar la imagen en el servidor."];
    //     }

    //     return ["ruta" => '../views/img/FotosProducto/' . $nombreArchivo];
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
// }

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

// Instanciar el controlador y llamar al método
// $controller = new ProductosController();
// $controller->obtenerProductos();
// $controller->obtenerProductoPorId($idProducto);
