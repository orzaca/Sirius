<?php
session_start();
require '../includes/db.php'; // Asegúrate de que la ruta sea correcta

$message = '';

// Verifica si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validar si se ingresaron los datos
    if (empty($email) || empty($password)) {
        $message = 'Por favor, ingresa tu correo electrónico y contraseña.';
    } else {
        // Verifica las credenciales del usuario
        $sql = "SELECT id, password, role FROM users WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Las credenciales son válidas, inicia la sesión
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role']; // Guarda el rol del usuario en la sesión

            // Redirige al dashboard según el rol
            if ($user['role'] == 'redes') {
                header("Location: dashboard_redes.php");
            } elseif ($user['role'] == 'telefonico') {
                header("Location: dashboard_telefonico.php");
            } else {
                // Redirige a una página de error si el rol no es reconocido
                header("Location: error.php");
            }
            exit;
        } else {
            $message = 'Correo electrónico o contraseña incorrectos.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="/assets/css/login.css">
    <link rel="icon" href="/assets/img/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Mega:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="auth-container">
        <div class="auth-form">
            <h1>Iniciar sesión</h1>
            <?php if (!empty($message)) : ?>
                <p class="message"><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>
            <form action="login.php" method="post">
                <label for="email">Correo electrónico:</label>
                <input type="email" id="email" name="email" required>
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Ingresar</button>
            </form>
            
        </div>


        <div class="logo">
        <img src="/assets/img/Zirius.png" />
        </div>

    </div>
</body>
</html>
