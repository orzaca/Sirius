
        let currentParagraphId = null;

        function copyToClipboard(paragraphId) {
            const paragraphText = document.getElementById(paragraphId).getElementsByTagName('p')[0].innerText;
            navigator.clipboard.writeText(paragraphText).then(() => {
                alert("¡Texto copiado al portapapeles!");
            }).catch(err => {
                console.error('Error al copiar el texto: ', err);
            });
        }
//Abre el modal para modificar guion
        function openModal(paragraphId) {
            currentParagraphId = paragraphId;
            const textElement = document.getElementById('paragraph' + paragraphId).getElementsByTagName('p')[0];
            document.getElementById('modalText').value = textElement.innerText; // Rellena el textarea con el texto actual
            document.getElementById('modal').style.display = "block"; // Muestra el modal
        }

        function closeModal() {
            document.getElementById('modal').style.display = "none"; // Oculta el modal
        }

        function saveText() {
            const newText = document.getElementById('modalText').value;
            const textElement = document.getElementById('paragraph' + currentParagraphId).getElementsByTagName('p')[0];
            textElement.innerText = newText;

            fetch('update_paragraph.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id=' + currentParagraphId + '&content=' + encodeURIComponent(newText)
            })
            .then(response => response.text())
            .then(data => {
                console.log(data); // Para depuración
            })
            .catch(error => console.error('Error:', error));

            closeModal();
        }

       