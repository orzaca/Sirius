<?php
session_start();
require '../includes/db.php'; // Ajusta la ruta si es necesario

// Verifica si el usuario ya está autenticado
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

// Procesa el formulario si se ha enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';

    // Validación básica del correo electrónico
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Aquí puedes agregar la lógica para enviar el enlace de restablecimiento de contraseña
        $message = 'Si el correo electrónico existe, se ha enviado un enlace para restablecer la contraseña.';
    } else {
        $message = 'Por favor, ingrese un correo electrónico válido.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olvidé mi contraseña</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-form">
            <h1>Olvidé mi contraseña</h1>
            <?php if (!empty($message)) : ?>
                <p class="message"><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>
            <form action="forgot_password.php" method="post">
                <label for="email">Correo electrónico:</label>
                <input type="email" id="email" name="email" required>
                <button type="submit">Enviar enlace de restablecimiento</button>
            </form>
            <p><a href="login.php">Volver al inicio de sesión</a></p>
        </div>
    </div>
</body>
</html>
