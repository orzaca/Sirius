<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba de Copiado</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #E5F5F5;
            color: #0D4D4D;
            margin: 0;
            padding: 20px;
        }
        .btn {
            display: inline-block;
            padding: 10px;
            font-size: 16px;
            color: #FFFFFF;
            background-color: #0D4D4D;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            margin-right: 10px;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #004d4d;
        }
        .copied-notification {
            display: none;
            color: green;
            font-weight: bold;
            margin-top: 10px;
        }
        .text-container {
            max-width: 150px; /* Limita el ancho del contenedor de texto */
            overflow: hidden; /* Oculta el desbordamiento si el texto es demasiado largo */
            margin-bottom: 20px; /* Añade espacio entre los bloques de texto */
        }
        #text-to-copy, #text-to-copy2 {
            font-size: 18px; /* Aumenta el tamaño del texto */
            color: #0D4D4D; /* Color del texto */
            margin: 0;
            padding: 10px;
            background-color: rgba(200, 200, 200, 0.5); /* Fondo gris con opacidad */
            border-radius: 5px; /* Redondea las esquinas del fondo */
        }
        .icon-btn {
            font-size: 20px; /* Ajusta el tamaño del ícono aquí */
        }

        /* Estilos para el modal */
        .modal {
            display: none; /* Oculto por defecto */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Fondo semi-transparente */
        }
        .modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            text-align: center;
        }
        .close {
            color: red;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover {
            color: darkred;
        }
        .modal input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>


<body>
    <div class="text-container" id="text-container-1">
        <p id="text-to-copy-1">Cargando...</p>
        <button class="btn icon-btn" onclick="copyToClipboard('text-to-copy-1', 'copied-notification1')">
            <i class="fas fa-copy"></i>
        </button>
        <button class="btn icon-btn" onclick="openModal('text-to-copy-1')">
            <i class="fas fa-edit"></i>
        </button>
        <p id="copied-notification1" class="copied-notification">¡Texto copiado al portapapeles!</p>
    </div>

    <!-- Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Editar Texto</h2>
            <input type="text" id="modalInput" value="">
            <button class="btn" onclick="saveText()">Guardar</button>
        </div>
    </div>

    <script>
        var currentTextId = ''; // Variable para almacenar el ID del texto que se está editando

        // Función para copiar al portapapeles
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

        // Abre el modal y carga el texto actual
        function openModal(textId) {
            currentTextId = textId; // Almacena el ID del texto actual
            var textElement = document.getElementById(textId);
            var modal = document.getElementById("editModal");
            var input = document.getElementById("modalInput");

            // Carga el texto actual en el campo de entrada
            input.value = textElement.innerText;

            // Muestra el modal
            modal.style.display = "block";
        }

        // Cierra el modal
        function closeModal() {
            var modal = document.getElementById("editModal");
            modal.style.display = "none";
        }

        // Guarda el texto modificado
        function saveText() {
            var input = document.getElementById("modalInput");
            var textElement = document.getElementById(currentTextId);
            var newText = input.value;

            // Actualiza el texto en la base de datos
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update_text.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Actualiza el texto en la página
                    textElement.innerText = newText;
                    
                    // Cierra el modal
                    closeModal();
                }
            };
            xhr.send("id=" + encodeURIComponent(currentTextId) + "&content=" + encodeURIComponent(newText));
        }

        // Cierra el modal si se hace clic fuera de él
        window.onclick = function(event) {
            var modal = document.getElementById("editModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Cargar el texto inicial desde la base de datos al cargar la página
        window.onload = function() {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "get_text.php?id=1", true); // Cambia el ID según sea necesario
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    document.getElementById('text-to-copy-1').innerText = response.content;
                }
            };
            xhr.send();
        }
    </script>
</body>
</html>