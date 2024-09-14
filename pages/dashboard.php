<?php
session_start();
require './includes/db.php'; // Ajusta la ruta si es necesario

// Verifica si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Obtiene los datos del usuario
$user_id = $_SESSION['user_id'];
$sql = "SELECT role FROM users WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    header("Location: login.php");
    exit;
}

// Determina el rol del usuario
$role = $user['role'];

// Redirige al dashboard correspondiente
if ($role === 'redes') {
    header("Location: dashboard_redes.php");
    exit;
} elseif ($role === 'telefonico') {
    header("Location: dashboard_telefonico.php");
    exit;
} else {
    echo "Rol no reconocido.";
}
?>
