<?php
session_start();
require '../includes/db.php'; // Asegúrate de que la ruta sea correcta

// Verifica si el usuario está logueado
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'telefonico') {
    header("Location: login.php");
    exit;
}

// Recupera la información del usuario
$user_id = $_SESSION['user_id'];
$sql = "SELECT email FROM users WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$user = $stmt->fetch();

$email = $user['email'];

// Recupera las noticias del sistema
$news_sql = "SELECT title, content, created_at FROM system_news ORDER BY created_at DESC";
$news_stmt = $pdo->prepare($news_sql);
$news_stmt->execute();
$news_list = $news_stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Telefónico</title>
    <link rel="stylesheet" href="/assets/css/dashboard_telefonico.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="/assets/js/theme-toggle.js" defer></script>
</head>
<body>
    <header class="header">
        <nav class="navbar">
            <div class="navbar-left">
                <h1>Dashboard Telefónico</h1>
            </div>
            <div class="navbar-icons">
                <a href="#" class="icon" title="Inicio"><i class="fas fa-home"></i></a>
                <a href="#" class="icon" title="Mensajes"><i class="fas fa-envelope"></i></a>
                <a href="#" class="icon" title="Notificaciones"><i class="fas fa-bell"></i></a>
                <a href="#" class="icon" title="Configuración"><i class="fas fa-cog"></i></a>
                <a href="#" class="icon" title="Ayuda"><i class="fas fa-question-circle"></i></a>
                <a href="#" class="icon" id="theme-toggle" title="Modo oscuro"><i class="fas fa-moon"></i></a>
            </div>
            <div class="navbar-right">
                <span>Hola, <?php echo htmlspecialchars($email); ?></span>
                <a href="logout.php" class="logout-link">Cerrar sesión</a>
            </div>
        </nav>
    </header>
    
    <aside class="sidebar">
        <ul class="menu">
            <li><a href="#"><i class="fas fa-file-alt"></i> Tipificaciones</a></li>
            <li><a href="#"><i class="fas fa-sticky-note"></i> Memo de quejas</a></li>
            <li><a href="#"><i class="fas fa-layer-group"></i> Plantillas WF</a></li>
            <li><a href="#"><i class="fas fa-book"></i> Manuales</a></li>
            <li><a href="#"><i class="fas fa-check-circle"></i> Checklist</a></li>
            <li><a href="#"><i class="fas fa-comments"></i> Guiones</a></li>
            <li><a href="#"><i class="fas fa-cogs"></i> Configuración</a></li>
        </ul>
    </aside>
    
    <main class="main-content">
        <!-- Sección de Noticias -->
        <section class="news-section">
            <h2>Noticias del Sistema</h2>
            <ul>
                <?php foreach ($news_list as $news): ?>
                    <li>
                        <h3><?php echo htmlspecialchars($news['title']); ?></h3>
                        <p><?php echo htmlspecialchars($news['content']); ?></p>
                        <span><?php echo htmlspecialchars($news['created_at']); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    </main>
</body>
</html>
