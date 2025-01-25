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
    fila.setAttribute('data-id', producto.id);

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

    // Columna de stock
    const colStock = document.createElement("td");
    colStock.textContent = producto.stock;
    fila.appendChild(colStock);

    // Columna de acciones (editar y eliminar)
    const colAcciones = document.createElement("td");

    const btnEditar = document.createElement("button");
    btnEditar.textContent = "Editar";
    btnEditar.classList.add("btn-editar");
    btnEditar.dataset.idProducto = producto.id; // Asignar el ID al atributo data
    btnEditar.addEventListener('click', () => editarProducto(producto.id));
    colAcciones.appendChild(btnEditar);

    const btnEliminar = document.createElement("button");
    btnEliminar.textContent = "Eliminar";
    btnEliminar.classList.add("btn-eliminar");
    btnEliminar.dataset.idProducto = producto.id; // Asignar el ID al atributo data
    btnEliminar.addEventListener('click', () => eliminarProducto(producto.id));
    colAcciones.appendChild(btnEliminar);

    fila.appendChild(colAcciones);

    return fila;
}

// Función para eliminar el producto
// function eliminarProducto(idProducto) {
//     // Aquí iría la lógica para eliminar el producto, por ejemplo:
//     alert(`Eliminando producto con ID: ${idProducto}`);
//     console.log(`Eliminando producto con ID: ${idProducto}`);
//     // Llamada a una API o acción de backend para eliminarlo
//     document.addEventListener("click", function (event) {
//         if (event.target.classList.contains("btn-eliminar")) {
//             const idProducto = event.target.dataset.idProducto;
//             if (confirm("¿Estás seguro de que deseas desactivar este producto?")) {
//                 eliminarProducto(idProducto);
//             }
//         }
//     });
// }

function eliminarProducto(idProducto) {
    fetch('../../src/Controller/ElminarProductosController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            id_producto: idProducto,
        }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message); // Muestra el mensaje de éxito
            // Elimina la fila correspondiente del producto en la tabla
            const fila = document.querySelector(`tr[data-id="${idProducto}"]`);
            if (fila) {
                fila.remove();
            }
        } else {
            alert(`Error: ${data.message}`);
        }
    })
    .catch(error => {
        console.error('Error al procesar la solicitud:', error);
        alert('Error de conexión con el servidor.');
    });
}
// Función para editar el producto
function editarProducto(idProducto) {
    // Aquí iría la lógica para editar el producto, por ejemplo:
    alert(`Editando producto con ID: ${idProducto}`);
    console.log(`Editando producto con ID: ${idProducto}`);
    // Llamada a una página de edición o abrir un formulario
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

document.addEventListener('click', (event) => {
    // Botón de editar
    if (event.target.classList.contains('btn-editar')) {
        const idProducto = event.target.dataset.idProducto;
        abrirModalEditarProducto(idProducto);
    }

    // // Botón de eliminar
    // if (event.target.classList.contains('btn-eliminar')) {
    //     const idProducto = event.target.dataset.idProducto;
    //     eliminarProducto(idProducto);
    // }
});

// Abrir modal para editar producto
async function abrirModalEditarProducto(idProducto) {
    try {
        const response = await fetch(`../../src/Controller/ProductosController.php?action=editar=${idProducto}`);
        const producto = await response.json();

        if (producto) {
            // Rellenar el formulario con los datos del producto
            document.getElementById('id_producto').value = producto.id_producto;
            document.getElementById('nombre_producto').value = producto.nombre_producto;
            document.getElementById('descripcion_producto').value = producto.descripcion_producto;
            document.getElementById('precio_producto').value = producto.precio_producto;
            document.getElementById('id_categoria').value = producto.id_categoria;
            document.getElementById('stock').value = producto.stock;

            // Mostrar el modal
            document.getElementById('modal-editar-producto').style.display = 'block';
        } else {
            alert('Error al obtener los datos del producto.');
        }
    } catch (error) {
        console.error('Error al abrir el modal:', error);
    }
}

// Función para cerrar el modal
function cerrarModal() {
    document.getElementById('modal-editar-producto').style.display = 'none';
}

// Previene el envío del formulario y realiza la acción que desees al guardar cambios
document.getElementById('form-editar-producto').addEventListener('submit', function (event) {
    event.preventDefault();
    // Aquí puedes agregar la lógica para guardar los cambios
    alert('Cambios guardados.');
    cerrarModal();
});


// Método para eliminar un producto de manera lógica
// function eliminarProducto(idProducto) {
//     fetch("../../src/Controller/ProductosController.php", {
//         method: "POST",
//         headers: {
//             "Content-Type": "application/json",
//         },
//         body: JSON.stringify({ action: "eliminar_logico", id_producto: idProducto }),
//     })
//         .then((response) => {
//             if (!response.ok) {
//                 throw new Error("Error en la respuesta del servidor.");
//             }
//             return response.json(); // Convertir la respuesta a JSON
//         })
//         .then((data) => {
//             if (data.success) {
//                 const fila = document.querySelector(`tr[data-id-producto='${idProducto}']`);
//                 if (fila) fila.remove(); // Eliminar la fila de la tabla si existe
//                 alert("Producto desactivado correctamente.");
//             } else {
//                 alert("Error al desactivar el producto: " + data.message);
//             }
//         })
//         .catch((error) => {
//             console.error("Error al desactivar el producto:", error);
//             alert("Ocurrió un error al intentar desactivar el producto.");
//         });
// }

// const eliminarProducto = async (idProducto) => {
//     try {
//         const response = await fetch('../../src/Controller/ProductosController.php', {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/json',
//             },
//             body: JSON.stringify({
//                 action: 'eliminar_logico',
//                 id_producto: idProducto,
//             }),
//         });

//         const data = await response.json();
//         if (data.success) {
//             alert(data.message);  // Muestra el mensaje correcto
//         } else {
//             alert(`Error: ${data.message}`);
//         }
//     } catch (error) {
//         console.error('Error al eliminar producto:', error);
//         alert('No se pudo procesar la solicitud.');
//     }
// };

// Asignar eventos a los botones de eliminar (manejo dinámico)


