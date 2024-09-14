<?php
require '../includes/db.php'; // Asegúrate de que la ruta sea correcta

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST['role'];
    $message = $_POST['message'];

    // Validación simple
    if (empty($role) || empty($message)) {
        echo "Todos los campos son obligatorios.";
        exit;
    }

    // Insertar notificación en la base de datos
    $stmt = $pdo->prepare("INSERT INTO notifications (role, message) VALUES (?, ?)");
    if ($stmt->execute([$role, $message])) {
        echo "Notificación enviada a todos los usuarios del rol $role.";
    } else {
        echo "Error al enviar la notificación.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar Notificación por Rol</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
        <h1>Enviar Notificación por Rol</h1>
    </header>
    <main>
        <form action="send_role_notification.php" method="POST">
            <label for="role">Seleccionar Rol:</label>
            <select name="role" id="role">
                <option value="redes">Redes</option>
                <option value="telefonico">Telefonico</option>
            </select>
            <br>
            <label for="message">Mensaje:</label>
            <textarea name="message" id="message" rows="4" cols="50"></textarea>
            <br>
            <button type="submit">Enviar Notificación</button>
        </form>
    </main>
</body>
</html>
