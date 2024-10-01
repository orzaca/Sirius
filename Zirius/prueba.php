<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Horizontal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #0D4D4D; /* Color de fondo del menú */
            padding: 10px 20px; /* Espaciado interno */
        }

        .menu {
            list-style-type: none; /* Eliminar viñetas */
            display: flex; /* Mostrar como flexbox */
            justify-content: space-around; /* Espacio entre elementos */
            margin: 0; /* Eliminar margen */
            padding: 0; /* Eliminar relleno */
        }

        .menu li {
            flex: 1; /* Cada elemento toma el mismo espacio */
        }

        .menu a {
            text-decoration: none; /* Sin subrayado */
            color: white; /* Color del texto */
            text-align: center; /* Centrar texto */
            padding: 15px 0; /* Espaciado interno */
            display: block; /* Mostrar como bloque para que ocupe todo el espacio */
            transition: background-color 0.3s; /* Transición suave al cambiar color */
        }

        .menu a:hover {
            background-color: #0A3E3E; /* Color de fondo al pasar el ratón */
        }

        .menu .icon {
            margin-right: 5px; /* Espaciado entre el ícono y el texto */
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <ul class="menu">
            <li><a href="#home">Inicio</a></li>
            <li><a href="#about">Acerca de</a></li>
            <li><a href="#services">Servicios</a></li>
            <li><a href="#portfolio">Portafolio</a></li>
            <li><a href="#blog">Blog</a></li>
            <li><a href="#contact">Contacto</a></li>
            <li><a href="#faq">Preguntas Frecuentes</a></li>
            <li><a href="#support">Soporte</a></li>
            <li><a href="#settings"><i class="fas fa-cog icon"></i></a></li> <!-- Solo el ícono de configuración -->
        </ul>
    </nav>
</body>
</html>
