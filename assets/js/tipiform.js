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