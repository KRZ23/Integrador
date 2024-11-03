
const placeholderImagen = "/src/views/img/img.webp"; // Cambia esta ruta a la imagen que deseas usar como placeholder

// Contenedor de productos
const contenedorProductos = document.getElementById("productos-container");

// Función para mostrar productos
function mostrarProductos(productos) {
    // Si no hay productos, mostrar un mensaje de placeholder
    if (productos.length === 0) {
        mostrarPlaceholder();
        return;
    }

    // Si hay productos, creamos las tarjetas
    productos.forEach(producto => {

        const imgSrc = producto.imagen || placeholderImagen;

        // Crear elementos de la tarjeta
        const col = document.createElement("div");
        col.classList.add("col");

        const card = document.createElement("div");
        card.classList.add("card", "h-100");

        const img = document.createElement("img");
        img.src = imgSrc;
        img.alt = producto.nombre;
        img.classList.add("card-img-top");

        const cardBody = document.createElement("div");
        cardBody.classList.add("card-body");

        const cardTitle = document.createElement("h5");
        cardTitle.classList.add("card-title");
        cardTitle.textContent = producto.nombre;

        const cardText = document.createElement("p");
        cardText.classList.add("card-text");
        cardText.textContent = producto.descripcion || "Descripción no disponible.";

        const cardPrice = document.createElement("p");
        cardPrice.classList.add("text-success");
        cardPrice.textContent = ` ${producto.precio} Soles`;

        const btnComprar = document.createElement("a");
        btnComprar.classList.add("btn", "btn-primary", "w-100");
        btnComprar.href = "#"; // Crear una vista para la compra
        btnComprar.textContent = "Comprar";

        // Construir la estructura de la tarjeta
        cardBody.appendChild(cardTitle);
        cardBody.appendChild(cardText);
        cardBody.appendChild(cardPrice);
        cardBody.appendChild(btnComprar);
        card.appendChild(img);
        card.appendChild(cardBody);
        col.appendChild(card);

        // Agregar la tarjeta al contenedor
        contenedorProductos.appendChild(col);
    });
}

// Función para mostrar el placeholder cuando no hay productos
function mostrarPlaceholder() {
    const col = document.createElement("div");
    col.classList.add("col");

    const card = document.createElement("div");
    card.classList.add("card", "h-100", "text-center");

    const img = document.createElement("img");
    img.src = placeholderImagen;
    img.alt = "Imagen no disponible";
    img.classList.add("card-img-top");

    const cardBody = document.createElement("div");
    cardBody.classList.add("card-body");

    const cardTitle = document.createElement("h5");
    cardTitle.classList.add("card-title");
    cardTitle.textContent = "Producto no disponible";

    const cardText = document.createElement("p");
    cardText.classList.add("card-text");
    cardText.textContent = "Actualmente no hay productos disponibles.";
    
    cardBody.appendChild(cardTitle);
    cardBody.appendChild(cardText);
    card.appendChild(img);
    card.appendChild(cardBody);
    col.appendChild(card);

    // Agregar el placeholder al contenedor
    contenedorProductos.appendChild(col);
}

// Llamada a la API para cargar los productos desde el backend
fetch('/src/Controller/ProductosController.php')
    .then(response => response.json())
    .then(data => {
        // Mostrar los productos si se cargaron correctamente
        mostrarProductos(data);
    })
    .catch(error => {
        console.error('Error al cargar productos:', error);
        // En caso de error, mostrar el placeholder
        mostrarPlaceholder();
    });