<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checklist</title>
    <style>

        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: whitesmoke;
            text-align: center;
        }
        .container {
            margin: 10px auto;
            padding: 20px;
            background-color: #c0392b;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            width: 400px;
        }
        .step {
            margin: 20px 0;
            padding: 15px;
            background-color: whitesmoke;
            border-radius: 5px;
        }
        .button {
            background-color: #c0392b;
            margin: 5px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
        }
        .button:hover {
            background-color: #d98880;
        }
        .hidden {
            display: none;
        }

        .img {
        display: block;
        margin: 0 auto;
        text-align: center;
}

.image-container {

    display: flex; /* Utiliza flexbox */
    justify-content: center; /* Centra horizontalmente */
    /*margin: 1px 0; Espacio por encima y por debajo */
}


/* Estilo para la imagen en tamaño pequeño */
#myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg:hover {
  opacity: 0.7;
}


#myImg1 {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg1:hover {
  opacity: 0.7;
}
/* Estilos para el modal (cuando la imagen se amplía) */
.modal {
  display: none;
  position: fixed;
  z-index: 1;
  padding-top: 100px;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgb(0, 0, 0);
  background-color: rgba(0, 0, 0, 0.9);
}

/* Imagen dentro del modal */
.modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}

/* Estilo de cierre (X) */
.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #fff;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* Añade animación a la imagen */
.modal-content {
  animation-name: zoom;
  animation-duration: 0.6s;
}

@keyframes zoom {
  from {transform: scale(0)}
  to {transform: scale(1)}
}



.titulo_step{

color: whitesmoke;

}

    </style>
</head>


<body>


    <?php include 'menu_navegacion.html'; ?>


    <div class="container">
        <p class="titulo_step" >Luces Ok No navega</p>
        <div id="step1" class="step">
            <p><h4>Preguntar al cliente por que medio se esta conectando</h4></p>
            <p>¿Esta conectando por cable o wifi?</p>
        </br>
            <button class="button" onclick="nextStep('cable')">Cable</button>
            <button class="button" onclick="nextStep('wifi')">WiFi</button>
        </div>

        <div id="step2" class="step hidden">
            <p><h4>Pregunta al cliente si el problema es en uno o varios dispositivos</h4></p>
             <p>Si es en varios dispositivo, indicar que solo se conecte uno</p>       
             <p>Valida en UMP si solo conecto un solo dispositivo</p>       
             <button class="button" onclick="reset()">Iniciar de Nuevo</button>
            <button class="button" onclick="nextStep('continuar_step2')">Continuar</button>
        </div>

        <div id="step3" class="step hidden">
            <p><h4>Revisa en PISA si tiene IP publica </h4></p>
            <p>1. Si tiene IP publica:</p>
            <p>Realiza Queja A Gestion, colocar en el Memo: IP publica</p>
            <p>Tipifica: Reclamo ▶ Averia ▶ Internet DSL MSAN  ▶  No Navega  ▶ Se genero averia </p>
            <button class="button" onclick="reset()">Iniciar de Nuevo</button>
            <button class="button" onclick="nextStep('continuar_step3')">No tiene IP publica</button>
        </div>

        <div id="step4" class="step hidden">
            <p><h4>Accion a tomar: </h4></p>
            <p>1. Indicale al cliente que desconecte el Router.</p>
            <p>2. Realiza Reset de puertos desde PISA:</p>
            <div class="image-container">
                    <img src="reset_msan.png" alt="resent" style="max-width: 100%; height: auto; margin: 10px 0;">
            </div>
            <p>3. Despues de Enviar el Reset, indicar que lo conecte nuevamente. Espera que las luces enciendan</p>
             <p><h4>4. Preguntale por el estado de las luces del Router</h4></p>
             <p><h4>5. Confirma si puede navegar</h4></p>
            <button class="button" onclick="reset()">iniciar de Nuevo</button>
            <button class="button" onclick="nextStep('step4_no')">No puede Navegar</button>
        </div>

        <div id="step5" class="step hidden">
            <p><h4>Colocar IP en automatico</h4></p>
            <p>1. Indicarle al cliente que vas a realizar pruebas a traves del computador</p>
            <p><i>Abrir la imagen</i><p>
            <div class="image-container">
                <img id="myImg" src="ip.png" alt="resent" style="max-width: 100%; height: auto; margin: 10px 0;">
            </div>
            <button class="button" onclick="nextStep('step5_no')">Continuar</button>
        </div>

        <div id="myModal" class="modal">
                <span class="close">&times;</span>
                <img class="modal-content" id="img01">
                <div id="caption"></div>
        </div>


         <div id="step6" class="step hidden">
            <p><h4>Realiza PING a Google</h4></p>
            <p>▶ Indicale al cliente que vas a realizar pruebas desde el computador</p>
            <p>▶ Sigue los pasos de la imagen</p>
            <div class="image-container">
                    <img id="myImg1" src="ping_a_google.png" alt="resent" style="max-width: 100%; height: auto; margin: 10px 0;">
              </div>

            <button class="button" onclick="reset()">Reiniciar</button>
            <button class="button" onclick="nextStep('step6_no')">Continuar</button>
        </div>

        <div id="step7" class="step hidden">
            <p><h4>Resultados del PING</h4></p>
            <p>Si Sale este resultado:</p>
              <div class="image-container">
                    <img src="resultado_ping.png" alt="resent" style="max-width: 100%; height: auto; margin: 10px 0;">
              </div>

              <p><h4>Confirme cliente navegacion</h4></p>
               <p>Tipificar como Soporte Efectivo</p>

           <button class="button" onclick="reset()">Reiniciar</button>
        </div>

        
   


        <div id="result" class="step hidden">
            <p id="resultMessage"></p>
            <button class="button" onclick="reset()">Reiniciar</button>
        </div>


    </div>

    <script>
        function nextStep(answer) {
            document.querySelectorAll('.step').forEach(step => step.classList.add('hidden'));
            /*step1*/
            if (answer === 'cable') {
                document.getElementById('step2').classList.remove('hidden');
            } else if (answer === 'wifi') {
                document.getElementById('resultMessage').innerText = 'Seguir Checklist Wireles';
                document.getElementById('result').classList.remove('hidden');
            }

            /*step2*/
            if (answer === 'cobroYes') {
                document.getElementById('step4').classList.remove('hidden');
            } else if (answer === 'continuar_step2') {
                document.getElementById('step3').classList.remove('hidden');
            }

            /*step3*/    
            if (answer === 'yes_programacion') {
                document.getElementById('resultMessage').innerText = 'Tipificar como soporte efectivo: Reclamos ▶ Avería ▶ TV IPTV ▶ Sin señal ▶ guía interactiva';
                document.getElementById('result').classList.remove('hidden');
          } else if (answer === 'continuar_step3') {
                document.getElementById('step4').classList.remove('hidden');
            }


            /*step4*/        
            if (answer === 'step4_no') {
                document.getElementById('step5').classList.remove('hidden');
            }

            /*step5*/        

            if (answer === 'step5_yes') {
                document.getElementById('resultMessage').innerText = 'Tipificar como soporte efectivo: Reclamos > Avería > TV IPTV > Sin señal > guía interactiva';
                document.getElementById('result').classList.remove('hidden');
            } else if (answer === 'step5_no') {
                document.getElementById('step6').classList.remove('hidden');
            }

            /*step6*/        

            if (answer === 'step6_no') {
                 document.getElementById('step7').classList.remove('hidden');
            }
       

            /*step7*/  

            if (answer === 'step7_yes') {
                document.getElementById('resultMessage').innerText = 'Tipificar como soporte efectivo: Reclamos > Avería > TV IPTV > Sin señal > guía interactiva';
                document.getElementById('result').classList.remove('hidden');
            } else if (answer === 'step7_no') {
                document.getElementById('step8').classList.remove('hidden');
            }
 }

        function reset() {
            document.querySelectorAll('.step').forEach(step => step.classList.add('hidden'));
            document.getElementById('step1').classList.remove('hidden');
            document.getElementById('resultMessage').innerText = '';
        }


        // modal de ip automatico
var modal = document.getElementById("myModal");

// Obtener la imagen y el modal de imagen ampliada
var img = document.getElementById("myImg");
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");

img.onclick = function(){
  modal.style.display = "block";
  modalImg.src = this.src;
  captionText.innerHTML = this.alt;
}

// Obtener el elemento de cerrar (X) y cerrar el modal cuando se haga clic
var span = document.getElementsByClassName("close")[0];

span.onclick = function() { 
  modal.style.display = "none";
}


// modal del ping
var modal = document.getElementById("myModal");

// Obtener la imagen y el modal de imagen ampliada
var img = document.getElementById("myImg1");
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");

img.onclick = function(){
  modal.style.display = "block";
  modalImg.src = this.src;
  captionText.innerHTML = this.alt;
}

// Obtener el elemento de cerrar (X) y cerrar el modal cuando se haga clic
var span = document.getElementsByClassName("close")[0];

span.onclick = function() { 
  modal.style.display = "none";
}

    </script>
</body>
</html>
