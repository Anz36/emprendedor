<?php

include_once "../FuncionesExtra/funciones.php";

$listaDetalle = obtenerIDProducto("4");
foreach ($listaDetalle as $listas) {
	$idDetalle = $listas->order_id;
	$nombrePedido = obtenerNombreDelProducto($idDetalle);
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
									foreach ($codigoProductoSKU as $codigoProductoSku) {
										
									}
								}
}

}
?>
