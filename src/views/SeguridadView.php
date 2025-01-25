<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 4) {
    header("Location: ../views/LoginView.php");
    exit();
}
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Administración</title>
    <link rel="stylesheet" href="../../public/css/StyleDashBoardView.css">
    <link rel="stylesheet" href="../../public/css/TablasVehiculo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="shortcut icon" href="img/FotosProducto/Logo.webp">
</head>

<body>

    <div class="dashboard">
        <!-- Barra lateral -->
        <aside class="sidebar">
            <h2> Panel</h2>
            <ul>
                <li><a href="#pedidos"><i class="fa-solid fa-truck"></i> Pedidos</a></li>
                <li><a href="#carros"><i class="fa-solid fa-truck"></i> Carros</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <!-- Encabezado -->
            <header>
                <h1>Dashboard</h1>
                <button id="logout-btn"><i class="fa-solid fa-sign-out-alt"></i> Salir</button>
            </header>

            <section id="pedidos" class="section active">
                <h2>Gestión de Pedidos</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID Pedido</th>
                            <th>Cliente</th>
                            <th>Correo</th>
                            <th>Productos</th>
                            <th>Descripción</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody id="pedidos-tbody">
                        <!-- Carga dinámica de pedidos -->
                    </tbody>
                </table>
            </section>
            </table>
            </section>

            <section id="carros" class="section">
                <h2>Carros</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID Vehiculo</th>
                            <th>Placa</th>
                            <th>Modelo</th>
                            <th>Color</th>
                            <th>Marca</th>
                        </tr>
                    </thead>
                    <tbody id="Vehiculos-tbody">
                        <!-- Carga dinámica de vehiculos -->
                    </tbody>
                </table>
            </main>
    </div>

    <script src="../../public/js/PedidoSegu.js"></script>
    <script src="../../public/js/Vehiculos.js"></script>

    <script src="../../public/js/bootstrap_js/bootstrap.bundle.min.js"></script>
</body>

</html>