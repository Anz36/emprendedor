<?php include_once "../Proveedor/funcionProveedor.php";


	if (isset($_POST["enviar"])) {
		$idProveedor = $_POST["proveedor"];
		$razon = $_POST["titulo"];
		$descripcion = $_POST["descripcion"];
		$prioridad = $_POST["prioridad"];
		$fecha = $_POST["fecha"];
		$visualizaciones = 0;
		$nombre = $_FILES['archivo']['name'];
		$tipo = $_FILES['archivo']['type'];
		$tamaño = $_FILES['archivo']['size'];
		$nombreTemporal = $_FILES['archivo']['tmp_name'];
		$permitidos = array('application/pdf');
		$limiteKb = 1000000*1024;
		if (empty($_POST["titulo"])) {
			header("Location: ../Proveedor/adjuntarProveedor.php?mensaje=Falta la Razon.");
			exit;
		} else {
			if (empty($_POST["descripcion"])) {
				header("Location: ../Proveedor/adjuntarProveedor.php?mensaje=Falta la Descripción.");
				exit;
			} else {
				if ($_POST["proveedor"] == "NULL") {
					header("Location: ../Proveedor/adjuntarProveedor.php?mensaje=Falta Proveedor.");
					exit;
				} else {
					if (in_array($tipo,$permitidos) && $tamaño <= $limiteKb) {
						#if (copy($ruta, $destino)) {
						$destino = "../archivos/".$idProveedor."/";
						$archivo = $destino.$nombre;
						if (!file_exists($destino)) {
							mkdir($destino);
						}
						if (!file_exists($archivo)) {
							$resultado = @move_uploaded_file($nombreTemporal,$archivo);
							if ($resultado) {
								$registradoCorrectamente = registrarPdf($razon,$descripcion,$tamaño,$tipo,$nombre,$idProveedor,$prioridad,$fecha,$visualizaciones);
								if ($registradoCorrectamente) {
									header("Location: ../Proveedor/adjuntarProveedor.php?mensaje=Archivo guardado.");
									exit;
							} else {
									header("Location: ../Proveedor/adjuntarProveedor.php?mensaje=Archivo rechazado.");
									exit;
							}
							} else {
								header("Location: ../Proveedor/adjuntarProveedor.php?mensaje=Archivo no guardado.");
							exit;
							}
						} else {
							header("Location: ../Proveedor/adjuntarProveedor.php?mensaje=Archivo existente.");
							exit;
						}
						} else {
							header("Location: ../Proveedor/adjuntarProveedor.php?mensaje=Archivo no permitido (Solo PDF) o execede el tamaño.");
							exit;
						}
					#}
				}
			}
		}
	}
 ?>