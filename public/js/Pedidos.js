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
            const response = await fetch(this.baseURL + '?action=fetch');
            const result = await response.json();
            if (result.success) {
                return result.pedidos;
            } else {
                console.error('Error al obtener los pedidos:', result.message);
                return [];
            }
        } catch (error) {
            console.error('Error en la solicitud al obtener pedidos:', error);
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
            if (!result.success) {
                console.error('Error al actualizar el estado:', result.message);
            }
            return result.success;
        } catch (error) {
            console.error('Error en la solicitud al actualizar estado:', error);
            return false;
        }
    }
    
    
}

class ElementFactory {
    static createTableRow(pedido) {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${pedido.id_pedido}</td>
            <td>${pedido.usuario || 'Sin asignar'}</td>
            <td>${pedido.correo || 'Sin asignar'}</td>
            <td>${pedido.nombre_producto || 'Sin productos asignados'}</td>
            <td>${pedido.desc_pedido || 'Sin descripción'}</td>
            <td>
                <select data-id="${pedido.id_pedido}" class="estado-select">
                    <option value="Pendiente" ${pedido.estado_material === 'Pendiente' ? 'selected' : ''}>Pendiente</option>
                    <option value="En proceso" ${pedido.estado_material === 'En proceso' ? 'selected' : ''}>En proceso</option>
                    <option value="Listo para entrega" ${pedido.estado_material === 'Listo para entrega' ? 'selected' : ''}>Listo para entrega</option>
                    <option value="Entregado" ${pedido.estado_material === 'Entregado' ? 'selected' : ''}>Entregado</option>
                </select>
            </td>
            <td>${pedido.fecha_pedido || 'Sin fecha registrada'}</td>
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

    tbody.addEventListener('change', async (event) => {
        if (event.target.classList.contains('estado-select')) {
            const idPedido = event.target.dataset.id;
            const nuevoEstado = event.target.value;
    
            try {
                const response = await api.actualizarEstado(idPedido, nuevoEstado);
    
                if (response.success) {
                    alert(`No se pudo actualizar el estado. Detalle: ${response.message}`);
                    // alert(`Estado del pedido ${idPedido} actualizado a ${nuevoEstado}`);
                } else {
                    alert(`Estado del pedido ${idPedido} actualizado a ${nuevoEstado}`);
                    // alert(`No se pudo actualizar el estado. Detalle: ${response.message}`);
                }
            } catch (error) {
                console.error('Error en la solicitud:', error);
                alert('Error al procesar la solicitud. Inténtalo nuevamente.');
            }
    
            // Actualizar la tabla después de la operación
            cargarPedidos();
        }
    });

    

    // Cargar pedidos al inicio
    async function cargarPedidos() {
        const pedidos = await api.fetchPedidos();
        pedidoObserver.notify(pedidos); // Notificar observadores
    }

    cargarPedidos();
});
