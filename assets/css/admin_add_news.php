<?php
session_start();
require '../includes/db.php';

// Verifica si el usuario está logueado y tiene permisos para administrar
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Inserta la noticia en la base de datos
    $sql = "INSERT INTO system_news (title, content) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $content]);

    header("Location: admin_add_news.php?success=1");
    exit;
}
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Noticias</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>
    <header>
        <h1>Agregar Noticias</h1>
    </header>
    <main>
        <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
            <p>Noticia agregada exitosamente.</p>
        <?php endif; ?>
        <form action="admin_add_news.php" method="POST">
            <label for="title">Título:</label>
            <input type="text" id="title" name="title" required>
            
            <label for="content">Contenido:</label>
            <textarea id="content" name="content" rows="5" required></textarea>
            
            <button type="submit">Agregar Noticia</button>
        </form>
    </main>
</body>
</html>
