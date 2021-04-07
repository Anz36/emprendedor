<?php

include_once "../FuncionesExtra/funciones.php";
$dato = obtenerClientes();
foreach ($dato as $datos){
	$estado = obtenerIdCliente($datos->customer_id);
	foreach ($estado as $Clientes) {
		if ($Clientes->Contador >= "5"){
			$pum = obtenerClientePorEstado($Clientes->customer_id);
			foreach ($pum as $pumes) {
				echo "Caso de Habitual"; echo "<br>";
				echo $pumes->customer_id;echo "<br>";
				echo $pumes->first_name;
			}
		}
		echo "<br>";
		if ($Clientes->Contador == "3" ||  $Clientes->Contador == "4"){
			$pum = obtenerClientePorEstado($Clientes->customer_id);
			foreach ($pum as $pumes) {
				echo "Caso Emprendedor"; echo "<br>";
				echo $pumes->customer_id; echo "<br>";
				echo $pumes->first_name;
			}
		}
		echo "<br>";
		if ($Clientes->Contador <= "2"){
			$pum = obtenerClientePorEstado($Clientes->customer_id);
			foreach ($pum as $pumes) {
				 echo "Caso Nuevo"; echo "<br>";
				echo $pumes->customer_id; echo "<br>";
				echo $pumes->first_name;
			}
		}
		echo "<br>";

	}
}
?>
