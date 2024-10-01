
/* Realiza la funcion del boton copiar*/

function capitalizeFirstLetter(element) {
            element.value = element.value.toLowerCase().replace(/^\w|\s\w/g, function (letter) {
                return letter.toUpperCase();
            });
        }
    function copiarFormulario() {
      var formulario = document.activeElement.parentElement.parentElement;
      var inputs = formulario.getElementsByTagName('input');
      var textoCopiado = '';

      for (var i = 0; i < inputs.length; i++) {
        var label = inputs[i].previousElementSibling.innerText;
        var valor = inputs[i].value;
        textoCopiado += label + ': ' + valor + '\n';
      }

      // Crear un textarea temporal para copiar el texto
      var textareaTemporal = document.createElement('textarea');
      textareaTemporal.value = textoCopiado;
      document.body.appendChild(textareaTemporal);

      // Seleccionar y copiar el texto
      textareaTemporal.select();
      document.execCommand('copy');

      // Eliminar el textarea temporal
      document.body.removeChild(textareaTemporal);

      alert('Formulario copiado al portapapeles. Pega en el Bloc de notas o en tu editor preferido.');
    }
  