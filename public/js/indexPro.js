const contenedorTarjetas = document.getElementById("productos-container");

/** Crea las tarjetas de productos teniendo en cuenta la lista en compras.js */
function crearTarjetasProductosInicio(productos){
  productos.forEach(producto => {
    const nuevoMaterial = document.createElement("div");
    nuevoMaterial.classList = "tarjeta-producto"
    nuevoMaterial.innerHTML = `
    <img src="../../src/views/img/images${producto.id}.jpg" alt="Material1">
    <h3>${producto.nombre}</h3>
    <p class="precio">$${producto.precio}</p>
    <button>Agregar al carrito</button>`
    contenedorTarjetas.appendChild(nuevoMaterial);
    nuevoMaterial.getElementsByTagName("button")[0].addEventListener("click",() => agregarAlCarrito(producto))
  });
}
crearTarjetasProductosInicio(materiales);