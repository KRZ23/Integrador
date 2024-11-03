<?php
include 'conexion.php';

try {
    $query = "SELECT nombre_material, descripcion, precio, ruta_imagen FROM material";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    
    // Fetch all products as an associative array
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    
} catch (PDOException $e) {
    echo "Error al obtener los productos: " . $e->getMessage();
}
?>