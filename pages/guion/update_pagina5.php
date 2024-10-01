<?php
session_start();
require '/home/ziriuson/public_html/includes/db.php'; // Conexión a la base de datos

// Verificar que el usuario esté autenticado y que se hayan recibido los datos
if (isset($_SESSION['user_id']) && isset($_POST['id']) && isset($_POST['content'])) {
    $userId = $_SESSION['user_id']; // ID del usuario
    $paragraphId = $_POST['id']; // ID del párrafo que se está actualizando
    $newContent = $_POST['content']; // Nuevo contenido del párrafo

    // Reemplazar el contenido del párrafo en la tabla user_pagina2
    $sql = "REPLACE INTO user_pagina5 (user_id, pagina5_id, content) 
            VALUES (:userId, :paragraphId, :content)";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'userId' => $userId,
            'paragraphId' => $paragraphId,
            'content' => $newContent
        ]);
        echo "Párrafo actualizado."; // Mensaje de éxito
    } catch (PDOException $e) {
        echo "Error al actualizar el párrafo: " . $e->getMessage(); // Captura el error y lo muestra
    }
} else {
    echo "No autorizado."; // Mensaje de error si no está autorizado
}
?>
