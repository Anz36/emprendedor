<?php include_once "../Personal/funcionPersonal.php";

	$nombre = $_POST["nombrePersona"];
	$apellido = $_POST["apellidoPersona"];
	$nacimiento = $_POST["nacimiento"];
	$correo = $_POST["correo"];
	$celular = $_POST["celular"];


	if (empty($_POST["nombrePersona"])) {
		header("Location: ../Personal/nuevoPersonal.php?mensaje=Ingrese el Nombre, faltan datos");
		exit;
	}else {
		if (empty($_POST["apellidoPersona"])) {
		header("Location: ../Personal/nuevoPersonal.php?mensaje=Ingrese el Apellido, faltan datos");
		exit;
	} else {
		if (empty($_POST["nacimiento"])) {
		header("Location: ../Personal/nuevoPersonal.php?mensaje=Ingrese el Nacimiento, faltan datos");
		exit;
	}
	}
	}
	
		$registradoCorrectamente = registrarPersona($nombre,$apellido,$nacimiento,$correo,$celular);
		if ($registradoCorrectamente) {
			    header("Location: ../Personal/nuevoPersonal.php?mensaje=Registro completado.");
			} else {
			    header("Location: ../Personal/nuevoPersonal.php?mensaje=Error al ingresar los datos, intentelo denuevo.");
			}


 ?>