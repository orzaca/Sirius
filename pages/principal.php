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
$email = htmlspecialchars($user['email']); // Escapar para seguridad

// Obtener los nombres de las pestañas desde la base de datos usando PDO
$sqlPestanas = "SELECT nombre FROM nombres_pestanas";
$stmtPestanas = $pdo->prepare($sqlPestanas);
$stmtPestanas->execute();
$nombres = $stmtPestanas->fetchAll(PDO::FETCH_COLUMN); // Usamos fetchAll para obtener todas las filas como un array simple
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú de Pestañas con Carga Dinámica</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
      .tab-container {
    position: fixed; /* Fija el menú en la pantalla */
    top: 0; /* Pegado a la parte superior */
    left: 0; /* Pegado a la parte izquierda */
    width: 100%; /* Ancho completo para el menú */
    background-color: #0D4D4D; /* Color de fondo del menú */
    display: flex; /* Alinea los elementos en línea */
    flex-wrap: wrap; /* Permite que el contenido se ajuste a la línea siguiente si es necesario */
    justify-content: space-evenly; /* Distribuye los elementos de manera uniforme */
    padding: 10px; /* Espaciado interno */
    z-index: 1000; /* Asegura que el menú esté por encima del contenido */
}

.tab {
    padding: 10px 20px;
    cursor: pointer;
    color: white;
    font-size: 16px;
    border-bottom: 3px solid transparent;
    transition: border-bottom 0.3s ease;
}

        .tab {
            padding: 10px 20px;
            cursor: pointer;
            color: white;
            font-size: 16px;
            border-bottom: 3px solid transparent;
            transition: border-bottom 0.3s ease;
        }
        .tab:hover, .tab.active {
            border-bottom: 3px solid #FFD700; /* Amarillo dorado */
        }
        .content {
            padding: 20px;
            background-color: white;
            border-top: 1px solid #ddd;
        }
        .message {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border-radius: 5px;
            font-size: 14px;
            display: none;
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }
        /* Estilos de fondo y texto por cada contenido */
        #content1 { background-color: #E5F5F5; color: #0D4D4D; }
        #content2 { background-color: #FFF2E5; color: #B35C00; }
        #content3 { background-color: #E5E9FF; color: #0033B3; }
        #content4 { background-color: #F5E5FF; color: #800080; }
        #content5 { background-color: #E5FFE5; color: #008000; }
        #content6 { background-color: #FFFDE5; color: #B39C00; }
        #content7 { background-color: #F5E5E5; color: #B30000; }
        #content8 { background-color: #E5FFF9; color: #00665B; }
        /* Estilo para el ícono de configuración */
        

        .settings-tab {
            padding: 10px;
            cursor: pointer;
            color: white;
            font-size: 18px;
            border-bottom: 3px solid transparent;
            transition: border-bottom 0.3s ease;
            text-decoration: none;
        }
        .settings-tab:hover {
            border-bottom: 3px solid #FFD700; /* Amarillo dorado */
        }
.settings-tab a {
    color: #FFFFFF; /* Color del ícono */
    text-decoration: none; /* Quita el subrayado del enlace */
}

.settings-tab a:active,
.settings-tab a:visited,
.settings-tab a:hover {
    color: #FFFFFF; /* Mantén el color en todos los estados */
}


        #dynamic-content {
    margin-top: 60px; /* Deja espacio suficiente para el menú fijo */
    padding: 20px;
    background-color: white;
    border-top: 1px solid #ddd;
}

    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <!-- Mensaje flotante de copiado -->
    <div id="copy-message" class="message">¡Texto copiado al portapapeles!</div>

    <!-- Menú de pestañas -->
    <div class="tab-container">
        <?php 
        $urls = [
            'https://zirius.online/pages/guion/pagina1.php', // URL para la pestaña 1
            'https://zirius.online/pages/guion/pagina2.php', // URL para la pestaña 2
            'pagina3.php', // URL para la pestaña 3
            'pagina4.php', // URL para la pestaña 4
            'pagina5.php', // URL para la pestaña 5
            'pagina6.php', // URL para la pestaña 6
            'pagina7.php', // URL para la pestaña 7
            'pagina8.php', // URL para la pestaña 8
        ];

        for ($i = 1; $i <= 8; $i++): ?>
            <div class="tab<?php echo $i === 1 ? ' active' : ''; ?>" onclick="loadContent('<?php echo $urls[$i-1]; ?>')">
                <?php echo isset($nombres[$i-1]) ? htmlspecialchars($nombres[$i-1]) : "Pestaña $i"; ?>
            </div>
        <?php endfor; ?>
        <div class="settings-tab">
            <a href="configuracion.php"><i class="fas fa-cog"></i></a>
        </div>
    </div>

    <!-- Contenedor para el contenido dinámico -->
    <div id="dynamic-content" class="content active">
            <p>ELIGE CUALQUIER OPCION DEL MENU</p>
    </div>



  <script src="/assets/js/principal.js"></script> <!-- controla el menu superior del principal de guion-->

  
    
</body>
</html>
