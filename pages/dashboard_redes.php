<?php
session_start();
require '../includes/db.php'; // Asegúrate de que la ruta sea correcta

// Verifica si el usuario está logueado y tiene el rol de 'redes'
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'redes') {
    header("Location: login.php");
    exit;
}

// Recupera la información del usuario
$user_id = $_SESSION['user_id'];
$email = ''; // Inicializa la variable $email

try {
    $sql = "SELECT email FROM users WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    if ($user) {
        $email = $user['email'];
    } else {
        // Maneja el caso donde no se encuentra el usuario
        $email = 'Usuario no encontrado';
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Redes</title>
    <link rel="stylesheet" href="/assets/css/dashboard_redes.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="/assets/js/theme-toggle.js" defer></script>
</head>
<body>
    <header class="header">
        <nav class="navbar">
            <div class="navbar-left">
                <h1>Dashboard Redes</h1>
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
                <a href="#" class="icon" title="Notificaciones"><i class="fas fa-bell"></i></a>
                <span>Hola, <?php echo htmlspecialchars($email); ?></span>
                <a href="logout.php" class="logout-link">Cerrar sesión</a>
            </div>
        </nav>
    </header>
    <main class="main-content">
        <h2>Bienvenido al Dashboard de Redes</h2>
        <p>Aquí es donde se mostrarán las funcionalidades específicas para el rol de Redes.</p>
        <div class="role-message">
            <p>Estás en soporte redes.</p>
        </div>
    </main>
</body>
</html>
