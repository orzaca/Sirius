// Creado por: Orlando Zambrano - 2024
// Whatsapp: +57 310 421 4197

//  ** Modulo Step **
//  La Funcion Principal de este codigo, es en los checklist, que al darle click al boton SI, NO, 
// CONTINUAR O REINICIAR, no se salga de la pagina y sea interactivo en la misma.

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

