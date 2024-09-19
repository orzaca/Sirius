document.addEventListener('DOMContentLoaded', function () {
    // Simula la verificación de nuevas noticias
    // En una implementación real, puedes hacer una llamada AJAX para verificar si hay nuevas noticias
    var hasNewNews = true; // Cambia esto según si hay nuevas noticias

    if (hasNewNews) {
        var notificationBadge = document.getElementById('notification-badge');
        notificationBadge.textContent = '!';
        notificationBadge.classList.add('show');
    }
});
