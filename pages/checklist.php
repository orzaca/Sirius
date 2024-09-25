<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checklist</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
        }
        .container {
            margin: 10px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        .step {
            margin: 20px 0;
            padding: 15px;
            background-color: #e2e2e2;
            border-radius: 5px;
        }
        .button {
            margin: 5px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #007BFF;
            color: white;
        }
        .button:hover {
            background-color: #0056b3;
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


    </style>
</head>
<body>

<?php include 'menu_navegacion.html'; ?>


    <div class="container">
        <h3>Programacion no coincide con GUÍA</h3>
        <div id="step1" class="step">
            <p><h4>Preguntar al cliente si la caja de la TV esta conectada por cable o wifi</h4></p>
            <p>¿Esta conectada por cable o wifi?</p>
        </br>
            <button class="button" onclick="nextStep('cable')">Cable</button>
            <button class="button" onclick="nextStep('wifi')">WiFi</button>
        </div>

        <div id="step2" class="step hidden">
            <p><h4>Ingresa a Skyway y envia los siguientes comandos:</h4></p>
                    <p>Primero este:</p>
                <div class="image-container">
                    <img src="limpiar.png" alt="Imagen de Cobro" style="max-width: 100%; height: auto; margin: 10px 0;">
                    </div>
                    <p>Esperas 20 segundos y Luego este:</p>
                  <div class="image-container">
                                        
                    <img src="reiniciar.png" alt="Imagen de Cobro" style="max-width: 100%; height: auto; margin: 10px 0;">
                </div>
                <p> <a href="https://www.skywayplatform.com/skyway-platform/login?backUrl=%252Ftms%252Fanalysis%252Fbasic&tenantCode=1143" target="_blank" style="color: #000000; text-decoration: underline;" >Ir a Skyway</a>.
                </p>

            <button class="button" onclick="reset()">Reiniciar</button>
            <button class="button" onclick="nextStep('continuar_step2')">Continuar</button>
        </div>

        <div id="step3" class="step hidden">
            <p><h4>Preguntar y confirmar con el cliente si ya tiene la programacion, hacer pruebas pasando los canales con el control </h4></p>
            <p>¿Coincide programacion?</p>
            <button class="button" onclick="nextStep('yes_programacion')">Sí</button>
            <button class="button" onclick="nextStep('no_programacion')">No</button>
        </div>

        <div id="step4" class="step hidden">
            <p>Envia El siguiente comando en SKYWAY:</p>
            <div class="image-container">
                    <img src="limpiar_datos.png" alt="Imagen de Cobro" style="max-width: 100%; height: auto; margin: 10px 0;">
                    </div>

                    <p> <a href="https://www.skywayplatform.com/skyway-platform/login?backUrl=%252Ftms%252Fanalysis%252Fbasic&tenantCode=1143" target="_blank" style="color: #000000; text-decoration: underline;" >Ir a Skyway</a>.
                </p>
            <button class="button" onclick="reset()">Reiniciar</button>
            <button class="button" onclick="nextStep('step4_no')">Continuar</button>
        </div>

        <div id="step5" class="step hidden">
            <p><h4>Preguntar y confirmar con el cliente si ya tiene la programacion</h4></p>
            <p>¿Coincide programacion?</p>
            <button class="button" onclick="nextStep('step5_yes')">Sí</button>
            <button class="button" onclick="nextStep('step5_no')">No</button>
        </div>
         <div id="step6" class="step hidden">
            <p><h4>Indicarle al cliente lo siguiente:</h4></p>
            <p>▶ Desconectar OTT player de la electricidad</p>
            <p>▶ Desconectar y conectar HDMI</p>
            <p>▶ Conectar todo nuevamente</p>
            <button class="button" onclick="reset()">Reiniciar</button>
            <button class="button" onclick="nextStep('step6_no')">Continuar</button>
        </div>

        <div id="step7" class="step hidden">
            <p><h4>Preguntar y confirmar con el cliente si ya tiene la programacion</h4></p>
            <p>¿Coincide programacion?</p>
             <button class="button" onclick="nextStep('step7_yes')">Sí</button>
            <button class="button" onclick="nextStep('step7_no')">No</button>
        </div>

        <div id="step8" class="step hidden">
            <p><h3>Realizar WF Por Guia Interactiva</h3></p>
            <p><h4>Reclamos > Avería > tv IPTV > sin acceso a guía interactiva WF<h4></p>
             <p><i>Importante: informarle al cliente que en 48hrs. Estará resuelto el inconveniente</i></p>
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
                document.getElementById('resultMessage').innerText = 'Ingresar queja detallando que la OTT se encuentra via wifi y esto ocasiona inconveniente con la señal y enviar a etapa FGD';
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
          } else if (answer === 'no_programacion') {
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
    </script>
</body>
</html>
