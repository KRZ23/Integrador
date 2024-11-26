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
        return new Promise((resolve, reject) => {
            // Cargar primero el placeholder
            this.imageElement.src = this.placeholderSrc;

            // Intentar cargar la imagen principal
            const tempImage = new Image();
            tempImage.src = this.src;

            tempImage.onload = () => {
                // Cuando la imagen principal carga exitosamente
                this.imageElement.src = this.src;
                resolve(this.imageElement);
            };

            tempImage.onerror = () => {
                console.error("Error al cargar la imagen:", this.src);
                // Usar placeholder en caso de error
                this.imageElement.src = this.placeholderSrc;
                reject(new Error("No se pudo cargar la imagen principal."));
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
    contenedorProductos.innerHTML = ""; // Limpiar el contenedor

    if (productos.length === 0) {
        // Si no hay productos, mostrar un placeholder
        productos = [ProductoFactory.crearProducto(null)];
    } else {
        // Crear productos reales con la Factory
        productos = productos.map(data => ProductoFactory.crearProducto({
            nombre: data.nombre_producto,
            descripcion: data.descripcion_producto,
            precio: data.precio_producto,
            imagen: data.imagen
        }));
    }

    productos.forEach(producto => {
        const col = document.createElement("div");
        col.classList.add("col");

        const card = document.createElement("div");
        card.classList.add("card", "h-100");

        // Imagen (con Proxy)
        const proxy = new ImagenProxy(producto.imagen, placeholderImagen);
        proxy.load().then(imgElement => {
            imgElement.classList.add("card-img-top");
            imgElement.alt = producto.nombre;

            // Añadir imagen al principio de la tarjeta
            card.insertBefore(imgElement, card.firstChild);
        });

        // Cuerpo de la tarjeta
        const cardBody = document.createElement("div");
        cardBody.classList.add("card-body");

        // Título
        const cardTitle = document.createElement("h5");
        cardTitle.classList.add("card-title");
        cardTitle.textContent = producto.nombre;

        // Descripción
        const cardText = document.createElement("p");
        cardText.classList.add("card-text");
        cardText.textContent = producto.descripcion;

        // Precio
        if (producto.precio) {
            const cardPrice = document.createElement("p");
            cardPrice.classList.add("text-success");
            cardPrice.textContent = `${producto.precio} Soles`;
            cardBody.appendChild(cardPrice);
        }

        // Añadir elementos al cuerpo de la tarjeta
        cardBody.appendChild(cardTitle);
        cardBody.appendChild(cardText);

        // Añadir el cuerpo de la tarjeta a la tarjeta principal
        card.appendChild(cardBody);

        // Botón "Comprar"
        if (producto.nombre !== "Producto no disponible") {
            const btnComprar = document.createElement("a");
            btnComprar.classList.add("btn", "btn-primary", "w-100");
            btnComprar.href = "#";
            btnComprar.textContent = "Comprar";
            card.appendChild(btnComprar);
        }

        // Agregar la tarjeta a la columna
        col.appendChild(card);

        // Agregar la tarjeta al contenedor de productos
        contenedorProductos.appendChild(col);
    });
}

// Llamada a la API
fetch('/src/Controller/ProductosController.php')
    .then(response => response.json())
    .then(data => {
        console.log("Datos de productos:", data); // Verificar datos
        productosObserver.notify(data); // Notificar cambios
        mostrarProductos(data); // Mostrar productos
    })
    .catch(error => {
        console.error('Error al cargar productos:', error);
        productosObserver.notify([]); // Notificar con un placeholder
        mostrarProductos([]); // Mostrar placeholder
    });

