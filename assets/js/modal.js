function openModal(paragraphId) {
    currentParagraphId = paragraphId;
    const textElement = document.getElementById('paragraph' + paragraphId).getElementsByTagName('p')[0];
    document.getElementById('modalText').value = textElement.innerText; // Rellena el textarea con el texto actual
    document.getElementById('modal').style.display = "block"; // Muestra el modal
}

function closeModal() {
    document.getElementById('modal').style.display = "none"; // Oculta el modal
}
