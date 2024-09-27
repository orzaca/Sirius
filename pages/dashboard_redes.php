<?php
session_start();
require '../includes/db.php';

// Verifica si el usuario está logueado
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'redes') {
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
    <title>Dashboard Redes Sociales</title>
        <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/assets/css/dashboard_redes.css">
    <link rel="stylesheet" href="/assets/css/checklist.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


</head>
<body>


   

    <header class="header">
        <nav class="navbar">
                <div class="navbar-left">
            </div>
            <div class="navbar-icons">
                <a href="dashboard_redes.php" class="icon" title="Inicio"><i class="fas fa-home"></i></a>
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
        <div class="logo">
            <img src="/assets/img/logo.png" alt="Logo" class="logo-img">
        </div>
    <ul class="menu">
        <li><a href="/pages/guion/principal.php" id="guiones"><i class="fas fa-comments"></i> Guiones</a></li>
        <li><a href="#"><i class="fas fa-sticky-note"></i> Memo de quejas</a></li>
        <li><a href="#"><i class="fas fa-layer-group"></i> Plantillas WF</a></li>
        <li><a href="#"><i class="fas fa-book"></i> Manuales</a></li>
        <li><a href="#" id="load-checklist"><i class="fas fa-check-circle"></i> Checklist</a></li>
        <li><a href="#"><i class="fas fa-cogs"></i> Zonas operativas</a></li>
        <li><a href="#"><i class="fas fa-cogs"></i> Configuración</a></li>
    </ul>
</aside>


   <main class="main-content">
    <!-- Sección de Noticias en la parte superior -->
    <section class="news-section">

        <h2>Mensajes</h2>
        <ul>
            <?php foreach ($news_list as $news): ?>
                <li>
                    <h3><?php echo htmlspecialchars($news['title']); ?></h3>
                    <p><?php echo htmlspecialchars($news['content']); ?></p>
                    <span><?php echo htmlspecialchars($news['created_at']); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>


        
    </div>

    <div class="news-images">
      <div class="image-gallery">
        <img src="/assets/img/promo.jpg" alt="Noticias" />
        <!-- Más imágenes -->
    </div>



</section>


<!-- Módulos en la parte superior -->
<section class="top-modules">
    <!-- Botón de pestaña flotante -->

    <div id="floating-button" class="floating-button">
        <button id="open-form-button">Tipificación</button>
    </div>

    <!-- Contenedor flotante del formulario -->
    <div id="floating-form-container" class="floating-form-container">
        <button type="button" id="minimize-form-button" class="minimize-button">
            <i class="fas fa-window-minimize"></i>
        </button>
        <form action="save_tipification.php" method="POST" id="tipification-form"><h3>Tipificación</h3>
            <input type="text" id="call_id" name="call_id" placeholder="ID llamada" required>
            <input type="text" id="client_name" name="client_name" placeholder="Nombre del Cliente" required>
            <input type="text" id="line" name="line" placeholder="Línea" required>
            <textarea id="reported_problem" name="reported_problem" placeholder="Problema Reportado" rows="3" required></textarea>
            <textarea id="tests" name="tests" placeholder="Pruebas" rows="3" required></textarea>

            <div class="button-container">
                <button type="submit" class="styled-button">Guardar</button>
                <button type="button" id="copy-button" class="styled-button copy-button">Copiar</button>
            </div>
        </form>
    </div>
    <button id="show-timer-btn">Cronómetro</button>
    <!-- Cronómetro Flotante -->
    <div class="floating-timer" id="floating-timer">
        <h3>Cronómetro</h3>
        <div id="timer">
            <span id="hours">00</span>:<span id="minutes">00</span>:<span id="seconds">00</span>
        </div>
        <button id="start-btn">Iniciar</button>
        <button id="stop-btn">Detener</button>
        <button id="reset-btn">Reiniciar</button>
    </div>

</section>


<section class="checklist-section" id="checklist-section" style="display: none;">
    <!-- Contenido de checklist.php se cargará aquí -->
</section>


<div class="guion-wrapper" id="guion-wrapper">
        <!-- El contenido se cargará aquí -->
</div>




</main>


<script src="/assets/js/theme-toggle.js" defer></script> 
<script src="/assets/js/step.js"></script>
<script src="/assets/js/checklist.js"></script>
<script src="/assets/js/cronometro.js"></script>
<script src="/assets/js/tipiform.js"></script>
<script src="/assets/js/noticias.js"></script>




</body>
</html>