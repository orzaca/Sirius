<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba de Copiado</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #E5F5F5;
            color: #0D4D4D;
            margin: 0;
            padding: 20px;
        }
        .btn {
            display: inline-block;
            padding: 10px;
            font-size: 16px;
            color: #FFFFFF;
            background-color: #0D4D4D;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            margin-right: 10px;
        }
        .btn:hover {
            background-color: #004d4d;
        }
        .icon-button {
            background: none;
            border: none;
            color: #0D4D4D;
            cursor: pointer;
            font-size: 20px;
            margin-right: 10px;
        }
        .icon-button:hover {
            color: #004d4d;
        }
        .copied-notification {
            display: none;
            color: green;
            font-weight: bold;
            margin-top: 10px;
        }
        #text-to-copy, #text-to-copy2 {
            font-size: 12px; /* Ajusta el tamaño del texto aquí */
            color: #0D4D4D; /* Opcional: ajusta el color si es necesario */
            margin-bottom: 10px;
        }
        .content {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="content">
        <p id="text-to-copy">Este es el texto que se copiará al portapapeles.</p>
        <button class="icon-button" onclick="copyToClipboard('text-to-copy', 'copied-notification1')">
            <i class="fas fa-copy"></i>
        </button>
        <button class="icon-button" onclick="editText('text-to-copy')">
            <i class="fas fa-edit"></i>
        </button>
        <p id="copied-notification1" class="copied-notification">¡Texto copiado!</p>
    </div>
    <div class="content">
        <p id="text-to-copy2">Este es el segundo texto que se copiará al portapapeles.</p>
        <button class="icon-button" onclick="copyToClipboard('text-to-copy2', 'copied-notification2')">
            <i class="fas fa-copy"></i>
        </button>
        <button class="icon-button" onclick="editText('text-to-copy2')">
            <i class="fas fa-edit"></i>
        </button>
        <p id="copied-notification2" class="copied-notification">¡Texto copiado!</p>
    </div>

    <script src="copiar.js"></script>
</body>
</html>
