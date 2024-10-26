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

<body>
    <header>
        <div class="text-center">
            <h1 class="lato-black">Piedra de agua</h1>
        </div>
    </header>
    <div class="container-fluid d-flex justify-content-center align-items-center vh-100">
        <div class="row w-100">
            <!-- Columna con la imagen -->
            <div class="col-md-6 d-none d-md-block">
                <div class="background-illustration"></div>
            </div>
            <!-- Columna con el formulario -->
            <div class="col-md-6 d-flex flex-column justify-content-center align-items-center">
                <div class="login-container">
                    <h3 class="text-center">Iniciar sesión</h3>
                    <form>
                        <div class="mb-3">
                            <label for="username" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="username"
                                placeholder="Ingresa tu nombre de usuario">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">contraseña</label>
                            <input type="password" class="form-control" id="password"
                                placeholder="Ingresa tu contraseña">
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="rememberMe">
                            <label class="form-check-label" for="rememberMe">Recordarme</label>
                        </div>
                        <button type="submit" class="btn btn-login w-100">Ingresar</button>
                        <div class="text-center mt-3">
                            <a href="#" class="text-decoration-none">Olvidé mi contraseña</a>
                        </div>
                        <div class="text-center mt-2">
                            <span>¿Nuevo aquí? <a href="#" class="text-decoration-none">Regístrate</a></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="/public/js/Bootstrap_js/bootstrap.min.js"></script>
</body>

</html>