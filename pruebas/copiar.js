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
