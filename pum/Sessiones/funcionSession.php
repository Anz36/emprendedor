<?php
    include_once "../ConexionDb/funcionConexion.php";
    include_once "../Encriptar/Encriptar.php";
    function login($usuario,$palabraSecreta1){
        $palabraSecreta = encriptar($palabraSecreta1);
        
        $db = obtenerBaseDeDatos();
        $sentencia = $db->prepare("SELECT * FROM usuarios WHERE usuarioIngreso = ?");
        $sentencia->execute([$usuario]);
        $registro = $sentencia->fetchObject();
        if ($registro == null) {
            # No existen registro de la DBA, con el Codigo del Usuario
            return 0;
        } else{
            $valor = $registro->estadoUsuario;
            if ($valor == 1) {
            #Verificamos el estado del usuario
            #Verificamos la Palabra Secreta Correcta.
            $palabraSecretaCorrecta = $registro->palabraClave;
            #Comprobamos
            if ($palabraSecreta == $palabraSecretaCorrecta) {
                #Todo Correcto.
                iniciarSession($registro->id);
                return 1;
                }
            } else {
                if ($valor == 0) {
                    # Restringir el acceso
                    return 3;
                }
            }
        }  
    } 
    function iniciarSession($usuario){
        session_start();
        $_SESSION["codUsuario"] = $usuario;
    }
    #id Personal
    function idPersonal($usuario){
        $db = obtenerBaseDeDatos();
        $sentencia = $db->prepare("SELECT * FROM personal WHERE id_usuario = ?");
        $sentencia->execute([$usuario]);
        return $sentencia->fetchObject()->id_persona;
    }
    #Datos Personal
    function datosPersonal($usuario){
        $db = obtenerBaseDeDatos();
        $sentencia = $db->prepare("SELECT * FROM personas WHERE id = ?");
        $sentencia->execute([$usuario]);
        return $sentencia->fetchObject();
    }
    #id Proveedor
    function idProveedor($usuario){
        $db = obtenerBaseDeDatos();
        $sentencia = $db->prepare("SELECT * FROM proveedores WHERE id_usuario = ?");
        $sentencia->execute([$usuario]);
        return $sentencia->fetchObject()->id_empresa;
    }
    #Datos Personal
    function datosEmpresas($usuario){
        $db = obtenerBaseDeDatos();
        $sentencia = $db->prepare("SELECT * FROM empresas WHERE id = ?");
        $sentencia->execute([$usuario]);
        return $sentencia->fetchObject();
    }



    #Nombre Empresarial o Proovedores
    function nombreEmpresa($usuario){
        $db = obtenerBaseDeDatos();
        $sentencia = $db->prepare("SELECT * FROM proveedores WHERE id = ?");
        $sentencia->execute([$usuario]);
        return $sentencia->fetchObject();
    }
 ?>