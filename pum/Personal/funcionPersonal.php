<?php 
	include_once "../ConexionDb/funcionConexion.php";
	#Mostramos en la Lista de Personas -- Desabilitado.
	function capturarPersonas(){
		$db = obtenerBaseDeDatos();
		$sentencia = $db->query("SELECT * FROM personas");
		return $sentencia->fetchAll();
	}
	#Registramos los datos, otenidos mediante el formulario
	function registrarPersona($nombre,$apellido,$nacimiento,$correo,$telefono){
		$db = obtenerBaseDeDatos();
		$sentencia = $db->prepare("INSERT INTO personas(nombre,apellido,nacimiento,correo,telefono) VALUES (?,?,?,?,?)");
		return $sentencia->execute([$nombre,$apellido,$nacimiento,$correo,$telefono]);
	}
	#Por verse ...
	function existeProveedor($ruc){
		$db = obtenerBaseDeDatos();
		$sentencia = $db->prepare("SELECT ruc FROM proveedores WHERE ruc = ? LIMIT 1");
		$sentencia->execute([$ruc]);
    	return $sentencia->fetchObject();
	}
 ?>