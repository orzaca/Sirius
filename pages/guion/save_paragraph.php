<?php
session_start();
require '../includes/db.php'; // Asegúrate de que la ruta sea correcta

// Obtener datos del cuerpo de la solicitud
$data = json_decode(file_get_contents("php://input"), true);

// Verifica si los datos requeridos están presentes
if (isset($data['userId']) && isset($data['paragraphId']) && isset($data['content'])) {
    $userId = $data['userId'];
    $paragraphId = $data['paragraphId'];
    $content = $data['content'];

    // Preparar la consulta SQL para insertar o actualizar el párrafo
    $sql = "INSERT INTO paragraphs (user_id, paragraph_id, content) VALUES (?, ?, ?) 
            ON DUPLICATE KEY UPDATE content = ?";
    $stmt = $pdo->prepare($sql);
    
    // Ejecutar la consulta y pasar los parámetros
    if ($stmt->execute([$userId, $paragraphId, $content, $content])) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->errorInfo()]);
    }
} else {
    echo json_encode(['success' => false]);
}
?>
