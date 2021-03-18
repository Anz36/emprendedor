<?php 
	include_once "../ConexionDb/funcionConexion.php";
    #Obtener los Datos del Usuario al iniciar session
    function obtenerDatoUsuario($usuario){
        $db = obtenerBaseDeDatos();
        $sentencia = $db->prepare("SELECT * FROM usuarios WHERE id = ?");
        $sentencia->execute([$usuario]);
        return $sentencia->fetchObject();
    }
    #Obtener los Datos de la Tabla Usuarios
    function obtenerUsuarios(){
        $db = obtenerBaseDeDatos();
        $sentencia = $db->query("SELECT * FROM usuarios");
        return $sentencia->fetchAll();      
    }
    #Obtener Datos de la Tabla Persona
    function obtenerPersonas(){
    	$db = obtenerBaseDeDatos();
    	$sentencia = $db->query("SELECT * FROM personas");
    	return $sentencia->fetchAll();
    }
    #Obtener Datos de la Tabla Proveedores
    function obtenerProveedores(){
    	$db = obtenerBaseDeDatos();
    	$sentencia = $db->query("SELECT * FROM empresas");
    	return $sentencia->fetchAll();
    }
    #Buscamos el Nombre Persona Natural
    function busquedaDeNombreNatural($dato){
    	$db = obtenerBaseDeDatos();
    	$sentencia = $db->prepare("SELECT * FROM personas WHERE id = ?");
    	$sentencia->execute([$dato]);
    	return $sentencia->fetchObject()->nombre;
    }
    #Buscamos el nobmre Persona Natural
    function busquedaDeApellidoNatural($dato){
    	$db = obtenerBaseDeDatos();
    	$sentencia = $db->prepare("SELECT * FROM personas WHERE id = ?");
    	$sentencia->execute([$dato]);
    	return $sentencia->fetchObject()->apellido;
    }
    #Buscamos el Nombre Persona Empresarial
    function busquedaDeNombreEmpresa($dato){
    	$db = obtenerBaseDeDatos();
    	$sentencia = $db->prepare("SELECT * FROM proveedores WHERE id = ?");
    	$sentencia->execute([$dato]);
    	return $sentencia->fetchObject()->nombre;
    }
    #Verificamos el NULL dentro de la tabla Usuarios 
    function estadoUsuario($dato){
        if ($dato == 1) {
            # Mostraremos un digito 0
            return "Activo";
        } else{
            return "Desactivado";
        }
    }
    function nombreUsuariosNaturales($dato){
    	if ($dato == null) {
    		return "Restringido";
    	} else {
    		return busquedaDeNombreNatural($dato)." ".busquedaDeApellidoNatural($dato);
    	}
    }
    function nombreUsuariosEmpresa($dato){
    	if ($dato == null) {
    		return "Restringido";
    	} else {
    		return busquedaDeNombreEmpresa($dato);
    	}
    }
    function usuarioExiste($usuario){
        $db = obtenerBaseDeDatos();
        $sentencia = $db->prepare("SELECT usuarioIngreso FROM usuarios WHERE usuarioIngreso = ? LIMIT 1");
        $sentencia->execute([$usuario]);
        return $sentencia->fetchObject();
    }
    function registrarUsuario($personaNatural,$personaProovedor,$usuarioIngreso,$palabraClave,$estadoUsuario,$tipoUsuario){
        $db = obtenerBaseDeDatos();
        if ($personaNatural == "NULL") {
            $sentencia = $db->prepare("INSERT INTO usuarios(usuarioIngreso,palabraClave,estadoUsuario,tipoUsuario) VALUES (?,?,?,?)");
            $sentencia->execute([$usuarioIngreso,$palabraClave,$estadoUsuario,$tipoUsuario]);
            return ingresarEmpresa(idUsuario($usuarioIngreso),$personaProovedor);
        } else
        {
            $sentencia = $db->prepare("INSERT INTO usuarios(usuarioIngreso,palabraClave,estadoUsuario,tipoUsuario) VALUES (?,?,?,?)");
            $sentencia->execute([$usuarioIngreso,$palabraClave,$estadoUsuario,$tipoUsuario]);
            return ingresarPersonal(idUsuario($usuarioIngreso),$personaNatural);
        }
            
    }
    function idUsuario($nombreUsuario){
        $db = obtenerBaseDeDatos();
        $sentencia = $db->prepare("SELECT id FROM usuarios WHERE usuarioIngreso = ?");
        $sentencia->execute([$nombreUsuario]);
        return $sentencia->fetchObject()->id;
    }

    function ingresarEmpresa($idUsuario,$idProveedor){
        $db = obtenerBaseDeDatos();
        $sentencia = $db->prepare("INSERT INTO proveedores(id_empresa,id_usuario) VALUES (?,?)");
        return $sentencia->execute([$idProveedor,$idUsuario]);
    }

    function ingresarPersonal($idUsuario,$idPersonal){
        $db = obtenerBaseDeDatos();
        $sentencia = $db->prepare("INSERT INTO personal(id_persona,id_usuario) VALUES (?,?)");
        return $sentencia->execute([$idPersonal,$idUsuario]);
    }

    function updateContraseña($idUsuario, $nombreIngreso, $palabraClave){
        $db = obtenerBaseDeDatos();
            $sentencia = $db->prepare("UPDATE usuarios SET usuarioIngreso = ?, palabraClave = ? WHERE id = ?");
            return $sentencia->execute([$nombreIngreso,$palabraClave,$idUsuario]);
    }

    function updatePersona($idPersona, $nombrePersona, $apellidoPersona, $nacimientoPersona, $correo, $telefono){
        $db = obtenerBaseDeDatos();
        $sentencia = $db->prepare("UPDATE personas SET nombre = ?, apellido = ?, nacimiento = ?, correo = ?, telefono = ? WHERE id = ?");
        return $sentencia->execute([$nombrePersona, $apellidoPersona, $nacimientoPersona, $correo, $telefono , $idPersona]);
    }
    

    function updateProveedor($idEmpresa, $rucEmpresa, $nombreEmpresa, $rubroEmpresa, $direccionEmpresa){
        $db = obtenerBaseDeDatos();
        $sentencia = $db->prepare("UPDATE empresas SET RUC = ?, nombre = ?, rubro = ?, direccion = ? WHERE id = ?");
        return $sentencia->execute([$rucEmpresa, $nombreEmpresa, $rubroEmpresa,$direccionEmpresa, $idEmpresa]);
    }
        
        

    function validarContraseña($dato){
        if (strlen($dato) < 8) {
            # Clave debe tener al menos 8 caracteres
            return 1;
        }
        if (strlen($dato) > 18) {
            # Clave debe tener al menos 18 caracteres
            return 2;
        }
        if (!preg_match("[a-z]",$dato)) {
            # Clave debe tener al menos una letra minúscula;
            return 3;
        }
        if (!preg_match("[A-Z]",$dato)) {
            # Clave debe tener al menos una letra mayuscula;
            return 4;
        }
        if (!preg_match("[0-9]")) {
            # Clave debe tener al menos un caracter numérico;
            return 5;
        }
        return true;
    }
 ?>