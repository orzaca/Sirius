<?php

session_start();
require '/home/ziriuson/public_html/includes/db.php';

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

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Preparar la consulta para actualizar los nombres de las pestañas
        $sql = "UPDATE nombres_pestanas SET nombre = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);

        // Actualizar cada nombre de pestaña
        for ($i = 1; $i <= 8; $i++) {
            $nombre = filter_var($_POST["nombre$i"], FILTER_SANITIZE_STRING);
            $stmt->execute([$nombre, $i]);
        }

        // Redirigir de vuelta a la página principal
        header('Location: principal.php');
        exit;

    } catch (Exception $e) {
        // Manejar errores
        echo "Error al actualizar los nombres de las pestañas: " . $e->getMessage();
    }
}

// Recuperar los nombres actuales desde la base de datos
$sql = "SELECT nombre FROM nombres_pestanas ORDER BY id ASC";
$stmt = $pdo->query($sql);
$nombres = $stmt->fetchAll(PDO::FETCH_COLUMN);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editor de Pestañas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            color: #333;
        }
        label {
            display: inline-block;
            width: 100px;
            font-weight: bold;
        }
        input[type="text"] {
            width: 300px;
            padding: 5px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Configuración de Pestañas</h1>
    <form action="configuracion.php" method="POST">
        <?php for ($i = 1; $i <= 10; $i++): ?>
            <label>Pestaña <?php echo $i; ?>: </label>
            <input type="text" name="nombre<?php echo $i; ?>" value="<?php echo htmlspecialchars($nombres[$i-1]); ?>"><br><br>
        <?php endfor; ?>
        <button type="submit">Guardar Cambios</button>
    </form>
</body>
</html>
