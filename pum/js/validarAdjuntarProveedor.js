
function Validar() {
    
    var nombre = document.getElementById("razon").value;
    var errorDiv = document.getElementById("error");

    var mensajeError = [];

    
    if (nombre === "") {
        $('div.error').removeClass('ocultar');
        mensajeError.push("Ingrese Razon Social");
    }    

    errorDiv.innerHTML = mensajeError.join('<br>');
    if (mensajeError.length > 0) {
        document.getElementById("divError").style.display = "block";
        return false;
    } else {
        $('div.error').addClass('ocultar');
        return confirm('¿Estas seguro de adjuntar?');
    }
}