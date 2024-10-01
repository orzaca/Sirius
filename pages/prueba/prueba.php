<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Horizontal con PHP</title>
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

        .icon {
            margin-right: 5px; /* Espaciado entre el ícono y el texto */
        }

        /* Estilos para el modal */
        .modal {
            display: none; /* Ocultar el modal por defecto */
            position: fixed; /* Fijo en la pantalla */
            z-index: 1; /* Estar encima de otros elementos */
            left: 0;
            top: 0;
            width: 100%; /* Ancho completo */
            height: 100%; /* Alto completo */
            overflow: auto; /* Permitir el desplazamiento si es necesario */
            background-color: rgb(0,0,0); /* Color de fondo negro */
            background-color: rgba(0,0,0,0.4); /* Fondo negro con opacidad */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% desde arriba y centrado */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Ancho del modal */
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <ul class="menu">
            <?php
            // Conexión a la base de datos
            session_start(); // Iniciar sesión para acceder a la información del usuario

require '/home/ziriuson/public_html/includes/db.php'; // Conexión a la base de datos

// Suponiendo que ya tienes la sesión iniciada y $userId es el ID del usuario logueado
$userId = $_SESSION['user_id'];

            // Consulta para obtener los nombres de las pestañas
            $result = $conn->query("SELECT * FROM tabs");

            // Imprimir las pestañas en el menú
            if ($result->num_rows > 0) {
                while($tab = $result->fetch_assoc()) {
                    echo '<li><a href="#' . strtolower($tab['name']) . '" id="link-' . strtolower($tab['name']) . '">' . $tab['name'] . '</a></li>';
                }
            } else {
                echo '<li>No hay pestañas disponibles.</li>';
            }

            // Cerrar conexión
            $conn->close();
            ?>
            <li><a href="#settings" id="config-button"><i class="fas fa-cog icon"></i> Configuración</a></li>
        </ul>
    </nav>

    <!-- Modal para actualizar nombres -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Actualizar Nombres de Pestañas</h2>
            <form id="updateForm">
                <?php
                // Reabrir la conexión a la base de datos
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Verificar conexión
                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }

                // Obtener los nombres de las pestañas nuevamente
                $result = $conn->query("SELECT * FROM tabs");

                // Crear campos de formulario para cada pestaña
                if ($result->num_rows > 0) {
                    while($tab = $result->fetch_assoc()) {
                        echo '<label for="tabName' . $tab['id'] . '">' . $tab['name'] . ':</label>';
                        echo '<input type="text" id="tabName' . $tab['id'] . '" value="' . $tab['name'] . '"><br><br>';
                    }
                }

                // Cerrar conexión
                $conn->close();
                ?>
                <button type="submit">Actualizar Nombres</button>
            </form>
        </div>
    </div>

    <script>
        // Obtener el modal
        var modal = document.getElementById("myModal");

        // Obtener el botón que abre el modal
        var btn = document.getElementById("config-button");

        // Obtener el elemento <span> que cierra el modal
        var span = document.getElementsByClassName("close")[0];

        // Cuando el usuario hace clic en el botón, abrir el modal
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // Cuando el usuario hace clic en <span> (x), cerrar el modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // Cuando el usuario hace clic en cualquier parte fuera del modal, cerrarlo
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Manejo del envío del formulario
        document.getElementById("updateForm").onsubmit = function(e) {
            e.preventDefault(); // Prevenir la recarga de la página

            // Obtener los nuevos nombres
            var newNames = {};
            for (let i = 1; i <= 8; i++) {
                newNames[i] = document.getElementById("tabName" + i).value;
            }

            // Enviar los nuevos nombres al servidor
            fetch('update_names.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(newNames)
            })
            .then(response => response.text())
            .then(data => {
                console.log(data); // Manejar la respuesta
                // Actualizar los enlaces del menú
                for (let i = 1; i <= 8; i++) {
                    document.getElementById("link-" + Object.keys(newNames)[i - 1].toLowerCase()).textContent = newNames[i];
                }
                // Cerrar el modal
                modal.style.display = "none";
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
</body>
</html>
