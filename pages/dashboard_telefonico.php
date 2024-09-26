<?php
session_start();
require '../includes/db.php';

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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Telefónico</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Estilos adicionales para mejorar la visibilidad y usabilidad */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #2c3e50;
            color: #ecf0f1;
            position: fixed;
            top: 0;
            left: 0;
            transition: width 0.3s;
            overflow: auto;
        }
        .sidebar.collapsed {
            width: 80px;
        }
        .sidebar a {
            display: block;
            padding: 15px;
            color: #ecf0f1;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .sidebar a:hover {
            background-color: #34495e;
        }
        .header {
            background-color: #2c3e50;
            color: #ecf0f1;
            padding: 15px;
            position: fixed;
            top: 0;
            left: 250px;
            width: calc(100% - 250px);
            transition: width 0.3s, left 0.3s;
        }
        .header.collapsed {
            left: 80px;
            width: calc(100% - 80px);
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s;
        }
        .content.collapsed {
            margin-left: 80px;
        }
        .module {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        .module h2 {
            margin-top: 0;
        }
        .timer {
            background-color: #fff;
            border-radius: 5px;
            padding: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
        .floating-form {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: none;
            transition: opacity 0.3s;
        }
        .floating-form.active {
            display: block;
            opacity: 1;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <a href="#">Inicio</a>
        <a href="#">Noticias</a>
        <a href="#">Usuarios</a>
        <a href="#">Configuración</a>
        <a href="#">Cerrar sesión</a>
    </div>
    <div class="header">
        <h1>Panel de Control</h1>
    </div>
    <div class="content">
        <div class="module">
            <h2>Noticias</h2>
            <ul>
                <!-- Aquí iría el contenido de las noticias -->
            </ul>
        </div>
        <div class="module">
            <h2>Lista de Usuarios</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Aquí irían los datos de los usuarios -->
                </tbody>
            </table>
        </div>
        <div class="module">
            <h2>Resumen</h2>
            <p>Contenido del resumen.</p>
        </div>
    </div>
    <div class="timer">
        <h2>Cronómetro</h2>
        <p id="timer">00:00:00</p>
    </div>
    <div class="floating-form" id="floatingForm">
        <h2>Formulario de Tipificación</h2>
        <form id="tipForm">
            <label for="tip">Tipo:</label>
            <input type="text" id="tip" name="tip">
            <button type="submit">Enviar</button>
        </form>
    </div>
    <script>
        // Script para manejar la animación del cronómetro y el formulario flotante
        document.addEventListener('DOMContentLoaded', function () {
            let timerElement = document.getElementById('timer');
            let formElement = document.getElementById('floatingForm');
            
            // Inicialización del cronómetro
            let startTime = Date.now();
            function updateTimer() {
                let elapsed = Date.now() - startTime;
                let hours = String(Math.floor(elapsed / (1000 * 60 * 60))).padStart(2, '0');
                let minutes = String(Math.floor((elapsed % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
                let seconds = String(Math.floor((elapsed % (1000 * 60)) / 1000)).padStart(2, '0');
                timerElement.textContent = `${hours}:${minutes}:${seconds}`;
            }
            setInterval(updateTimer, 1000);

            // Mostrar/Ocultar formulario flotante
            document.getElementById('tipForm').addEventListener('submit', function (e) {
                e.preventDefault();
                alert('Formulario enviado');
                formElement.classList.remove('active');
            });

            // Ejemplo de cómo activar el formulario flotante (puede ser con un botón)
            document.querySelector('.header').addEventListener('click', function () {
                formElement.classList.toggle('active');
            });
        });
    </script>
</body>
</html>
