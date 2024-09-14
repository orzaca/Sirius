document.addEventListener('DOMContentLoaded', function () {
    const stopwatchToggle = document.getElementById('stopwatch-toggle');
    const stopwatchContainer = document.getElementById('stopwatch-container');
    const stopwatchDisplay = document.getElementById('stopwatch');

    let timer;
    let timeLeft = 60; // Tiempo en segundos (1 minuto)
    
    stopwatchToggle.addEventListener('click', function () {
        if (stopwatchContainer.classList.contains('hidden')) {
            stopwatchContainer.classList.remove('hidden');
            startStopwatch();
        } else {
            stopwatchContainer.classList.add('hidden');
            stopStopwatch();
        }
    });

    function startStopwatch() {
        timer = setInterval(() => {
            timeLeft--;
            updateDisplay();

            if (timeLeft <= 0) {
                clearInterval(timer);
                playSound();
            }
        }, 1000);
    }

    function stopStopwatch() {
        clearInterval(timer);
        timeLeft = 60; // Reiniciar el tiempo
        updateDisplay();
    }

    function updateDisplay() {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        stopwatchDisplay.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
    }

    function playSound() {
        const audio = new Audio('/assets/sounds/alarm.mp3'); // Asegúrate de tener un archivo de sonido
        audio.play();
    }
});
