<?php
include 'conexion.php';

try {
    $query = "SELECT nombre_material, descripcion, precio, ruta_imagen FROM material";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    
    // Fetch all products as an associative array
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Opcional: convierte los datos a JSON para usarlos directamente en JavaScript
    header('Content-Type: application/json');
    echo json_encode($productos);
    
} catch (PDOException $e) {
    echo "Error al obtener los productos: " . $e->getMessage();
}
?>