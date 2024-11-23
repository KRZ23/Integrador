<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="productos.css">
  <link rel="stylesheet" href="carrito.css">
	<script src="./js/bicicletas.js"></script>
  <script src="./js/cartService.js" defer></script>
	<script src="./js/cart.js" defer></script>
	<title>Bicicletas puntoJson - Carrito</title>
</head>
<body>
  <header>
    <br>
		<nav>
			<a href="index.html">INICIO</a>
			<div>
				<a href="./cart.html" id="cart"><img src="catalogo/shopping-cart.png" alt=""><span id="cuenta-carrito">0</span></a>
			</div>
		</nav>
    <br>
	</header>
	<main>
		<p id="carrito-vacio">Ups! El carrito está vacío, <a href="./index.html">elige algunos productos</a></p>
		<section id="cart-container">
		</section>
  <section id="totales">
    <p>Total unidades: <span id="cantidad">0</span></p>
    <p>Total precio: $<span id="precio">0</span></p>
    <button disabled>Comprar</button>
    <button id="reiniciar">Reiniciar</button>
  </section>
</main>
	<footer>
        <p>"Construyendo confianza, calidad y futuro juntos."</p>
	</footer>
</body>
</html>