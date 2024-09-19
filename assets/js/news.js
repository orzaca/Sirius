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

    // Función para actualizar la lista de noticias
    function updateNewsList(newNewsItem) {
        const newsList = document.querySelector('.news-section ul');
        const newItem = document.createElement('li');
        newItem.innerHTML = `
            <h3>${newNewsItem.title}</h3>
            <p>${newNewsItem.description}</p>
        `;
        newsList.appendChild(newItem);
    }

    // Simular la llegada de una nueva noticia
    function fetchNews() {
        // Simulación de la llegada de una nueva noticia
        setTimeout(() => {
            const newNewsItem = { title: 'Nueva Noticia', description: 'Se ha publicado una nueva noticia.' };
            updateNewsList(newNewsItem);
            showNewMessageAlert();
        }, 2000); // Simula una nueva noticia después de 2 segundos
    }

    // Ejecutar la función para simular la llegada de nuevas noticias
    fetchNews();

    // Si estás usando WebSockets o algún otro método de actualización en tiempo real, 
    // puedes conectar esto a la función showNewMessageAlert() para mostrar el aviso inmediatamente.
});
