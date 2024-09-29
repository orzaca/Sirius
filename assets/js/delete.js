function deleteParagraph(paragraphId) {
    if (confirm("¿Estás seguro de que quieres eliminar este párrafo?")) {
        fetch('delete_paragraph.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'id=' + paragraphId
        })
        .then(response => response.text())
        .then(data => {
            console.log(data); // Para depuración
            document.getElementById('paragraph' + paragraphId).remove(); // Elimina el párrafo de la interfaz
        })
        .catch(error => console.error('Error:', error));
    }
}
