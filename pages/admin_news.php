<?php
session_start();
require '../includes/db.php';

// Verifica si el usuario está logueado
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'telefonico') {
    header("Location: login.php");
    exit;
}

// Agregar una noticia
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_news'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "INSERT INTO system_news (title, content, created_at) VALUES (?, ?, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $content]);

    header("Location: admin_news.php");
    exit;
}

// Eliminar una noticia
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    $sql = "DELETE FROM system_news WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$delete_id]);

    header("Location: admin_news.php");
    exit;
}

// Recupera todas las noticias
$sql = "SELECT id, title, content, created_at FROM system_news ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$news_list = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Noticias</title>
    <link rel="stylesheet" href="/assets/css/admin_news.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <h1>Administración de Noticias</h1>
        <a href="dashboard_telefonico.php" class="back-link">Volver al Dashboard</a>
    </header>
    
    <main>
        <section class="add-news">
            <h2>Agregar Noticia</h2>
            <form action="admin_news.php" method="POST">
                <label for="title">Título:</label>
                <input type="text" id="title" name="title" required>
                
                <label for="content">Contenido:</label>
                <textarea id="content" name="content" rows="5" required></textarea>
                
                <button type="submit" name="add_news">Agregar Noticia</button>
            </form>
        </section>

        <section class="news-list">
            <h2>Lista de Noticias</h2>
            <ul>
                <?php foreach ($news_list as $news): ?>
                    <li>
                        <h3><?php echo htmlspecialchars($news['title']); ?></h3>
                        <p><?php echo htmlspecialchars($news['content']); ?></p>
                        <span><?php echo htmlspecialchars($news['created_at']); ?></span>
                        <a href="admin_news.php?delete_id=<?php echo $news['id']; ?>" class="delete-link" onclick="return confirm('¿Estás seguro de que deseas eliminar esta noticia?');">Eliminar</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    </main>

    <script>
        // Solicitar permiso para notificaciones de escritorio
        function requestNotificationPermission() {
            if (Notification.permission === "default") {
                Notification.requestPermission().then(permission => {
                    if (permission === "granted") {
                        console.log("Notificaciones habilitadas.");
                    } else {
                        console.log("Notificaciones bloqueadas.");
                    }
                });
            }
        }

        // Mostrar una notificación
        function showNotification(title, body) {
            if (Notification.permission === "granted") {
                new Notification(title, {
                    body: body,
                    icon: '/assets/img/news-icon.png' // Opcional: puedes agregar un icono
                });
            }
        }

        // Verificar si hay nuevas noticias
        let lastNewsId = 0;
        function checkForNews() {
            fetch('/check_news.php')
                .then(response => response.json())
                .then(data => {
                    if (data && data.id > lastNewsId) {
                        // Si es una nueva noticia, mostrar la notificación
                        showNotification("Nueva Noticia", data.title);
                        lastNewsId = data.id;
                    }
                })
                .catch(error => console.error('Error al verificar noticias:', error));
        }

        // Al cargar la página, solicitar permisos
        document.addEventListener("DOMContentLoaded", function() {
            requestNotificationPermission();

            // Verificar cada 30 segundos si hay noticias nuevas
            setInterval(checkForNews, 30000);
        });
    </script>
</body>
</html>
