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

document.addEventListener("DOMContentLoaded", () => {
    const tablaVehiculos = document.querySelector("#Vehiculos-tbody"); // Asegúrate de usar el selector correcto

    const cargarVehiculos = async () => {
        try {
            const response = await fetch("../../src/Controller/VehiculoController.php");
            const result = await response.json(); // Respuesta completa del servidor

            console.log(result); // Verifica que la respuesta tenga la estructura correcta

            if (result.success && Array.isArray(result.data)) {
                const vehiculos = result.data; // Accede al array de vehículos

                tablaVehiculos.innerHTML = ""; // Eliminar contenido previo

                vehiculos.forEach((vehiculo) => {
                    const fila = document.createElement("tr");

                    fila.innerHTML = `
                        <td>${vehiculo.id_vehiculo}</td>
                        <td>${vehiculo.placa}</td>
                        <td>${vehiculo.modelo}</td>
                        <td>${vehiculo.marca}</td>
                        <td>${vehiculo.color}</td>
                    `;

                    tablaVehiculos.appendChild(fila);
                });
            } else {
                console.error("La respuesta no contiene los vehículos:", result);
            }
        } catch (error) {
            console.error("Error al cargar los vehículos:", error);
        }
    };

    cargarVehiculos();
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