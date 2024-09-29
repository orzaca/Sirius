// LLAMA A guiones y checklist
document.addEventListener('DOMContentLoaded', function() {
    const guionLink = document.getElementById('load-guion');
    const checklistLink = document.getElementById('load-checklist'); // Asegúrate de tener este enlace
    const guionSection = document.getElementById('guion-section');
    const checklistSection = document.getElementById('checklist-section');

    // Manejador de eventos para el enlace de Guion
    guionLink.addEventListener('click', function(event) {
        event.preventDefault(); // Evita la acción por defecto del enlace

        // Oculta el contenido principal
        document.querySelector('.news-section').style.display = 'none';
        document.querySelector('.module-1').style.display = 'none';
        document.querySelector('.module-2').style.display = 'none';
         document.querySelector('.noticias').style.display = 'none';
         document.querySelector('.module-3').style.display = 'none';
        
        // Muestra la sección de guiones
        guionSection.style.display = 'block';
        checklistSection.style.display = 'none'; // Asegúrate de ocultar la sección de checklist

        // Carga el contenido de guion
        fetch('/pages/guion/principal.php')
            .then(response => response.text())
            .then(html => {
                guionSection.innerHTML = html;
            })
            .catch(error => {
                console.error('Error al cargar Principal.php:', error);
            });
    });

    // Manejador de eventos para el enlace de Checklist
    checklistLink.addEventListener('click', function(event) {
        event.preventDefault(); // Evita la acción por defecto del enlace

        // Oculta el contenido principal
        document.querySelector('.news-section').style.display = 'none';
        document.querySelector('.module-1').style.display = 'none';
        document.querySelector('.module-2').style.display = 'none';
         document.querySelector('.noticias').style.display = 'none';
          document.querySelector('.module-3').style.display = 'none';
        
        // Muestra la sección de checklist
        checklistSection.style.display = 'block';
        guionSection.style.display = 'none'; // Asegúrate de ocultar la sección de guiones

        // Carga el contenido de checklist
        fetch('/pages/Inicio_checklist.php') // Asegúrate de que esta ruta sea correcta
            .then(response => response.text())
            .then(html => {
                checklistSection.innerHTML = html;
            })
            .catch(error => {
                console.error('Error al cargar Checklist.php:', error);
            });
    });
});
