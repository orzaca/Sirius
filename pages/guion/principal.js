
        function loadContent(url) {
            // Remover la clase activa de todas las pestañas
            var tabs = document.querySelectorAll('.tab');
            tabs.forEach(function(tab) {
                tab.classList.remove('active');
            });

            // Activar la pestaña seleccionada
            var activeTab = document.querySelector('.tab[onclick="loadContent(\'' + url + '\')"]');
            activeTab.classList.add('active');

            // Realizar la solicitud AJAX para cargar el contenido
            var xhr = new XMLHttpRequest();
            xhr.open('GET', url, true);
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 400) {
                    // Actualizar el contenedor de contenido dinámico
                    document.getElementById('dynamic-content').innerHTML = xhr.responseText;
                } else {
                    document.getElementById('dynamic-content').innerHTML = 'Error al cargar el contenido.';
                }
            };
            xhr.onerror = function() {
                document.getElementById('dynamic-content').innerHTML = 'Error de red.';
            };
            xhr.send();
        }

        // Cargar el contenido inicial de la pestaña activa por defecto
        document.addEventListener('DOMContentLoaded', function() {
            loadContent('<?php echo $urls[0]; ?>');
        });

        // Event delegation para manejar los clics del botón en contenido dinámico
        document.addEventListener('click', function(event) {
            if (event.target.matches('.btn')) {
                copyToClipboard();
            }
        });
