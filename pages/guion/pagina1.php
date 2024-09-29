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



</body>
</html>
