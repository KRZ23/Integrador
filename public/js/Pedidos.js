// Singleton para gestionar la instancia del API
class PedidoAPI {
    static instance;

    constructor(baseURL) {
        if (PedidoAPI.instance) return PedidoAPI.instance;
        this.baseURL = baseURL;
        PedidoAPI.instance = this;
    }

    async fetchPedidos() {
        try {
            const response = await fetch(`${this.baseURL}?action=fetch`);
            if (!response.ok) throw new Error('Error al obtener los pedidos');
            const data = await response.json();
            return data.data || [];
        } catch (error) {
            console.error(error);
            return [];
        }
    }

    async actualizarEstado(idPedido, nuevoEstado) {
        try {
            const response = await fetch(this.baseURL, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ idPedido, nuevoEstado }),
            });
            const result = await response.json();
            return result.success;
        } catch (error) {
            console.error('Error al actualizar el estado:', error);
            return false;
        }
    }
}

// Factory para crear elementos HTML dinámicos
class ElementFactory {
    static createTableRow(pedido) {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${pedido.id_pedido}</td>
            <td>${pedido.nombre_material || 'Sin asignar'}</td>
            <td>
                <select data-id="${pedido.id_pedido}" class="estado-select">
                    <option value="Pendiente" ${pedido.estado_material === 'Pendiente' ? 'selected' : ''}>Pendiente</option>
                    <option value="En proceso" ${pedido.estado_material === 'En proceso' ? 'selected' : ''}>En proceso</option>
                    <option value="Listo para entrega" ${pedido.estado_material === 'Listo para entrega' ? 'selected' : ''}>Listo para entrega</option>
                    <option value="Entregado" ${pedido.estado_material === 'Entregado' ? 'selected' : ''}>Entregado</option>
                </select>
            </td>
            <td>${pedido.desc_pedido}</td>
            <td>${pedido.nombre_usuario} ${pedido.apellido_usuario}</td>
            <td>${pedido.correo_usuario}</td>
        `;
        return tr;
    }
}

// Observer para manejar actualizaciones dinámicas en la vista
class PedidoObserver {
    constructor() {
        this.observers = [];
    }

    subscribe(callback) {
        this.observers.push(callback);
    }

    notify(data) {
        this.observers.forEach((callback) => callback(data));
    }
}

// Gestor principal
document.addEventListener('DOMContentLoaded', () => {
    const api = new PedidoAPI('../../src/Controller/PedidosController.php');
    const pedidoObserver = new PedidoObserver();
    const tbody = document.getElementById('pedidos-tbody');

    // Actualizar la tabla de pedidos
    pedidoObserver.subscribe((pedidos) => {
        tbody.innerHTML = ''; // Limpiar tabla
        pedidos.forEach((pedido) => {
            const row = ElementFactory.createTableRow(pedido);
            tbody.appendChild(row);
        });
    });

    // Manejo del cambio de estado
    tbody.addEventListener('change', async (event) => {
        if (event.target.classList.contains('estado-select')) {
            const idPedido = event.target.dataset.id;
            const nuevoEstado = event.target.value;

            const exito = await api.actualizarEstado(idPedido, nuevoEstado);
            if (!exito) {
                alert('Error al actualizar el estado. Inténtalo de nuevo.');
                return;
            }
            alert(`Estado del pedido ${idPedido} actualizado a ${nuevoEstado}`);
            cargarPedidos(); // Recargar pedidos
        }
    });

    // Cargar pedidos al inicio
    async function cargarPedidos() {
        const pedidos = await api.fetchPedidos();
        pedidoObserver.notify(pedidos); // Notificar observadores
    }

    cargarPedidos();
});
