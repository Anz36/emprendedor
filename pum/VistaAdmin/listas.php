<?php include_once "../VistaAdmin/main.php";
	  include_once "../Sessiones/funcionSession.php";
	  include_once "../FuncionesExtra/funciones.php";
	  include_once "../VistaAdmin/funciones.php";
if (empty($_SESSION["codUsuario"])) {
    # Lo redireccionamos al formulario de inicio de sesión
    header("Location: ../Login/formulario_login.php?mensaje=Necesita iniciar session para ingresar a la pagina protegida");
    # Y salimos del script
    exit();
}
 $listarEmprendedor = obtenerListas();
?>
<div class="row">
 	<div class="col-auto">
 		<h3>Vista Emprendedor</h3>
 	</div>
 </div>
 <div class="row">
			<div class="col">
				<nav class="navbar navbar-expand-lg navbar-light bg-light" style="border-color: #219D9F">
  <a class="navbar-brand" href="listas.php">Busqueda Por <span> &nbsp&nbsp;|</span></a>
  <div class="collapse navbar-collapse" id="navbarColor03">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="<?php echo "../VistaAdmin/listas.php?estado=wc-pending";?>">Pendiente Pago</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo "../VistaAdmin/listas.php?estado=wc-processing";?>">Procesando</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo "../VistaAdmin/listas.php?estado=wc-on-hold";?>">En Espera</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo "../VistaAdmin/listas.php?estado=wc-completed";?>">Completado</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo "../VistaAdmin/listas.php?estado=wc-cancelled";?>">Cancelado</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo "../VistaAdmin/listas.php?estado=wc-refunded";?>">Reembolsado</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo "../VistaAdmin/listas.php?estado=wc-failed";?>">Fallido</a>
      </li>
    </ul>
  </div>
</nav>
			</div>
		</div>
 <div class="container-fluid">
 <?php 
		
		if (!isset($_GET["estado"])){
		$paginasPropuestas = 5;
		$pagina = 1;
	  	if (isset($_GET["pagina"])) {
    	$pagina= $_GET["pagina"];
  		}
		$limit = $paginasPropuestas;
		$offSet = ($pagina - 1) * $paginasPropuestas;
		$db = obtenerBaseDeDatosSecundaria();
		$sentencia = $db->query("SELECT count(*) AS conteo FROM wp_wc_order_stats WHERE status != 'wc-completed' AND status != 'wc-failed' AND status != 'wc-cancelled' ");
		$conteo = $sentencia->fetchObject()->conteo;
  		$paginas = ceil($conteo / $paginasPropuestas);

		$sentencia = $db->prepare("SELECT * FROM wp_wc_order_stats WHERE status != 'wc-completed' AND status != 'wc-failed' AND status != 'wc-cancelled' ORDER BY atencion ASC, date_created DESC LIMIT ? OFFSET ?");
		$sentencia->execute([$limit,$offSet]);
  		$sentencia->execute();
 		$paginaLimit = $sentencia->fetchAll();
		//$listar = obtenerListas();
		foreach ($paginaLimit as $listaDetalles) {
            $listasDetalles = $sentencia->fetchObject();
            $idDetalle = $listaDetalles->order_id;
            $granTotal = 0;
			?>
			<div class="accordion-main">
			    <div class="list-accordion">
			        <div class="item">
			            <button class="btn-item">
			            	<span>
			            		Detalle # <?php echo $idDetalle; ?>
			            	</span>&nbsp;
			            	<span class="badge rounded-pill bg-light text-dark" style="font-weight: bold;"> <?php echo atencionUsuario($idDetalle);  ?></span>&nbsp;
			            	<span class="badge rounded-pill bg-light text-dark" style="font-weight: bold;"> <?php echo disponibleUsuario($idDetalle) ?></span>
			            </button>
			    <div class="accordion-content">
			    	<div class="container">
			    	<div class="row">
			    		<div class="col-10">
							<br>
						 	<h4>Detalle Pedido # <?php echo $idDetalle; ?></h4>
						 	<br>
			    		</div>
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

					 <br>
					 
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
			<!--<br> -->
		<?php } ?>
		<nav>
      <div class="row">
        <div class="col-xs-12 col-sm-6">
          <p>Mostrando <?php echo $paginasPropuestas; ?> de <?php echo $conteo; ?> afiches disponibles</p>
        </div>
        <div class="col-xs-12 col-sm-6">
          <p>Página <?php echo $pagina; ?> de <?php echo $paginas; ?></p>
        </div>
      </div>
      <ul class="pagination justify-content-center">
        <?php if ($pagina > 1) { ?>
        <li class="page-item disabled">
          <a class="page-link" href="./listas.php?pagina=<?php echo $pagina - 1 ?>">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
      <?php } ?>
      <?php for ($x=1; $x <= $paginas ; $x++) { ?>
        <li class="page-item" class="<?php if($x == $pagina) echo "active" ?>">
          <a class="page-link" href="./listas.php?pagina=<?php echo $x ?>">
            <?php echo $x; ?>
          </a>
        </li>
      <?php } ?>
      <?php if ($pagina < $paginas) { ?>
        <li class="page-item">
          <a class="page-link" href="./listas.php?pagina=<?php echo $pagina + 1 ?> ">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      <?php } ?>
      </ul>
    </nav>
		<?php } else {
			$estado = $_GET["estado"];
			$listar = obtenerListasMedianteEstado($estado); ?>
	<div class="alert alert-dismissible alert" style="background-color: #219D9F;">
		<a href="../VistaAdmin/listas.php" style="text-decoration-color: #fff;color: #fff">Volver Principal</a>
	</div>
	<?php
		foreach ($listar as $listaPorEstados) { 
			$idDetalleEstado = $listaPorEstados->order_id;
			?>
			<div class="accordion-main">
			    <div class="list-accordion">
			        <div class="item">
			            <p class="btn-item">
			                <span>
			                    Detalle # <?php echo $idDetalleEstado;?> | Estado : <?php determinarEstado($listaPorEstados->status); ?>
			                </span>
			                <span class="badge rounded-pill bg-light text-dark" style="font-weight: bold;"> <?php echo atencionUsuario($idDetalleEstado);  ?></span>&nbsp;
			            	<span class="badge rounded-pill bg-light text-dark" style="font-weight: bold;"> <?php echo disponibleUsuario($idDetalleEstado) ?></span>
			            </p>
			    <div class="accordion-content">
			    	<div class="row">
			    		<div class="container">
			    			<div class="col-10">
			    				<h4>Detalle Pedido # <?php echo $idDetalleEstado; ?></h4>
			    			</div>
			    			<div class="col-2">
			    				<button type="submit" style="background-color: #219D9F; color: #fff" class="btn btn" data-toggle="modal" data-target="#myModal_<?php echo $idDetalleEstado; ?>">
								    Atender Pedido
								  </button>

								  <!-- The Modal -->
								  <div class="modal" id="myModal_<?php echo $idDetalleEstado; ?>">
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
							        				<h5> Pedido # <?php echo $idDetalleEstado; ?></h5>
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
							        				<input type="hidden" name="id" value="<?php echo $idDetalleEstado; ?>">
							        				<input type="hidden" name="idPersona" value="<?php echo $datoPersona->id; ?>">
							        			</div>
							        		</div>
							        	</div>
								        </div>
								        
								        <!-- Modal footer -->
								        <div class="modal-footer">
								        	<button type="submit" class="btn btn" style="background-color: #219D9F; color: #fff" name="modificar_<?php echo $idDetalleEstado; ?>">Modificar</button>
							        	</form>
								          <button type="button" class="btn btn" style="background-color: #219D9F; color: #fff" data-dismiss="modal">Cerrar</button>
								        </div>
								        
								      </div>
								    </div>
								  </div>
			    			</div>
					 	<br>
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
					 		<input type="text" id="Nombre" name="Nombre" readonly class="form-control" value="<?php obtenerNombreDelCliente($idDetalleEstado); echo " "; obtenerApellidoDelCliente($idDetalleEstado); ?>">
					 		<label for="codCliente">Cod-Cliente</label>
					 		<input type="text" id="codCliente" name="codCliente" readonly class="form-control" value="<?php obtenerCodigoCliente($idDetalleEstado); ?>">
					 		<label for="telefono">Teléfono</label>
					 		<input type="text" id="telefono" name="telefono" readonly class="form-control" value="<?php obtenerTelefonoCliente($idDetalleEstado); ?>">
					 		<label for="direccion">Dirección</label>
					 		<input type="text" id="direccion" name="direccion" readonly class="form-control" value="<?php obtenerDireccionCliente($idDetalleEstado); ?>">
					 	</div>
					 		</div>
					 		<div class="col">
					 			<div class="form-group col">
					 		<label for="Nombre">Fecha</label>
					 		<input type="text" id="Nombre" name="Nombre" readonly class="form-control" value="<?php obtenerFechaPedido($idDetalleEstado); ?>">
					 		<label for="codCliente">Estado</label>
					 		<input type="text" id="codCliente" name="codCliente" readonly class="form-control" value="<?php 
					 		if(obtenerEstadoPedido($idDetalleEstado) == "No existe Estado Pago"){
					 			obtenerEstadoPedido($idDetalleEstado);
					 		}else {
					 			$estadoPedido = obtenerEstadoPedido($idDetalleEstado);
					 			determinarEstado($estadoPedido);
					 		} ?>">
					 		<label for="telefono">Metodo de Pago</label>
					 		<input type="text" id="telefono" name="telefono" readonly class="form-control" value="<?php obtenerMetodoDePago($idDetalleEstado); ?>">
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
					 			<a class="btn btn-outline-warning btn-sm" target="_Blank" href="<?php echo "detallePdf.php?id=".$idDetalleEstado;?>">Ver <i class="fa fa-file"></i></a>
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
					 				$nombrePedido = obtenerNombreDelProducto($idDetalleEstado);
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
					 				foreach ($total as $totales) {
					 					$granTotal = 0;
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
		<?php } ?>
<?php	} ?>
	</div>

 <?php include_once "../VistaAdmin/pie.php"; ?>
