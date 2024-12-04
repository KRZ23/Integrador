// Clase ProductoReal para manejar productos existentes
class ProductoReal {
    constructor(id, nombre, descripcion, precio, imagen, categoria, stock) {
        this.id = id;
        this.nombre = nombre;
        this.descripcion = descripcion;
        this.precio = precio;
        this.imagen = imagen;
        this.categoria = categoria;
        this.stock = stock;
    }
}

// Clase ProductoPlaceholder para manejar productos inexistentes
class ProductoPlaceholder {
    constructor() {
        this.id = "N/A";
        this.nombre = "Producto no disponible";
        this.descripcion = "Actualmente no hay productos disponibles.";
        this.precio = "N/A";
        this.imagen = "/src/views/img/FotosProducto/img.webp";
        this.categoria = "N/A";
        this.stock = 'N/A';
    }
}

// Factory para crear instancias de ProductoReal o ProductoPlaceholder
class ProductoFactory {
    static crearProducto(data) {
        if (data) {
            return new ProductoReal(
                data.id_producto,
                data.nombre_producto,
                data.descripcion_producto,
                data.precio_producto,
                data.imagen,
                data.id_categoria,
                data.stock,
            );
        } else {
            return new ProductoPlaceholder();
        }
    }
}

// Contenedor de la tabla
const contenedorTabla = document.getElementById("productos-table-body");

if (!contenedorTabla) {
    console.error("Error: No se encontró el contenedor de la tabla en el DOM.");
}

// Función para mostrar productos en una tabla
function mostrarProductosEnTabla(productos) {
    contenedorTabla.innerHTML = ""; // Limpiar el contenido previo

    if (productos.length === 0) {
        // Si no hay productos, agregar una fila con un producto placeholder
        const placeholder = ProductoFactory.crearProducto(null);
        const fila = crearFilaProducto(placeholder);
        contenedorTabla.appendChild(fila);
        return;
    }

    // Crear filas para productos reales
    productos.forEach(data => {
        const producto = ProductoFactory.crearProducto(data);
        const fila = crearFilaProducto(producto);
        contenedorTabla.appendChild(fila);
    });
}

// Función para crear una fila de la tabla
function crearFilaProducto(producto) {
    const fila = document.createElement("tr");

    // Columna de imagen
    const colImagen = document.createElement("td");
    const imagen = new Image();
    imagen.src = producto.imagen;
    imagen.alt = producto.nombre;
    imagen.style.maxWidth = "150px"; // Ajustar tamaño de imagen
    imagen.onerror = () => (imagen.src = "/src/views/img/FotosProducto/img.webp"); // Placeholder en caso de error
    colImagen.appendChild(imagen);
    fila.appendChild(colImagen);

    // Columna de ID
    const colId = document.createElement("td");
    colId.textContent = producto.id;
    fila.appendChild(colId);

    // Columna de nombre
    const colNombre = document.createElement("td");
    colNombre.textContent = producto.nombre;
    fila.appendChild(colNombre);

    // Columna de descripción
    const colDescripcion = document.createElement("td");
    colDescripcion.textContent = producto.descripcion;
    fila.appendChild(colDescripcion);

    // Columna de precio
    const colPrecio = document.createElement("td");
    colPrecio.textContent = `${producto.precio} Soles`;
    fila.appendChild(colPrecio);

    // Columna de categoría
    const colCategoria = document.createElement("td");
    colCategoria.textContent = producto.categoria;
    fila.appendChild(colCategoria);

    const colStock = document.createElement("td");
    colStock.textContent = producto.stock;
    fila.appendChild(colStock);

    return fila;
}

// Llamada a la API para cargar los productos
fetch('/src/Controller/ProductosController.php')
    .then(response => response.json())
    .then(data => {
        console.log("Datos de productos:", data); // Verificar los datos recibidos
        mostrarProductosEnTabla(data); // Mostrar los productos en la tabla
    })
    .catch(error => {
        console.error("Error al cargar productos:", error);
        mostrarProductosEnTabla([]); // Mostrar un placeholder si hay error
    });


const modal = document.getElementById("modalProducto");
const openModalBtn = document.getElementById("btnAbrirModal");
const closeModalBtn = document.getElementById("btnCerrarModal");

openModalBtn.addEventListener("click", () => {
    modal.style.display = "block";
});

closeModalBtn.addEventListener("click", () => {
    modal.style.display = "none";
});

// Manejo del envío del formulario
document.querySelector("#formularioProducto").addEventListener("submit", async function (e) {
    e.preventDefault();

    const formData = new FormData(this); // Crear FormData para incluir la imagen

    try {
        const response = await fetch("/src/Controller/ProductosController.php?action=agregar", {
            method: "POST",
            body: formData,
        });

        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

        const data = await response.json();

        if (data.error) {
            alert(`Error: ${data.error}`);
        } else if (data.success) {
            alert(data.success);
            this.reset(); // Limpiar el formulario
            modal.style.display = "none"; // Cerrar modal tras éxito
        }
    } catch (error) {
        console.error("Error al agregar el producto:", error);
        alert("Ocurrió un error al procesar tu solicitud.");
    }
});