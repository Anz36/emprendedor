
function ValidarPersonal() {
    
    var nombre = document.getElementById("nombre").value;
    var apellido = document.getElementById("apellido").value;
    var fecha = document.getElementById("fecha").value;
    var correo = document.getElementById("correo").value;
    var celular = document.getElementById("celular").value;
    var errorDiv = document.getElementById("error");

    var mensajeError = [];

    
    if (nombre === "") {
        $('div.error').removeClass('ocultar');
        mensajeError.push("Ingrese el Nombre del Usuario");
    }
    if (apellido === "") {
        $('div.error').removeClass('ocultar');
        mensajeError.push("Ingrese los Apellidos del Usuario");
    } 
    if (correo === "") {
        $('div.error').removeClass('ocultar');
        mensajeError.push("Ingrese el correo");
    } 
    if (ValidarCelular(celular) !== "") {
        $('div.error').removeClass('ocultar');
        mensajeError.push(ValidarCelular(celular));
    }    
    if (ValidarFecha(fecha) !== "") {
        $('div.error').removeClass('ocultar');
        mensajeError.push(ValidarFecha(fecha));
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

function ValidarCelular(celular) {
    var bandera = "";
    if(celular === ""){
        bandera = "Ingrese el Celular";
    }
    else if (celular.length !== 9)
        bandera = "El Celular debe tener 9 numeros";
    return bandera;
}

function ValidarFecha(fecha) {
    var bandera = "";
    var menor = false;
    var f = new Date();
    var fechaActual = f.getFullYear() + "/0" + (f.getMonth() + 1) + "/" + f.getDate();

    var day = fecha.charAt(8) + fecha.charAt(9);
    var month = fecha.charAt(5) + fecha.charAt(6);
    var year = fecha.charAt(0) + fecha.charAt(1) + fecha.charAt(2) + fecha.charAt(3);

    var dayy = fechaActual.charAt(8) + fechaActual.charAt(9);
    var monthh = fechaActual.charAt(5) + fechaActual.charAt(6);
    var yearr = fechaActual.charAt(0) + fechaActual.charAt(1) + fechaActual.charAt(2) + fechaActual.charAt(3);


    if (parseInt(yearr) - parseInt(year) <= 0)
        menor = true;
    if (parseInt(yearr) - parseInt(year) <= 18)
        if (parseInt(month) > parseInt(monthh))
            menor = true;

    if (parseInt(yearr) - parseInt(year) <= 18)
        if (parseInt(month) == parseInt(monthh))
            if (parseInt(day) > parseInt(dayy))
                menor = true;

    if (menor)
        bandera = "Usted es menor de edad";

    if (!fecha)
        bandera = "Seleccione fecha de nacimiento";
    return bandera;
}