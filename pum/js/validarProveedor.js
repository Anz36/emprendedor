
function ValidarProveedor() {
    
    var ruc = document.getElementById("ruc").value;
    var razonSocial = document.getElementById("razonSocial").value;
    var rubro = document.getElementById("rubro").value;
    var direccion = document.getElementById("direccion").value;
    var errorDiv = document.getElementById("error");

    var mensajeError = [];   
    if (ValidarRUC(ruc) !== "") {
        $('div.error').removeClass('ocultar');
        mensajeError.push(ValidarRUC(ruc));
    }
    if (razonSocial === "") {
        $('div.error').removeClass('ocultar');
        mensajeError.push("Ingrese Razon Social");
    }
    if (rubro === "") {
        $('div.error').removeClass('ocultar');
        mensajeError.push("Ingrese Rubro");
    }
    if (direccion === "") {
        $('div.error').removeClass('ocultar');
        mensajeError.push("Ingrese Dirección");
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

function ValidarRUC(ruc) {
    var bandera = "";
    if(ruc === ""){
        bandera = "Ingrese el RUC";
    }
    else if (ruc.length !== 11)
        bandera = "El RUC debe tener 11 numeros";
    return bandera;
}