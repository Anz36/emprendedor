<?php 
	include_once "../ConexionDb/funcionConexionSecundaria.php";
	#Obtener los Limites de una liesta Syntaxis - Prueba - Desactivado.
	function obtenerListasLimit($idPaginas){ 
		$paginasPropuestas = 5;
		$pagina = $idPaginas;
		if (isset($pagina)) {
			$pagina = $idPaginas;
		}
		$limit = $paginasPropuestas;
		$offSet = ($pagina - 1) * $paginasPropuestas;
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->query("SELECT count(*) AS conteo FROM wp_wc_order_stats");
		$conteo = $sentencia->fetchObject()->conteo;
		$paginas = ceil($conteo / $paginasPropuestas);

		$sentencia = $db->prepare("SELECT * FROM wp_wc_order_stats ORDER BY date_created LIMIT ? OFFSET ?");
  		$sentencia->execute([$limit,$offSet]);
 		return $sentencia->fetchAll(PDO::FETCH_OBJ);
	}
	#Obtener las Ventas del Repositorio de Woocommerce
	function obtenerListas(){
		$db = obtenerBaseDeDatosSecundaria();
		$consulta = "SELECT * FROM wp_wc_order_stats ORDER BY date_created DESC";
		$sentencia = $db->prepare($consulta,[PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,]);
		$sentencia->execute();
		return $sentencia->fetchAll();
	}
	#Obtener las Ventas del Repositorio de Woocommerce mediante Estados
	function obtenerListasMedianteEstado($idEstado){
		$db = obtenerBaseDeDatosSecundaria();
		$consulta = "SELECT * FROM wp_wc_order_stats WHERE status = ? ORDER BY date_created DESC";
		$sentencia = $db->prepare($consulta);
		$sentencia->execute([$idEstado]);
		return $sentencia->fetchall();
	}
	#Determino el Estado del Pedido
	function determinarEstado($idEstado){
		if ($idEstado == "wc-completed") {
			echo "Completado";
		}else{
			if ($idEstado == "wc-on-hold") {
				echo "En Espera";
			} else{
				if ($idEstado == "wc-pending") {
					echo "Pendiente Pago";
				} else{
					if ($idEstado == "wc-processing") {
						echo "Procesando";
					} else{
						if ($idEstado == "wc-cancelled") {
							echo "Cancelado";
						} else {
							if ($idEstado == "wc-refunded") {
								echo "Reembolsado";
							} else {
								if ($idEstado == "wc-failed") {
									echo "Fallido";
								}
							}
						}
					}
				}
			}
		}
		if ($idEstado == null) {
			return "N.E";
		}
	}
	#Determino el Estado del Pedido
	function determinarEstadoPDF($idEstado){
		if ($idEstado == "wc-completed") {
			return "Completado";
		}else{
			if ($idEstado == "wc-on-hold") {
				return "En Espera";
			} else{
				if ($idEstado == "wc-pending") {
					return "Pendiente Pago";
				} else{
					if ($idEstado == "wc-processing") {
						return "Procesando";
					} else{
						if ($idEstado == "wc-cancelled") {
							return "Cancelado";
						} else {
							if ($idEstado == "wc-refunded") {
								return "Reembolsado";
							} else {
								if ($idEstado == "wc-failed") {
									return "Fallido";
								}
							}
						}
					}
				}
			}
		}
		if ($idEstado == null) {
			return "N.E";
		}
	}
	#Obtener el Metodo de Pago del Pedido
	function obtenerMetodoDePago($idPedido,$metodoCodigo = "_payment_method_title"){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT * FROM wp_postmeta WHERE post_id  = ? AND meta_key = ?");
		$sentencia->execute([$idPedido,$metodoCodigo]);
		$pagoPedido = $sentencia->fetchObject();
		if ($pagoPedido == null) {
			# No existe Pago
			echo "No existe Pago";
		} else{
			echo $pagoPedido->meta_value;
		}
	}
	#Obtener el Metodo de Pago del Pedido PDF
	function obtenerMetodoDePagoPDF($idPedido,$metodoCodigo = "_payment_method_title"){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT * FROM wp_postmeta WHERE post_id  = ? AND meta_key = ?");
		$sentencia->execute([$idPedido,$metodoCodigo]);
		$pagoPedido = $sentencia->fetchObject();
		if ($pagoPedido == null) {
			# No existe Pago
			return "No existe Pago";
		} else{
			return $pagoPedido->meta_value;
		}
	}
	#Obtener el Estado del Pedido
	function obtenerEstadoPedido($idPedido){
		$db = obtenerBaseDeDatosSecundaria();
		$consulta = "SELECT * FROM wp_wc_order_stats WHERE order_id = ?";
		$sentencia = $db->prepare($consulta);
		$sentencia->execute([$idPedido]);
		$estadoPedido = $sentencia->fetchObject();
		if ($estadoPedido == null) {
			#No existe Estado Pago
			echo "No existe Estado Pago";
		} else {
			return $estadoPedido->status;
		}
		
	}
	#Obtener el Estado del Pedido para PDF
	function obtenerEstadoPedidoPDF($idPedido){
		$db = obtenerBaseDeDatosSecundaria();
		$consulta = "SELECT * FROM wp_wc_order_stats WHERE order_id = ?";
		$sentencia = $db->prepare($consulta);
		$sentencia->execute([$idPedido]);
		$estadoPedido = $sentencia->fetchObject();
		if ($estadoPedido == null) {
			#No existe Estado Pago
			return "No existe Estado Pago";
		} else {
			return $estadoPedido->status;
		}
		
	}
	#Obtener la Fecha del Pedido
	function obtenerFechaPedido($idPedido){
		$db = obtenerBaseDeDatosSecundaria();
		$consulta = "SELECT * FROM wp_wc_order_stats WHERE order_id = ?";
		$sentencia = $db->prepare($consulta);
		$sentencia->execute([$idPedido]);
		$fechaPedido = $sentencia->fetchObject();
		if ($fechaPedido == null) {
			#No existe Estado Pago
			echo "No existe Fecha";
		} else {
			echo $fechaPedido->date_created;
		}
		
	}
	#Obtener la Fecha del Pedido para PDF
	function obtenerFechaPedidoPDF($idPedido){
		$db = obtenerBaseDeDatosSecundaria();
		$consulta = "SELECT * FROM wp_wc_order_stats WHERE order_id = ?";
		$sentencia = $db->prepare($consulta);
		$sentencia->execute([$idPedido]);
		$fechaPedido = $sentencia->fetchObject();
		if ($fechaPedido == null) {
			#No existe Estado Pago
			return "No existe Fecha";
		} else {
			return $fechaPedido->date_created;
		}
		
	}
	#Obtener el Nombre del Cliente, de forma mas especificada de acuerdo al ID del Pedido ya que el Primery Key es el Email.
	function obtenerNombreDelCliente($idPedido,$nombreCodigo = "_billing_first_name"){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT * FROM wp_postmeta WHERE post_id  = ? AND meta_key = ?");
		$sentencia->execute([$idPedido,$nombreCodigo]);
		$nombreCliente = $sentencia->fetchObject();
		if ($nombreCliente == null) {
			# No existe Nombre
			echo "";
		} else{
			echo $nombreCliente->meta_value;
		}
	}
	#Obtener Nombre para el PDF
	function obtenerNombreDelClientePDF($idPedido,$nombreCodigo = "_billing_first_name"){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT * FROM wp_postmeta WHERE post_id  = ? AND meta_key = ?");
		$sentencia->execute([$idPedido,$nombreCodigo]);
		$nombreCliente = $sentencia->fetchObject();
		if ($nombreCliente == null) {
			# No existe Nombre
			return "No existe Nombre ";
		} else{
			return $nombreCliente->meta_value;
		}
	}
	#Obtener el Apellido del Cliente, mas detalles linea 131.
	function obtenerApellidoDelCliente($idPedido,$apellidoCodigo = "_billing_last_name"){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT * FROM wp_postmeta WHERE post_id  = ? AND meta_key = ?");
		$sentencia->execute([$idPedido,$apellidoCodigo]);
		$apellidoCliente = $sentencia->fetchObject();
		if ($apellidoCliente == null) {
			# No existe Apellido
			echo "";
		} else{
			echo $apellidoCliente->meta_value;
		}
	}
	#Obtener el Apellido del Cliente para el PDF
	function obtenerApellidoDelClientePDF($idPedido,$apellidoCodigo = "_billing_last_name"){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT * FROM wp_postmeta WHERE post_id  = ? AND meta_key = ?");
		$sentencia->execute([$idPedido,$apellidoCodigo]);
		$apellidoCliente = $sentencia->fetchObject();
		if ($apellidoCliente == null) {
			# No existe Apellido
			return " ";
		} else{
			return $apellidoCliente->meta_value;
		}
	}
	#Obtener Codigo del Cliente, salvo que el Codigo el Primary Key es el Email.
	function obtenerCodigoCliente($idPedido){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT * FROM wp_wc_order_stats WHERE order_id = ?");
		$sentencia->execute([$idPedido]);
		$codigoCliente = $sentencia->fetchObject();
		if ($codigoCliente == null) {
			# No existe Codigo Cliente.
			echo "No existe cliente";
		} else {
			echo $codigoCliente->customer_id;
		}
	}
	#Obtener Codigo del Cliente para PDF, salvo que el Codigo el Primary Key es el Email.
	function obtenerCodigoClientePDF($idPedido){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT * FROM wp_wc_order_stats WHERE order_id = ?");
		$sentencia->execute([$idPedido]);
		$codigoCliente = $sentencia->fetchObject();
		if ($codigoCliente == null) {
			# No existe Codigo Cliente.
			return "No existe cliente";
		} else {
			return $codigoCliente->customer_id;
		}
	}
	#Obtener Teléfono del Cliente.
	function obtenerTelefonoCliente($idPedido,$telefonoCodigo = "_billing_phone"){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT * FROM wp_postmeta WHERE post_id  = ? AND meta_key = ?");
		$sentencia->execute([$idPedido,$telefonoCodigo]);
		$telefonoCliente = $sentencia->fetchObject();
		if ($telefonoCliente == null) {
			# No existe teléfono Cliente
			echo "No existe teléfono";
		} else{
			echo $telefonoCliente->meta_value;
		}
	}
	#Obtener Teléfono del Cliente para el PDF.
	function obtenerTelefonoClientePDF($idPedido,$telefonoCodigo = "_billing_phone"){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT * FROM wp_postmeta WHERE post_id  = ? AND meta_key = ?");
		$sentencia->execute([$idPedido,$telefonoCodigo]);
		$telefonoCliente = $sentencia->fetchObject();
		if ($telefonoCliente == null) {
			# No existe teléfono Cliente
			return "No existe teléfono";
		} else{
			return $telefonoCliente->meta_value;
		}
	}
		#Obtener Dirección del Cliente.
	function obtenerDireccionCliente($idPedido,$direccionCodigo = "_billing_address_1"){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT * FROM wp_postmeta WHERE post_id  = ? AND meta_key = ?");
		$sentencia->execute([$idPedido,$direccionCodigo]);
		$direccionCliente = $sentencia->fetchObject();
		if ($direccionCliente == null) {
			# No existe dirección Cliente
			echo "No existe Dirección ";
		} else{
			echo $direccionCliente->meta_value;
		}
	}
		#Obtener Dirección del Cliente.
	function obtenerDireccionClientePDF($idPedido,$direccionCodigo = "_billing_address_1"){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT * FROM wp_postmeta WHERE post_id  = ? AND meta_key = ?");
		$sentencia->execute([$idPedido,$direccionCodigo]);
		$direccionCliente = $sentencia->fetchObject();
		if ($direccionCliente == null) {
			# No existe dirección Cliente
			return "No existe Dirección ";
		} else{
			return $direccionCliente->meta_value;
		}
	}
	#Obtener Codigo Producto
	function obtenerCodigo($idPedido){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->query("SELECT * FROM wp_wc_order_product_lookup WHERE order_id = $idPedido");
		return $sentencia->fetchAll();
	}

	#Obtener Nombre del Producto
	function obtenerNombreDelProducto($idPedido){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->query("SELECT * FROM wp_woocommerce_order_items WHERE order_id = $idPedido");
		return $sentencia->fetchAll();
	}
	#Obtener el Codigo Variacion
	function obtenerCodigoProducto($idPedido){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT product_id, variation_id FROM wp_wc_order_product_lookup WHERE order_item_id = ?");
		$sentencia->execute([$idPedido]);
		return $sentencia->fetchAll();
	}
	#Obtener el Codigo SKU
	function obtenerCodigoSKU($idProducto){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT sku FROM wp_wc_product_meta_lookup WHERE product_id = ?");
		$sentencia->execute([$idProducto]);
		return $sentencia->fetchAll();
	}
	#Obtener Modelo del Producto
	function obtenerModeloProductoSKU($idProducto){
		$separacion = "-";
		$dato = strstr($idProducto, $separacion, true);
		if ($dato == "P") {
			#Retorna el Dato Polo
			return "Polo";
		} else {
			if ($dato == "G") {
				#Retorna el Dato Gorro
				return "Gorro";
			} else{
				if ($dato == "T") {
					#Retorna el dato Taza
					return "Taza";
				} else {
					if ($dato == "M") {
						#Retorna el Dato MUG
						return "M";
					} else {
						if ($dato == "PM") {
							#Retorna el Dato Maus Pad
							return "PM";
						} else {
							if ($dato == "L") {
								#Retorna el Dato Libreta
								return "L";
							} else {
								if ($dato == "B") {
									# Retorna el Dato Bolsa
									return "B";
								} else {
									if ($dato == "GAD") {
										# Retona el Dato Gadget
										return "GAD";
									}
								}
							}
						}
					} 
				}
			}
		}
		if ($dato == "P" || $dato == "G" || $dato == "T" || $dato == "M") {
		} else {
			return "N.E";
		}
		#Si no se obtiene datos, devolvera N.E, es decir, "No existente"
		if ($dato == null) {
			return "N.E";
		}
	}
	#Obtener Costo del Producto x Pedido
	function obtenerCostoProducto($idProducto){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT max_price FROM wp_wc_product_meta_lookup WHERE product_id = ?");
		$sentencia->execute([$idProducto]);
		return $sentencia->fetchAll();
	}
	#Obtener la Cantidad
	function obtenerCantidadPedido($idProducto){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT product_qty FROM wp_wc_order_product_lookup WHERE order_item_id = ?");
		$sentencia->execute([$idProducto]);
		return $sentencia->fetchAll();
	}
	#Obtener Total del Pedido
	function obtenerTotalPedido($idProducto){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT product_net_revenue FROM wp_wc_order_product_lookup WHERE order_item_id = ?");
		$sentencia->execute([$idProducto]);
		return $sentencia->fetchAll();
	}
	#Obtener Modelo del Producto
	function obtenerModeloProducto($idProducto,$modeloId="pa_modelo"){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT * FROM wp_woocommerce_order_itemmeta WHERE order_item_id = ? AND meta_key = ?");
		$sentencia->execute([$idProducto,$modeloId]);
		return $sentencia->fetchall(PDO::FETCH_OBJ);
	}
	#Modelo Producto Detalle
	function obtenerModelo($idProducto,$modeloId="pa_modelo"){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT * FROM wp_woocommerce_order_itemmeta WHERE order_item_id = ? AND meta_key = ?");
		$sentencia->execute([$idProducto,$modeloId]);
		$modeloProducto = $sentencia->fetchObject();
		if ($modeloProducto == null) {
			# No existe Modelo
			echo "No existe Modelo ";
		} else{
			echo ucfirst($modeloProducto->meta_value);
		}
	}
	#Hoja Producto Detalle
	function obtenerHoja($idProducto,$modeloId="pa_hoja"){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT * FROM wp_woocommerce_order_itemmeta WHERE order_item_id = ? AND meta_key = ?");
		$sentencia->execute([$idProducto,$modeloId]);
		$modeloProducto = $sentencia->fetchObject();
		if ($modeloProducto == null) {
			# No existe Modelo
			echo "No existe Hoja ";
		} else{
			echo ucfirst($modeloProducto->meta_value);
		}
	}
	#Modelo Producto Detalle para PDF
	function obtenerModeloPDF($idProducto,$modeloId="pa_modelo"){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT * FROM wp_woocommerce_order_itemmeta WHERE order_item_id = ? AND meta_key = ?");
		$sentencia->execute([$idProducto,$modeloId]);
		$modeloProducto = $sentencia->fetchObject();
		if ($modeloProducto == null) {
			# No existe Modelo
			return "No existe Modelo ";
		} else{
			return ucfirst($modeloProducto->meta_value);
		}
	}

	#Obtener Color del Producto
	function obtenerColorProducto($idProducto,$colorId="pa_color"){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT * FROM wp_woocommerce_order_itemmeta WHERE order_item_id = ? AND meta_key = ?");
		$sentencia->execute([$idProducto,$colorId]);
		return $sentencia->fetchall(PDO::FETCH_OBJ);
	}
	#Color Producto Detalle
	function obtenerColor($idProducto,$colorId="pa_color"){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT * FROM wp_woocommerce_order_itemmeta WHERE order_item_id = ? AND meta_key = ?");
		$sentencia->execute([$idProducto,$colorId]);
		$colorProducto = $sentencia->fetchObject();
		if ($colorProducto == null) {
			# No existe dirección
			echo "No existe Color ";
		} else{
			echo ucfirst($colorProducto->meta_value);
		}
	}
	#Color Producto Detalle PDF
	function obtenerColorPDF($idProducto,$colorId="pa_color"){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT * FROM wp_woocommerce_order_itemmeta WHERE order_item_id = ? AND meta_key = ?");
		$sentencia->execute([$idProducto,$colorId]);
		$colorProducto = $sentencia->fetchObject();
		if ($colorProducto == null) {
			# No existe dirección
			return "No existe Color ";
		} else{
			return ucfirst($colorProducto->meta_value);
		}
	}
	#Obtener Talla del Producto
	function obtenerTallaProducto($idProducto,$tallaId="pa_talla"){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT * FROM wp_woocommerce_order_itemmeta WHERE order_item_id = ? AND meta_key = ?");
		$sentencia->execute([$idProducto,$tallaId]);
		return $sentencia->fetchall(PDO::FETCH_OBJ);
	}
	#Talla
	function obtenerTalla($idProducto,$tallaId="pa_talla"){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT * FROM wp_woocommerce_order_itemmeta WHERE order_item_id = ? AND meta_key = ?");
		$sentencia->execute([$idProducto,$tallaId]);
		$tallaProducto = $sentencia->fetchObject();
		if ($tallaProducto == null) {
			# No existe dirección
			echo "No existe Talla ";
		} else{
			echo ucfirst($tallaProducto->meta_value);
		}
	}
	#Talla PDF
	function obtenerTallaPDF($idProducto,$tallaId="pa_talla"){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT * FROM wp_woocommerce_order_itemmeta WHERE order_item_id = ? AND meta_key = ?");
		$sentencia->execute([$idProducto,$tallaId]);
		$tallaProducto = $sentencia->fetchObject();
		if ($tallaProducto == null) {
			# No existe dirección
			return "No existe Talla ";
		} else{
			return ucfirst($tallaProducto->meta_value);
		}
	}
	#Obtener Total del Producto
	function obtenerTotalProducto($idProducto,$totalId="_line_total"){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT * FROM wp_woocommerce_order_itemmeta WHERE order_item_id = ? AND meta_key = ?");
		$sentencia->execute([$idProducto,$totalId]);
		$totalProducto = $sentencia->fetchObject();
		if ($totalProducto == null) {
			# No existe dirección
			echo "No existe Total ";
		} else{
			echo ucfirst($totalProducto->meta_value);
		}
	}
	#Obtener Total del Producto PDF
	function obtenerTotalProductoPDF($idProducto,$totalId="_line_total"){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT * FROM wp_woocommerce_order_itemmeta WHERE order_item_id = ? AND meta_key = ?");
		$sentencia->execute([$idProducto,$totalId]);
		$totalProducto = $sentencia->fetchObject();
		if ($totalProducto == null) {
			# No existe dirección
			return "No existe Total ";
		} else{
			return ucfirst($totalProducto->meta_value);
		}
	}
	#Tecnica
	function obtenerTecnica($idProducto,$tecnicaId="pa_tecnica"){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT * FROM wp_woocommerce_order_itemmeta WHERE order_item_id = ? AND meta_key = ?");
		$sentencia->execute([$idProducto,$tecnicaId]);
		$tallaProducto = $sentencia->fetchObject();
		if ($tallaProducto == null) {
			# No existe dirección
			echo "No existe Tecnica ";
		} else{
			echo ucfirst($tallaProducto->meta_value);
		}
	}
	#Tecnica PDF
	function obtenerTecnicaPDF($idProducto,$tecnicaId="pa_tecnica"){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT * FROM wp_woocommerce_order_itemmeta WHERE order_item_id = ? AND meta_key = ?");
		$sentencia->execute([$idProducto,$tecnicaId]);
		$tallaProducto = $sentencia->fetchObject();
		if ($tallaProducto == null) {
			# No existe dirección
			return "No existe Tecnica ";
		} else{
			return ucfirst($tallaProducto->meta_value);
		}
	}
	#Codigo Producto
	function obtenerProducto($idProducto,$productoId="_product_id"){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT * FROM wp_woocommerce_order_itemmeta WHERE order_item_id = ? AND meta_key = ?");
		$sentencia->execute([$idProducto,$productoId]);
		$codProducto = $sentencia->fetchObject();
		if ($codProducto == null) {
			# No existe dirección
			echo "No existe ID Producto ";
		} else{
			echo ucfirst($codProducto->meta_value);
		}
	}
	#Codigo Producto para PDF
	function obtenerProductoPDF($idProducto,$productoId="_product_id"){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT * FROM wp_woocommerce_order_itemmeta WHERE order_item_id = ? AND meta_key = ?");
		$sentencia->execute([$idProducto,$productoId]);
		$codProducto = $sentencia->fetchObject();
		if ($codProducto == null) {
			# No existe dirección
			return "No existe ID Producto ";
		} else{
			return ucfirst($codProducto->meta_value);
		}
	}
	#Codigo Variacion Producto
	function obtenerProductoVariacion($idProducto,$productoId="_variation_id"){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT * FROM wp_woocommerce_order_itemmeta WHERE order_item_id = ? AND meta_key = ?");
		$sentencia->execute([$idProducto,$productoId]);
		$codProducto = $sentencia->fetchObject();
		if ($codProducto == null) {
			# No existe dirección
			echo "No existe ID Variación Producto ";
		} else{
			echo ucfirst($codProducto->meta_value);
		}
	}
	#Codigo Variacion Producto para PDF
	function obtenerProductoVariacionPDF($idProducto,$productoId="_variation_id"){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT * FROM wp_woocommerce_order_itemmeta WHERE order_item_id = ? AND meta_key = ?");
		$sentencia->execute([$idProducto,$productoId]);
		$codProducto = $sentencia->fetchObject();
		if ($codProducto == null) {
			# No existe dirección
			return "No existe ID Variación Producto ";
		} else{
			return ucfirst($codProducto->meta_value);
		}
	}
	#Codigo Nombre Producto
	function obtenerProductoNombre($idProducto){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT * FROM wp_woocommerce_order_items WHERE order_item_id = ?");
		$sentencia->execute([$idProducto]);
		$codProducto = $sentencia->fetchObject();
		if ($codProducto == null) {
			# No existe dirección
			echo "No existe Nombre del Producto ";
		} else{
			echo ucfirst($codProducto->order_item_name);
		}
	}
	#Codigo Nombre Producto para PDF
	function obtenerProductoNombrePDF($idProducto){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT * FROM wp_woocommerce_order_items WHERE order_item_id = ?");
		$sentencia->execute([$idProducto]);
		$codProducto = $sentencia->fetchObject();
		if ($codProducto == null) {
			# No existe dirección
			return "No existe Nombre del Producto ";
		} else{
			return ucfirst($codProducto->order_item_name);
		}
	}
	#Codigo de Imagen Producto
	function obtenerCodigoImagen($idProducto,$imagenId="_thumbnail_id"){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT * FROM wp_postmeta WHERE post_id = ? AND meta_key = ?");
		$sentencia->execute([$idProducto,$imagenId]);
		$codImagen = $sentencia->fetchObject();
		if ($codImagen == null) {
			# No existe dirección
			echo "No existe imagen";
		} else{
			return $codImagen->meta_value;
		}
	}
	#Codigo de Imagen Producto PDF
	function obtenerCodigoImagenPDF($idProducto,$imagenId="_thumbnail_id"){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT * FROM wp_postmeta WHERE post_id = ? AND meta_key = ?");
		$sentencia->execute([$idProducto,$imagenId]);
		$codImagen = $sentencia->fetchObject();
		if ($codImagen == null) {
			# No existe dirección
			return "No existe imagen";
		} else{
			return $codImagen->meta_value;
		}
	}
	#Codigo de Imagen Producto Parte 2
	function obtenerUrlImagen($idImagen){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT * FROM wp_posts WHERE ID = ?");
		$sentencia->execute([$idImagen]);
		$codImagen = $sentencia->fetchObject();
		if ($codImagen == null) {
			# No existe dirección
			echo "No existe imagen";
		} else{
			return $codImagen->guid;
		}
	}
	#Codigo de Imagen Producto Parte 2 PDF
	function obtenerUrlImagenPDF($idImagen){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT * FROM wp_posts WHERE ID = ?");
		$sentencia->execute([$idImagen]);
		$codImagen = $sentencia->fetchObject();
		if ($codImagen == null) {
			# No existe dirección
			return "No existe imagen";
		} else{
			return $codImagen->guid;
		}
	}
	#Obtener la Fecha en D-M-Y
	function convertirFecha($fecha){
		echo $fechaObtenida = date("d-m-Y",strtotime($fecha));
	}
	function atributoImagen($urlImagen){
	$dato = substr(strrchr($urlImagen,"/"),1);
	$dato = strstr($dato,".",0);
	$dato = substr($dato,1);
	if ($dato == "jpg") {
		return $dato;
	} else {
		if ($dato == "png") {
			return $dato;
		}
	}
}
	function obtenerClientes(){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->query("SELECT * FROM wp_wc_customer_lookup");
		return $sentencia->fetchAll();
	}

	function obtenerEstadoCliente($idCliente){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT count(customer_id) AS Contador FROM wp_wc_order_stats WHERE customer_id = ?");
		$sentencia->execute([$idCliente]);
		$estadoCliente = $sentencia->fetchObject()->Contador;
		if ($estadoCliente >= "5") {
			return "Cliente Habitual";
		} elseif ($estadoCliente == "3" || $estadoCliente == "4") {
			return "Cliente Emprendedor";
		} else{
			return "Cliente Nuevo";
		}
	}

	function obtenerIdCliente($idCliente){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT count(customer_id) AS Contador,customer_id FROM wp_wc_order_stats WHERE customer_id = ?");
		$sentencia->execute([$idCliente]);
		return $sentencia->fetchall();
	}
	
	function obtenerClientePorEstado($idCliente){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT * FROM wp_wc_customer_lookup WHERE customer_id = ?");
		$sentencia->execute([$idCliente]);
		return $sentencia->fetchAll();
	}

	function sumaTotal($idCliente){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT SUM(total_sales) AS Total FROM wp_wc_order_stats WHERE customer_id = ?");
		$sentencia->execute([$idCliente]);
		return $sentencia->fetchObject()->Total;
	}

	#Obtener ID del Producto
	function obtenerIDProducto($idCliente){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->query("SELECT * FROM wp_wc_order_stats WHERE customer_id = $idCliente");
		return $sentencia->fetchAll();
	}

	#Obtener el Codigo Variacion
	function capturarProducto($idPedido){
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->prepare("SELECT product_id, variation_id FROM wp_wc_order_product_lookup WHERE order_id = ?");
		$sentencia->execute([$idPedido]);
		return $sentencia->fetchAll();
	}

 ?>