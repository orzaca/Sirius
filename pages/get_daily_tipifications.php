<?php
session_start();
require '../includes/db.php';

// Verifica si el usuario está logueado y es del rol correcto
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'telefonico') {
    http_response_code(403); // Acceso prohibido
    exit;
}

// Obtiene la fecha actual en formato Y-m-d
$current_date = date('Y-m-d');

// Consulta para contar las tipificaciones del día
$sql = "SELECT COUNT(*) AS count FROM tipifications WHERE DATE(created_at) = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$current_date]);
$result = $stmt->fetch();

echo json_encode([
    'count' => (int) $result['count']
]);
?>
