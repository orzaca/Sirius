// LLAMA A guiones
document.addEventListener('DOMContentLoaded', function() {
    const checklistLink = document.getElementById('load-guion');
    const checklistSection = document.getElementById('guion-section');

    checklistLink.addEventListener('click', function(event) {
        event.preventDefault(); // Evita la acción por defecto del enlace

        // Oculta el contenido principal
          document.querySelector('.news-section').style.display = 'none';
         document.querySelector('.module-1').style.display = 'none';
           document.querySelector('.module-2').style.display = 'none';
        
        // Muestra la sección de checklist
        checklistSection.style.display = 'block';

        // Carga el contenido de checklist.php
        fetch('/pages/guion/principal.php')
            .then(response => response.text())
            .then(html => {
                checklistSection.innerHTML = html;
            })
            .catch(error => {
                console.error('Error al cargar Principal.php:', error);
            });
    });
});

