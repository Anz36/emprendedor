<?php 
session_start();
	include_once "../Sessiones/funcionSession.php"; include_once "../Proveedor/funcionProveedor.php"; 
	if (empty($_SESSION["codUsuario"])) {
    # Lo redireccionamos al formulario de inicio de sesión
    header("Location: formulario_login.php?mensaje=Necesita iniciar session para ingresar a la pagina protegida");
    # Y salimos del script
    exit();
}
	$idProveedor = $_GET["id"];
	$nombreArchivo = utf8_decode($_GET["nombre"]);
	$resultado = descargarFichero($idProveedor,$nombreArchivo);
	if ($resultado) {
		$contador = contadorIdDescargas($idProveedor,$nombreArchivo);
		$contadores = $contador->visulizaciones;
		$vista = $contadores;
	for ($i=$contadores; $i <= $contadores; $i++) {
		$vista += 1;
	}
		descargarFichero($idProveedor,$nombreArchivo);
		contadorDescargas($contador->id,$vista);
	} else {
		header("Location: pdfProveedor.php?mensaje=Archivo PDF inexiste");
	}

 ?>