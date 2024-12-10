document.getElementById('nav-link').addEventListener('click', () => {
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