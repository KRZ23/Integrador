<?php
// Asegúrate de que la solicitud sea de tipo POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtén el cuerpo de la solicitud
    $data = json_decode(file_get_contents("php://input"), true);

    // Verifica que se haya enviado un ID de producto
    if (isset($data['id_producto'])) {
        $idProducto = $data['id_producto'];

        // Conexión a la base de datos (asegúrate de que esta sea tu conexión)
        $conexion = new PDO('mysql:host=localhost;dbname=nombre_de_tu_base_de_datos', 'usuario', 'contraseña');
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        try {
            // Aquí realizas la consulta para eliminar el producto (eliminar lógicamente, por ejemplo)
            $consulta = "UPDATE productos SET estado = 0 WHERE id_producto = :id_producto";
            $stmt = $conexion->prepare($consulta);
            $stmt->bindParam(':id_producto', $idProducto, PDO::PARAM_INT);
            $stmt->execute();

            // Verifica si se afectaron filas (producto eliminado)
            if ($stmt->rowCount() > 0) {
                echo json_encode(['success' => true, 'message' => 'Producto desactivado correctamente.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'No se encontró el producto o no se pudo desactivar.']);
            }
        } catch (Exception $e) {
            // Si ocurre un error en la consulta
            echo json_encode(['success' => false, 'message' => 'Error al eliminar el producto.', 'error' => $e->getMessage()]);
        }
    } else {
        // Si no se recibió el ID del producto
        echo json_encode(['success' => false, 'message' => 'Falta el ID del producto.']);
    }
} else {
    // Si la solicitud no es POST
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}
?>
