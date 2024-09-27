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




function updateNewsList(newNewsItem) {
    const newsList = document.querySelector('.news-section ul');
    const newItem = document.createElement('li');
    newItem.innerHTML = `
    <h3>${newNewsItem.title}</h3>
    <p>${newNewsItem.description}</p>
    `;
    newsList.appendChild(newItem);
}
