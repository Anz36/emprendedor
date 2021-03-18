<?php 
	include_once "../Usuario/funcionUsuarios.php";
	$idEmpresa = $_POST["id"];
	$rucEmpresa = $_POST["rucEmpresa"];
	$nombreEmpresa = $_POST["nombreEmpresa"];
	$rubroEmpresa = $_POST["rubroEmpresa"];
	$direccionEmpresa = $_POST["direccionEmpresa"];
	
			$updateCorrectamente = updateProveedor($idEmpresa,$rucEmpresa,$nombreEmpresa,$rubroEmpresa,$direccionEmpresa);
 			if ($updateCorrectamente) {
 				header("Location: ../Usuario/perfil.php?mensaje=Perfil Actualizado.");
 			} else {
 				header("Location: ../Usuario/perfil.php?mensaje=Perfil no actualizado, verifique sus datos.");
 			}
?>