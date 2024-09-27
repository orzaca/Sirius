

// LLAMA A CHECKLIST.PHP
document.addEventListener('DOMContentLoaded', function() {
    const checklistLink = document.getElementById('load-checklist');
    const checklistSection = document.getElementById('checklist-section');

    checklistLink.addEventListener('click', function(event) {
        event.preventDefault(); // Evita la acción por defecto del enlace

        // Oculta el contenido principal
        document.querySelector('.news-section').style.display = 'none';
        
        // Muestra la sección de checklist
        checklistSection.style.display = 'block';

        // Carga el contenido de checklist.php
        fetch('/pages/Inicio_checklist.php')
            .then(response => response.text())
            .then(html => {
                checklistSection.innerHTML = html;
            })
            .catch(error => {
                console.error('Error al cargar Inicio_checklist.php:', error);
            });
    });
});

