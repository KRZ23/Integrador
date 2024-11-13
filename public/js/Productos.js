class ProductoReal {
    constructor(nombre, descripcion, precio, imagen) {
        this.nombre = nombre;
        this.descripcion = descripcion;
        this.precio = precio;
        this.imagen = imagen;
    }
}

class ProductoPlaceholder {
    constructor() {
        this.nombre = "Producto no disponible";
        this.descripcion = "Actualmente no hay productos disponibles.";
        this.precio = "";
        this.imagen = "/src/views/img/FotosProducto/img.webp";
    }
}

class ProductoFactory {
    static crearProducto(data) {
        if (data) {
            return new ProductoReal(data.nombre, data.descripcion, data.precio, data.imagen);
        } else {
            return new ProductoPlaceholder();
        }
    }
}

class ProductosObserver {
    constructor() {
        this.subscribers = [];
    }

    subscribe(func) {
        this.subscribers.push(func);
    }

    notify(data) {
        this.subscribers.forEach(func => func(data));
    }
}

const productosObserver = new ProductosObserver();

class ImagenProxy {
    constructor(src, placeholderSrc) {
        this.src = src;
        this.placeholderSrc = placeholderSrc;
        this.imageElement = new Image();
    }

    load() {
        return new Promise((resolve) => {
            this.imageElement.src = this.placeholderSrc;
            this.imageElement.onload = () => {
                this.imageElement.src = this.src;
                resolve(this.imageElement);
            };
        });
    }
}
// Contenedor de productos
const placeholderImagen = "/src/views/img/FotosProducto/img.webp";
const contenedorProductos = document.getElementById("productos-container");

if (!contenedorProductos) {
    console.error("Error: No se encontró el contenedor de productos en el DOM.");
}

// Función para mostrar productos
function mostrarProductos(productos) {
    contenedorProductos.innerHTML = ""; // Limpiar contenedor

    if (productos.length === 0) {
        // Mostrar un placeholder si no hay productos
        productos = [{
            nombre: "Producto no disponible",
            descripcion: "Actualmente no hay productos disponibles.",
            precio: "",
            imagen: placeholderImagen
        }];
    }

    productos.forEach(data => {
        const col = document.createElement("div");
        col.classList.add("col");

        const card = document.createElement("div");
        card.classList.add("card", "h-100");

        // Imagen
        const img = document.createElement("img");
        img.src = data.imagen || placeholderImagen;
        img.alt = data.nombre;
        img.classList.add("card-img-top");
        card.appendChild(img);

        // Cuerpo de la tarjeta
        const cardBody = document.createElement("div");
        cardBody.classList.add("card-body");

        // Título
        const cardTitle = document.createElement("h5");
        cardTitle.classList.add("card-title");
        cardTitle.textContent = data.nombre;

        // Descripción
        const cardText = document.createElement("p");
        cardText.classList.add("card-text");
        cardText.textContent = data.descripcion;

        // Precio (solo si existe)
        if (data.precio) {
            const cardPrice = document.createElement("p");
            cardPrice.classList.add("text-success");
            cardPrice.textContent = `${data.precio} Soles`;
            cardBody.appendChild(cardPrice);
        }

        // Añadir título y descripción al cuerpo de la tarjeta
        cardBody.appendChild(cardTitle);
        cardBody.appendChild(cardText);

        // Añadir el cuerpo de la tarjeta a la tarjeta principal
        card.appendChild(cardBody);

        // Mostrar botón "Comprar" solo si hay productos disponibles (no es un placeholder)
        if (data.nombre !== "Producto no disponible") {
            const btnComprar = document.createElement("a");
            btnComprar.classList.add("btn", "btn-primary", "w-100");
            btnComprar.href = "#";
            btnComprar.textContent = "Comprar";
            card.appendChild(btnComprar); // Añadir botón al final
        }

        // Agregar la tarjeta a la columna
        col.appendChild(card);

        // Agregar la tarjeta al contenedor de productos
        contenedorProductos.appendChild(col);
    });
}

// Llamada a la API para cargar los productos desde el backend
fetch('/src/Controller/ProductosController.php')
    .then(response => response.json())
    .then(data => {
        console.log("Datos de productos:", data); // Verificar datos
        mostrarProductos(data);
    })
    .catch(error => {
        console.error('Error al cargar productos:', error);
        mostrarProductos([]); // Mostrar placeholder en caso de error
    });
