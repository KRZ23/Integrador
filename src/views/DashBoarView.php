<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Administración</title>
    <link rel="stylesheet" href="../../public/css/StyleDashBoardView.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    
    <div class="dashboard">
        <!-- Barra lateral -->
        <aside class="sidebar">
            <h2>Admin Panel</h2>
            <ul>
                <li><a href="#usuarios" class="active"><i class="fa-solid fa-users"></i> Usuarios</a></li>
                <li><a href="#productos"><i class="fa-solid fa-box"></i> Productos</a></li>
                <li><a href="#reportes"><i class="fa-solid fa-chart-line"></i> Reportes</a></li>
                <li><a href="#pedidos"><i class="fa-solid fa-truck"></i> Pedidos</a></li>
                <li><a href="#config"><i class="fa-solid fa-cogs"></i> Configuración</a></li>
            </ul>
        </aside>

        <!-- Contenido principal -->
        <main class="main-content">
            <!-- Encabezado -->
            <header>
                <h1>Dashboard</h1>
                <button id="logout-btn"><i class="fa-solid fa-sign-out-alt"></i> Salir</button>
            </header>

            <!-- Contenedor de secciones -->
            <section id="usuarios" class="section active">
                <h2>Gestión de Usuarios</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Aquí se cargarán los usuarios dinámicamente -->
                    </tbody>
                </table>
            </section>

            <section id="productos" class="section">
                <h2>Gestión de Productos</h2>
                <button id="add-product-btn"><i class="fa-solid fa-plus"></i> Añadir Producto</button>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Categoría</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Aquí se cargarán los productos dinámicamente -->
                    </tbody>
                </table>
            </section>

            <section id="reportes" class="section">
                <h2>Generar Reportes</h2>
                <button id="generate-report-btn"><i class="fa-solid fa-download"></i> Generar Reporte</button>
                <div id="report-container">
                    <!-- Aquí se mostrarán los reportes -->
                </div>
            </section>

            <section id="pedidos" class="section">
            <button id="btnAbrirFormulario" class="btn btn-primary">Agregar Pedido</button>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID Pedido</th>
                            <th>Material</th>
                            <th>Estado</th>
                            <th>Descripción</th>
                            <th>Nombre del cliente</th>
                            <th>Correo del cliente</th>
                        </tr>
                    </thead>
                    <tbody id="pedidos-tbody">
                        <!-- Carga dinámica de pedidos -->
                    </tbody>
                </table>
            </section>

        </main>
    </div>

    <script src="../../public/js/DasBoard.js"></script>
    <script src="../../public/js/Pedidos.js"></script>
</body>

</html>