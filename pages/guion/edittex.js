 function editText(textId) {
            var textElement = document.getElementById(textId);
            var newText = prompt("Edita el texto:", textElement.textContent);
            if (newText !== null && newText.trim() !== "") {
                textElement.textContent = newText;  // Actualiza el contenido de texto
            }
        }