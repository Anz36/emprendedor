<?php 
		include_once "funciones.php";
		$idDetalle = $_POST["id"];

		if (isset($_POST["modificar_".$idDetalle])) {
		       		$resultado = datosTemporales($_POST["id"],$_POST["idPersona"],$_POST["atender"]);
		        		if ($resultado) {
		        			$datos = capturarListado();
		        			$tabla = filtroListaPedido();
		        			$result = xdxd($datos,$tabla);
		        			if ($result) {
		        				updateStatus($idDetalle,convertirStatus($_POST["atender"]));
		        				header("Location: ../Producto/detalleAtencion.php");
		        			} else {
		        				header("Location: ../VistaAdmin/listas.php");
		        			}
			        	}
			    }
?>