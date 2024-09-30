let currentParagraphId;
let currentPage;

// Abre el modal para editar el párrafo
function openModal(paragraphId, page) {
    currentParagraphId = paragraphId;
    currentPage = page;

    const text = document.getElementById('paragraph' + paragraphId).getElementsByTagName('p')[0].innerText;
    document.getElementById('modalText').value = text;
    document.getElementById('modal').style.display = 'block';
}

// Cierra el modal
function closeModal() {
    document.getElementById('modal').style.display = 'none';
}

// Guarda el nuevo texto en la base de datos
function saveText() {
    const newText = document.getElementById('modalText').value;
    const textElement = document.getElementById('paragraph' + currentParagraphId).getElementsByTagName('p')[0];
    textElement.innerText = newText;

    // Realizar la solicitud AJAX para guardar los cambios
    fetch('update_paragraph.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'id=' + currentParagraphId + '&content=' + encodeURIComponent(newText) + '&page=' + currentPage
    })
    .then(response => response.text())
    .then(data => {
        console.log(data); // Para depuración
        alert("Párrafo actualizado para " + currentPage);
    })
    .catch(error => console.error('Error:', error));

    closeModal();
}
