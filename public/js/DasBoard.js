// Navegación entre secciones
document.querySelectorAll('.sidebar a').forEach(link => {
    link.addEventListener('click', (e) => {
        e.preventDefault();
        document.querySelectorAll('.section').forEach(section => section.classList.remove('active'));
        document.querySelectorAll('.sidebar a').forEach(a => a.classList.remove('active'));

        const targetId = link.getAttribute('href').slice(1);
        document.getElementById(targetId).classList.add('active');
        link.classList.add('active');
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

