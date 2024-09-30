// Elementos del DOM
const openFormButton = document.getElementById('open-form-button');
const floatingFormContainer = document.getElementById('floating-form-container');
const minimizeFormButton = document.getElementById('minimize-form-button');
const copyButton = document.getElementById('copy-button');

// Función para abrir el formulario
function openForm() {
    floatingFormContainer.style.bottom = '20px'; // Subir el formulario
}

// Función para minimizar el formulario
function minimizeForm() {
    floatingFormContainer.style.bottom = '-100%'; // Bajar el formulario fuera de la pantalla
}

// Función para copiar el contenido del formulario
function copyFormContent() {
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
    navigator.clipboard.writeText(formContent)
        .then(() => {
            alert('Contenido copiado al portapapeles.');
        })
        .catch((error) => {
            console.error('Error al copiar:', error);
            alert('Error al copiar el contenido. Por favor, inténtalo de nuevo.');
        });
}

// Agregar eventos a los botones
openFormButton.addEventListener('click', openForm);
minimizeFormButton.addEventListener('click', minimizeForm);
copyButton.addEventListener('click', copyFormContent);
