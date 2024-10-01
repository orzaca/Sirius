const formularioUtils = {
    // Función para capitalizar la primera letra de cada palabra en un campo de texto
    capitalizarPrimeraLetra: function(elemento) {
        elemento.value = elemento.value.toLowerCase().replace(/^\w|\s\w/g, function(letra) {
            return letra.toUpperCase();
        });
    },

    // Función para copiar el contenido del formulario de quejas
    copiarFormularioQuejas: function() {
        const formulario = document.querySelector('form'); // Selecciona el formulario directamente
        const inputs = formulario.getElementsByTagName('input');
        let textoCopiado = '';

        // Iterar sobre los inputs y recoger sus valores
        for (let i = 0; i < inputs.length; i++) {
            const etiqueta = inputs[i].previousElementSibling ? inputs[i].previousElementSibling.innerText : 'Campo sin etiqueta';
            const valor = inputs[i].value;
            textoCopiado += etiqueta + ': ' + valor + '\n';
        }

        // Usar el API moderno para copiar al portapapeles
        navigator.clipboard.writeText(textoCopiado).then(function() {
            alert('Formulario copiado al portapapeles. Pega en el Bloc de notas o en tu editor preferido.');
        }).catch(function(err) {
            console.error('Error al copiar el texto: ', err);
        });
    }
};
