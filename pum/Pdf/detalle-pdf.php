<?php
//AddPage(orientacion[PORTRAIT, LANDSCAPE], tamaño[A3, A4, A5, LETTER, LEGAL], rotacion(90, 180, 270, 360)),
//SetFont(tipo[COURIER, HELVETICA, ARIAL, TIMES, SYMBOL, ZAPDINGBATS], estilo[normal, B, I, U], tamaño),
//Cell(ancho, alto, texto, border, ?, alineacion, rellenar, link),
//OutPut(destino[I, D, F, S], nombre_archivo, utf8)
// $pdf->Image(ruta, posicionX, posicionY, alto, ancho, tipo, link);
require('../libreria/Fdpf/fpdf.php');

Class PDF extends FPDF{
	#Cabecera de la Pagina
	function Header(){
		//Times blod 12
		$this->SetFont('Times','B',10);
		$this->Cell(0,5,'Informe Pedido',0,0,'');
		//Posición
		$this->Image('img/Logo-Compina.jpg',150, 5, 50, 20, 'jpg');
		$this->SetX(-30);
		//$this->Write(5,'Compina');
		$this->Ln(20);
		
	}
	function Footer(){
	// Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Times italic 8
    $this->SetFont('Times','I',8);
    // Número de página
    $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
	}
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('PORTRAIT','A4');
//$pdf->SetMargins(10,30,20,20);
session_start();
include_once "funciones.php";
include_once "funcionSession.php";
#Sí no esta logueado dentro del Sistema, salir inmediatamente.
	if (empty($_SESSION["codUsuario"])) {
    # Lo redireccionamos al formulario de inicio de sesión
    header("Location: formulario_login.php?mensaje=Necesita iniciar session para ingresar a la pagina protegida");
    # Y salimos del script
    exit();
}
	if (!isset($_GET["id"])) {
		#Si no encuentra datos dentro del $_GET["ID"];
		exit("Faltan Datos");
	}
	$id_pedido = $_GET["id"];
	if (obtenerEstadoPedidoPDF($id_pedido) == "No existe Estado Pago") {
		$estadoPedido = obtenerEstadoPedidoPDF($id_pedido);
	}else{
		$estadoPedido = obtenerEstadoPedidoPDF($id_pedido);
		$estadoPedido = determinarEstadoPDF($estadoPedido);
	}
	$granTotal = 0;
	#Sí el usuario esta logueado, mostrata los Datos Correspondientes.
	$pdf->SetFont('Times','B',15);
	#Titulo
	$pdf->Write(10,'Detalle Pedido #'); $pdf->Write(10,$id_pedido);
	$pdf->Ln(10);
	#Subtitulos
	$pdf->SetFont('Times','B',13.5);
	$pdf->Cell(10,10,utf8_decode('Información del Cliente'),0,0,'',0);
	$pdf->Cell(80,10,'',0,0,'B',0);
	$pdf->Cell(40,10,utf8_decode('Datos del Pedido'),0,0,'',0);
	#Label's Primera Linea
	$pdf->Ln(10);
	$pdf->SetFont('Times','B',12.5);
	$pdf->Write(5,'  ');
	$pdf->Cell(33,5,utf8_decode('Nombre y Apellido'),0,0,'',0);
	$pdf->Cell(57,5,'',0,0,'B',0);
	$pdf->Cell(40,5,utf8_decode('Fecha'),0,0,'',0);
	#Datos Segunda Linea
	$pdf->Ln(5);
	$pdf->SetFont('Times','',12);
	$pdf->Write(5,'  ');
	$pdf->Cell(5,5,'',0,0,'',0); $pdf->Write(5,utf8_decode(obtenerNombreDelClientePDF($id_pedido)));
	$pdf->Write(5,' '); $pdf->Write(5,utf8_decode(obtenerApellidoDelClientePDF($id_pedido)));
	$pdf->Cell(35,5,'',0,0,'',0);
	$pdf->Cell(40,5,'',0,0,'',0); $pdf->Write(5,obtenerFechaPedidoPDF($id_pedido));
	#Label's Tercera Linea
	$pdf->Ln(5);
	$pdf->SetFont('Times','B',12.5);
	$pdf->Write(5,'  ');
	$pdf->Cell(33,5,utf8_decode('Cod - Cliente'),0,0,'',0);
	$pdf->Cell(57,5,'',0,0,'B',0);
	$pdf->Cell(43,5,utf8_decode('Estado'),0,0,'',0);
	#Datos Cuarta Linea
	$pdf->Ln(5);
	$pdf->SetFont('Times','',12);
	$pdf->Write(5,'  ');
	$pdf->Cell(5,5,'',0,0,'',0); $pdf->Write(5,obtenerCodigoClientePDF($id_pedido));
	$pdf->Cell(45,5,'',0,0,'',0);
	$pdf->Cell(40,5,'',0,0,'',0); $pdf->Write(5,utf8_decode($estadoPedido));
	#Label's Quinta Linea
	$pdf->Ln(5);
	$pdf->SetFont('Times','B',12.5);
	$pdf->Write(5,'  ');
	$pdf->Cell(33,5,utf8_decode('Teléfono'),0,0,'',0);
	$pdf->Cell(57,5,'',0,0,'',0);
	$pdf->Cell(43,5,utf8_decode('Metodo de Pago'),0,0,'',0);
	#Datos Sexta Linea
	$pdf->Ln(5);
	$pdf->SetFont('Times','',12);
	$pdf->Write(5,'  ');
	$pdf->Cell(5,5,'',0,0,'',0); $pdf->Write(5,utf8_decode(obtenerTelefonoClientePDF($id_pedido)));
	$pdf->Cell(28,5,'',0,0,'',0);
	$pdf->Cell(40,5,'',0,0,'',0); $pdf->Write(5,utf8_decode(obtenerMetodoDePagoPDF($id_pedido)));
	#Label's Septima Linea
	$pdf->Ln(5);
	$pdf->SetFont('Times','B',12.5);
	$pdf->Write(5,'  ');
	$pdf->Cell(33,5,utf8_decode('Dirección'),0,0,'',0);
	#Datos Octava Linea
	$pdf->Ln(5);
	$pdf->SetFont('Times','',12);
	$pdf->Write(5,'  ');
	$pdf->Cell(5,5,'',0,0,'',0); $pdf->Write(5,utf8_decode(obtenerDireccionClientePDF($id_pedido)));
	#Salto de Linea
	$pdf->Ln(10);
	#Titulo
	$pdf->SetFont('Times','B',13.5);
	$pdf->Write(10,'Articulos o Productos');
	#Salto de Linea
	$pdf->Ln(10);
	#Header de la Tabla
	$pdf->SetFontSize(12);
	#Color de Relleno
	$pdf->SetFillColor(255,255,255);
	#Color de Texto
	$pdf->SetTextColor(40,40,40);
	#Color del Borde de la tabla
	$pdf->SetDrawColor(40,40,40);
	$pdf->SetLineWidth(1);
    $pdf->Cell(50,10,"Nombre",0,0,'C',1);
	$pdf->Cell(30,10,"Codigo",0,0,'C',1);
	$pdf->Cell(35,10,"Producto",0,0,'C',1);
	$pdf->Cell(20,10,"Cantidad",0,0,'C',1);
	$pdf->Cell(30,10,"Costo",0,0,'C',1);
	$pdf->Cell(25,10,"Total",0,0,'C',1);
	$pdf->SetDrawColor(33, 157, 159, 62);
	$pdf->Line(10.2,115,199.9,115);
	#Salto de Linea
	$pdf->Ln(12);
	#Datos de la Tabla
	$pdf->SetLineWidth(0.5);
	$pdf->SetFontSize(11.5);
	$pdf->SetTextColor(40,40,40);
	$pdf->SetFillColor(240,240,240);
	$pdf->SetDrawColor(255,255,255);
	$nombrePedido = obtenerNombreDelProducto($id_pedido);
	$granTotal = 0;
	foreach ($nombrePedido as $producto) {
		$skuPedido = obtenerCodigoProducto($producto->order_item_id);
				foreach ($skuPedido as $codigoPedido) {
					if ($codigoPedido->variation_id == 0) {
						$codigoProducto = $codigoPedido->product_id;
					}else{
						$codigoProducto = $codigoPedido->variation_id;
					}
				$codigoProductoSKU = obtenerCodigoSKU($codigoProducto);
				$costoPedido = obtenerCostoProducto($codigoProducto);
		$pdf->Cell(50,10,$producto->order_item_name,1,0,'C',1);
		foreach ($codigoProductoSKU as $codigoProductoSku) {
			if ($codigoProductoSku->sku == null) {
				$pdf->Cell(30,10,"N.E",1,0,'C',1);		
			} else {
				$pdf->Cell(30,10,$codigoProductoSku->sku,1,0,'C',1);
			}
			$codigoSku = $codigoProductoSku->sku;
			$idSku = obtenerModeloProductoSKU($codigoProductoSku->sku);
			$pdf->Cell(35,10,obtenerModeloProductoSKU($codigoProductoSku->sku),1,0,'C',1);
		 }
		#$modeloProducto = obtenerModeloProducto($producto->order_item_id);
 		#	foreach ($modeloProducto as $nombreModelo) {
		#$pdf->Cell(35,10,ucfirst($nombreModelo->meta_value),1,0,'C',1); }
		$cantidad = obtenerCantidadPedido($producto->order_item_id);
 			foreach ($cantidad as $cantidadPedido) {
		$pdf->Cell(20,10,$cantidadPedido->product_qty,1,0,'C',1); }
		foreach ($costoPedido as $costo) {
		$pdf->Cell(30,10,"S/. ".doubleval($costo->max_price),1,0,'C',1); }
		$total = obtenerTotalPedido($producto->order_item_id);
 				foreach ($total as $totales) {
 					$granTotal += $totales->product_net_revenue;
		$pdf->Cell(25,10,"S/. ".doubleval($totales->product_net_revenue),1,1,'C',1); }
	}
}
	$pdf->Ln(5);
	$pdf->Cell(140,10,'',0,0,'',0);
	$pdf->Cell(32,10,'Total a Pagar : S/. ',0,0,'',0);
	$pdf->Cell(1,10,$granTotal,0,0,'',0);
$pdf->AddPage('PORTRAIT','A4');
//$pdf->SetMargins(10,30,20,20);
$pdf->SetFont('Times','',15);
foreach ($nombrePedido as $articulo) {
$idProducto = $articulo->order_item_id;
if ($idSku == "N.E") {
	$pdf->Ln(10);
	$pdf->Cell(10,5,'Detalle Producto Desconocido',0,1,'',0);
	$pdf->Ln();
	$pdf->Cell(10,5,'Contacte con su Supervisor en Jefe.',0,1,'',0);
} else {
					if ($idSku == "Polo") {
					#Titulo
					$pdf->Ln(10);
					$pdf->Cell(10,5,'Detalle Producto Polo ',0,1,'',0);
					$pdf->Ln();
					#Label's y Datos Primera Linea
					$pdf->SetFont('Times','B',12.5);
					$pdf->Write(5,'  ');
					$pdf->Cell(20,10,utf8_decode('Nombre : '),0,0,'',0);
					$pdf->SetFont('Times','',12.5);
					$pdf->Cell(5,10,utf8_decode(obtenerProductoNombrePDF($idProducto)),0,1,'',0);
					#Label's Segunda Linea
					$pdf->SetFont('Times','B',12.5);
					$pdf->Write(5,'  ');
					$pdf->Cell(34,10,utf8_decode('Codigo de Orden: '),0,0,'',0);
					$pdf->SetFont('Times','',12.5);
					$pdf->Cell(5,10,utf8_decode($idProducto),0,1,'',0);
					#Label's Tercera Linea
					$pdf->SetFont('Times','B',12.5);
					$pdf->Write(5,'  ');
					$pdf->Cell(39,10,utf8_decode('Codigo de Producto: '),0,0,'',0);
					$pdf->SetFont('Times','',12.5);
					$pdf->Cell(5,10,utf8_decode(obtenerProductoPDF($idProducto)),0,1,'',0);
					#Label's Cuarta Linea
					$pdf->SetFont('Times','B',12.5);
					$pdf->Write(5,'  ');
					$pdf->Cell(40,10,utf8_decode('Codigo de Variacion: '),0,0,'',0);
					$pdf->SetFont('Times','',12.5);
					$pdf->Cell(5,10,utf8_decode(obtenerProductoVariacionPDF($idProducto)),0,1,'',0);
					#Label's Sexta Linea
					$pdf->SetFont('Times','B',12.5);
					$pdf->Write(5,'  ');
					$pdf->Cell(20,10,utf8_decode('Modelo: '),0,0,'',0);
					$pdf->SetFont('Times','',12.5);
					$pdf->Cell(5,10,utf8_decode(obtenerModeloPDF($idProducto)),0,1,'',0);
					#Label's Septima Linea
					$pdf->SetFont('Times','B',12.5);
					$pdf->Write(5,'  ');
					$pdf->Cell(20,10,utf8_decode('Color: '),0,0,'',0);
					$pdf->SetFont('Times','',12.5);
					$pdf->Cell(5,10,utf8_decode(obtenerColorPDF($idProducto)),0,1,'',0);
					#Label's Octava Linea
					$pdf->SetFont('Times','B',12.5);
					$pdf->Write(5,'  ');
					$pdf->Cell(20,10,utf8_decode('Talla: '),0,0,'',0);
					$pdf->SetFont('Times','',12.5);
					$pdf->Cell(5,10,utf8_decode(obtenerTallaPDF($idProducto)),0,1,'',0);
					#Label's Novena Linea
					$pdf->SetFont('Times','B',12.5);
					$pdf->Write(5,'  ');
					$pdf->Cell(28,10,utf8_decode('Precio Venta: '),0,0,'',0);
					$pdf->SetFont('Times','',12.5);
					$pdf->Cell(5,10,utf8_decode(obtenerTotalProductoPDF($idProducto)),0,1,'',0);
					#Label's Decima Linea
					$pdf->SetFont('Times','B',12.5);
					$pdf->Write(5,'  ');
					$pdf->Cell(20,10,utf8_decode('Imagen '),0,0,'',0);
					$pdf->SetFont('Times','',12.5);
					$skuPedido = obtenerCodigoProducto($idProducto);
								foreach ($skuPedido as $codigoPedido) {
									if ($codigoPedido->variation_id == 0) {
										$codigoProducto = $codigoPedido->product_id;
									}else{
										$codigoProducto = $codigoPedido->variation_id;
									}
									$codigoImagen = obtenerCodigoImagenPDF($codigoProducto);
				 					$imagenURL = obtenerUrlImagenPDF($codigoImagen);
				 				}
				 				$pdf->Cell(5,10,utf8_decode($codigoImagen),0,1,'',0); 
				 				$pdf->Cell(5,125,'',0,1,'',0);
				 				$pdf->Image($imagenURL,110,45,80,'',atributoImagen($imagenURL));
					}
	else {
		if ($idSku == "Gorro") {
				#Titulo
				$pdf->Ln(10);
				$pdf->Cell(10,5,'Detalle Producto Gorro ',0,1,'',0);
				$pdf->Ln();
				#Label's y Datos Primera Linea
				$pdf->SetFont('Times','B',12.5);
				$pdf->Write(5,'  ');
				$pdf->Cell(20,10,utf8_decode('Nombre : '),0,0,'',0);
				$pdf->SetFont('Times','',12.5);
				$pdf->Cell(5,10,utf8_decode(obtenerProductoNombrePDF($idProducto)),0,1,'',0);
				#Label's Segunda Linea
				$pdf->SetFont('Times','B',12.5);
				$pdf->Write(5,'  ');
				$pdf->Cell(34,10,utf8_decode('Codigo de Orden: '),0,0,'',0);
				$pdf->SetFont('Times','',12.5);
				$pdf->Cell(5,10,utf8_decode($idProducto),0,1,'',0);
				#Label's Tercera Linea
				$pdf->SetFont('Times','B',12.5);
				$pdf->Write(5,'  ');
				$pdf->Cell(39,10,utf8_decode('Codigo de Producto: '),0,0,'',0);
				$pdf->SetFont('Times','',12.5);
				$pdf->Cell(5,10,utf8_decode(obtenerProductoPDF($idProducto)),0,1,'',0);
				#Label's Cuarta Linea
				$pdf->SetFont('Times','B',12.5);
				$pdf->Write(5,'  ');
				$pdf->Cell(40,10,utf8_decode('Codigo de Variacion: '),0,0,'',0);
				$pdf->SetFont('Times','',12.5);
				$pdf->Cell(5,10,utf8_decode(obtenerProductoVariacionPDF($idProducto)),0,1,'',0);
				#Label's Quinta Linea
				$pdf->SetFont('Times','B',12.5);
				$pdf->Write(5,'  ');
				$pdf->Cell(20,10,utf8_decode('Modelo: '),0,0,'',0);
				$pdf->SetFont('Times','',12.5);
				$pdf->Cell(5,10,utf8_decode(obtenerModeloPDF($idProducto)),0,1,'',0);
				#Label's Sexta Linea
				$pdf->SetFont('Times','B',12.5);
				$pdf->Write(5,'  ');
				$pdf->Cell(20,10,utf8_decode('Color: '),0,0,'',0);
				$pdf->SetFont('Times','',12.5);
				$pdf->Cell(5,10,utf8_decode(obtenerColorPDF($idProducto)),0,1,'',0);
				#Label's Setima Linea
				$pdf->SetFont('Times','B',12.5);
				$pdf->Write(5,'  ');
				$pdf->Cell(28,10,utf8_decode('Precio Venta: '),0,0,'',0);
				$pdf->SetFont('Times','',12.5);
				$pdf->Cell(5,10,utf8_decode(obtenerTotalProductoPDF($idProducto)),0,1,'',0);
				#Label's Octava Linea
				$pdf->SetFont('Times','B',12.5);
				$pdf->Write(5,'  ');
				$pdf->Cell(20,10,utf8_decode('Imagen '),0,0,'',0);
				$pdf->SetFont('Times','',12.5);
				$skuPedido = obtenerCodigoProducto($idProducto);
							foreach ($skuPedido as $codigoPedido) {
								if ($codigoPedido->variation_id == 0) {
									$codigoProducto = $codigoPedido->product_id;
								}else{
									$codigoProducto = $codigoPedido->variation_id;
								}
								$codigoImagen = obtenerCodigoImagenPDF($codigoProducto);
			 					$imagenURL = obtenerUrlImagenPDF($codigoImagen);
			 					$pdf->Cell(5,10,utf8_decode($codigoImagen),0,1,'',0); 
			 					$pdf->Cell(5,135,$pdf->Image($imagenURL,110,45,80,'','',),1,1,'C',0);
			 				}
		} else {
			if ($idSku == "Taza") {
						#Titulo
						$pdf->Ln(10);
						$pdf->Cell(10,5,'Detalle Producto Taza ',0,1,'',0);
						$pdf->Ln();
						#Label's y Datos Primera Linea
						$pdf->SetFont('Times','B',12.5);
						$pdf->Write(5,'  ');
						$pdf->Cell(20,10,utf8_decode('Nombre : '),0,0,'',0);
						$pdf->SetFont('Times','',12.5);
						$pdf->Cell(5,10,utf8_decode(obtenerProductoNombrePDF($idProducto)),0,1,'',0);
						#Label's Segunda Linea
						$pdf->SetFont('Times','B',12.5);
						$pdf->Write(5,'  ');
						$pdf->Cell(34,10,utf8_decode('Codigo de Orden: '),0,0,'',0);
						$pdf->SetFont('Times','',12.5);
						$pdf->Cell(5,10,utf8_decode($idProducto),0,1,'',0);
						#Label's Tercera Linea
						$pdf->SetFont('Times','B',12.5);
						$pdf->Write(5,'  ');
						$pdf->Cell(39,10,utf8_decode('Codigo de Producto: '),0,0,'',0);
						$pdf->SetFont('Times','',12.5);
						$pdf->Cell(5,10,utf8_decode(obtenerProductoPDF($idProducto)),0,1,'',0);
						#Label's Cuarta Linea
						$pdf->SetFont('Times','B',12.5);
						$pdf->Write(5,'  ');
						$pdf->Cell(40,10,utf8_decode('Codigo de Variacion: '),0,0,'',0);
						$pdf->SetFont('Times','',12.5);
						$pdf->Cell(5,10,utf8_decode(obtenerProductoVariacionPDF($idProducto)),0,1,'',0);
						#Label's Quinta Linea
						$pdf->SetFont('Times','B',12.5);
						$pdf->Write(5,'  ');
						$pdf->Cell(20,10,utf8_decode('Modelo: '),0,0,'',0);
						$pdf->SetFont('Times','',12.5);
						$pdf->Cell(5,10,utf8_decode(obtenerModeloPDF($idProducto)),0,1,'',0);
						#Label's Sexta Linea
						$pdf->SetFont('Times','B',12.5);
						$pdf->Write(5,'  ');
						$pdf->Cell(20,10,utf8_decode('Color: '),0,0,'',0);
						$pdf->SetFont('Times','',12.5);
						$pdf->Cell(5,10,utf8_decode(obtenerColorPDF($idProducto)),0,1,'',0);
						#Label's Quinta Linea
						$pdf->SetFont('Times','B',12.5);
						$pdf->Write(5,'  ');
						$pdf->Cell(20,10,utf8_decode('Tecnica: '),0,0,'',0);
						$pdf->SetFont('Times','',12.5);
						$pdf->Cell(5,10,utf8_decode(obtenerTecnicaPDF($idProducto)),0,1,'',0);
						#Label's Quinta Linea
						$pdf->SetFont('Times','B',12.5);
						$pdf->Write(5,'  ');
						$pdf->Cell(28,10,utf8_decode('Precio Venta: '),0,0,'',0);
						$pdf->SetFont('Times','',12.5);
						$pdf->Cell(5,10,utf8_decode(obtenerTotalProductoPDF($idProducto)),0,1,'',0);
						#Label's Quinta Linea
						$pdf->SetFont('Times','B',12.5);
						$pdf->Write(5,'  ');
						$pdf->Cell(20,10,utf8_decode('Imagen '),0,0,'',0);
						$pdf->SetFont('Times','',12.5);
						$skuPedido = obtenerCodigoProducto($idProducto);
									foreach ($skuPedido as $codigoPedido) {
										if ($codigoPedido->variation_id == 0) {
											$codigoProducto = $codigoPedido->product_id;
										}else{
											$codigoProducto = $codigoPedido->variation_id;
										}
										$codigoImagen = obtenerCodigoImagenPDF($codigoProducto);
					 					$imagenURL = obtenerUrlImagenPDF($codigoImagen);
					 					$pdf->Cell(5,10,utf8_decode($codigoImagen),0,1,'',0); 
					 					$pdf->Cell(5,135,$pdf->Image($imagenURL,110,45,80,'','',),1,1,'C',0);
					 				}
			} else {
				if ($idSku == "M") {
							#Titulo
							$pdf->Ln(10);
							$pdf->Cell(10,5,'Detalle Producto MUG ',0,1,'',0);
							$pdf->Ln();
							#Label's y Datos Primera Linea
							$pdf->SetFont('Times','B',12.5);
							$pdf->Write(5,'  ');
							$pdf->Cell(20,10,utf8_decode('Nombre : '),0,0,'',0);
							$pdf->SetFont('Times','',12.5);
							$pdf->Cell(5,10,utf8_decode(obtenerProductoNombrePDF($idProducto)),0,1,'',0);
							#Label's Segunda Linea
							$pdf->SetFont('Times','B',12.5);
							$pdf->Write(5,'  ');
							$pdf->Cell(34,10,utf8_decode('Codigo de Orden: '),0,0,'',0);
							$pdf->SetFont('Times','',12.5);
							$pdf->Cell(5,10,utf8_decode($idProducto),0,1,'',0);
							#Label's Tercera Linea
							$pdf->SetFont('Times','B',12.5);
							$pdf->Write(5,'  ');
							$pdf->Cell(39,10,utf8_decode('Codigo de Producto: '),0,0,'',0);
							$pdf->SetFont('Times','',12.5);
							$pdf->Cell(5,10,utf8_decode(obtenerProductoPDF($idProducto)),0,1,'',0);
							#Label's Cuarta Linea
							$pdf->SetFont('Times','B',12.5);
							$pdf->Write(5,'  ');
							$pdf->Cell(40,10,utf8_decode('Codigo de Variacion: '),0,0,'',0);
							$pdf->SetFont('Times','',12.5);
							$pdf->Cell(5,10,utf8_decode(obtenerProductoVariacionPDF($idProducto)),0,1,'',0);
							#Label's Quinta Linea
							$pdf->SetFont('Times','B',12.5);
							$pdf->Write(5,'  ');
							$pdf->Cell(20,10,utf8_decode('Modelo: '),0,0,'',0);
							$pdf->SetFont('Times','',12.5);
							$pdf->Cell(5,10,utf8_decode(obtenerModeloPDF($idProducto)),0,1,'',0);
							#Label's Sexta Linea
							$pdf->SetFont('Times','B',12.5);
							$pdf->Write(5,'  ');
							$pdf->Cell(20,10,utf8_decode('Color: '),0,0,'',0);
							$pdf->SetFont('Times','',12.5);
							$pdf->Cell(5,10,utf8_decode(obtenerColorPDF($idProducto)),0,1,'',0);
							#Label's Quinta Linea
							$pdf->SetFont('Times','B',12.5);
							$pdf->Write(5,'  ');
							$pdf->Cell(28,10,utf8_decode('Precio Venta: '),0,0,'',0);
							$pdf->SetFont('Times','',12.5);
							$pdf->Cell(5,10,utf8_decode(obtenerTotalProductoPDF($idProducto)),0,1,'',0);
							#Label's Quinta Linea
							$pdf->SetFont('Times','B',12.5);
							$pdf->Write(5,'  ');
							$pdf->Cell(20,10,utf8_decode('Imagen '),0,0,'',0);
							$pdf->SetFont('Times','',12.5);
							$skuPedido = obtenerCodigoProducto($idProducto);
										foreach ($skuPedido as $codigoPedido) {
											if ($codigoPedido->variation_id == 0) {
												$codigoProducto = $codigoPedido->product_id;
											}else{
												$codigoProducto = $codigoPedido->variation_id;
											}
											$codigoImagen = obtenerCodigoImagenPDF($codigoProducto);
						 					$imagenURL = obtenerUrlImagenPDF($codigoImagen);
						 					$pdf->Cell(5,10,utf8_decode($codigoImagen),0,1,'',0); 
						 					$pdf->Cell(5,135,$pdf->Image($imagenURL,110,45,80,'','',),1,1,'C',0);
						 				}
				} else {
					if ($idSku == "PM") {
						#Titulo
							$pdf->Ln(10);
							$pdf->Cell(10,5,'Detalle Producto PadMaus ',0,1,'',0);
							$pdf->Ln();
							#Label's y Datos Primera Linea
							$pdf->SetFont('Times','B',12.5);
							$pdf->Write(5,'  ');
							$pdf->Cell(20,10,utf8_decode('Nombre : '),0,0,'',0);
							$pdf->SetFont('Times','',12.5);
							$pdf->Cell(5,10,utf8_decode(obtenerProductoNombrePDF($idProducto)),0,1,'',0);
							#Label's Segunda Linea
							$pdf->SetFont('Times','B',12.5);
							$pdf->Write(5,'  ');
							$pdf->Cell(34,10,utf8_decode('Codigo de Orden: '),0,0,'',0);
							$pdf->SetFont('Times','',12.5);
							$pdf->Cell(5,10,utf8_decode($idProducto),0,1,'',0);
							#Label's Tercera Linea
							$pdf->SetFont('Times','B',12.5);
							$pdf->Write(5,'  ');
							$pdf->Cell(39,10,utf8_decode('Codigo de Producto: '),0,0,'',0);
							$pdf->SetFont('Times','',12.5);
							$pdf->Cell(5,10,utf8_decode(obtenerProductoPDF($idProducto)),0,1,'',0);
							#Label's Cuarta Linea
							$pdf->SetFont('Times','B',12.5);
							$pdf->Write(5,'  ');
							$pdf->Cell(40,10,utf8_decode('Codigo de Variacion: '),0,0,'',0);
							$pdf->SetFont('Times','',12.5);
							$pdf->Cell(5,10,utf8_decode(obtenerProductoVariacionPDF($idProducto)),0,1,'',0);
							#Label's Sexta Linea
							$pdf->SetFont('Times','B',12.5);
							$pdf->Write(5,'  ');
							$pdf->Cell(20,10,utf8_decode('Color: '),0,0,'',0);
							$pdf->SetFont('Times','',12.5);
							$pdf->Cell(5,10,utf8_decode(obtenerColorPDF($idProducto)),0,1,'',0);
							#Label's Quinta Linea
							$pdf->SetFont('Times','B',12.5);
							$pdf->Write(5,'  ');
							$pdf->Cell(28,10,utf8_decode('Precio Venta: '),0,0,'',0);
							$pdf->SetFont('Times','',12.5);
							$pdf->Cell(5,10,utf8_decode(obtenerTotalProductoPDF($idProducto)),0,1,'',0);
							#Label's Quinta Linea
							$pdf->SetFont('Times','B',12.5);
							$pdf->Write(5,'  ');
							$pdf->Cell(20,10,utf8_decode('Imagen '),0,0,'',0);
							$pdf->SetFont('Times','',12.5);
							$skuPedido = obtenerCodigoProducto($idProducto);
										foreach ($skuPedido as $codigoPedido) {
											if ($codigoPedido->variation_id == 0) {
												$codigoProducto = $codigoPedido->product_id;
											}else{
												$codigoProducto = $codigoPedido->variation_id;
											}
											$codigoImagen = obtenerCodigoImagenPDF($codigoProducto);
						 					$imagenURL = obtenerUrlImagenPDF($codigoImagen);
						 					$pdf->Cell(5,10,utf8_decode($codigoImagen),0,1,'',0); 
						 					$pdf->Cell(5,135,$pdf->Image($imagenURL,110,45,80,'','',),1,1,'C',0);
						 				}
					}else{
						if ($idSku == "L") {
							#Titulo
							$pdf->Ln(10);
							$pdf->Cell(10,5,'Detalle Producto Libreta ',0,1,'',0);
							$pdf->Ln();
							#Label's y Datos Primera Linea
							$pdf->SetFont('Times','B',12.5);
							$pdf->Write(5,'  ');
							$pdf->Cell(20,10,utf8_decode('Nombre : '),0,0,'',0);
							$pdf->SetFont('Times','',12.5);
							$pdf->Cell(5,10,utf8_decode(obtenerProductoNombrePDF($idProducto)),0,1,'',0);
							#Label's Segunda Linea
							$pdf->SetFont('Times','B',12.5);
							$pdf->Write(5,'  ');
							$pdf->Cell(34,10,utf8_decode('Codigo de Orden: '),0,0,'',0);
							$pdf->SetFont('Times','',12.5);
							$pdf->Cell(5,10,utf8_decode($idProducto),0,1,'',0);
							#Label's Tercera Linea
							$pdf->SetFont('Times','B',12.5);
							$pdf->Write(5,'  ');
							$pdf->Cell(39,10,utf8_decode('Codigo de Producto: '),0,0,'',0);
							$pdf->SetFont('Times','',12.5);
							$pdf->Cell(5,10,utf8_decode(obtenerProductoPDF($idProducto)),0,1,'',0);
							#Label's Cuarta Linea
							$pdf->SetFont('Times','B',12.5);
							$pdf->Write(5,'  ');
							$pdf->Cell(40,10,utf8_decode('Codigo de Variacion: '),0,0,'',0);
							$pdf->SetFont('Times','',12.5);
							$pdf->Cell(5,10,utf8_decode(obtenerProductoVariacionPDF($idProducto)),0,1,'',0);
							#Label's Quinta Linea
							$pdf->SetFont('Times','B',12.5);
							$pdf->Write(5,'  ');
							$pdf->Cell(20,10,utf8_decode('Modelo: '),0,0,'',0);
							$pdf->SetFont('Times','',12.5);
							$pdf->Cell(5,10,utf8_decode(obtenerModeloPDF($idProducto)),0,1,'',0);
							#Label's Sexta Linea
							$pdf->SetFont('Times','B',12.5);
							$pdf->Write(5,'  ');
							$pdf->Cell(20,10,utf8_decode('Color: '),0,0,'',0);
							$pdf->SetFont('Times','',12.5);
							$pdf->Cell(5,10,utf8_decode(obtenerColorPDF($idProducto)),0,1,'',0);
							#Label's Quinta Linea
							$pdf->SetFont('Times','B',12.5);
							$pdf->Write(5,'  ');
							$pdf->Cell(28,10,utf8_decode('Precio Venta: '),0,0,'',0);
							$pdf->SetFont('Times','',12.5);
							$pdf->Cell(5,10,utf8_decode(obtenerTotalProductoPDF($idProducto)),0,1,'',0);
							#Label's Quinta Linea
							$pdf->SetFont('Times','B',12.5);
							$pdf->Write(5,'  ');
							$pdf->Cell(20,10,utf8_decode('Imagen '),0,0,'',0);
							$pdf->SetFont('Times','',12.5);
							$skuPedido = obtenerCodigoProducto($idProducto);
										foreach ($skuPedido as $codigoPedido) {
											if ($codigoPedido->variation_id == 0) {
												$codigoProducto = $codigoPedido->product_id;
											}else{
												$codigoProducto = $codigoPedido->variation_id;
											}
											$codigoImagen = obtenerCodigoImagenPDF($codigoProducto);
						 					$imagenURL = obtenerUrlImagenPDF($codigoImagen);
						 					$pdf->Cell(5,10,utf8_decode($codigoImagen),0,1,'',0); 
						 					$pdf->Cell(5,135,$pdf->Image($imagenURL,110,45,80,'','',),1,1,'C',0);
						 				}
						} else {
							if ($idSku == "B") {
								#Titulo
							$pdf->Ln(10);
							$pdf->Cell(10,5,'Detalle Producto Bolsa ',0,1,'',0);
							$pdf->Ln();
							#Label's y Datos Primera Linea
							$pdf->SetFont('Times','B',12.5);
							$pdf->Write(5,'  ');
							$pdf->Cell(20,10,utf8_decode('Nombre : '),0,0,'',0);
							$pdf->SetFont('Times','',12.5);
							$pdf->Cell(5,10,utf8_decode(obtenerProductoNombrePDF($idProducto)),0,1,'',0);
							#Label's Segunda Linea
							$pdf->SetFont('Times','B',12.5);
							$pdf->Write(5,'  ');
							$pdf->Cell(34,10,utf8_decode('Codigo de Orden: '),0,0,'',0);
							$pdf->SetFont('Times','',12.5);
							$pdf->Cell(5,10,utf8_decode($idProducto),0,1,'',0);
							#Label's Tercera Linea
							$pdf->SetFont('Times','B',12.5);
							$pdf->Write(5,'  ');
							$pdf->Cell(39,10,utf8_decode('Codigo de Producto: '),0,0,'',0);
							$pdf->SetFont('Times','',12.5);
							$pdf->Cell(5,10,utf8_decode(obtenerProductoPDF($idProducto)),0,1,'',0);
							#Label's Cuarta Linea
							$pdf->SetFont('Times','B',12.5);
							$pdf->Write(5,'  ');
							$pdf->Cell(40,10,utf8_decode('Codigo de Variacion: '),0,0,'',0);
							$pdf->SetFont('Times','',12.5);
							$pdf->Cell(5,10,utf8_decode(obtenerProductoVariacionPDF($idProducto)),0,1,'',0);
							#Label's Sexta Linea
							$pdf->SetFont('Times','B',12.5);
							$pdf->Write(5,'  ');
							$pdf->Cell(20,10,utf8_decode('Color: '),0,0,'',0);
							$pdf->SetFont('Times','',12.5);
							$pdf->Cell(5,10,utf8_decode(obtenerColorPDF($idProducto)),0,1,'',0);
							#Label's Quinta Linea
							$pdf->SetFont('Times','B',12.5);
							$pdf->Write(5,'  ');
							$pdf->Cell(28,10,utf8_decode('Precio Venta: '),0,0,'',0);
							$pdf->SetFont('Times','',12.5);
							$pdf->Cell(5,10,utf8_decode(obtenerTotalProductoPDF($idProducto)),0,1,'',0);
							#Label's Quinta Linea
							$pdf->SetFont('Times','B',12.5);
							$pdf->Write(5,'  ');
							$pdf->Cell(20,10,utf8_decode('Imagen '),0,0,'',0);
							$pdf->SetFont('Times','',12.5);
							$skuPedido = obtenerCodigoProducto($idProducto);
										foreach ($skuPedido as $codigoPedido) {
											if ($codigoPedido->variation_id == 0) {
												$codigoProducto = $codigoPedido->product_id;
											}else{
												$codigoProducto = $codigoPedido->variation_id;
											}
											$codigoImagen = obtenerCodigoImagenPDF($codigoProducto);
						 					$imagenURL = obtenerUrlImagenPDF($codigoImagen);
						 					$pdf->Cell(5,10,utf8_decode($codigoImagen),0,1,'',0); 
						 					$pdf->Cell(5,135,$pdf->Image($imagenURL,110,45,80,'','',),1,1,'C',0);
						 				}
							} else{
								if ($idSku == "GAD") {
									#Titulo
							$pdf->Ln(10);
							$pdf->Cell(10,5,'Detalle Producto Gadget ',0,1,'',0);
							$pdf->Ln();
							#Label's y Datos Primera Linea
							$pdf->SetFont('Times','B',12.5);
							$pdf->Write(5,'  ');
							$pdf->Cell(20,10,utf8_decode('Nombre : '),0,0,'',0);
							$pdf->SetFont('Times','',12.5);
							$pdf->Cell(5,10,utf8_decode(obtenerProductoNombrePDF($idProducto)),0,1,'',0);
							#Label's Segunda Linea
							$pdf->SetFont('Times','B',12.5);
							$pdf->Write(5,'  ');
							$pdf->Cell(34,10,utf8_decode('Codigo de Orden: '),0,0,'',0);
							$pdf->SetFont('Times','',12.5);
							$pdf->Cell(5,10,utf8_decode($idProducto),0,1,'',0);
							#Label's Tercera Linea
							$pdf->SetFont('Times','B',12.5);
							$pdf->Write(5,'  ');
							$pdf->Cell(39,10,utf8_decode('Codigo de Producto: '),0,0,'',0);
							$pdf->SetFont('Times','',12.5);
							$pdf->Cell(5,10,utf8_decode(obtenerProductoPDF($idProducto)),0,1,'',0);
							#Label's Cuarta Linea
							$pdf->SetFont('Times','B',12.5);
							$pdf->Write(5,'  ');
							$pdf->Cell(40,10,utf8_decode('Codigo de Variacion: '),0,0,'',0);
							$pdf->SetFont('Times','',12.5);
							$pdf->Cell(5,10,utf8_decode(obtenerProductoVariacionPDF($idProducto)),0,1,'',0);
							#Label's Quinta Linea
							$pdf->SetFont('Times','B',12.5);
							$pdf->Write(5,'  ');
							$pdf->Cell(20,10,utf8_decode('Modelo: '),0,0,'',0);
							$pdf->SetFont('Times','',12.5);
							$pdf->Cell(5,10,utf8_decode(obtenerModeloPDF($idProducto)),0,1,'',0);
							#Label's Sexta Linea
							$pdf->SetFont('Times','B',12.5);
							$pdf->Write(5,'  ');
							$pdf->Cell(20,10,utf8_decode('Color: '),0,0,'',0);
							$pdf->SetFont('Times','',12.5);
							$pdf->Cell(5,10,utf8_decode(obtenerColorPDF($idProducto)),0,1,'',0);
							#Label's Quinta Linea
							$pdf->SetFont('Times','B',12.5);
							$pdf->Write(5,'  ');
							$pdf->Cell(28,10,utf8_decode('Precio Venta: '),0,0,'',0);
							$pdf->SetFont('Times','',12.5);
							$pdf->Cell(5,10,utf8_decode(obtenerTotalProductoPDF($idProducto)),0,1,'',0);
							#Label's Quinta Linea
							$pdf->SetFont('Times','B',12.5);
							$pdf->Write(5,'  ');
							$pdf->Cell(20,10,utf8_decode('Imagen '),0,0,'',0);
							$pdf->SetFont('Times','',12.5);
							$skuPedido = obtenerCodigoProducto($idProducto);
										foreach ($skuPedido as $codigoPedido) {
											if ($codigoPedido->variation_id == 0) {
												$codigoProducto = $codigoPedido->product_id;
											}else{
												$codigoProducto = $codigoPedido->variation_id;
											}
											$codigoImagen = obtenerCodigoImagenPDF($codigoProducto);
						 					$imagenURL = obtenerUrlImagenPDF($codigoImagen);
						 					$pdf->Cell(5,10,utf8_decode($codigoImagen),0,1,'',0); 
						 					$pdf->Cell(5,135,$pdf->Image($imagenURL,110,45,80,'','',),1,1,'C',0);
						 				}
								}
							}
						}
					}
				}
			}
		}
	}
}
	
	$pdf->SetFontSize(15);
}
$pdf->Output('I',"Pedido_".$id_pedido.".pdf");
?>