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

    document.getElementById("form-agregar-producto").addEventListener("submit", async (e) => {
        e.preventDefault(); // Evitar recargar la página
    
        const nombre = document.getElementById("nombre").value;
        const descripcion = document.getElementById("descripcion").value;
        const precio = document.getElementById("precio").value;
        const imagen = document.getElementById("imagen").value;
        const categoria = document.getElementById("categoria").value;
        const stock = document.getElementById("stock").value;
    
        const producto = { nombre, descripcion, precio, imagen, categoria, stock };
    
        try {
            const response = await fetch('/src/Controller/ProductosController.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(producto),
            });
    
            const resultado = await response.json();
            alert(resultado.mensaje);
        } catch (error) {
            console.error("Error al agregar el producto:", error);
            alert("Hubo un error al agregar el producto.");
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        const modalP = document.getElementById('AgregarProducto');
        const abrirModalProd = document.getElementById('agregarProductos');
        const cerrarModalProd = document.getElementById('cerrarProductos');
        const body = document.body;
    
        // Abrir el modal con blur
        abrirModalProd.addEventListener('click', () => {
            body.classList.add('modal-open');
            modalP.showModal(); // Mostrar el modal
        });
    
        // Cerrar el modal y quitar el blur
        cerrarModalProd.addEventListener('click', () => {
            body.classList.remove('modal-open');
            modalP.close(); // Cerrar el modal
        })
    });