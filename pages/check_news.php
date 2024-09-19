<?php
require '../includes/db.php';

// Recupera la última noticia
$sql = "SELECT id, title, content FROM system_news ORDER BY created_at DESC LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$latest_news = $stmt->fetch();

echo json_encode($latest_news);
?>
