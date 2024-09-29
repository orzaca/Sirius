<?php
session_start(); // Iniciar sesión para acceder a la información del usuario

require '/home/ziriuson/public_html/includes/db.php'; // Conexión a la base de datos

// Suponiendo que ya tienes la sesión iniciada y $userId es el ID del usuario logueado
$userId = $_SESSION['user_id'];

// Obtener los párrafos específicos del usuario de la base de datos
$sql = "SELECT p.id, COALESCE(up.content, p.content) AS content FROM paragraphs p 
        LEFT JOIN user_paragraphs up ON p.id = up.paragraph_id AND up.user_id = :userId";
$stmt = $pdo->prepare($sql);
$stmt->execute(['userId' => $userId]);
$paragraphs = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejemplo de Copia, Modificación y Eliminación de Párrafos</title>
    <style>
        /* Estilos similares a los del ejemplo anterior */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            width: 100%;
        }
        .paragraph-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 10px;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
            width: 200px;
        }
        .paragraph-container:hover {
            transform: scale(1.02);
        }
        button {
            margin: 5px;
            padding: 5px 10px;
            font-size: 14px;
            cursor: pointer;
            background-color: #007BFF;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
        /* Estilo para botón de eliminar */
        .delete-button {
            background-color: #FF0000;
        }
        .delete-button:hover {
            background-color: #cc0000;
        }

        /* Estilos del modal */
        #modal {
            display: none; /* Inicialmente oculto */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Fondo oscuro */
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 300px; /* Ancho del modal */
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <div class="container">
        <?php
        foreach ($paragraphs as $paragraph) {
            echo '<div class="paragraph-container" id="paragraph' . $paragraph['id'] . '">';
            echo '<p>' . htmlspecialchars($paragraph['content']) . '</p>';
            echo '<button onclick="copyToClipboard(\'paragraph' . $paragraph['id'] . '\')">Copiar</button>';
            echo '<button onclick="openModal(' . $paragraph['id'] . ')">Modificar</button>';
            echo '<button class="delete-button" onclick="deleteParagraph(' . $paragraph['id'] . ')">Eliminar</button>';
            echo '</div>';
        }
        ?>
    </div>

    <!-- Modal -->
    <div id="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Modificar Párrafo</h2>
            <textarea id="modalText" rows="4" style="width: 100%;"></textarea>
            <button id="saveButton" onclick="saveText()">Guardar</button>
        </div>
    </div>

    <script>
        let currentParagraphId = null;

        function copyToClipboard(paragraphId) {
            const paragraphText = document.getElementById(paragraphId).getElementsByTagName('p')[0].innerText;
            navigator.clipboard.writeText(paragraphText).then(() => {
                alert("¡Texto copiado al portapapeles!");
            }).catch(err => {
                console.error('Error al copiar el texto: ', err);
            });
        }

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
    </script>

</body>
</html>
