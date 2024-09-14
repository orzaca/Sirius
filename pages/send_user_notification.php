<?php
require '../includes/db.php'; // Asegúrate de que la ruta sea correcta

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $message = $_POST['message'];

    // Validación simple
    if (empty($user_id) || empty($message)) {
        echo "Todos los campos son obligatorios.";
        exit;
    }

    // Insertar notificación en la base de datos
    $stmt = $pdo->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
    if ($stmt->execute([$user_id, $message])) {
        echo "Notificación enviada al usuario con ID $user_id.";
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
    <title>Enviar Notificación a Usuario</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
        <h1>Enviar Notificación a Usuario</h1>
    </header>
    <main>
        <form action="send_user_notification.php" method="POST">
            <label for="user_id">ID del Usuario:</label>
            <input type="number" name="user_id" id="user_id">
            <br>
            <label for="message">Mensaje:</label>
            <textarea name="message" id="message" rows="4" cols="50"></textarea>
            <br>
            <button type="submit">Enviar Notificación</button>
        </form>
    </main>
</body>
</html>
