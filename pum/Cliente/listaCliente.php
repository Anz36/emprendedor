<?php include_once "../VistaAdmin/main.php";
	  include_once "../Sessiones/funcionSession.php";
	  include_once "../FuncionesExtra/funciones.php";
if (empty($_SESSION["codUsuario"])) {
    # Lo redireccionamos al formulario de inicio de sesión
    header("Location: ../Login/formulario_login.php?mensaje=Necesita iniciar session para ingresar a la pagina protegida");
    # Y salimos del script
    exit();
}
 $listaCliente = obtenerClientes();
?>
<div class="row">
 	<div class="col-auto">
 		<h3>Clientes</h3>
 	</div>
 </div>
 <div class="row">
			<div class="col">
				<nav class="navbar navbar-expand-lg navbar-light bg-light" style="border-color: #219D9F">
					  <a class="navbar-brand" href="listaCliente.php">Busqueda Por <span> &nbsp&nbsp;|</span></a>
					  <div class="collapse navbar-collapse" id="navbarColor03">
					    <ul class="navbar-nav mr-auto">
					      <li class="nav-item">
					        <a class="nav-link" href="<?php echo "../Cliente/listaCliente.php?estado=Cliente Habitual";?>">Cliente Habitual</a>
					      </li>
					      <li class="nav-item">
					        <a class="nav-link" href="<?php echo "../Cliente/listaCliente.php?estado=Cliente Emprendedor";?>">Cliente Emprendedor</a>
					      </li>
					      <li class="nav-item">
					        <a class="nav-link" href="<?php echo "../Cliente/listaCliente.php?estado=Cliente Nuevo";?>">Cliente Nuevo</a>
					      </li>
					  </ul>
					</div>
				</nav>
			</div>
	</div>
	<?php if (isset($_GET["estado"])) { ?>
	<br>
	<?php if ($_GET["estado"] == "Cliente Habitual") { ?>
	<div class="row">
		<div class="col">
			<div class="table table-hover">
				<table class="table table-striped table-responsive-xl">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nombres</th>
							<th>Email</th>
							<th>Recaudado</th>
							<th>Estado</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($listaCliente as $datos){
							$estado = obtenerIdCliente($datos->customer_id);
							$listaDetalle = obtenerIDProducto($datos->customer_id);
							foreach ($estado as $Clientes) {
								if ($Clientes->Contador >= "5"){
									$pum = obtenerClientePorEstado($Clientes->customer_id);
									foreach ($pum as $pumes) {
								 ?>
						<tr>
							<td><?php echo $pumes->customer_id ?></td>
							<td><?php echo $pumes->first_name ?></td>
							<td><?php echo $pumes->email ?></td>
							<td><?php echo "S/. ".sumaTotal($pumes->customer_id) ?></td>
							<td><?php echo obtenerEstadoCliente($pumes->customer_id); ?></td>
							<td>
									<button type="button" style="background-color: #219D9F; color: #fff" class="btn btn" data-toggle="modal" data-target="#myModal_<?php echo $pumes->customer_id; ?>">
									    Detalles
									  </button>

									  <!-- The Modal -->
									  <div class="modal fade" id="myModal_<?php echo $pumes->customer_id; ?>">
									    <div class="modal-dialog modal-lg">
									      <div class="modal-content">
									      
									        <!-- Modal Header -->
									        <div class="modal-header">
									          <h4 class="modal-title">Productos Comprados</h4>
									          <button type="button" class="close" data-dismiss="modal">&times;</button>
									        </div>
									        
									        <!-- Modal body -->
									        <div class="modal-body">
									        	<div class="container">
									        		<div class="row">
											          	<div class="col">
											          		Articulos o Productos	
											          	</div>
											         </div>
											         <div class="row">
											         	<div class="col">
											         		<div class="table table-hover">
											         			<table class="table-striped table-responsive-xl">
											         				<thead>
											         					<tr>
											         						<th>Producto</th>
											         						<th>Sku</th>
											         						<th>Modelo</th>
											         						<th>Cantidad</th>
											         						<th>Precio</th>
											         						<th>Total</th>
											         					</tr>
											         				</thead>
											         				<tbody>
											         					<?php 
											         					foreach ($listaDetalle as $listas) {
																			$idDetalle = $listas->order_id;
											         						$nombrePedido = obtenerNombreDelProducto($idDetalle);
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
																								foreach ($codigoProductoSKU as $codigoProductoSku) {
											         					 ?>
											         					<tr>
											         						<td><?php echo $producto->order_item_name; ?></td>
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
											         					<?php 		}
											         				}
											         			}
															 ?>
											         				</tbody>
											         			</table>
											         		</div>
											         	</div>
											         </div>
									        	</div>
									        </div>
									        
									        <!-- Modal footer -->
									        <div class="modal-footer">
									          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
									        </div>
									        
									      </div>
									    </div>
									  </div>

								</td>
						</tr>
					<?php 		}
							}
						}
					} ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<?php } ?>
	<?php if ($_GET["estado"] == "Cliente Emprendedor") { ?>
	<div class="row">
		<div class="col">
			<div class="table table-hover">
				<table class="table table-striped table-responsive-xl">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nombres</th>
							<th>Email</th>
							<th>Recaudado</th>
							<th>Estado</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($listaCliente as $datos){
							$estado = obtenerIdCliente($datos->customer_id);
							$listaDetalle = obtenerIDProducto($datos->customer_id);
							foreach ($estado as $Clientes) {
								if ($Clientes->Contador == "3" ||  $Clientes->Contador == "4"){
									$pum = obtenerClientePorEstado($Clientes->customer_id);
									foreach ($pum as $pumes) {
								 ?>
						<tr>
							<td><?php echo $pumes->customer_id ?></td>
							<td><?php echo $pumes->first_name ?></td>
							<td><?php echo $pumes->email ?></td>
							<td><?php echo "S/. ".sumaTotal($pumes->customer_id) ?></td>
							<td><?php echo obtenerEstadoCliente($pumes->customer_id); ?></td>
							<td>
									<button type="button" style="background-color: #219D9F; color: #fff" class="btn btn" data-toggle="modal" data-target="#myModal_<?php echo $pumes->customer_id; ?>">
									    Detalles
									  </button>

									  <!-- The Modal -->
									  <div class="modal fade" id="myModal_<?php echo $pumes->customer_id; ?>">
									    <div class="modal-dialog modal-lg">
									      <div class="modal-content">
									      
									        <!-- Modal Header -->
									        <div class="modal-header">
									          <h4 class="modal-title">Productos Comprados</h4>
									          <button type="button" class="close" data-dismiss="modal">&times;</button>
									        </div>
									        
									        <!-- Modal body -->
									        <div class="modal-body">
									        	<div class="container">
									        		<div class="row">
											          	<div class="col">
											          		Articulos o Productos	
											          	</div>
											         </div>
											         <div class="row">
											         	<div class="col">
											         		<div class="table table-hover">
											         			<table class="table-striped table-responsive-xl">
											         				<thead>
											         					<tr>
											         						<th>Producto</th>
											         						<th>Sku</th>
											         						<th>Modelo</th>
											         						<th>Cantidad</th>
											         						<th>Precio</th>
											         						<th>Total</th>
											         					</tr>
											         				</thead>
											         				<tbody>
											         					<?php 
											         					foreach ($listaDetalle as $listas) {
																			$idDetalle = $listas->order_id;
											         						$nombrePedido = obtenerNombreDelProducto($idDetalle);
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
																								foreach ($codigoProductoSKU as $codigoProductoSku) {
											         					 ?>
											         					<tr>
											         						<td><?php echo $producto->order_item_name; ?></td>
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
											         					<?php 		}
											         				}
											         			}
															 ?>
											         				</tbody>
											         			</table>
											         		</div>
											         	</div>
											         </div>
									        	</div>
									        </div>
									        
									        <!-- Modal footer -->
									        <div class="modal-footer">
									          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
									        </div>
									        
									      </div>
									    </div>
									  </div>

								</td>
						</tr>
					<?php 		}
							}
						}
					} ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<?php } ?>
	<?php if ($_GET["estado"] == "Cliente Nuevo") { ?>
	<div class="row">
		<div class="col">
			<div class="table table-hover">
				<table class="table table-striped table-responsive-xl">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nombres</th>
							<th>Email</th>
							<th>Recaudado</th>
							<th>Estado</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($listaCliente as $datos){
							$estado = obtenerIdCliente($datos->customer_id);
							$listaDetalle = obtenerIDProducto($datos->customer_id);
							foreach ($estado as $Clientes) {
								if ($Clientes->Contador <= "2"){
									$pum = obtenerClientePorEstado($Clientes->customer_id);
									foreach ($pum as $pumes) {
								 ?>
						<tr>
							<td><?php echo $pumes->customer_id ?></td>
							<td><?php echo $pumes->first_name ?></td>
							<td><?php echo $pumes->email ?></td>
							<td><?php echo "S/. ".sumaTotal($pumes->customer_id) ?></td>
							<td><?php echo obtenerEstadoCliente($pumes->customer_id); ?></td>
							<td>
									<button type="button" style="background-color: #219D9F; color: #fff" class="btn btn" data-toggle="modal" data-target="#myModal_<?php echo $pumes->customer_id; ?>">
									    Detalles
									  </button>

									  <!-- The Modal -->
									  <div class="modal fade" id="myModal_<?php echo $pumes->customer_id; ?>">
									    <div class="modal-dialog modal-lg">
									      <div class="modal-content">
									      
									        <!-- Modal Header -->
									        <div class="modal-header">
									          <h4 class="modal-title">Productos Comprados</h4>
									          <button type="button" class="close" data-dismiss="modal">&times;</button>
									        </div>
									        
									        <!-- Modal body -->
									        <div class="modal-body">
									        	<div class="container">
									        		<div class="row">
											          	<div class="col">
											          		Articulos o Productos	
											          	</div>
											         </div>
											         <div class="row">
											         	<div class="col">
											         		<div class="table table-hover">
											         			<table class="table-striped table-responsive-xl">
											         				<thead>
											         					<tr>
											         						<th>Producto</th>
											         						<th>Sku</th>
											         						<th>Modelo</th>
											         						<th>Cantidad</th>
											         						<th>Precio</th>
											         						<th>Total</th>
											         					</tr>
											         				</thead>
											         				<tbody>
											         					<?php 
											         					foreach ($listaDetalle as $listas) {
																			$idDetalle = $listas->order_id;
											         						$nombrePedido = obtenerNombreDelProducto($idDetalle);
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
																								foreach ($codigoProductoSKU as $codigoProductoSku) {
											         					 ?>
											         					<tr>
											         						<td><?php echo $producto->order_item_name; ?></td>
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
											         					<?php 		}
											         				}
											         			}
															 ?>
											         				</tbody>
											         			</table>
											         		</div>
											         	</div>
											         </div>
									        	</div>
									        </div>
									        
									        <!-- Modal footer -->
									        <div class="modal-footer">
									          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
									        </div>
									        
									      </div>
									    </div>
									  </div>

								</td>
						</tr>
					<?php 		}
							}
						}
					} ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<?php } ?>

	<?php } else { ?>
	<br>
	<div class="row">
		<div class="col">
			<div class="table table-hover">
				<table class="table table-striped table-responsive-xl">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nombres</th>
							<th>Email</th>
							<th>Recaudado</th>
							<th>Estado</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($listaCliente as $lista) {
							$listaDetalle = obtenerIDProducto($lista->customer_id);
						 ?>
						<tr>
								<td><?php echo $lista->customer_id ?></td>	
								<td><?php echo $lista->first_name." ".$lista->last_name ?></td>
								<td><?php echo $lista->email ?></td>
								<td><?php echo "S/. ".sumaTotal($lista->customer_id) ?></td>
								<td><?php echo obtenerEstadoCliente($lista->customer_id); ?></td>
								<td>
									<button type="button" style="background-color: #219D9F; color: #fff" class="btn btn" data-toggle="modal" data-target="#myModal_<?php echo $lista->customer_id; ?>">
									    Detalles
									  </button>

									  <!-- The Modal -->
									  <div class="modal fade" id="myModal_<?php echo $lista->customer_id; ?>">
									    <div class="modal-dialog modal-lg">
									      <div class="modal-content">
									      
									        <!-- Modal Header -->
									        <div class="modal-header">
									          <h4 class="modal-title">Productos Comprados</h4>
									          <button type="button" class="close" data-dismiss="modal">&times;</button>
									        </div>
									        
									        <!-- Modal body -->
									        <div class="modal-body">
									        	<div class="container">
									        		<div class="row">
											          	<div class="col">
											          		Articulos o Productos	
											          	</div>
											         </div>
											         <div class="row">
											         	<div class="col">
											         		<div class="table table-hover">
											         			<table class="table-striped table-responsive-xl">
											         				<thead>
											         					<tr>
											         						<th>Producto</th>
											         						<th>Sku</th>
											         						<th>Modelo</th>
											         						<th>Cantidad</th>
											         						<th>Precio</th>
											         						<th>Total</th>
											         					</tr>
											         				</thead>
											         				<tbody>
											         					<?php 
											         					foreach ($listaDetalle as $listas) {
																			$idDetalle = $listas->order_id;
											         						$nombrePedido = obtenerNombreDelProducto($idDetalle);
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
																								foreach ($codigoProductoSKU as $codigoProductoSku) {
											         					 ?>
											         					<tr>
											         						<td><?php echo $producto->order_item_name; ?></td>
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
											         					<?php 		}
											         				}
											         			}
															 ?>
											         				</tbody>
											         			</table>
											         		</div>
											         	</div>
											         </div>
									        	</div>
									        </div>
									        
									        <!-- Modal footer -->
									        <div class="modal-footer">
									          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
									        </div>
									        
									      </div>
									    </div>
									  </div>

								</td>
						</tr>
						<?php }
						 ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php } ?>