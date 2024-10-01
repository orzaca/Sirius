<?php
session_start(); // Iniciar sesión para acceder a la información del usuario

require '/home/ziriuson/public_html/includes/db.php'; // Conexión a la base de datos

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirigir a inicio de sesión si no está autenticado
    exit();
}

// Suponiendo que ya tienes la sesión iniciada y $userId es el ID del usuario logueado
$userId = $_SESSION['user_id'];

// Obtener los párrafos específicos del usuario de la base de datos
$sql = "SELECT p.id, COALESCE(up.content, p.content) AS content FROM pagina2 p 
        LEFT JOIN user_pagina2 up ON p.id = up.pagina2_id AND up.user_id = :userId";
$stmt = $pdo->prepare($sql);
$stmt->execute(['userId' => $userId]);
$paragraphs = $stmt->fetchAll(); // Obtener todos los párrafos
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Párrafos de Página 2</title>
    <style>
        /* Estilos generales para la página */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #eef;
        }
        .content-wrapper {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin: 20px;
        }
        .paragraph-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 15px;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #aaa;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            width: 250px;
        }
        button {
            margin: 5px;
            padding: 8px 12px;
            font-size: 15px;
            cursor: pointer;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #218838; /* Color más oscuro al pasar el mouse */
        }
        /* Estilo para el botón de eliminar */
        .remove-button {
            background-color: #dc3545; /* Color rojo para eliminar */
        }
        .remove-button:hover {
            background-color: #c82333;
        }

        /* Estilos del modal */
        #editModal2 {
            display: none; /* Inicialmente oculto */
            position: fixed;
            z-index: 10;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7); /* Fondo oscuro */
        }
        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border-radius: 8px;
            width: 300px; /* Ancho del modal */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .close-btn {
            float: right;
            font-size: 20px;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <div class="content-wrapper">
        <?php
        // Mostrar cada párrafo en la interfaz
        foreach ($paragraphs as $para) {
            echo '<div class="paragraph-box" id="para2' . $para['id'] . '">'; // Cambiado a para2
            echo '<p>' . htmlspecialchars($para['content']) . '</p>';
            echo '<button onclick="copyText(\'para2' . $para['id'] . '\')">Copiar</button>';
            echo '<button onclick="openEditModal(' . $para['id'] . ')">Modificar</button>';
            echo '<button class="remove-button" onclick="confirmRemoval(' . $para['id'] . ')">Eliminar</button>';
            echo '</div>';
        }
        ?>
    </div>

    <!-- Modal para editar párrafos -->
    <div id="editModal2"> <!-- Cambiado a editModal2 -->
        <div class="modal-content">
            <span class="close-btn" onclick="closeEditModal()">&times;</span>
            <h2>Editar Párrafo</h2>
            <textarea id="editText2" rows="4" style="width: 100%;"></textarea> <!-- Cambiado a editText2 -->
            <button id="saveChanges2" onclick="saveParagraph()">Guardar</button>
        </div>
    </div>

    <script>
        let currentParaId = null;

        // Función para copiar texto al portapapeles
        function copyText(paraId) {
            const textContent = document.getElementById(paraId).getElementsByTagName('p')[0].innerText;
            navigator.clipboard.writeText(textContent).then(() => {
                alert("Texto copiado al portapapeles!");
            }).catch(err => {
                console.error('Error al copiar el texto: ', err);
            });
        }

        // Abre el modal para editar el párrafo
        function openEditModal(paraId) {
            currentParaId = paraId;
            const textElement = document.getElementById('para2' + paraId).getElementsByTagName('p')[0]; // Cambiado a para2
            document.getElementById('editText2').value = textElement.innerText; // Rellena el textarea
            document.getElementById('editModal2').style.display = "block"; // Muestra el modal
        }

        // Cierra el modal
        function closeEditModal() {
            document.getElementById('editModal2').style.display = "none"; // Oculta el modal
        }

        // Guarda el texto editado
        function saveParagraph() {
            const updatedText = document.getElementById('editText2').value; // Cambiado a editText2
            const textElement = document.getElementById('para2' + currentParaId).getElementsByTagName('p')[0]; // Cambiado a para2
            textElement.innerText = updatedText; // Actualiza el párrafo en la interfaz

            // Envía la nueva información al servidor
            fetch('update_pagina2.php', { // Cambiado a update_pagina2.php
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id=' + currentParaId + '&content=' + encodeURIComponent(updatedText)
            })
            .then(response => response.text())
            .then(data => {
                console.log(data); // Para depuración
            })
            .catch(error => console.error('Error:', error));

            closeEditModal(); // Cierra el modal
        }

        // Función para confirmar la eliminación del párrafo
        function confirmRemoval(paraId) {
            if (confirm("¿Estás seguro de que deseas eliminar este párrafo?")) {
                deleteParagraph(paraId);
            }
        }

        
    </script>
</body>
</html>
