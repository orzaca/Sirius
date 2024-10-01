function enableEditing(textId) {
    const textElement = document.getElementById(textId);
    const originalValue = textElement.value;

    textElement.removeAttribute('readonly');
    textElement.focus();

    textElement.addEventListener('blur', () => {
        const newValue = textElement.value;
        if (newValue !== originalValue) {
            updateTextInDatabase(textId, newValue);
        }
        textElement.setAttribute('readonly', 'readonly');
    });
}

function updateTextInDatabase(textId, newValue) {
    const xhr = new XMLHttpRequest();
    const formData = new FormData();
    formData.append('textId', textId);
    formData.append('newValue', newValue);

    xhr.open('POST', 'update_text.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            const notificationId = textId.replace('text-to-copy', 'edit-notification');
            document.getElementById(notificationId).style.display = 'block';
            setTimeout(() => {
                document.getElementById(notificationId).style.display = 'none';
            }, 2000);
        } else {
            console.error('Error al actualizar el texto:', xhr.statusText);
        }
    };
    xhr.send(formData);
}
