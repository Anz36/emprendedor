<?php include_once "../Proveedor/funcionProveedor.php";


	if (isset($_POST["enviar"])) {
		$idProveedor = $_POST["proveedor"];
		$idPersona = $_POST["idPersona"];
		$razon = $_POST["titulo"];
		$descripcion = $_POST["descripcion"];
		$prioridad = $_POST["prioridad"];
		$fecha = $_POST["fecha"];
		$visualizaciones = 0;

		$pum = false;
		$registroMensaje = registrarMensaje($razon,$descripcion,$fecha,$idPersona,$idProveedor);
		if ($registroMensaje) {
			$idMensaje = capturarMensaje($idPersona);
			foreach($_FILES["archivo"]['tmp_name'] as $key => $tmp_name){
						//Validamos que el archivo exista
						if($_FILES["archivo"]["name"][$key]) {
							$filename = $_FILES["archivo"]["name"][$key]; //Obtenemos el nombre original del archivo
							$source = $_FILES["archivo"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo
							
							$directorio = '../archivos/'.$idPersona."/"; //Declaramos un  variable con la ruta donde guardaremos los archivos
							
							//Validamos si la ruta de destino existe, en caso de no existir la creamos
							if(!file_exists($directorio)){
								mkdir($directorio);
							}
							
							$dir=opendir($directorio); //Abrimos el directorio de destino
							$archivo = $directorio."/".$filename;
							//Movemos y validamos que el archivo se haya cargado correctamente
							//El primer campo es el origen y el segundo el destino
							if(@move_uploaded_file($source, $archivo)) {
								registrarPdf($idMensaje,$filename,$idProveedor,$prioridad,$fecha,$visualizaciones);
								$pum = true;
							}
							closedir($dir); //Cerramos el directorio de destino
						}
					}
					if ($pum) {
						header("Location: ../Proveedor/adjuntarProveedor.php?mensaje=Archivos Guardados Correctamente.");
					}
		} else {
			header("Location: ../Proveedor/adjuntarProveedor.php?mensaje=Ha ocurrido un error al guardar los archivos.");
	} 
}
 ?>		
