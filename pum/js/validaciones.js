
function numeros(e) {
    key = e.keyCode || e.which;
    teclado = String.fromCharCode(key);
    numero = "0123456789";
    if (numero.indexOf(teclado) == -1)
        return false;
}

function letras(e) {
    key = e.keyCode || e.which;
    teclado1 = String.fromCharCode(key).toLowerCase(); //convertir a minusculas
    letra = "abcdefghijklmnñopqrstuvwxyz ";
    if (letra.indexOf(teclado1) == -1)
        return false;
}

function ValidarUsuario() {
    
    var usuario = document.getElementById("usuario").value;
    var pass1 = document.getElementById("pass1").value;
    var pass2 = document.getElementById("pass2").value;
    var errorDiv = document.getElementById("error");

    var mensajeError = [];

    
    if (usuario === "") {
        $('div.error').removeClass('ocultar');
        mensajeError.push("Ingrese el Nombre del Usuario");
    }
    if (pass1 === "") {
        $('div.error').removeClass('ocultar');
        mensajeError.push("Ingrese el la Contraseña del Usuario");
    }
    if (pass2 === "") {
        $('div.error').removeClass('ocultar');
        mensajeError.push("No se olvide de repetir la contraseña");
    }

    if (pass2 !== pass1) {
        $('div.error').removeClass('ocultar');
        mensajeError.push("Las contraseñas no coninciden");
    }
    

    errorDiv.innerHTML = mensajeError.join('<br>');
    if (mensajeError.length > 0) {
        document.getElementById("divError").style.display = "block";
        return false;
    } else {
        $('div.error').addClass('ocultar');
        return true;
    }
}

