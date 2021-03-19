<?php 
    include_once "../ConexionDb/funcionConexion.php";
	include_once "../ConexionDb/funcionConexionSecundaria.php";

	function datosTemporales($idPedido,$idUsuario,$status){
		$db = obtenerBaseDeDatos();
		$fecha =  date("Y-m-d")." ".date("H:i:s");
		$sentencia = $db->prepare("INSERT INTO atencion (id_persona,pedido,status,fecha) VALUES (?,?,?,?)");
		return $sentencia->execute([$idUsuario,$idPedido,$status,$fecha]);
	}

	function convertirNombreAtencion($atencion){
		if ($atencion == 1) {
			return "Pendiente";
		} else if ($atencion == 2) {
			return "Procesando";
		} elseif ($atencion == 3) {
			return "En Espera";
		} else if ($atencion == 4) {
			return "Cancelado";
		} else if ($atencion == 5) {
			return "Reembolsado";
		} else if ($atencion == 6) {
			return "Compleado";
		}
	}
	function disponibleUsuario($idPedido){
		$db = obtenerBaseDeDatos();
		$sentencia = $db->prepare("SELECT * FROM atencion WHERE pedido = ? ORDER BY id DESC LIMIT 1");
		$sentencia->execute([$idPedido]);
		$atencion = $sentencia->fetchObject();
		if ($atencion) {
			return convertirNombreAtencion($atencion->status);
		} else {
			return "Disponible";
		}
	}

	function nombreUsuario($idPersona){
		$db = obtenerBaseDeDatos();
		$sentencia = $db->prepare("SELECT * FROM personas WHERE id = ?");
		$sentencia->execute([$idPersona]);
		$atencion = $sentencia->fetchObject();
		if ($atencion) {
			return $atencion->nombre;
		} else {
			return "Por Atender";
		}
	}

	function atencionUsuario($idPedido){
		$db = obtenerBaseDeDatos();
		$sentencia = $db->prepare("SELECT * FROM atencion WHERE pedido = ? ORDER BY id DESC LIMIT 1");
		$sentencia->execute([$idPedido]);
		$atencion = $sentencia->fetchObject();
		if ($atencion) {
			return nombreUsuario($atencion->id_persona);
		} else {
			return "Por Atender";
		}
	}


    function filtroListaPedido(){
        $datosTabla = array();
        $i = 0;
		$mysqli = new mysqli("localhost", "root", "", "crm_emprendedor");   
        
        if ($mysqli->connect_errno) {
            printf("Falló la conexión: %s\n", $mysqli->connect_error);
        }
        $result = $mysqli->query("select * from atencion");
		while($datos = mysqli_fetch_array($result)){
           $datosTabla[$i] = $datos['pedido'];
           $i++;
       }

       return $datosTabla;
	}

	function capturarListado(){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->query("SELECT * FROM wp_wc_order_stats");
		return $sentencia->fetchAll();
	}

    function xdxd($datos, $tabla){
        $db = obtenerBaseDeDatosSecundaria();
        foreach ($datos as $listaDetalles) {
            for($i=0; $i<count($tabla); $i++){
                if($listaDetalles->order_id == $tabla[$i]){
                    $sentencia = $db->prepare("update wp_wc_order_stats set atencion = ? where order_id =?");
                    return $sentencia->execute(["1",$listaDetalles->order_id]);
                }
            }
        }
    }

    function capturarIdPedido($idUsuario){
    	$db = obtenerBaseDeDatos();
    	$sentencia = $db->prepare("SELECT pedido FROM atencion WHERE id_persona = ?  ORDER BY pedido ASC, fecha DESC LIMIT 1");
    	$sentencia->execute([$idUsuario]);
    	return $sentencia->fetchObject()->pedido;
    }

 ?>