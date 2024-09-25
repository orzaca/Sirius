<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Principal</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            display: inline-block;
            min-height: 100vh;
            background: #f0f0f0; /* Fondo de página claro */
        }

        .container {
            margin: 10px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        .main-menu {
            display: flex;
            flex-direction: column; /* Muestra los elementos en columna */
            align-items: center; /* Centra los elementos horizontalmente */
            gap: 15px; /* Espacio entre los elementos */
        }

        .menu-item {
            display: flex;
            align-items: center;
            background-color: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 8px;
            padding: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 150px; /* Ancho reducido del menú */
            justify-content: center;
            gap: 10px; /* Espacio entre el ícono y el texto */
        }

        .menu-item img {
            width: 24px; /* Ancho reducido de los íconos */
            height: 24px; /* Alto reducido de los íconos */
        }

        .menu-item span {
            font-size: 1em; /* Tamaño del texto */
        }

        .titulo{
            justify-content: center;
            text-align: center;
            display: flex;
    
        }
    </style>
</head>
<body>

    <?php include 'menu_navegacion.html'; ?>
    
    <div class="container">

        <div class="titulo">
            <p>Opciones Mas comunes: </p>
        </div>
        <div class="main-menu">
            <div class="menu-item">
                <img src="icon1.png" alt="Opción 1">
                <span>Opción 1</span>
            </div>
            <div class="menu-item">
                <img src="icon2.png" alt="Opción 2">
                <span>Opción 2</span>
            </div>
            <div class="menu-item">
                <img src="icon3.png" alt="Opción 3">
                <span>Opción 3</span>
            </div>
            <div class="menu-item">
                <img src="icon4.png" alt="Opción 4">
                <span>Opción 4</span>
            </div>
            <div class="menu-item">
                <img src="icon5.png" alt="Opción 5">
                <span>Opción 5</span>
            </div>
            <div class="menu-item">
                <img src="icon6.png" alt="Opción 6">
                <span>Opción 6</span>
            </div>
        </div>
    </div>
</body>
</html>
