<?php
session_start(); // Iniciar sesión para acceder a la información del usuario

require '/home/ziriuson/public_html/includes/db.php'; // Conexión a la base de datos

// Obtener el ID del usuario
$userId = $_SESSION['user_id'];

// Obtener los datos enviados por POST
$paragraphId = $_POST['id'];
$content = $_POST['content'];

// Verificar si el párrafo ya existe para el usuario
$sql = "REPLACE INTO user_paragraphs (user_id, paragraph_id, content) VALUES (:userId, :paragraphId, :content)";
$stmt = $pdo->prepare($sql);
$stmt->execute(['userId' => $userId, 'paragraphId' => $paragraphId, 'content' => $content]);

echo "Párrafo actualizado"; // Mensaje de éxito
?>
