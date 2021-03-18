<?php 
	include_once "../Usuario/funcionUsuarios.php";
	$idPersona = $_POST["id"];
	$nombrePersona = $_POST["nombreUsuario"];
	$apellidoPersona = $_POST["apellidoUsuario"];
	$nacimiento = $_POST["nacimientoUsuario"];
	$correo = $_POST["correo"];
	$telefono = $_POST["celular"];
	
			$updateCorrectamente = updatePersona($idPersona,$nombrePersona,$apellidoPersona,$nacimiento,$correo,$telefono);
 			if ($updateCorrectamente) {
 				header("Location: ../Usuario/perfil.php?mensaje=Perfil Modificado.");
 			} else {
 				header("Location: ../Usuario/perfil.php?mensaje=Registro no actualizado, verifique sus datos.");
 			}
?>