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
