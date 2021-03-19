<?php 
    include_once "../VistaAdmin/main.php";
    include_once "../FuncionesExtra/funciones.php"; include_once "../Sessiones/funcionSession.php";
    include_once "../VistaAdmin/funciones.php";
	$granTotal = 0;
	if (empty($_SESSION["codUsuario"])) {
    # Lo redireccionamos al formulario de inicio de sesión
    header("Location: ../Login/formulario_login.php?mensaje=Necesita iniciar session para ingresar a la pagina protegida");
    # Y salimos del script
    exit();
	}
	$detalle = capturarIdPedido($datoPersona->id);
	if ($detalle == null) { ?>
		<div class="row">
			<div class="col">
				<h1>Usted no esta atendiendo un pedido</h1>
			</div>
		</div>
	<?php
	}
	$nombreStatus = disponibleUsuario($detalle);
	if ($nombreStatus == "Pendiente" || $nombreStatus == "Procesando" || $nombreStatus == "En Espera" || $nombreStatus == "Reembolsado") {
		$idDetalle = capturarIdPedido($datoPersona->id);
 ?>
        <div class="row">
					<div class="container">
						<div class="row">
							<div class="col-auto">
							<h4>Detalle Pedido # <?php echo $idDetalle; ?></h4>
							&nbsp;
			            	<span class="badge rounded-pill bg-light text-dark" style="font-weight: bold;"> <?php echo atencionUsuario($idDetalle);  ?></span>&nbsp;
			            	<span class="badge rounded-pill bg-light text-dark" style="font-weight: bold;"> <?php echo disponibleUsuario($idDetalle); ?></span>
							</div>
							<div class="col offset-7">
								<button type="button" class="btn btn" style="background-color: <?php echo color(disponibleUsuario($idDetalle)); ?>; color: black" data-toggle="modal" data-target="#myModal">
									    Modo de Atención
									  </button>

									  <!-- The Modal -->
									  <div class="modal" id="myModal">
									    <div class="modal-dialog">
									      <div class="modal-content">
									      
									        <!-- Modal Header -->
									        <div class="modal-header">
									          <h4 class="modal-title">Editar Atención</h4>
									          <button type="button" class="close" data-dismiss="modal">&times;</button>
									        </div>
									        
									        <!-- Modal body -->
									        <div class="modal-body">
									          <div class="row">
									          	<div class="col">
									          		<h5>Pedido # <?php echo $idDetalle; ?></h5>
									          	</div>
									          	<div class="col">
									          		<h6 class="text-muted">Usuario : <?php echo $datoPersona->nombre; ?></h6>
									          	</div>
									          </div>
									          <div class="row">
									          	<div class="col-7">
									          		<form action="actualizarProducto.php" method="POST">
									          		<label for="atender">Atención</label>
									          		<select name="atender" class="form-control">
									          			<option value="1">Pendiente</option>
							        					<option value="2">Procesando</option>
							        					<option value="3">En Espera</option>
							        					<option value="4">Cancelado</option>
							        					<option value="5">Reembolsado</option>
							        					<option value="6">Completado</option>
									          		</select>
									          		<input type="hidden" name="id" value="<?php echo $idDetalle; ?>">
									          		<input type="hidden" name="idUsuario" value="<?php echo $datoPersona->id; ?>">
									          	</div>
									          </div>
									        </div>
									        
									        <!-- Modal footer -->
									        <div class="modal-footer">
									        	<button type="submit" class="btn btn" style="background-color: #219D9F; color: #fff" name="actualizar">Modificar</button>
									        	</form>
									          <button type="button" class="btn btn" style="background-color: #219D9F; color: #fff" data-dismiss="modal">Close</button>
									        </div>
									        
									      </div>
									    </div>
									  </div>
							</div>
						</div>
						
					 	<br>
					 </div>
					 <div class="container">
					 	<div class="row">
					 		<div class="col">
					 			<h5>Informacion del Cliente</h5>
					 		</div>
					 		<div class="col">
					 			<h5>Datos del Pedido</h5>
					 		</div>
					 	</div>
					 	<div class="row">
					 		<div class="col">
					 			<div class="form-group col">
					 		<label for="Nombre">Nombre y Apellido</label>
					 		<input type="text" id="Nombre" name="Nombre" readonly class="form-control" value="<?php obtenerNombreDelCliente($idDetalle); echo " "; obtenerApellidoDelCliente($idDetalle); ?>">
					 		<label for="codCliente">Cod-Cliente</label>
					 		<input type="text" id="codCliente" name="codCliente" readonly class="form-control" value="<?php obtenerCodigoCliente($idDetalle); ?>">
					 		<label for="telefono">Teléfono</label>
					 		<input type="text" id="telefono" name="telefono" readonly class="form-control" value="<?php obtenerTelefonoCliente($idDetalle); ?>">
					 		<label for="direccion">Dirección</label>
					 		<input type="text" id="direccion" name="direccion" readonly class="form-control" value="<?php obtenerDireccionCliente($idDetalle); ?>">
					 			</div>
					 		</div>
					 		<div class="col">
					 			<div class="form-group col">
					 		<label for="Nombre">Fecha</label>
					 		<input type="text" id="Nombre" name="Nombre" readonly class="form-control" value="<?php obtenerFechaPedido($idDetalle); ?>">
					 		<label for="codCliente">Estado</label>
					 		<input type="text" id="codCliente" name="codCliente" readonly class="form-control" value="<?php 
					 		if(obtenerEstadoPedido($idDetalle) == "No existe Estado Pago"){
					 			obtenerEstadoPedido($idDetalle);
					 		}else {
					 			$estadoPedido = obtenerEstadoPedido($idDetalle);
					 			determinarEstado($estadoPedido);
					 		} ?>">
					 		<label for="telefono">Metodo de Pago</label>
					 		<input type="text" id="telefono" name="telefono" readonly class="form-control" value="<?php obtenerMetodoDePago($idDetalle); ?>">
					 	</div>
					 		</div>
					 	</div>
					 </div>
					 <br>
					 <div class="container">
					 	<div class="row">
					 		<div class="col">
					 			<h5>Articulo o Producto</h5>
					 		</div>
					 		<div class="col" align="end">
					 			<a class="btn btn-outline-warning btn-sm" target="_Blank" href="<?php echo "../Pdf/detalle-pdf.php?id=".$idDetalle;?>">PDF <i class="icon ion-md-document"></i></a>
					 		</div>
					 	</div>
					 	<br>
					 	<div class="row">
					 		<div class="col table-responsive table-hover">
					 			<table class="table">
					 		<thead>
					 			<tr style="background-color: #eff2f7;color: #219D9F">
					 				<th>Nombre</th>
					 				<th>Codigo</th>
					 				<th>Producto</th>
					 				<th>Cantidad</th>
					 				<th>Costo</th>
					 				<th>Total</th>
					 			</tr>
					 		</thead>
					 		<tbody>
					 			<?php 
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
					 				?>
					 			<tr>
					 				<td>
					 					<?php 
					 					echo $producto->order_item_name; 
					 					?>
					 				</td>
					 				<td><?php 
					 					# Codigo SKU
					 					if ($codigoProductoSku->sku == null) {
					 						echo "N.E";
					 					} else {
					 						echo $codigoProductoSku->sku;	
					 					}
					 					
					 			?></td>
					 			<td><?php  
					 				echo obtenerModeloProductoSKU($codigoProductoSku->sku);
					 			}
					 			 ?></td>
					 			<td><?php 
					 				$cantidad = obtenerCantidadPedido($producto->order_item_id);
					 			foreach ($cantidad as $cantidadPedido) {
					 				echo $cantidadPedido->product_qty;
					 			}
					 			 ?></td>
					 			<td><?php 
					 			foreach ($costoPedido as $costo) {
					 				echo "S/. ".doubleval($costo->max_price); 
					 			}
					 			?></td>
					 			<td> <?php 
					 				$total = obtenerTotalPedido($producto->order_item_id);
					 				foreach ($total as $totales) {
					 					$granTotal += $totales->product_net_revenue;
					 					echo "S/. ".doubleval($totales->product_net_revenue);
					 				}
					 			 ?></td>
					 			</tr>
					 		</tbody>
					 		<?php }
					 	}
					 		?>
					 	</table>
					 		</div>
					 	</div>
					 	<br><br>
					 	 		<div class="alert alert-dismissible alert" style="background-color: #219D9F">
					 			<h5 style="color: #fff">Total a Pagar S/. <?php echo $granTotal; ?></h5>
					 		</div>
					 </div>
					 <br>
<?php 
$pedido = obtenerNombreDelProducto($idDetalle);
foreach ($pedido as $articulo) {
	$id_producto = $articulo->order_item_id;
	$skuPedido = obtenerCodigoProducto($articulo->order_item_id);
	foreach ($skuPedido as $codigoPedido) {
				if ($codigoPedido->variation_id == 0) {
							$codigoProducto = $codigoPedido->product_id;
						}else{
								$codigoProducto = $codigoPedido->variation_id;
							}
							$codigoProductoSKU = obtenerCodigoSKU($codigoProducto);
							$costoPedido = obtenerCostoProducto($codigoProducto);
							foreach ($codigoProductoSKU as $codigoProductoSku) {
								$idSku = $codigoProductoSku->sku;
$dato = obtenerModeloProductoSKU($idSku);
	if ($dato == "Polo") {
 ?>
<div class="container">
	<h1>Detalle del Producto Polo</h1>
</div>
 <div class="container">
 	<br>
 	<div class="row align-items-center">
 		<div class="form-group col-6">
 		<label for="Nombre">Nombre</label>
 		<input type="text" id="Nombre" name="Nombre" readonly class="form-control" value="<?php obtenerProductoNombre($id_producto); ?>">
 		<label for="codCliente">Codigo de Orden</label>
 		<input type="text" id="codCliente" name="codCliente" readonly class="form-control" value="<?php echo $id_producto; ?>">
 		<label for="codCliente">Codigo de Producto</label>
 		<input type="text" id="codCliente" name="codCliente" readonly class="form-control" value="<?php obtenerProducto($id_producto); ?>">
 		<label for="codCliente">Codigo de Variacion</label>
 		<input type="text" id="codCliente" name="codCliente" readonly class="form-control" value="<?php obtenerProductoVariacion($id_producto); ?>">
 		<label for="codCliente">Codigo de Sku</label>
 		<input type="text" id="codCliente" name="codCliente" readonly class="form-control" value="<?php echo $idSku; ?>">
 		<label for="modelo">Modelo</label>
 		<input type="text" id="modelo" name="modelo" readonly class="form-control" value="<?php obtenerModelo($id_producto); ?>">
 		<label for="color">Color</label>
 		<input type="text" id="color" name="color" readonly class="form-control" value="<?php obtenerColor($id_producto); ?>">
 		<label for="talla">Talla</label>
 		<input type="text" id="talla" name="talla" readonly class="form-control" value="<?php obtenerTalla($id_producto); ?>">
 		<label for="precio">Precio de Venta</label>
 		<input type="text" id="precio" name="precio" readonly class="form-control" value="<?php obtenerTotalProducto($id_producto); ?>">
 		<label for="direccion" class="col-6">Imagen Codigo <?php 
 		$skuPedido = obtenerCodigoProducto($id_producto);
				foreach ($skuPedido as $codigoPedido) {
					if ($codigoPedido->variation_id == 0) {
						$codigoProducto = $codigoPedido->product_id;
					}else{
						$codigoProducto = $codigoPedido->variation_id;
					} 
				}
 		$codigoImagen = obtenerCodigoImagen($codigoProducto);
 		$imagenURL = obtenerUrlImagen($codigoImagen);
 		echo $codigoImagen; ?></label>
 		</div>
 		<div class="col-6" align="center">
 			<img width="400px" src="<?php echo $imagenURL ?>" alt="" class="img-thumbnail" style="border-color: #219D9F">
 		</div>
 	</div>
 </div>
	 <?php 
} if ($dato == "N.E") { ?>
	<div class="container">
			<div class="col">
				<h1>Producto sin Detalles</h1>
				<br>
				<h6><?php echo $articulo->order_item_name;  ?></h6>
			</div>
		</div>
		<div class="container">
			<br>
			<div class="col-11">
				<div class="alert alert" style="background-color: #219D9F; border-color: #219D9F">
					<h5 style="color: #fff">Dar aviso al Supervisor en Jefe</h5>
				</div>
			</div>
		</div>
		<?php
} if ($dato == "Gorro") { ?>
	<div class="container">
				<h1>Detalle del Producto Gorro</h1>
			</div>
			 <div class="container">
			 	<br>
			 	<div class="row align-items-center">
			 		<div class="form-group col-6">
			 		<label for="Nombre">Nombre</label>
			 		<input type="text" id="Nombre" name="Nombre" readonly class="form-control" value="<?php obtenerProductoNombre($id_producto); ?>">
			 		<label for="codCliente">Codigo de Orden</label>
			 		<input type="text" id="codCliente" name="codCliente" readonly class="form-control" value="<?php echo $id_producto; ?>">
			 		<label for="codCliente">Codigo de Producto</label>
			 		<input type="text" id="codCliente" name="codCliente" readonly class="form-control" value="<?php obtenerProducto($id_producto); ?>">
			 		<label for="codCliente">Codigo de Variacion</label>
			 		<input type="text" id="codCliente" name="codCliente" readonly class="form-control" value="<?php obtenerProductoVariacion($id_producto); ?>">
			 		<label for="codCliente">Codigo de Sku</label>
 					<input type="text" id="codCliente" name="codCliente" readonly class="form-control" value="<?php echo $idSku; ?>">
			 		<label for="modelo">Modelo</label>
			 		<input type="text" id="modelo" name="modelo" readonly class="form-control" value="<?php obtenerModelo($id_producto); ?>">
			 		<label for="color">Color</label>
			 		<input type="text" id="color" name="color" readonly class="form-control" value="<?php obtenerColor($id_producto); ?>">
			 		<label for="precio">Precio de Venta</label>
			 		<input type="text" id="precio" name="precio" readonly class="form-control" value="<?php obtenerTotalProducto($id_producto); ?>">
			 		<label for="direccion" class="col-6">Imagen Codigo <?php 
			 		$skuPedido = obtenerCodigoProducto($id_producto);
							foreach ($skuPedido as $codigoPedido) {
								if ($codigoPedido->variation_id == 0) {
									$codigoProducto = $codigoPedido->product_id;
								}else{
									$codigoProducto = $codigoPedido->variation_id;
								} 
							}
			 		$codigoImagen = obtenerCodigoImagen($codigoProducto);
			 		$imagenURL = obtenerUrlImagen($codigoImagen);
			 		echo $codigoImagen; ?></label>
			 		</div>
			 		<div class="col-6" align="center">
			 			<img width="400px" src="<?php echo $imagenURL ?>" alt="" class="img-thumbnail" style="border-color: #219D9F">
			 		</div>
			 	</div>
			 </div> 
			 <?php } if ($dato == "Taza") { ?>
			 	<div class="container">
				<h1>Detalle del Producto Taza</h1>
			</div>
			 <div class="container">
			 	<br>
			 	<div class="row align-items-center">
			 		<div class="form-group col-6">
			 		<label for="Nombre">Nombre</label>
			 		<input type="text" id="Nombre" name="Nombre" readonly class="form-control" value="<?php obtenerProductoNombre($id_producto); ?>">
			 		<label for="codCliente">Codigo de Orden</label>
			 		<input type="text" id="codCliente" name="codCliente" readonly class="form-control" value="<?php echo $id_producto; ?>">
			 		<label for="codCliente">Codigo de Producto</label>
			 		<input type="text" id="codCliente" name="codCliente" readonly class="form-control" value="<?php obtenerProducto($id_producto); ?>">
			 		<label for="codCliente">Codigo de Variacion</label>
			 		<input type="text" id="codCliente" name="codCliente" readonly class="form-control" value="<?php obtenerProductoVariacion($id_producto); ?>">
			 		<label for="codCliente">Codigo de Sku</label>
 					<input type="text" id="codCliente" name="codCliente" readonly class="form-control" value="<?php echo $idSku; ?>">
			 		<label for="modelo">Modelo</label>
			 		<input type="text" id="modelo" name="modelo" readonly class="form-control" value="<?php obtenerModelo($id_producto); ?>">
			 		<label for="color">Color</label>
			 		<input type="text" id="color" name="color" readonly class="form-control" value="<?php obtenerColor($id_producto); ?>">
			 		<label for="talla">Tecnica</label>
			 		<input type="text" id="talla" name="talla" readonly class="form-control" value="<?php obtenerTecnica($id_producto); ?>">
			 		<label for="precio">Precio de Venta</label>
			 		<input type="text" id="precio" name="precio" readonly class="form-control" value="<?php obtenerTotalProducto($id_producto); ?>">
			 		<label for="direccion" class="col-6">Imagen Codigo <?php 
			 		$skuPedido = obtenerCodigoProducto($id_producto);
							foreach ($skuPedido as $codigoPedido) {
								if ($codigoPedido->variation_id == 0) {
									$codigoProducto = $codigoPedido->product_id;
								}else{
									$codigoProducto = $codigoPedido->variation_id;
								} 
							}
			 		$codigoImagen = obtenerCodigoImagen($codigoProducto);
			 		$imagenURL = obtenerUrlImagen($codigoImagen);
			 		echo $codigoImagen; ?></label>
			 		</div>
			 		<div class="col-6" align="center">
			 			<img width="400px" src="<?php echo $imagenURL ?>" alt="" class="img-thumbnail" style="border-color: #219D9F">
			 		</div>
			 	</div>
			 </div>
	<?php } if ($dato == "M") { ?>
		<div class="container">
				<h1>Detalle del Producto MUG</h1>
			</div>
			 <div class="container">
			 	<br>
			 	<div class="row align-items-center">
			 		<div class="form-group col-6">
			 		<label for="Nombre">Nombre</label>
			 		<input type="text" id="Nombre" name="Nombre" readonly class="form-control" value="<?php obtenerProductoNombre($id_producto); ?>">
			 		<label for="codCliente">Codigo de Orden</label>
			 		<input type="text" id="codCliente" name="codCliente" readonly class="form-control" value="<?php echo $id_producto; ?>">
			 		<label for="codCliente">Codigo de Producto</label>
			 		<input type="text" id="codCliente" name="codCliente" readonly class="form-control" value="<?php obtenerProducto($id_producto); ?>">
			 		<label for="codCliente">Codigo de Variacion</label>
			 		<input type="text" id="codCliente" name="codCliente" readonly class="form-control" value="<?php obtenerProductoVariacion($id_producto); ?>">
			 		<label for="codCliente">Codigo de Sku</label>
 					<input type="text" id="codCliente" name="codCliente" readonly class="form-control" value="<?php echo $idSku; ?>">
			 		<label for="color">Color</label>
			 		<input type="text" id="color" name="color" readonly class="form-control" value="<?php obtenerColor($id_producto); ?>">
			 		<label for="precio">Precio de Venta</label>
			 		<input type="text" id="precio" name="precio" readonly class="form-control" value="<?php obtenerTotalProducto($id_producto); ?>">
			 		<label for="direccion" class="col-6">Imagen Codigo <?php 
			 		$skuPedido = obtenerCodigoProducto($id_producto);
							foreach ($skuPedido as $codigoPedido) {
								if ($codigoPedido->variation_id == 0) {
									$codigoProducto = $codigoPedido->product_id;
								}else{
									$codigoProducto = $codigoPedido->variation_id;
								} 
							}
			 		$codigoImagen = obtenerCodigoImagen($codigoProducto);
			 		$imagenURL = obtenerUrlImagen($codigoImagen);
			 		echo $codigoImagen; ?></label>
			 		</div>
			 		<div class="col-6" align="center">
			 			<img width="400px" src="<?php echo $imagenURL ?>" alt="" class="img-thumbnail" style="border-color: #219D9F">
			 		</div>
			 	</div>
			 </div>  
			 <?php } if ($dato == "PM") { ?>
			 	<div class="container">
				<h1>Detalle del Producto Maus Pad</h1>
			</div>
			 <div class="container">
			 	<br>
			 	<div class="row align-items-center">
			 		<div class="form-group col-6">
			 		<label for="Nombre">Nombre</label>
			 		<input type="text" id="Nombre" name="Nombre" readonly class="form-control" value="<?php obtenerProductoNombre($id_producto); ?>">
			 		<label for="codCliente">Codigo de Orden</label>
			 		<input type="text" id="codCliente" name="codCliente" readonly class="form-control" value="<?php echo $id_producto; ?>">
			 		<label for="codCliente">Codigo de Producto</label>
			 		<input type="text" id="codCliente" name="codCliente" readonly class="form-control" value="<?php obtenerProducto($id_producto); ?>">
			 		<label for="codCliente">Codigo de Variacion</label>
			 		<input type="text" id="codCliente" name="codCliente" readonly class="form-control" value="<?php obtenerProductoVariacion($id_producto); ?>">
			 		<label for="codCliente">Codigo de Sku</label>
 					<input type="text" id="codCliente" name="codCliente" readonly class="form-control" value="<?php echo $idSku; ?>">
			 		<label for="color">Color</label>
			 		<input type="text" id="color" name="color" readonly class="form-control" value="<?php obtenerColor($id_producto); ?>">
			 		<label for="precio">Precio de Venta</label>
			 		<input type="text" id="precio" name="precio" readonly class="form-control" value="<?php obtenerTotalProducto($id_producto); ?>">
			 		<label for="direccion" class="col-6">Imagen Codigo <?php 
			 		$skuPedido = obtenerCodigoProducto($id_producto);
							foreach ($skuPedido as $codigoPedido) {
								if ($codigoPedido->variation_id == 0) {
									$codigoProducto = $codigoPedido->product_id;
								}else{
									$codigoProducto = $codigoPedido->variation_id;
								} 
							}
			 		$codigoImagen = obtenerCodigoImagen($codigoProducto);
			 		$imagenURL = obtenerUrlImagen($codigoImagen);
			 		echo $codigoImagen; ?></label>
			 		</div>
			 		<div class="col-6" align="center">
			 			<img width="400px" src="<?php echo $imagenURL ?>" alt="" class="img-thumbnail" style="border-color: #219D9F">
			 		</div>
			 	</div>
			 </div>
			 <?php 
			 } if ($dato == "L") { ?>
			 	<div class="container">
				<h1>Detalle del Producto Libreta</h1>
			</div>
			 <div class="container">
			 	<br>
			 	<div class="row align-items-center">
			 		<div class="form-group col-6">
			 		<label for="Nombre">Nombre</label>
			 		<input type="text" id="Nombre" name="Nombre" readonly class="form-control" value="<?php obtenerProductoNombre($id_producto); ?>">
			 		<label for="codCliente">Codigo de Orden</label>
			 		<input type="text" id="codCliente" name="codCliente" readonly class="form-control" value="<?php echo $id_producto; ?>">
			 		<label for="codCliente">Codigo de Producto</label>
			 		<input type="text" id="codCliente" name="codCliente" readonly class="form-control" value="<?php obtenerProducto($id_producto); ?>">
			 		<label for="codCliente">Codigo de Variacion</label>
			 		<input type="text" id="codCliente" name="codCliente" readonly class="form-control" value="<?php obtenerProductoVariacion($id_producto); ?>">
			 		<label for="codCliente">Codigo de Sku</label>
 					<input type="text" id="codCliente" name="codCliente" readonly class="form-control" value="<?php echo $idSku; ?>">
			 		<label for="hoja">Hoja</label>
			 		<input type="text" id="hoja" name="hoja" readonly class="form-control" value="<?php obtenerHoja($id_producto); ?>">
			 		<label for="color">Color</label>
			 		<input type="text" id="color" name="color" readonly class="form-control" value="<?php obtenerColor($id_producto); ?>">
			 		<label for="precio">Precio de Venta</label>
			 		<input type="text" id="precio" name="precio" readonly class="form-control" value="<?php obtenerTotalProducto($id_producto); ?>">
			 		<label for="direccion" class="col-6">Imagen Codigo <?php 
			 		$skuPedido = obtenerCodigoProducto($id_producto);
							foreach ($skuPedido as $codigoPedido) {
								if ($codigoPedido->variation_id == 0) {
									$codigoProducto = $codigoPedido->product_id;
								}else{
									$codigoProducto = $codigoPedido->variation_id;
								} 
							}
			 		$codigoImagen = obtenerCodigoImagen($codigoProducto);
			 		$imagenURL = obtenerUrlImagen($codigoImagen);
			 		echo $codigoImagen; ?></label>
			 		</div>
			 		<div class="col-6" align="center">
			 			<img width="400px" src="<?php echo $imagenURL ?>" alt="" class="img-thumbnail" style="border-color: #219D9F">
			 		</div>
			 	</div> 
			 </div> 
			 <?php
			 } if ($dato == "B") { ?>
			 	<div class="container">
				<h1>Detalle del Producto Bolsa</h1>
			</div>
			 <div class="container">
			 	<br>
			 	<div class="row align-items-center">
			 		<div class="form-group col-6">
			 		<label for="Nombre">Nombre</label>
			 		<input type="text" id="Nombre" name="Nombre" readonly class="form-control" value="<?php obtenerProductoNombre($id_producto); ?>">
			 		<label for="codCliente">Codigo de Orden</label>
			 		<input type="text" id="codCliente" name="codCliente" readonly class="form-control" value="<?php echo $id_producto; ?>">
			 		<label for="codCliente">Codigo de Producto</label>
			 		<input type="text" id="codCliente" name="codCliente" readonly class="form-control" value="<?php obtenerProducto($id_producto); ?>">
			 		<label for="codCliente">Codigo de Variacion</label>
			 		<input type="text" id="codCliente" name="codCliente" readonly class="form-control" value="<?php obtenerProductoVariacion($id_producto); ?>">
			 		<label for="codCliente">Codigo de Sku</label>
 					<input type="text" id="codCliente" name="codCliente" readonly class="form-control" value="<?php echo $idSku; ?>">
			 		<label for="color">Color</label>
			 		<input type="text" id="color" name="color" readonly class="form-control" value="<?php obtenerColor($id_producto); ?>">
			 		<label for="precio">Precio de Venta</label>
			 		<input type="text" id="precio" name="precio" readonly class="form-control" value="<?php obtenerTotalProducto($id_producto); ?>">
			 		<label for="direccion" class="col-6">Imagen Codigo <?php 
			 		$skuPedido = obtenerCodigoProducto($id_producto);
							foreach ($skuPedido as $codigoPedido) {
								if ($codigoPedido->variation_id == 0) {
									$codigoProducto = $codigoPedido->product_id;
								}else{
									$codigoProducto = $codigoPedido->variation_id;
								} 
							}
			 		$codigoImagen = obtenerCodigoImagen($codigoProducto);
			 		$imagenURL = obtenerUrlImagen($codigoImagen);
			 		echo $codigoImagen; ?></label>
			 		</div>
			 		<div class="col-6" align="center">
			 			<img width="400px" src="<?php echo $imagenURL ?>" alt="" class="img-thumbnail" style="border-color: #219D9F">
			 		</div>
			 	</div>
			 </div> 
			 <?php
			 } if ($dato == "GAD") { ?>
			 	<div class="container">
				<h1>Detalle del Producto Gadget</h1>
			</div>
			 <div class="container">
			 	<br>
			 	<div class="row align-items-center">
			 		<div class="form-group col-6">
			 		<label for="Nombre">Nombre</label>
			 		<input type="text" id="Nombre" name="Nombre" readonly class="form-control" value="<?php obtenerProductoNombre($id_producto); ?>">
			 		<label for="codCliente">Codigo de Orden</label>
			 		<input type="text" id="codCliente" name="codCliente" readonly class="form-control" value="<?php echo $id_producto; ?>">
			 		<label for="codCliente">Codigo de Producto</label>
			 		<input type="text" id="codCliente" name="codCliente" readonly class="form-control" value="<?php obtenerProducto($id_producto); ?>">
			 		<label for="codCliente">Codigo de Variacion</label>
			 		<input type="text" id="codCliente" name="codCliente" readonly class="form-control" value="<?php obtenerProductoVariacion($id_producto); ?>">>
			 		<label for="codCliente">Codigo de Sku</label>
 					<input type="text" id="codCliente" name="codCliente" readonly class="form-control" value="<?php echo $idSku; ?>">
			 		<label for="precio">Precio de Venta</label>
			 		<input type="text" id="precio" name="precio" readonly class="form-control" value="<?php obtenerTotalProducto($id_producto); ?>">
			 		<label for="direccion" class="col-6">Imagen Codigo <?php 
			 		$skuPedido = obtenerCodigoProducto($id_producto);
							foreach ($skuPedido as $codigoPedido) {
								if ($codigoPedido->variation_id == 0) {
									$codigoProducto = $codigoPedido->product_id;
								}else{
									$codigoProducto = $codigoPedido->variation_id;
								} 
							}
			 		$codigoImagen = obtenerCodigoImagen($codigoProducto);
			 		$imagenURL = obtenerUrlImagen($codigoImagen);
			 		echo $codigoImagen; ?></label>
			 		</div>
			 		<div class="col-6" align="center">
			 			<img width="400px" src="<?php echo $imagenURL ?>" alt="" class="img-thumbnail" style="border-color: #219D9F">
			 		</div>
			 	</div>
			 </div> 
			 <?php
			 }
			} 
		
		}
	} ?>
	
</div>
<?php } else {
	if ($nombreStatus == "Cancelado" || $nombreStatus == "Completado") { ?>
		<div class="row">
			<div class="col">
				<h1>Usted no esta atendiendo un pedido</h1>
			</div>
		</div>
		<?php
	}
} ?>
</div>
<?php include_once "../VistaAdmin/pie.php"; ?>