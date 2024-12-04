// Navegación entre secciones
document.querySelectorAll('.sidebar a').forEach(link => {
    link.addEventListener('click', (e) => {
        e.preventDefault();

        // Remover clase activa de todas las secciones y links
        document.querySelectorAll('.section').forEach(section => section.classList.remove('active'));
        document.querySelectorAll('.sidebar a').forEach(a => a.classList.remove('active'));

        // Activar la sección y el link seleccionados
        const targetId = link.getAttribute('href').slice(1);
        document.getElementById(targetId).classList.add('active');
        link.classList.add('active');
    });
});



// Botón de logout
document.getElementById('logout-btn').addEventListener('click', () => {
    alert("Cerrando sesión...");
});

// Generar reporte (provisional)
document.getElementById('generate-report-btn').addEventListener('click', () => {
    alert("Generando reporte...");
});


document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('modalFormulario');
    const abrirModalBtn = document.getElementById('abrirModal');
    const cerrarModalBtn = document.getElementById('cerrarModal');
    const body = document.body;

    // Abrir el modal con blur
    abrirModalBtn.addEventListener('click', () => {
        body.classList.add('modal-open');
        modal.showModal(); // Mostrar el modal
    });

    // Cerrar el modal y quitar el blur
    cerrarModalBtn.addEventListener('click', () => {
        body.classList.remove('modal-open');
        modal.close(); // Cerrar el modal
    });

    // async function cargarProductos() {
    //     try {
    //         const response = await fetch("ProductosController.php");
    //         if (!response.ok) {
    //             throw new Error("Error al obtener los productos.");
    //         }
    //         const productos = await response.json();

    //         // Llenar el select con los productos
    //         productosSelect.innerHTML = "<option value=''>Selecciona un producto</option>";
    //         productos.forEach(producto => {
    //             const option = document.createElement("option");
    //             option.value = producto.id_producto;
    //             option.textContent = producto.nombre_producto;
    //             productosSelect.appendChild(option);
    //         });
    //     } catch (error) {
    //         console.error(error);
    //         alert("No se pudieron cargar los productos.");
    //     }
    // }

    // // Función para cargar detalles del producto seleccionado
    // async function cargarDetalleProducto(idProducto) {
    //     try {
    //         const response = await fetch(`../../src/Controller/ProductosController.php?id_producto=${idProducto}`);
    //         if (!response.ok) {
    //             throw new Error("Error al obtener el detalle del producto.");
    //         }
    //         const producto = await response.json();
    //         productoDetalle.innerHTML = `
    //             <h2>Detalles del Producto</h2>
    //             <p><strong>Nombre:</strong> ${producto.nombre_producto}</p>
    //             <p><strong>Descripción:</strong> ${producto.descripcion_producto}</p>
    //             <p><strong>Precio:</strong> $${producto.precio_producto}</p>
    //         `;
    //     } catch (error) {
    //         console.error(error);
    //         productoDetalle.innerHTML = "<p>Error al cargar los detalles del producto.</p>";
    //     }
    // }

    // // Event listener para el cambio en el select
    // productosSelect.addEventListener("change", (event) => {
    //     const idProducto = event.target.value;
    //     if (idProducto) {
    //         cargarDetalleProducto(idProducto);
    //     } else {
    //         productoDetalle.innerHTML = "";
    //     }
    // });

    // // Cargar los productos al cargar la página
    // cargarProductos();

    document.addEventListener("DOMContentLoaded", () => {
        const productosLista = document.getElementById("productos-lista");
    
        // Función para cargar los productos
        async function cargarProductos() {
            try {
                const response = await fetch("../../src/Controller/ProductosController.php");
                if (!response.ok) {
                    throw new Error("Error al obtener los productos.");
                }
    
                const productos = await response.json();
    
                // Llenar la lista con los productos
                productos.forEach(producto => {
                    const listItem = document.createElement("li");
                    listItem.textContent = `${producto.nombre_producto} - $${producto.precio_producto}`;
                    productosLista.appendChild(listItem);
                });
            } catch (error) {
                console.error(error);
                productosLista.innerHTML = "<li>Error al cargar los productos.</li>";
            }
        }
    
        // Llamar a la función para cargar los productos
        cargarProductos();
    });
    
});