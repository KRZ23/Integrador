<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: ../views/LoginView.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Administración</title>
    <link rel="stylesheet" href="../../public/css/StyleDashBoardView.css">
    <link rel="stylesheet" href="../../public/css/StyleModal.css">
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
                            <th>DNI</th>
                            <th>Rol</th>
                            <th>Correo</th>
                        </tr>
                    <tbody id="usuarios-tbody">
                        <!-- Aquí se cargarán los productos dinámicamente -->
                    </tbody>
                    </thead>
                    <tbody>
                        <!-- Aquí se cargarán los usuarios dinámicamente -->
                    </tbody>
                </table>
            </section>

            <section id="productos" class="section">
                <h2>Gestión de Productos</h2>
                <button id="btnAbrirModal">Agregar Producto</button>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Categoría</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                    <tbody id="productos-table-body">
                        <!-- Las filas de productos se insertarán aquí dinámicamente -->
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
                <button id="abrirModal" class="btn btn-primary">Agregar Pedido</button>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID Pedido</th>
                            <th>Cliente</th>
                            <th>Correo</th>
                            <th>Productos</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody id="pedidos-tbody">
                        <!-- Carga dinámica de pedidos -->
                    </tbody>
                </table>
            </section>


            <div id="modalProducto" class="modal">
        <div class="modal-content">
            <span id="btnCerrarModal" class="close">&times;</span>
            <h2>Agregar Producto</h2>
            <form id="formularioProducto" enctype="multipart/form-data">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>

                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" required></textarea>

                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" step="0.01" required>

                <label for="categoria">Categoría:</label>
                <input type="text" id="categoria" name="categoria" required>

                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock" required>

                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" name="imagen" accept=".png, .jpg, .jpeg, .webp" required>

                <button type="submit">Agregar Producto</button>
            </form>
        </div>
    </div>
            <!-- <dialog id="modalFormulario" class="rounded-3 shadow-lg">
            <form action="../Controller/ProductosController.php?action=agregar" method="POST" enctype="multipart/form-data">
                    <h3 class="text-center mb-4">Registrar Nuevo Pedido</h3>

                    <div class="mb-3">
                        <label for="fechaPedido" class="form-label">Fecha del Pedido:</label>
                        <input type="date" id="fechaPedido" name="fecha_pedido" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="nombreUsuario" class="form-label">Nombre del Usuario:</label>
                        <input type="text" id="nombreUsuario" name="nombre_usuario" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="producto" class="form-label">Producto:</label>
                        <select id="producto" name="id_producto" class="form-select" required>

                        </select>
                    </div>

                    
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado:</label>
                        <select id="estado" name="estado" class="form-select" required>
                            <option value="Pendiente">Pendiente</option>
                            <option value="En proceso">En proceso</option>
                            <option value="Listo para entrega">Listo para entrega</option>
                            <option value="Entregado">Entregado</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción:</label>
                        <textarea id="descripcion" name="descripcion" class="form-control" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="cantidad" class="form-label">Cantidad pedida:</label>
                        <input type="number" id="cantidad" name="cantidad" class="form-control" min="1" required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-success">Guardar</button>
                        <button type="button" id="cerrarModal" class="btn btn-secondary">Cancelar</button>
                    </div>
                </form>
            </dialog>  -->
        </main>
    </div>

    <script src="../../public/js/DasBoard.js"></script>
    <script src="../../public/js/Pedidos.js"></script>
    <script src="../../public/js/Usuarios.js"></script>
    <script src="../../public/js/ProductosAdm.js"></script>
</body>

</html>