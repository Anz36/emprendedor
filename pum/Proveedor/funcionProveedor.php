<?php 
	include_once "../ConexionDb/funcionConexion.php";
	#Mostramos en la Lista de Proveedores.
	function capturarProveedor(){
		$db = obtenerBaseDeDatos();
		$sentencia = $db->query("SELECT * FROM empresas");
		return $sentencia->fetchAll();
	}
	#Mostramos las prioridades
	function listarPrioridad(){
		$db = obtenerBaseDeDatos();
		$sentencia = $db->query("SELECT * FROM status_documentos");
		return $sentencia->fetchAll();
	}
	#Registramos los datos, otenidos mediante el formulario.
	function registrarProveedor($ruc,$nombre,$rubro,$direccion){
		$db = obtenerBaseDeDatos();
		$sentencia = $db->prepare("INSERT INTO empresas(RUC,nombre,rubro,direccion) VALUES (?,?,?,?)");
		return $sentencia->execute([$ruc,$nombre,$rubro,$direccion]);
	}
	#Existe Proveedor con el mismo RUC.
	function existeProveedor($ruc){
		$db = obtenerBaseDeDatos();
		$sentencia = $db->prepare("SELECT RUC FROM empresas WHERE RUC = ? LIMIT 1");
		$sentencia->execute([$ruc]);
    	return $sentencia->fetchObject();
	}
	#Capturamos el ID Mensaje.
	function capturarMensaje($idPersona){
		$db = obtenerBaseDeDatos();
		$sentencia = $db->prepare("SELECT id FROM mensajes WHERE id_persona = ? ORDER BY fecha DESC LIMIT 1");
		$sentencia->execute([$idPersona]);
		return $sentencia->fetchObject()->id;
	}
	#Registramos el Mensaje.
	function registrarMensaje($titulo,$mensaje,$fecha,$idPersona,$idProveedor){
		$db = obtenerBaseDeDatos();
		$sentencia = $db->prepare("INSERT INTO mensajes(titulo, descripcion, fecha, id_persona, id_empresa) VALUES (?,?,?,?,?)");
		return $sentencia->execute([$titulo,$mensaje,$fecha,$idPersona,$idProveedor]);
	}
	#Registramos el PDF a la DBA.
	function registrarPdf($idMensaje,$nombreArchivo,$idProveedor,$idStatus,$fecha,$visulizaciones){
		$db = obtenerBaseDeDatos();
		$sentencia = $db->prepare("INSERT INTO documentosProveedor(id_proveedor,id_status,id_mensaje,nombreArchivo,fecha,visulizaciones) VALUES (?,?,?,?,?,?)");
		return $sentencia->execute([$idProveedor,$idStatus,$idMensaje,$nombreArchivo,$fecha,$visulizaciones]);
	}
	#Mostramos en la Lista de Proveedores.
	function capturarIdProveedor($idProveedor){
		$db = obtenerBaseDeDatos();
		$sentencia = $db->prepare("SELECT id_empresa FROM proveedores WHERE id_usuario = ?");
		$sentencia->execute([$idProveedor]);
		return $sentencia->fetchObject()->id_empresa;
	}
	#Obtener datos de los Proveedores para monitorear las vistas.
	function obtenerDatosProveedores($idPersona){
		$db = obtenerBaseDeDatos();
		$sentencia = $db->prepare("SELECT * FROM mensajes WHERE id_persona = ? ORDER BY fecha DESC");
		$sentencia->execute([$idPersona]);
		return $sentencia->fetchAll();
	}
	#Obtener los datos status y mas.
	function obtenerDatosEnvios($idMensaje){
		$db = obtenerBaseDeDatos();
		$sentencia = $db->prepare("SELECT * FROM documentosProveedor WHERE id_mensaje = ? ORDER BY fecha DESC");
		$sentencia->execute([$idMensaje]);
		return $sentencia->fetchAll();
	}
	#Obtener datos de los Proveedores para visualizar el PDF.
	function obtenerProveedoresPdf($proveedor){
		$db = obtenerBaseDeDatos();
		$sentencia = $db->prepare("SELECT * FROM documentosProveedor WHERE id_proveedor = ? ORDER BY fecha DESC");
		$sentencia->execute([$proveedor]);
		return $sentencia->fetchAll();
	}
	#Obtener el ID del Status y visualizar el nombre
	function obtenerStatusDocumento($idStatus){
		$db = obtenerBaseDeDatos();
		$sentencia = $db->prepare("SELECT * FROM status_documentos WHERE id = ?");
		$sentencia->execute([$idStatus]);
		return $sentencia->fetchObject()->status;
	}
	#Obtener datos mediante el id.
	function obtenerPdf($idProveedor){
		$db = obtenerBaseDeDatos();
		$sentencia = $db->prepare("SELECT nombreArchivo FROM pdfproveedor WHERE id = ?");
		$sentencia->execute([$idProveedor]);
		return $sentencia->fetchObject()->nombreArchivo;
	}
	function descargarFichero($idProveedor,$nombreArchivo){
		$fichero = "../archivos/".$idProveedor."/".$nombreArchivo; 
		if (file_exists($fichero)) {
			header('Content-Description: File Transfer');
		    header('Content-Type: application/octet-stream');
		    header('Content-Disposition: attachment; filename="'.basename($fichero).'"');
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate');
		    header('Pragma: public');
		    header('Content-Length: ' . filesize($fichero));
		    ob_clean();
		    flush();
		    return readfile($fichero);
		}
	}
	function contadorIdDescargas($idProveedor,$nobmreArchivo){
		$db = obtenerBaseDeDatos();
		$sentencia = $db->prepare("SELECT id,visulizaciones FROM documentosProveedor WHERE id_proveedor = ? AND nombreArchivo = ?");
		$sentencia->execute([$idProveedor,$nobmreArchivo]);
		return $sentencia->fetchObject();
	}
	function contadorDescargas($nombreArchivo,$visulizaciones){
		$db = obtenerBaseDeDatos();
		$sentencia = $db->prepare("UPDATE documentosProveedor SET visulizaciones = ? WHERE nombreArchivo = ?");
		return $sentencia->execute([$visulizaciones,$nombreArchivo]);
	}
 ?>