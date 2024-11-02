// Array de productos con datos
const productos = [
    {
        nombre: "Producto 1",
        descripcion: "",
        precio: 29.99,
        imagen: "" ,
    },
    {
        nombre: "Producto 2",
        descripcion: "Descripción del producto 2.",
        precio: 39.99,
        imagen: "" 
    },
    {
        nombre: "Producto 3",
        descripcion: "Descripción del producto 3.",
        precio: 19.99,
        imagen: "/public/img/producto3.jpg"
    },
    {
        nombre: "Producto 4",
        descripcion: "Descripción del producto 4.",
        precio: 24.99,
        imagen: "" 
    }
]; //Agregar diversa cantidad de productos


const placeholderImagen = "/src/views/img/"; //crear una imagen para que sirva como placeholder

// Selecciona el contenedor de productos
const contenedorProductos = document.getElementById("productos-container");

// Función para mostrar los productos en el contenedor
function mostrarProductos() {
    productos.forEach(producto => {
        // Usar la imagen del producto o el "placeholder" si la imagen no existe
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
        cardText.textContent = producto.descripcion;

        const cardPrice = document.createElement("p");
        cardPrice.classList.add("text-success");
        cardPrice.textContent = ` $${producto.precio} `; 

        const btnComprar = document.createElement("a");
        btnComprar.classList.add("btn", "btn-primary", "w-100");
        btnComprar.href = "#";
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

// Llama a la función para mostrar los productos
mostrarProductos();