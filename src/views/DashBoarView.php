<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 2) {
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
    <link rel="stylesheet" href="../../public/css/StyleModal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="shortcut icon" href="img/FotosProducto/Logo.webp">
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
                <button id="btnActualizarProductos">Actualizar Productos</button>
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
                            <th>Acciones</th>
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
                <h2>Gestión de Pedidos</h2>
                <button id="btnAbrirModalPedido">Agregar Pedido</button>
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

            <div id="modalPedido" class="modal">
                <div class="modal-content">
                    <span id="btnCerrarModalPedido" class="close">&times;</span>
                    <h2>Agregar Pedido</h2>
                    <form id="formularioPedido">
                        <label for="usuario">Usuario:</label>
                        <select id="usuario" name="usuario" required>
                            <!-- Opciones dinámicas cargadas desde la base de datos -->
                        </select>

                        <label for="fecha_pedido">Fecha del Pedido:</label>
                        <input type="datetime-local" id="fecha_pedido" required>

                        <label for="desc_pedido">Descripción:</label>
                        <input type="text" id="desc_pedido" required>
                        <div id="productosContainer">
                            <!-- Productos dinámicos -->
                        </div>

                        <button type="submit">Guardar Pedido</button>
                    </form>
                </div>
            </div>

            <!-- Modal sin Bootstrap -->
            <div class="modal" id="modal-editar-producto">
                <div class="modal-content">
                    <form id="form-editar-producto">
                        <div class="modal-header">
                            <h5 class="modal-title">Editar Producto</h5>
                            <button type="button" class="close" onclick="cerrarModal()"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="id_producto" name="id_producto">
                            <div class="mb-3">
                                <label for="nombre_producto" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre_producto" name="nombre_producto">
                            </div>
                            <div class="mb-3">
                                <label for="descripcion_producto" class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcion_producto" name="descripcion_producto"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="precio_producto" class="form-label">Precio</label>
                                <input type="number" class="form-control" id="precio_producto" name="precio_producto" step="0.01">
                            </div>
                            <div class="mb-3">
                                <label for="id_categoria" class="form-label">Categoría</label>
                                <select class="form-control" id="id_categoria" name="id_categoria">
                                    <!-- Opciones de categorías -->
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="stock" class="form-label">Stock</label>
                                <input type="number" class="form-control" id="stock" name="stock">
                            </div>
                            <div class="mb-3">
                                <label for="imagen" class="form-label">Imagen</label>
                                <input type="file" class="form-control" id="imagen" name="imagen">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                            <button type="button" class="btn btn-secondary" onclick="cerrarModal()">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>

        </main>
    </div>

    <script src="../../public/js/DasBoard.js"></script>
    <script src="../../public/js/Pedidos.js"></script>
    <script src="../../public/js/Usuarios.js"></script>
    <script src="../../public/js/ProductosAdm.js"></script>
    <script src="../../public/js/bootstrap_js/bootstrap.bundle.min.js"></script>
</body>

</html>