<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piedra de Agua</title>
    <link rel="stylesheet" href="../../public/css/Bootstrap_css/bootstrap.min.css">
    <link rel="stylesheet" href="../../public/css/StyleLoginView.css">
    <link rel="shortcut icon" href="img/FotosProducto//Logo.webp">
</head>

<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="container-login">
        <!-- Formulario de inicio de sesión -->
        <div class="login-container">
            <header class="header-img text-center mb-4">
                <img src="./img/FotosProducto/Logo.webp" alt="Chuquinuni" class="img-fluid logo">
            </header>
            <h3 class="text-center mb-4">Iniciar sesión</h3>
            <form action="../Controller/AccsesUsers.php" class="login-form" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Nombre de usuario</label>
                    <input type="email" class="form-control" id="username" name="username"
                        placeholder="Ingresa tu nombre de usuario" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Ingresa tu contraseña" required>
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">Recordarme</label>
                </div>
                <button type="submit" class="btn btn-login w-100">Ingresar</button>
                <div class="text-center mt-3">
                    <a href="#" class="text-decoration-none">Olvidé mi contraseña</a>
                </div>
                <div class="mt-3 text-center">
                    <p>No te encuentras registrado?</p>
                    <a href="./RegisroView.php">Crear cuenta</a>
                </div>
            </form>
        </div>
    </div>
    <script src=""></script>
</body>

</html>