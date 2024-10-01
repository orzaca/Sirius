// Función para copiar el texto al portapapeles
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

// Función para habilitar la edición del texto
function editText(textId) {
    var textElement = document.getElementById(textId);
    var currentText = textElement.innerText;

    // Crear un campo de entrada y un botón de guardar
    var inputField = document.createElement('input');
    inputField.type = 'text';
    inputField.value = currentText;
    inputField.style.width = '100%'; // Ajusta el ancho según sea necesario

    var saveButton = document.createElement('button');
    saveButton.innerText = 'Guardar';
    saveButton.style.marginTop = '10px';
    saveButton.onclick = function() {
        var updatedText = inputField.value;
        // Actualizar el texto en la página
        textElement.innerText = updatedText;

        // Guardar el texto actualizado en el backend
        saveTextToBackend(textId, updatedText);
    };

    // Reemplazar el contenido del texto con el campo de entrada y el botón
    textElement.innerHTML = '';
    textElement.appendChild(inputField);
    textElement.appendChild(saveButton);
}

// Función para guardar el texto editado en el backend
function saveTextToBackend(textId, updatedText) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'guardar_texto.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    // Enviar el ID del texto y el texto actualizado
    xhr.send('id=' + encodeURIComponent(textId) + '&text=' + encodeURIComponent(updatedText));
    
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            console.log('Texto guardado correctamente');
        } else {
            console.error('Error al guardar el texto:', xhr.statusText);
        }
    };
}
