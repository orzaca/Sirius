let currentParagraphId = null;

function copyToClipboard(paragraphId) {
    const paragraphText = document.getElementById(paragraphId).getElementsByTagName('p')[0].innerText;
    navigator.clipboard.writeText(paragraphText).then(() => {
        alert("¡Texto copiado al portapapeles!");
    }).catch(err => {
        console.error('Error al copiar el texto: ', err);
    });
}
