<?php
session_start();
require '/home/ziriuson/public_html/includes/db.php';

// Verifica si el usuario está logueado
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'redes') {
    header("Location: login.php");
    exit;
}

// Verifica si los datos han sido enviados
if (isset($_POST['id']) && isset($_POST['content'])) {
    $id = $_POST['id'];
    $content = $_POST['content'];

    // Actualiza el contenido en la base de datos
    $sql = "UPDATE texts SET content = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$content, $id]);

    echo "Texto actualizado exitosamente";
} else {
    echo "Datos incompletos";
}
?>
