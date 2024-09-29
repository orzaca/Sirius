<?php
session_start();
require '/home/ziriuson/public_html/includes/db.php'; // Asegúrate de que este archivo contenga la conexión a tu base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $content = trim($_POST['content']);

    if (!empty($content)) {
        $sql = "UPDATE paragraphs SET content = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$content, $id])) {
            echo "Párrafo actualizado correctamente.";
        } else {
            echo "Error al actualizar el párrafo.";
        }
    } else {
        echo "El contenido no puede estar vacío.";
    }
} else {
    echo "Método no permitido.";
}
?>
