<?php
session_start();
require '../includes/db.php'; // Asegúrate de que la ruta sea correcta

$message = '';

// Verifica si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    // Validar si se ingresaron los datos
    if (empty($name) || empty($email) || empty($password) || empty($role)) {
        $message = 'Por favor, completa todos los campos.';
    } else {
        // Verificar si el correo ya está registrado
        $sql = "SELECT COUNT(*) FROM users WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $emailExists = $stmt->fetchColumn();

        if ($emailExists) {
            $message = 'El correo electrónico ya está registrado.';
        } else {
            // Cifra la contraseña
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Inserta el nuevo usuario en la base de datos
            $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);

            try {
                $stmt->execute([$name, $email, $hashed_password, $role]);
                $user_id = $pdo->lastInsertId(); // Obtener el ID del nuevo usuario

                // Agregar un párrafo por defecto para el nuevo usuario
                $defaultParagraph = "Este es un párrafo por defecto."; // Puedes ajustar este contenido
                $sql = "INSERT INTO paragraphs (content, user_id) VALUES (?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$defaultParagraph, $user_id]);

                $message = 'Cuenta registrada exitosamente.';
            } catch (PDOException $e) {
                $message = 'Error al registrar el usuario: ' . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
    <link rel="stylesheet" href="/assets/css/register.css">
</head>
<body>
    <div class="register-container">
        <div class="register-form">
            <h1>Regístrate</h1>
            <?php if (!empty($message)) : ?>
                <p class="message"><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>
            <form action="register.php" method="post">
                <label for="name">Nombre:</label>
                <input type="text" id="name" name="name" required>
                <label for="email">Correo electrónico:</label>
                <input type="email" id="email" name="email" required>
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
                <label for="role">Rol:</label>
                <select id="role" name="role" required>
                    <option value="redes">Redes</option>
                    <option value="telefonico">Telefónico</option>
                </select>
                <button type="submit">Regístrate</button>
            </form>
            <p><a href="login.php">Iniciar sesión</a></p>
        </div>
    </div>
</body>
</html>
