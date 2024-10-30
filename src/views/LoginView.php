<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piedra de agua</title>
    <link rel="stylesheet" href="/public/css/Bootstrap_css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
        rel="stylesheet">
</head>

<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="container-login">
        <!-- Formulario de inicio de sesión -->
        <div class="login-container">
            <header class="header-img text-center mb-4">
                <img src="../img/LogoPiedraDeAgua.webp" alt="" class="img-fluid logo">
            </header>
            <h3 class="text-center mb-4">Iniciar sesión</h3>
            <form action="/src/Controller/AccsesUsers.php" class="login-form">
                <div class="mb-3">
                    <label for="username" class="form-label">Nombre de usuario</label>
                    <input type="text" class="form-control" id="username" name="username"
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
                <div class="text-center mt-2">
                    <button type="submit" class="btn btn-login2 w-100">Ingresar con google</button>
                </div>
                <div class="text-center mt-3">
                    <a href="#" class="text-decoration-none">Olvidé mi contraseña</a>
                </div>
            </form>
        </div>
    </div>
    <script src="/public/js/Bootstrap_js/bootstrap.min.js"></script>
</body>

</html>