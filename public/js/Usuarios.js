// Clase para crear dinámicamente las filas de la tabla de usuarios
class FactoryUsuarios {
    static createTableRowUsuario(usuario) {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${usuario.id_usuario}</td>
            <td>${usuario.nombre_usuario}</td>
            <td>${usuario.dni_usuario}</td>
            <td>${usuario.id_rol}</td>
            <td>${usuario.correo_usuario}</td>
        `;
        return tr;
    }
}

// Clase para interactuar con la API de usuarios
class UsuariosAPI {
    constructor(baseURL) {
        this.baseURL = baseURL;
    }

    async fetchUsuarios() {
        try {
            const response = await fetch(`${this.baseURL}?action=fetchUsuarios`);
            
            if (!response.ok) {
                throw new Error('Error al obtener los usuarios: ' + response.statusText);
            }

            const responseText = await response.text();
            
            if (!responseText) {
                throw new Error('Respuesta vacía del servidor');
            }

            console.log('Respuesta del servidor:', responseText);

            const data = JSON.parse(responseText);

            if (data.success && Array.isArray(data.data)) {
                return data.data; // Retornar los usuarios si es un arreglo
            } else {
                throw new Error('La respuesta no contiene un arreglo de usuarios');
            }
        } catch (error) {
            console.error('Error al obtener los usuarios:', error);
            return []; // Retornar un arreglo vacío en caso de error
        }
    }
}

// Función principal para cargar los usuarios al cargar el DOM
document.addEventListener('DOMContentLoaded', async () => {
    const usuariosAPI = new UsuariosAPI('../../src/Controller/CargarUsuarioController.php');
    const usuarios = await usuariosAPI.fetchUsuarios();

    if (!Array.isArray(usuarios)) {
        console.error('Los datos de usuarios no son un arreglo válido');
        return;
    }

    const tbody = document.getElementById('usuarios-tbody');
    tbody.innerHTML = '';

    // Iterar sobre los usuarios y agregarlos a la tabla
    usuarios.forEach(usuario => {
        const row = FactoryUsuarios.createTableRowUsuario(usuario);
        tbody.appendChild(row);
    });
});

