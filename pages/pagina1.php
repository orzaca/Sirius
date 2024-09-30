<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejemplo de Copia y Modificación de Múltiples Párrafos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .paragraph-container {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            margin-left: 10px;
            padding: 5px 10px;
            font-size: 14px;
            cursor: pointer;
        }
        .message {
            display: none;
            color: green;
            margin-top: 5px;
        }
    </style>
</head>
<body>

    <!-- Ejemplo de párrafos, modificando el ID para que coincida con el de la base de datos -->
    <?php
    // Conexión a la base de datos
    require '/home/ziriuson/public_html/includes/db.php'; // Asegúrate de que este archivo contenga la conexión a tu base de datos

    // Obtener los párrafos de la base de datos
    $sql = "SELECT id, content FROM paragraphs";
    $stmt = $pdo->query($sql);
    $paragraphs = $stmt->fetchAll();
    
    foreach ($paragraphs as $paragraph) {
        echo '<div class="paragraph-container" id="paragraph' . $paragraph['id'] . '">';
        echo '<p>' . htmlspecialchars($paragraph['content']) . '</p>';
        echo '<button onclick="copyToClipboard(\'paragraph' . $paragraph['id'] . '\')">Copiar</button>';
        echo '<button onclick="modifyText(' . $paragraph['id'] . ')">Modificar</button>';
        echo '<p class="message" id="copyMessage' . $paragraph['id'] . '">¡Texto copiado al portapapeles!</p>';
        echo '</div>';
    }
    ?>

    <script>
        function copyToClipboard(paragraphId) {
            const paragraphText = document.getElementById(paragraphId).getElementsByTagName('p')[0].innerText;
            navigator.clipboard.writeText(paragraphText).then(() => {
                const messageElement = document.getElementById('copyMessage' + paragraphId);
                messageElement.style.display = 'block';
                setTimeout(() => {
                    messageElement.style.display = 'none';
                }, 2000);
            });
        }

        function modifyText(paragraphId) {
            const textElement = document.getElementById('paragraph' + paragraphId).getElementsByTagName('p')[0];
            const newText = prompt("Introduce el nuevo texto:", textElement.innerText);
            if (newText !== null) {
                // Actualiza el texto en la interfaz
                textElement.innerText = newText;

                // Actualiza el texto en la base de datos
                fetch('update_paragraph.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'id=' + paragraphId + '&content=' + encodeURIComponent(newText)
                })
                .then(response => response.text())
                .then(data => {
                    console.log(data); // Para depuración
                })
                .catch(error => console.error('Error:', error));
            }
        }
    </script>

</body>
</html>
