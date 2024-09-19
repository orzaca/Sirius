<?php
require '../includes/db.php';

// Obtener el filtro
$filter = $_GET['filter'] ?? 'day';

// Configura la consulta según el filtro
switch ($filter) {
    case 'day':
        $sql = "SELECT * FROM tipifications WHERE DATE(created_at) = CURDATE() ORDER BY created_at DESC";
        break;
    case 'week':
        $sql = "SELECT * FROM tipifications WHERE YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1) ORDER BY created_at DESC";
        break;
    case 'month':
        $sql = "SELECT * FROM tipifications WHERE MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE()) ORDER BY created_at DESC";
        break;
    default:
        $sql = "SELECT * FROM tipifications ORDER BY created_at DESC";
}

// Ejecuta la consulta
$stmt = $pdo->prepare($sql);
$stmt->execute();
$tipifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Devuelve los datos en formato JSON
header('Content-Type: application/json');
echo json_encode($tipifications);
?>
