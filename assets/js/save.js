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
