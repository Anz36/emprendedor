<?php 
	include_once "funcionUsuarios.php";
	include_once "../Encriptar/Encriptar.php";
	$idUsuario = $_POST["id"];
	$nombreUsuario = $_POST["nombreUsuario"];
	$palabraSecretaActual = $_POST["palabraSecretaActual"];
	$palabraSecreta = $_POST["palabraSecreta"];
	$palabraSecretaRepetir = $_POST["palabraSecretaRepetir"];

	$datoUsuario = obtenerDatoUsuario($idUsuario);

	$palabraSecretaActual = encriptar($palabraSecretaActual);
	if ($palabraSecretaActual != $datoUsuario->palabraClave) {
		header("Location: ../Usuario/perfil.php?mensaje=La contraseña actual no coinciden con las credenciales.");
	} else {
		if ($palabraSecreta != $palabraSecretaRepetir) {
		header("Location: ../Usuario/perfil.php?mensaje=Las contraseñas no coinciden.");
	} else {
		$resultado = updateContraseña($idUsuario,$nombreUsuario,encriptar($palabraSecreta));
		if ($resultado) {
			header("Location: ../Login/formulario_login.php?mensaje=Crecendiales Modificadas, vuelva a ingresar, por favor.");
		} else {
			header("Location: ../Usuario/perfil.php?mensaje=Credenciales no actualizados, verificar los datos.");
		}
	}
}
 ?>