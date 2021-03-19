<?php 
    include_once "../ConexionDb/funcionConexion.php";
	include_once "../ConexionDb/funcionConexionSecundaria.php";

	#INsertamos Datos Temporales a la tabla Atencion 
	function datosTemporales($idPedido,$idUsuario,$status){
		$db = obtenerBaseDeDatos();
		$fecha =  date("Y-m-d")." ".date("H:i:s");
		$sentencia = $db->prepare("INSERT INTO atencion (id_persona,pedido,status,fecha) VALUES (?,?,?,?)");
		return $sentencia->execute([$idUsuario,$idPedido,$status,$fecha]);
	}
	#Nombre del Estado de la atencion
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
			return "Completado";
		}
	}
	#Verificamos el Estado
	function disponibleUsuario($idPedido){
		$db = obtenerBaseDeDatos();
		$sentencia = $db->prepare("SELECT * FROM atencion WHERE pedido = ? ORDER BY fecha DESC LIMIT 1");
		$sentencia->execute([$idPedido]);
		$atencion = $sentencia->fetchObject();
		if ($atencion) {
			return convertirNombreAtencion($atencion->status);
		} else {
			return "Disponible";
		}
	}
	#Colores
	function color($pedido){
        $color = "";
        if($pedido == "Compleado"){ //Completado
            $color = "#17F45F";
        }
        else if($pedido == "Procesando"){ //Procesando
            $color = "#F1F417";
        }
        else if($pedido == "En Espera"){ //En Espera
            $color = "#17F4EF";
        }
        else if($pedido == "Cancelado"){ //Cancelado
            $color = "#F41732";
        }
        else if($pedido == "Reembolsado"){ //Reembolsado
            $color = "#D5E8EF";
        }
        else { //Pendiente
            $color = "#EC8C13";
        }

        return $color;
    }
    #Nombre del Usuario
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
	# Nombre de quien va a atender en la vista
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
	#Filtro en array de los pedido obtenidos de la tabla atencion
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
	#Capturamos el listado
	function capturarListado(){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->query("SELECT * FROM wp_wc_order_stats");
		return $sentencia->fetchAll();
	}
	#Actualizamos la estrucutra atecnion de 0 a 1
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
    #Captraumos la ID 
    function capturarIdPedido($idUsuario){
    	$db = obtenerBaseDeDatos();
    	$sentencia = $db->prepare("SELECT * FROM atencion WHERE id_persona = ?  ORDER BY fecha DESC LIMIT 1");
    	$sentencia->execute([$idUsuario]);
    	$dato = $sentencia->fetchObject();
    	if ($dato) {
    		return $dato->pedido;
    	} else {
    		return null;
    	}
    }
    #Update status
    function updatePedido($idPersona,$idPedido,$status){
    	$db = obtenerBaseDeDatos();
    	$sentencia = $db->prepare("UPDATE atencion SET status = ? WHERE id_persona = ? AND pedido = ?");
    	return $sentencia->execute([$status,$idPersona,$idPedido]);
    }
    function convertirStatus($status){
		if ($status == 1) {
			return "wc-pending";
		} else if ($status == 2) {
			return "wc-processing";
		} else if ($status == 3) {
			return "wc-on-hold";
		} else if ($status == 4) {
			return "wc-cancelled";
		} else if ($status == 5) {
			return "wc-refunded";
		} else if ($status == 6) {
			return "wc-completed";
		}
	}

    #Update tabla Woocomerce Status
    function updateStatus($idPedido,$status){
        $db = obtenerBaseDeDatosSecundaria();
        $sentencia = $db->prepare("UPDATE wp_wc_order_stats SET status = ? WHERE order_id = ? ");
        return $sentencia->execute([$status,$idPedido]);
    }
 ?>