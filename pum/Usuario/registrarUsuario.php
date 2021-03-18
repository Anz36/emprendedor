<?php include_once "../Usuario/funcionUsuarios.php"; 
include_once "../Encriptar/Encriptar.php";
	
	$personaNatural = $_POST["personaNatural"];
	$personaEmpresa = $_POST["personaEmpresa"];
	$nombreUsuario = $_POST["nombreUsuario"];
	$estadoUsuario = $_POST["estadoUsuario"];
	$palabraSecreta = $_POST["palabraSecreta"];
	$palabraSecretaValidar = $_POST["palabraSecretaValidar"];
	$tipoUsuario = $_POST["tipoUsuario"];

	if (empty($_POST["nombreUsuario"])) {
		header("Location: ../Usuario/nuevoUsuarios.php?mensaje=Ingrese el Nombre del Usuario");
		exit;
	} else {
		if (empty($_POST["palabraSecreta"])) {
			header("Location: ../Usuario/nuevoUsuarios.php?mensaje=Ingrese el la Contraseña del Usuario");
			exit;
		} else {
			if (empty($_POST["palabraSecretaValidar"])) {
				header("Location: ../Usuario/nuevoUsuarios.php?mensaje=No se olvide de repetir la contraseña");
				exit;
			}
		}
	}
	if ($palabraSecreta !== $palabraSecretaValidar) {
   	 	header("Location: ../Usuario/nuevoUsuarios.php?mensaje=Las contraseñas no coninciden");
   	 	exit;
	}

	$existe = usuarioExiste($nombreUsuario);
	if ($existe) {
		header("Location: ../Usuario/nuevoUsuarios.php?mensaje=El Usuario ya existe.");
		exit;
	}

 $valor = validarContraseña($palabraSecreta);
 	if ($valor == true) {
 		#Aquí se ingresara los datos obtenidos dentro de los cambos del formulario;
 		$registradoCorrectamente = registrarUsuario($personaNatural,$personaEmpresa,$nombreUsuario,encriptar($palabraSecreta),$estadoUsuario,$tipoUsuario);
		if ($registradoCorrectamente) {
			    header("Location: ../Usuario/nuevoUsuarios.php?mensaje=Registro completado. Ahora puedes iniciar session.");
			} else {
			    header("Location: ../Usuario/nuevoUsuarios.php?mensaje=Error al ingresar los datos, intentelo denuevo.");
			}
 	} else {
 		if ($valor == 1) {
 		header("Location: ../Usuario/nuevoUsuarios.php?mensaje=La contraseña debe tener al menos 6 caracteres");	
 		} else{
 			if ($valor == 2) {
 				header("Location: ../Usuario/nuevoUsuarios.php?mensaje=La contraseña debe tener al menos 18 caracteres");	
 			} else {
 				if ($valor == 3) {
 					header("Location: ../Usuario/nuevoUsuarios.php?mensaje=La contraseña debe tener al menos una letra minuscula");	
 				} else {
 					if ($valor == 4) {
 						header("Location: ../Usuario/nuevoUsuarios.php?mensaje=La contraseña debe tener al menos una letra mayuscula");	
 					} else {
 						if ($valor == 5) {
 							header("Location: ../Usuario/nuevoUsuarios.php?mensaje=La contraseña debe tener al menos un dato numérico");	
 						}
 					}
 				}
 			}
 		}
 	}
?>
