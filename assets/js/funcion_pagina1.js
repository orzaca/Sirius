let currentParagraphId = null;

// Copia el texto del párrafo al portapapeles
function copyToClipboard(paragraphId) {
    const paragraphText = document.getElementById(paragraphId).getElementsByTagName('p')[0].innerText;
    navigator.clipboard.writeText(paragraphText).then(() => {
        alert("¡Texto copiado al portapapeles!");
    }).catch(err => {
        console.error('Error al copiar el texto: ', err);
    });
}

// Abre el modal para modificar el guion
function openModal(paragraphId) {
    currentParagraphId = paragraphId;
    const textElement = document.getElementById('paragraph' + paragraphId).getElementsByTagName('p')[0];
    document.getElementById('modalText').value = textElement.innerText; // Rellena el textarea con el texto actual
    document.getElementById('modal').style.display = "block"; // Muestra el modal
}

function closeModal() {
    document.getElementById('modal').style.display = "none"; // Oculta el modal
}

// Guarda el nuevo texto del párrafo en la base de datos y actualiza el contenido en la página
function saveText() {
    const newText = document.getElementById('modalText').value;
    const textElement = document.getElementById('paragraph' + currentParagraphId).getElementsByTagName('p')[0];
    textElement.innerText = newText; // Actualiza el contenido del párrafo visible

    // Envia la actualización al servidor
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
        // Aquí puedes agregar un mensaje al usuario si lo deseas
    })
    .catch(error => console.error('Error:', error));

    closeModal(); // Cierra el modal
}
