<?php
include './HeadView.php';
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: ../views/LoginView.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/Bootstrap_css/bootstrap.min.css">
    <title>Cantera Piedra de Agua</title>
</head>

<body>
    <!-- Sección de Productos -->
    <section class="container my-5">
        <h2 class="text-center mb-4">Productos Disponibles</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4" id="productos-container">
            <!-- Los productos se generarán dinámicamente aquí -->
        </div>
    </section>

    <!-- Pie de página -->
    <footer class="bg-dark text-white text-center py-4">
        <p>Contacto: <a href="#" class="text-white">...</a></p>
    </footer>

    <script src="/public/js/Bootstrap_js/bootstrap.bundle.min.js"></script>
    <script src="/public/js/Productos.js"></script> <!-- Archivo JS para generar productos -->
</body>

</html>