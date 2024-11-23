<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PIEDRA DE AGUA</title>
    <link rel="stylesheet" href="/public/css/styles.css">   
</head>

<body>
    <header class="header">
        <div class="menu Contenedor">
            <a href="/index.php" class="logo">Logo</a>
            <input type="checkbox" id="menu"/>

            <label for="menu">
                <img src="./src/views/img/images/menu.png" class="menuIcono" alt="">
            </label>

            <nav class="navbar">
                <ul>
                    <li><a href="#">Inicio</a></li>
                    <li><a href="./src/views/productos.php  ">Productos</a></li>
                    <li><a href="./src/views/ContactoView.php">Contáctanos</a></li>
                    <li><a href="./src/views/LoginView.php">Iniciar Sesion</a></li>
                </ul>
            </nav>
        </div>

        <div class="headerContenido Contenedor">
            <h1>PIEDRA DE AGUA</h1>
            <p>En Piedra de Agua, nos especializamos en la extracción y comercialización de materiales de cimentación como arena de río, confitillo, piedra chancada y mármol. Nuestro enfoque es ofrecer productos de calidad con opciones de entrega flexibles, como delivery o recogida en sucursal, simplificando la experiencia de compra para nuestros clientes en Piura y sus alrededores.</p>
        </div>
    </header>

    <section class="section1">
        <img class="piedraImg" src="./src/views/img/images/bg2.png" alt="">

        <div class="section1Contenido Contenedor"> 
            <h2>NUESTROS PRODUCTOS MÁS VENDIDOS EN ESTA TEMPORADA</h2>
            <p class="txt-p">
                Construye con lo mejor: Confitillo, Piedra Chancada y Arena de Médano. ¡La base sólida para tus proyectos!
            </p>

            <div class="piedraGrupo">
                <div class="piedra1">
                    <img src="./src/views/img/images/c1.png" alt="">
                    <h3>Piedra chancada</h3>
                    <p>
                        Material clave para estructuras fuertes y duraderas. Ideal para cimentaciones, bases y concreto resistente
                    </p>
                </div>

                <div class="piedra1">
                    <img src="./src/views/img/images/c2.png" alt="">
                    <h3>Hormigón</h3>
                    <p>
                        La solución perfecta para obras sólidas y confiables. Calidad garantizada para tus proyectos de construcción
                    </p>
                </div>

                <div class="piedra1">
                    <img src="./src/views/img/images/c3.png" alt="">
                    <h3>Grava</h3>
                    <p>
                        Versátil y resistente, perfecta para acabados, drenajes y mezclas que requieren estabilidad y durabilidad.
                    </p>
                </div>
            </div>
            
            <a href="#" class="boton1">¡COMPRA YA!</a>
        </div>
    </section>
    <main class="productos">
        <div class="productosContenido Contenedor">
            <h2>LOS DIFERENTES TIPOS DE MATERIALES</h2>
            <div class="productosGrupo">
                <div class="productos1">
                    <img src="./src/views/img/images/tipo1.png" alt="">
                    <h3>CIMENTACIÓN Y ESTRUCTURAS</h3>
                </div>

                <div class="productos1">
                    <img src="./src/views/img/images/tipo2.png" alt="">
                    <h3>ACABADOS Y MEZCLAS</h3>
                </div>

                <div class="productos1">
                    <img src="./src/views/img/images/tipo3.png" alt="">
                    <h3>FILTRACIÓN Y SEPARACIÓN</h3>
                </div>
            </div>
            <p>¡Todo lo que necesitas para construir con calidad: bases sólidas, acabados perfectos y soluciones versátiles en un solo lugar!</p>
        </div>
    </main>

    <section class="general">
        <div class="general1">
            <h2>MISIÓN</h2>
            <p>Proveer materiales de construcción de alta calidad que satisfagan las necesidades de nuestros clientes, garantizando un servicio eficiente, accesible y comprometido con el desarrollo sostenible de la industria.</p>
        </div>     
        <div class="general2"></div>
    </section>

    <section class="general">
        <div class="general3"></div>
        <div class="general1">
            <h2>VISIÓN</h2>
            <p>Ser líderes en el suministro de materiales de construcción en la región, reconocidos por nuestra calidad, innovación y responsabilidad social, impulsando el crecimiento de proyectos que transformen nuestro entorno.</p>
        </div>
    </section>

    <section class="blog Contenedor">
        <h2>NUESTRO PERSONAL</h2>
        <p>Conozca al equipo que hace posible nuestro compromiso con la calidad y el servicio. Profesionales dedicados a construir juntos el futuro.</p>

        <div class="blogContenido">
            <div class="blog1">
                <img src="./src/views/img/images/blog1.jpg" alt="">
                <h3>DUEÑO</h3>
                <p>
                    VICENTE HIDELBRANDO RIVERA DELGADO
                </p>
            </div>

            <div class="blog1">
                <img src="./src/views/img/images/blog2.jpg" alt="">
                <h3>ADMINISTRADOR</h3>
                <p>
                    CRISTHOPER SPIER RIVERA SAENZ
                </p>
            </div>

            <div class="blog1">
                <img src="./src/views/img/images/blog3.jpg" alt="">
                <h3>JEFE DE MAQUINARIA PESADA</h3>
                <p>
                    BRYAN JOEL YOVERA VÍLCHEZ
                </p>
            </div>
        </div>

        <a href="/src/views/ContactoView.php" class="boton1">CONTÁCTANOS</a>
    </section>

    <footer class="footer">
        <div class="footerContenido Contenedor">
            <div class="link">
                <h3>NUESTRAS REDES SOCIALES</h3>
                <ul>
                    <li><a href="#">INSTAGRAM</a></li>
                    <li><a href="#">FACEBOOK</a></li>
                </ul>
            </div>
            <p>"Construyendo confianza, calidad y futuro juntos."<p>
        </div>
    </footer>
</body>
</html>