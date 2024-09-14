 /* REALIZA LA FUNCION DEL NO SALDOS */
 function mostrarMensaje() {
    var mensaje = document.getElementById("mensaje-personalizado");
    var mensaje1 = document.getElementById("mensaje-pagos");
    var mensaje2 = document.getElementById("mensaje-orden");
    var mensaje3 = document.getElementById("mensaje-quejas");
    mensaje.style.display = "block";
    mensaje1.style.display = "block";
    mensaje2.style.display = "block";
    mensaje3.style.display = "block";
document.getElementById("siBtn").disabled = true;
  }

    /* REALIZA LA FUNCION DEL SI SALDOS */
  function mostrarQuejas() {
    var mensajeQuejas = document.getElementById("mensaje-quejas");
    var saldos = document.getElementById("saldos");
    mensajeQuejas.style.display = "block";
    saldos.style.display = "none";
  }
  
          /* REALIZA LA FUNCION DEL SI QUEJAS */

  function mostrarMensajeQuejas() {
    var mensaje = document.getElementById("MenQuejas");
    mensaje.style.display = "block";
document.getElementById("noquejasBtn").disabled = true;
  }

        /* REALIZA LA FUNCION DEL NO QUEJAS */

  function mostrarOrden() {
    var mensaje_orden = document.getElementById("mensaje-orden");
    var quejas1 = document.getElementById("mensaje-quejas");
    mensaje_orden.style.display = "block";
    quejas1.style.display = "none";
  }
          /* REALIZA LA FUNCION DEL SI ORDEN */
          function mostrarMensajeOrden() {
    var mensaje = document.getElementById("MenOrden");
    mensaje.style.display = "block";
document.getElementById("noOrdenBtn").disabled = true;
  }

        /* REALIZA LA FUNCION DEL NO ORDEN */

  function mostrarVelocidad() {
    var mensaje_velocidad = document.getElementById("mensaje-velocidad");
    var orden1 = document.getElementById("mensaje-orden");
    mensaje_velocidad.style.display = "block";
    orden1.style.display = "none";
  }

function copyToClipboard(text, showAlert = false) {


            const textarea = document.createElement('textarea');
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();

            try {
                document.execCommand('copy');
                if (showAlert) {
                    alert('Texto copiado al portapapeles');
                }
            } catch (err) {
                console.error('No se pudo     al portapapeles', err);
            }

            document.body.removeChild(textarea);
        }