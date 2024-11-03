<?php
session_start();
    
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
    <nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">PIEDRA DE AGUA</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Productos</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

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