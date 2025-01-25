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
    fetch('../../src/Controller/LogOut.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        }
    })
    .then(response => {
        if (response.ok) {
            alert("Sesión cerrada correctamente.");
            window.location.href = '../../index.php'; 
        } else {
            alert("Error al cerrar sesión.");
        }
    })
    .catch(error => console.error('Error:', error));
});


// Generar reporte (provisional)
document.getElementById('generate-report-btn').addEventListener('click', () => {
    alert("Generando reporte...");
});

document.addEventListener("DOMContentLoaded", () => {
    const productosLista = document.getElementById("productos-table-body");

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
                listItem.textContent = `${producto.nombre_producto}`;
                productosLista.appendChild(listItem);
            });
        } catch (error) {
            console.error(error);
            productosLista.innerHTML = "<li> Error al cargar los productos.</li>";
        }
    }
});

const modalPedido = document.getElementById("modalPedido");
const openModalPedidoBtn = document.getElementById("btnAbrirModalPedido");
const closeModalPedidoBtn = document.getElementById("btnCerrarModalPedido");

openModalPedidoBtn.addEventListener("click", () => {
    modalPedido.style.display = "block";
    cargarUsuarios(); // Cargar usuarios en el select
    cargarProductos(); // Cargar productos disponibles
});

closeModalPedidoBtn.addEventListener("click", () => {
    modalPedido.style.display = "none";
});

async function cargarUsuarios() {
    try {
        const response = await fetch("../../src/Controller/CargarUsuarioController.php?action=fetchUsuarios");
        
        if (!response.ok) {
            throw new Error("Error al obtener los usuarios. Código: " + response.status);
        }

        const json = await response.json();

        if (!json.success) {
            throw new Error("Error del servidor: " + json.message);
        }

        const usuarios = json.data; // Extraer usuarios de la respuesta
        const selectUsuario = document.getElementById("usuario");

        selectUsuario.innerHTML = ""; // Limpiar opciones previas

        usuarios.forEach(usuario => {
            const option = document.createElement("option");
            option.value = usuario.id_usuario; // Usar el ID del usuario
            option.textContent = usuario.nombre_usuario; // Mostrar el nombre del usuario
            selectUsuario.appendChild(option);
        });
    } catch (error) {
        console.error("Error al cargar usuarios:", error);
        alert("No se pudieron cargar los usuarios. Por favor, revisa la consola para más detalles.");
    }
}

// Cargar productos dinámicamente
async function cargarProductos() {
    const response = await fetch("/src/Controller/ProductosController.php?action=listar");
    const productos = await response.json();
    const productosContainer = document.getElementById("productosContainer");

    productosContainer.innerHTML = ""; // Limpiar productos previos
    productos.forEach(producto => {
        const productoDiv = document.createElement("div");
        productoDiv.className = "producto-item";

        const checkbox = document.createElement("input");
        checkbox.type = "checkbox";
        checkbox.value = producto.id_Producto;
        checkbox.name = "productos[]";

        const label = document.createElement("label");
        label.textContent = producto.nombre_producto;

        productoDiv.appendChild(checkbox);
        productoDiv.appendChild(label);
        productosContainer.appendChild(productoDiv);
    });
}
document.addEventListener("DOMContentLoaded", cargarUsuarios);

// Enviar formulario
document.querySelector("#formularioPedido").addEventListener("submit", async function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    try {
        const response = await fetch("/src/Controller/PedidosController.php?action=agregar", {
            method: "POST",
            body: formData,
        });

        const data = await response.json();

        if (data.error) {
            alert(`Error: ${data.error}`);
        } else if (data.success) {
            alert(data.success);
            modalPedido.style.display = "none"; // Cerrar modal tras éxito
            this.reset(); // Limpiar formulario
        }
    } catch (error) {
        console.error("Error al agregar el pedido:", error);
        alert("Ocurrió un error al procesar tu solicitud.");
    }
});

async function agregarPedido() {
    const usuario = document.getElementById("usuario").value;
    const producto = document.getElementById("producto").value;
    const fechaPedido = document.getElementById("fecha_pedido").value;
    const cantidad = document.getElementById("cantidad").value;
    const descPedido = document.getElementById("desc_pedido").value;

    const payload = {
        usuario,
        producto,
        fecha_pedido: fechaPedido,
        estado_material: "Pendiente", // Estado predeterminado
        desc_pedido: descPedido,
        cantidad,
    };

    try {
        const response = await fetch("../../src/Controller/PedidoController.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(payload),
        });

        const result = await response.json();

        if (result.success) {
            alert("Pedido agregado correctamente.");
            document.getElementById("form-pedido").reset();
        } else {
            alert("Error al agregar pedido: " + result.message);
        }
    } catch (error) {
        console.error("Error al agregar el pedido:", error);
        alert("Hubo un problema al agregar el pedido. Revisa la consola para más detalles.");
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const btnActualizarProductos = document.getElementById("btnActualizarProductos");

    // Verifica si el botón existe
    if (btnActualizarProductos) {
        btnActualizarProductos.addEventListener("click", function () {
            location.reload(); // Recarga la página
        });
    }
});