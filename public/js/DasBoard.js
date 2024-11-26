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

        // Generar contenido dinámico (si es necesario)
        if (targetId === 'pedidos') {
            cargarPedidos(); // Solo se ejecuta al ir a la sección Pedidos
        }
    });
});



// Botón de logout
document.getElementById('logout-btn').addEventListener('click', () => {
    alert("Cerrando sesión...");
});

// Ejemplo de añadir producto (provisional)
document.getElementById('add-product-btn').addEventListener('click', () => {
    alert("Abrir modal para añadir producto.");
});

// Generar reporte (provisional)
document.getElementById('generate-report-btn').addEventListener('click', () => {
    alert("Generando reporte...");
});


//Modal
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

    // Enviar el formulario
        formPedido.addEventListener('submit', async (e) => {
            e.preventDefault();

            // Capturar los datos del formulario
            const formData = new FormData(formPedido);
            const pedidoData = Object.fromEntries(formData);

            try {
                // Enviar los datos al servidor
                const response = await fetch('../../src/Controller/PedidosController.php?action=insertarPedido', {
                    method: 'POST',
                    body: JSON.stringify(pedidoData),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });

                const result = await response.json();

                if (result.success) {
                    alert('Pedido agregado exitosamente.');
                    body.classList.remove('modal-open');
                    modal.close();
                    formPedido.reset();
                    // Opcional: Recargar la lista de pedidos
                } else {
                    alert(`Error: ${result.message}`);
                }
            } catch (error) {
                console.error('Error al guardar el pedido:', error);
                alert('Hubo un problema al guardar el pedido.');
            }
        });
    });
