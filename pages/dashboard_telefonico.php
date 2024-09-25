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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Telefónico</title>
    <link rel="stylesheet" href="/assets/css/dashboard_telefonico.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="/assets/js/theme-toggle.js" defer></script>
</head>
<body>
    <header class="header">
        <nav class="navbar">
            <div class="navbar-left">
                <h1>Zirius Desk</h1>
            </div>
            <div class="navbar-icons">
                <a href="dashboard_telefonico.php" class="icon" title="Inicio"><i class="fas fa-home"></i></a>
                <a href="#" class="icon" title="Mensajes"><i class="fas fa-envelope"></i></a>
                <a href="#" class="icon" title="Notificaciones"><i class="fas fa-bell"></i></a>
                <a href="#" class="icon" title="Configuración"><i class="fas fa-cog"></i></a>
                <a href="#" class="icon" title="Ayuda"><i class="fas fa-question-circle"></i></a>
                <a href="#" class="icon" id="theme-toggle" title="Modo oscuro"><i class="fas fa-moon"></i></a>
            </div>
            <div class="navbar-right">
                <span>Hola, <?php echo htmlspecialchars($email); ?></span>
                <a href="logout.php" class="logout-link">Cerrar sesión</a>
            </div>
        </nav>
    </header>
    
    <aside class="sidebar">
       <ul class="menu">
       <li><a href="#" id="load-tipifications"><i class="fas fa-file-alt"></i> Tipificaciones</a></li>
        <li><a href="#"><i class="fas fa-sticky-note"></i> Memo de quejas</a></li>
        <li><a href="#"><i class="fas fa-layer-group"></i> Plantillas WF</a></li>
        <li><a href="#"><i class="fas fa-book"></i> Manuales</a></li>
        <li><a href="#" id="load-checklist"><i class="fas fa-check-circle"></i> Checklist</a></li>
        <li><a href="#"><i class="fas fa-comments"></i> Guiones</a></li>
        <li><a href="#"><i class="fas fa-cogs"></i> Configuración</a></li>
    </ul>
</aside>
<main class="main-content">
    <!-- Sección de Noticias en la parte superior -->
    <section class="news-section">

    <h2>Mensajes</h2>
        <ul>
            <?php foreach ($news_list as $news): ?>
                <li>
                    <h3><?php echo htmlspecialchars($news['title']); ?></h3>
                    <p><?php echo htmlspecialchars($news['content']); ?></p>
                    <span><?php echo htmlspecialchars($news['created_at']); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>


        
    </div>

    <div class="news-images">
              <div class="image-gallery">
            <img src="/assets/img/promo.jpg" alt="Noticia 1" />
            <!-- Más imágenes -->
        </div>
    </section>

 
    <!-- Módulos en la parte superior -->
    <section class="top-modules">
   

<!-- Botón de pestaña flotante -->
<!-- Botón de pestaña flotante -->
<div id="floating-button" class="floating-button">
    <button id="open-form-button">Tipificación</button>
</div>

<!-- Contenedor flotante del formulario -->
<div id="floating-form-container" class="floating-form-container">
    <button type="button" id="minimize-form-button" class="minimize-button">
        <i class="fas fa-window-minimize"></i>
    </button>
    <form action="save_tipification.php" method="POST" id="tipification-form">
        <h3>Tipificación</h3>
        <input type="text" id="call_id" name="call_id" placeholder="ID llamada" required>
        <input type="text" id="client_name" name="client_name" placeholder="Nombre del Cliente" required>
        <input type="text" id="line" name="line" placeholder="Línea" required>
        <textarea id="reported_problem" name="reported_problem" placeholder="Problema Reportado" rows="3" required></textarea>
        <textarea id="tests" name="tests" placeholder="Pruebas" rows="3" required></textarea>
        
        <div class="button-container">
            <button type="submit" class="styled-button">Guardar</button>
            <button type="button" id="copy-button" class="styled-button copy-button">Copiar</button>
        </div>
    </form>
</div>
<button id="show-timer-btn">Cronómetro</button>
       <!-- Cronómetro Flotante -->
       <div class="floating-timer" id="floating-timer">
    <h3>Cronómetro</h3>
    <div id="timer">
        <span id="hours">00</span>:<span id="minutes">00</span>:<span id="seconds">00</span>
    </div>
    <button id="start-btn">Iniciar</button>
    <button id="stop-btn">Detener</button>
    <button id="reset-btn">Reiniciar</button>
</div>

    </section>
    <section class="checklist-section" id="checklist-section" style="display: none;">
        <!-- Contenido de checklist.php se cargará aquí -->
    </section>
    
</main>



    <script>
        // Solicitar permiso para notificaciones de escritorio
        function requestNotificationPermission() {
            if (Notification.permission === "default") {
                Notification.requestPermission().then(permission => {
                    if (permission === "granted") {
                        console.log("Notificaciones habilitadas.");
                    } else {
                        console.log("Notificaciones bloqueadas.");
                    }
                });
            }
        }

        // Mostrar una notificación
        function showNotification(title, body) {
            if (Notification.permission === "granted") {
                new Notification(title, {
                    body: body,
                    icon: '/assets/img/news-icon.png' // Opcional: puedes agregar un icono
                });
            }
        }

        // Verificar si hay nuevas noticias
        let lastNewsId = 0;
        function checkForNews() {
            fetch('/check_news.php')
                .then(response => response.json())
                .then(data => {
                    if (data && data.id > lastNewsId) {
                        // Si es una nueva noticia, mostrar la notificación
                        showNotification("Nueva Noticia", data.title);
                        lastNewsId = data.id;
                    }
                })
                .catch(error => console.error('Error al verificar noticias:', error));
        }

        // Al cargar la página, solicitar permisos
        document.addEventListener("DOMContentLoaded", function() {
            requestNotificationPermission();

            // Verificar cada 30 segundos si hay noticias nuevas
            setInterval(checkForNews, 30000);
        });
    </script>




<script>
    // Botón para abrir el formulario
    const openFormButton = document.getElementById('open-form-button');
    const floatingFormContainer = document.getElementById('floating-form-container');
    const minimizeFormButton = document.getElementById('minimize-form-button');

    // Mostrar el formulario cuando se presiona el botón flotante
    openFormButton.addEventListener('click', function() {
        floatingFormContainer.style.bottom = '20px'; // Subir el formulario
    });

    // Minimizar el formulario cuando se presiona el botón "Minimizar"
    minimizeFormButton.addEventListener('click', function() {
        floatingFormContainer.style.bottom = '-100%'; // Bajar el formulario fuera de la pantalla
    });

    // Botón para copiar el contenido del formulario
    document.getElementById('copy-button').addEventListener('click', function() {
        // Obtener los valores del formulario
        const callId = document.getElementById('call_id').value;
        const clientName = document.getElementById('client_name').value;
        const line = document.getElementById('line').value;
        const reportedProblem = document.getElementById('reported_problem').value;
        const tests = document.getElementById('tests').value;

        // Crear una plantilla con los datos
        const formContent = `
ID llamada: ${callId}
Nombre del Cliente: ${clientName}
Línea: ${line}
Problema Reportado: ${reportedProblem}
Pruebas: ${tests}
        `.trim(); // Remover espacios innecesarios

        // Usar el API moderna para copiar al portapapeles
        navigator.clipboard.writeText(formContent).then(function() {
            alert('Contenido copiado al portapapeles.');
        }).catch(function(error) {
            console.error('Error al copiar:', error);
            alert('Error al copiar el contenido. Por favor, inténtalo de nuevo.');
        });
    });
</script>

<script>
    // Función para cargar la estadística de tipificaciones
    function loadTipificationStatistics() {
        fetch('/path/to/get_daily_tipifications.php')
            .then(response => response.json())
            .then(data => {
                const countElement = document.getElementById('tipification-count');
                countElement.textContent = data.count; // Actualiza el número de tipificaciones
            })
            .catch(error => {
                console.error('Error al cargar la estadística:', error);
                const countElement = document.getElementById('tipification-count');
                countElement.textContent = 'Error al cargar datos'; // Mensaje de error
            });
    }

    // Cargar estadísticas cuando la página esté completamente cargada
    document.addEventListener('DOMContentLoaded', function() {
        loadTipificationStatistics();
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Función para mostrar el aviso de nuevo mensaje
    function showNewMessageAlert() {
        const newMessageAlert = document.querySelector('.news-section .new-message');
        if (newMessageAlert) {
            newMessageAlert.style.display = 'block'; // Muestra el aviso
            setTimeout(() => {
                newMessageAlert.style.display = 'none'; // Oculta el aviso después de un tiempo
            }, 5000); // Tiempo en milisegundos (5 segundos en este caso)
        }
    }

    // Simular la llegada de una nueva noticia
    // Reemplaza este código con la lógica para detectar nuevas noticias
    setTimeout(showNewMessageAlert, 2000); // Simula una nueva noticia después de 2 segundos
});

</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Función para mostrar el aviso de nuevo mensaje
    function showNewMessageAlert() {
        const newMessageAlert = document.querySelector('.news-section .new-message');
        if (newMessageAlert) {
            newMessageAlert.style.display = 'block'; // Muestra el aviso
            setTimeout(() => {
                newMessageAlert.style.display = 'none'; // Oculta el aviso después de un tiempo
            }, 5000); // Tiempo en milisegundos (5 segundos en este caso)
        }
    }

    // Simular la llegada de una nueva noticia
    // Reemplaza esta simulación con tu lógica para recibir nuevas noticias
    function fetchNews() {
        // Simulación de la llegada de una nueva noticia
        setTimeout(() => {
            // Mostrar el aviso de nueva noticia
            showNewMessageAlert();
            
            // Aquí deberías actualizar la lista de noticias con la nueva información
            // Ejemplo: actualizarNewsList();
        }, 2000); // Simula una nueva noticia después de 2 segundos
    }

    // Ejecutar la función para simular la llegada de nuevas noticias
    fetchNews();

    // Si estás usando WebSockets o algún otro método de actualización en tiempo real, 
    // puedes conectar esto a la función showNewMessageAlert() para mostrar el aviso inmediatamente.
});

</script>

<script>

function updateNewsList(newNewsItem) {
    const newsList = document.querySelector('.news-section ul');
    const newItem = document.createElement('li');
    newItem.innerHTML = `
        <h3>${newNewsItem.title}</h3>
        <p>${newNewsItem.description}</p>
    `;
    newsList.appendChild(newItem);
}
</script>

<script>
// Variables para el cronómetro
let timerInterval;
let hours = 0;
let minutes = 0;
let seconds = 0;

// Función para actualizar el cronómetro
function updateTimer() {
    document.getElementById('hours').textContent = String(hours).padStart(2, '0');
    document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
    document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');
}

// Función para iniciar el cronómetro
function startTimer() {
    timerInterval = setInterval(() => {
        seconds++;
        if (seconds >= 60) {
            seconds = 0;
            minutes++;
        }
        if (minutes >= 60) {
            minutes = 0;
            hours++;
        }
        updateTimer();
    }, 1000);
}

// Función para detener el cronómetro
function stopTimer() {
    clearInterval(timerInterval);
}

// Función para reiniciar el cronómetro
function resetTimer() {
    clearInterval(timerInterval);
    hours = 0;
    minutes = 0;
    seconds = 0;
    updateTimer();
}

// Mostrar/Ocultar el cronómetro al hacer clic en el botón
document.getElementById('show-timer-btn').addEventListener('click', () => {
    const timerElement = document.getElementById('floating-timer');
    timerElement.style.display = timerElement.style.display === 'none' ? 'block' : 'none';
});

// Asignar eventos a los botones del cronómetro
document.getElementById('start-btn').addEventListener('click', startTimer);
document.getElementById('stop-btn').addEventListener('click', stopTimer);
document.getElementById('reset-btn').addEventListener('click', resetTimer);

// Inicializar el cronómetro
updateTimer();

document.addEventListener('DOMContentLoaded', function() {
    const checklistLink = document.getElementById('load-checklist');
    const checklistSection = document.getElementById('checklist-section');

    checklistLink.addEventListener('click', function(event) {
        event.preventDefault(); // Evita la acción por defecto del enlace

        // Oculta el contenido principal
        document.querySelector('.news-section').style.display = 'none';
        
        // Muestra la sección de checklist
        checklistSection.style.display = 'block';

        // Carga el contenido de checklist.php
        fetch('checklist.php')
            .then(response => response.text())
            .then(html => {
                checklistSection.innerHTML = html;
            })
            .catch(error => {
                console.error('Error al cargar checklist.php:', error);
            });
    });
});



</script>

<script>
    function nextStep(answer) {
        document.querySelectorAll('.step').forEach(step => step.classList.add('hidden'));
        /*step1*/
        if (answer === 'cable') {
            document.getElementById('step2').classList.remove('hidden');
        } else if (answer === 'wifi') {
            document.getElementById('resultMessage').innerText = 'Ingresar queja detallando que la OTT se encuentra via wifi y esto ocasiona inconveniente con la señal y enviar a etapa FGD';
            document.getElementById('result').classList.remove('hidden');
        }

        /*step2*/
        if (answer === 'cobroYes') {
            document.getElementById('step4').classList.remove('hidden');
        } else if (answer === 'continuar_step2') {
            document.getElementById('step3').classList.remove('hidden');
        }

        /*step3*/    
        if (answer === 'yes_programacion') {
            document.getElementById('resultMessage').innerText = 'Tipificar como soporte efectivo: Reclamos ▶ Avería ▶ TV IPTV ▶ Sin señal ▶ guía interactiva';
            document.getElementById('result').classList.remove('hidden');
      } else if (answer === 'no_programacion') {
            document.getElementById('step4').classList.remove('hidden');
        }


        /*step4*/        
        if (answer === 'step4_no') {
            document.getElementById('step5').classList.remove('hidden');
        }

        /*step5*/        

        if (answer === 'step5_yes') {
            document.getElementById('resultMessage').innerText = 'Tipificar como soporte efectivo: Reclamos > Avería > TV IPTV > Sin señal > guía interactiva';
            document.getElementById('result').classList.remove('hidden');
        } else if (answer === 'step5_no') {
            document.getElementById('step6').classList.remove('hidden');
        }

        /*step6*/        

        if (answer === 'step6_no') {
             document.getElementById('step7').classList.remove('hidden');
        }
   

        /*step7*/  

        if (answer === 'step7_yes') {
            document.getElementById('resultMessage').innerText = 'Tipificar como soporte efectivo: Reclamos > Avería > TV IPTV > Sin señal > guía interactiva';
            document.getElementById('result').classList.remove('hidden');
        } else if (answer === 'step7_no') {
            document.getElementById('step8').classList.remove('hidden');
        }
}

    function reset() {
        document.querySelectorAll('.step').forEach(step => step.classList.add('hidden'));
        document.getElementById('step1').classList.remove('hidden');
        document.getElementById('resultMessage').innerText = '';
    }
</script>





</body>
</html>