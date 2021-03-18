<?php 
include_once "../Proveedor/funcionProveedor.php";

	$resultado = false;
	if ($resultado) {
		$contador = contadorIdDescargas(1,"Detalle PDFAsd.pdf");
		$contadores = $contador->visulizaciones;
		$vista = $contadores;
	for ($i=$contadores; $i <= $contadores; $i++) {
		$vista += 1;
	}
	echo contadorDescargas($contador->id,$vista); echo "<br>";
	echo $vista;	
	echo "<br>";
	echo $contadores;
	} else {
		echo "Adios Mundo";
	}
	
 ?>