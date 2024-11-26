<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Piedra de Agua</title>
    <link rel="stylesheet" href="/public/css/Bootstrap_css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/css/StyleRegistroView.css"> <!-- Enlace al archivo CSS externo -->
</head>

<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="container-register">
        <div class="register-container card">
            <header class="header-img text-center mb-3">
                <img src="./img/FotosProducto/Logo.webp" alt="Logo" class="img-fluid logo">
            </header>
            <h4 class="text-center mb-3">Registro</h4>
            <form action="/src/Controller/RegistroContoller.php" method="POST"> <!-- CREAR UN CONTROLADOR PARA EL REGISTRO DE USUARIOS-->
                <div class="form-row">
                    <div class="form-group mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="dni" class="form-label">DNI</label>
                        <input type="text" class="form-control" id="dni" name="dni" placeholder="DNI" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="correo" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                    </div>
                <button type="submit" class="btn btn-primary w-100">Registrarse</button>
                <a class='cuenta'href="./LoginView.php">Ya tienes una cuenta?</a>
                </div>
            </form>
        </div>
    </div>

    <script src="/public/js/Bootstrap_js/bootstrap.min.js"></script>
</body>

</html>