
        var currentTextId = ''; // Variable para almacenar el ID del texto que se está editando

        function copyToClipboard(textId, notificationId) {
            var textElement = document.getElementById(textId);
            var text = textElement.innerText;
            var notification = document.getElementById(notificationId);

            navigator.clipboard.writeText(text).then(function() {
                // Mostrar la notificación
                notification.style.display = 'block';

                // Ocultar la notificación después de 2 segundos
                setTimeout(function() {
                    notification.style.display = 'none';
                }, 2000);
            }).catch(function(error) {
                console.error('Error al copiar el texto: ', error);
            });
        }

        // Abre el modal y carga el texto actual
        function openModal(textId) {
            currentTextId = textId; // Almacena el ID del texto actual
            var textElement = document.getElementById(textId);
            var modal = document.getElementById("editModal");
            var input = document.getElementById("modalInput");

            // Carga el texto actual en el campo de entrada
            input.value = textElement.innerText;

            // Muestra el modal
            modal.style.display = "block";
        }

        // Cierra el modal
        function closeModal() {
            var modal = document.getElementById("editModal");
            modal.style.display = "none";
        }

        // Guarda el texto modificado
        function saveText() {
            var input = document.getElementById("modalInput");
            var textElement = document.getElementById(currentTextId);

            // Actualiza el texto
            textElement.innerText = input.value;

            // Cierra el modal
            closeModal();
        }

        // Cierra el modal si se hace clic fuera de él
        window.onclick = function(event) {
            var modal = document.getElementById("editModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }