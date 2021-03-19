<?php 

	include_once "../VistaAdmin/funciones.php";

	$idDetalle = $_POST["id"];
	$idPersona = $_POST["idUsuario"];
	$atender = $_POST["atender"];


	if (isset($_POST["actualizar"])) {
		if ($atender == "4" || $atender == 6) {
			$resultado = updatePedido($idPersona,$idDetalle,$atender);
			if ($resultado) {
				updateStatus($idDetalle,convertirStatus($atender));
				header("Location: ../VistaAdmin/listas.php");
			}
		} else {
			$resultado = updatePedido($idPersona,$idDetalle,$atender);
			if ($resultado) {
				updateStatus($idDetalle,convertirStatus($atender));
				header("Location: ../Producto/detalleAtencion.php");
			}
		}
	}
	
 ?>