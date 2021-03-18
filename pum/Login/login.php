<?php 
	#Capturamos los Datos a validar
	$usuario = $_POST["usuario"];
	$palabraSecreta = $_POST["palabraSecreta"];

	#Luego de haber obtenido los datos, comprobamos.
	if (!isset($_POST["usuario"]) || !isset($_POST["palabraSecreta"])) {
		exit("Faltan Datos");
	}
	include ("../Sessiones/funcionSession.php");
	$logueoConExito = login($usuario,$palabraSecreta);
	if ($logueoConExito == 0) {
		# Logueo Fallido, redireccionamos.
		header("Location: ../Login/formulario_login.php?mensaje=Usuario o Contraseña incorrecta, vuelta a intentarlo.");
	} 
	if ($logueoConExito == 1) {
			# Logueo Exitoso
			header("Location: ../VistaAdmin/main.php");
		}
		if ($logueoConExito == 3) {
			# Inteto de ingreso forzoso.
			header("Location: ../Login/formulario_login.php?mensaje=Su cuenta se encuentra Desactivada, contactar con un Adminitrador.");
		}

 ?>