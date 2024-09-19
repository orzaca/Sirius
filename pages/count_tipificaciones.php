<?php
session_start();
require '../includes/db.php';

// Verifica si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

$user_id = $_SESSION['user_id'];
$today = date('Y-m-d');

// Consulta para contar las tipificaciones del día actual
$tipifications_sql = "SELECT COUNT(*) AS count FROM tipificaciones WHERE user_id = ? AND DATE(created_at) = ?";
$tipifications_stmt = $pdo->prepare($tipifications_sql);
$tipifications_stmt->execute([$user_id, $today]);
$tipifications_count = $tipifications_stmt->fetch()['count'];

// Devolver el conteo como respuesta JSON
echo json_encode(['count' => $tipifications_count]);
