<?php include_once "../VistaAdmin/main.php";
	  include_once "../Sessiones/funcionSession.php";
	  include_once "../FuncionesExtra/funciones.php";
	  include_once "../VistaAdmin/funciones.php";
	  include_once "../ConexionDb/funcionConexionSecundaria.php";
if (empty($_SESSION["codUsuario"])) {
    # Lo redireccionamos al formulario de inicio de sesión
    header("Location: ../Login/formulario_login.php?mensaje=Necesita iniciar session para ingresar a la pagina protegida");
    # Y salimos del script
    exit();
}
$consulta = "SELECT * FROM wp_wc_order_stats ORDER BY date_created DESC, atencion ASC";

  $fechaInicio = null;
  $fechaFinal = null;
  if (isset($_GET["fechaInicio"]) && isset($_GET["fechaFinal"])) {
    $fechaInicio = $_GET["fechaInicio"];
    $fechaFinal = $_GET["fechaFinal"];
    $consulta = "SELECT * FROM wp_wc_order_stats WHERE date_created BETWEEN ? AND ? ORDER BY date_created DESC, atencion ASC";
  }
  $db = obtenerBaseDeDatosSecundaria();
  $sentencia = $db->prepare($consulta,[PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,]);
  if ($fechaInicio === null && $fechaFinal === null) {
    $sentencia->execute();
  } else{
    $parametro = "$fechaInicio";
    $parametros = "$fechaFinal";
    $sentencia->execute([$parametro,$parametros]);
  }

?>
<div class="row">
	<div class="col">
		<h3>Busqueda</h3>
	</div>
</div>
<div class="row justify-content-center">
	<div class="col-5">
		<form action="../Usuario/busqueda.php" method="get">
		<label for="fechaInicio">Fecha Inicial</label>
		<input type="date" name="fechaInicio" class="form-control">
	</div>
	<div class="col-5">
		<label for="fechaInicio">Fecha Final</label>
		<input type="date" name="fechaFinal" class="form-control">
	</div>
	<div class="col-2">
		<button type="submit" style="background-color: #219D9F; color: #fff" class="btn btn" >Buscar
		</button>
		</form>
	</div>
</div>
<?php while ($detalles = $sentencia->fetchObject()) {
	$idDetalle = $detalles->order_id;
 ?>
<div class="row">
	<div class="col">
		<div class="accordion-main">
			    <div class="list-accordion">
			        <div class="item">
			            <button class="btn-item">
			            	<span>
			            		Detalle # <?php echo $idDetalle; ?>
			            	</span>&nbsp;
			            	<span class="badge rounded-pill bg-light text-dark" style="font-weight: bold;"> <?php echo atencionUsuario($idDetalle);  ?></span>&nbsp;
			            	<span class="badge rounded-pill bg-light text-dark" style="font-weight: bold;"> <?php echo disponibleUsuario($idDetalle); ?></span>
			            </button>
			    <div class="accordion-content">
			    	<div class="container">
			    		<div class="row">
			    			<div class="col-10">
			    				<h4>Detalle Pedido # <?php echo $idDetalle; ?></h4>
						 	<br>
			    			</div>
			    		<!-- Inicio del Modal -->
			    			<div class="col-2">
			    				
			    				<button type="submit" style="background-color: #219D9F; color: #fff" class="btn btn" data-toggle="modal" data-target="#myModal_<?php echo $idDetalle; ?>">
								    Atender Pedido
								</button>
								<!-- The Modal -->
							  <div class="modal" id="myModal_<?php echo $idDetalle; ?>">
							    <div class="modal-dialog">
							      <div class="modal-content">
							        <!-- Modal Header -->
							        <div class="modal-header">
							          <h4 class="modal-title">Atender Pedido</h4>
							          <button type="button" class="close" data-dismiss="modal">&times;</button>
							        </div>
							        
							        <!-- Modal body -->
							        <div class="modal-body">
							        	<div class="container">
							        		<div class="row">
							        			<div class="col">
							        				<h5> Pedido # <?php echo $idDetalle; ?></h5>
							        			</div>
							        			<div class="col">
							        				<h6 class="text-muted"> Usuario : <?php echo $datoPersona->nombre; ?></h6>
							        			</div>		
							        		</div>
							        		<div class="row">
							        			<div class="col-2">
							        				<label for="atender">Atender: </label>
							        			</div>
							        			<div class="col-5">
							        				<form method="POST" action="actualizarAtencion.php">
							        				
							        				<select name="atender" class="form-control">
							        					<option value="1">Pendiente</option>
							        					<option value="2">Procesando</option>
							        					<option value="3">En Espera</option>
							        					<option value="4">Cancelado</option>
							        					<option value="5">Reembolsado</option>
							        					<option value="6">Completado</option>
							        				</select>
							        				<input type="hidden" name="id" value="<?php echo $idDetalle; ?>">
							        				<input type="hidden" name="idPersona" value="<?php echo $datoPersona->id; ?>">
							        			</div>
							        		</div>
							        	</div>
							        </div>
							        
							        <!-- Modal footer -->
							        <div class="modal-footer">
							        	<button type="submit" class="btn btn" style="background-color: #219D9F; color: #fff" name="modificar_<?php echo $idDetalle; ?>">Modificar</button>
							        	</form>
							          	<button type="button" class="btn btn" style="background-color: #219D9F; color: #fff" data-dismiss="modal">Cerrar</button>
							        </div>
							      </div>
							    </div>
							  </div>
			    			</div>
			    		<!-- Fin del Modal -->
			    		</div>
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
					 <div class="container">
					 	<div class="row">
					 		<div class="col">
					 			<h5>Articulo o Producto</h5>
					 		</div>
					 		<div class="col" align="end">
					 			<a class="btn btn-outline-warning btn-sm" target="_Blank" href="<?php echo "../Pdf/detalle-pdf.php?id=".$idDetalle;?>">Ver <i class="icon ion-md-document"></i></a>
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
					 				<td><a href="<?php echo "../Producto/detalle-producto.php?id=". $producto->order_item_id."&skuModelo=".$codigoProductoSku->sku;?>"> 
					 					<?php echo $producto->order_item_name; ?></td>
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
					 				$granTotal = 0;
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
			    </div>
			</div>
		</div>
		
	</div>
	<?php  } ?>
	</div>
</div>
<?php include_once "../VistaAdmin/pie.php" ?>