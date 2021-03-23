<?php include_once "../VistaAdmin/main.php"; ?>
<?php
include_once "../Sessiones/funcionSession.php";
include_once "../FuncionesExtra/funciones.php";
#Sí no esta logueado dentro del Sistema, salir inmediatamente.
	if (empty($_SESSION["codUsuario"])) {
    # Lo redireccionamos al formulario de inicio de sesión
    header("Location: ../Login/formulario_login.php?mensaje=Necesita iniciar session para ingresar a la pagina protegida");
    # Y salimos del script
    exit();
}
	if (!isset($_GET["id"]) || !isset($_GET["skuModelo"])) {
		#Si no encuentra datos dentro del $_GET["ID"];
		exit("Faltan Datos");
	}
	$id_producto = $_GET["id"];
	$idSku = $_GET["skuModelo"];
	#Sí el usuario esta logueado, mostrata los Datos Correspondientes.
	$dato = obtenerModeloProductoSKU($idSku);
	if ($dato == "Polo") {
 ?>

<div class="container">
	<h1>Detalle del Producto Polo</h1>
	<br>
	<?php if (isset($_GET["referencia"])) { ?>
		<a href="../Usuario/busqueda.php" class="btn btn-outline-warning offset-10">Volver</a>
	<?php } else { ?>
		<a href="../VistaAdmin/listas.php" class="btn btn-outline-warning offset-10">Volver</a> 
 <?php } ?>
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
 	
 </div> <?php 
	} else {
		if ($dato == "Gorro") { ?>
			<div class="container">
				<h1>Detalle del Producto Gorro</h1>
			<br>
				<?php if (isset($_GET["referencia"])) { ?>
					<a href="../Usuario/busqueda.php" class="btn btn-outline-warning offset-10">Volver</a>
				<?php } else { ?>
					<a href="../VistaAdmin/listas.php" class="btn btn-outline-warning offset-10">Volver</a> 
			 <?php } ?>
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
 <?php  
	} else {
		if ($dato == "Taza") { ?>
			<div class="container">
				<h1>Detalle del Producto Taza</h1>
			<br>
				<?php if (isset($_GET["referencia"])) { ?>
					<a href="../Usuario/busqueda.php" class="btn btn-outline-warning offset-10">Volver</a>
				<?php } else { ?>
					<a href="../VistaAdmin/listas.php" class="btn btn-outline-warning offset-10">Volver</a> 
			 <?php } ?>
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
			 <?php
		} else {
			if ($dato == "M") { ?>
				<div class="container">
				<h1>Detalle del Producto MUG</h1>
			<br>
				<?php if (isset($_GET["referencia"])) { ?>
					<a href="../Usuario/busqueda.php" class="btn btn-outline-warning offset-10">Volver</a>
				<?php } else { ?>
					<a href="../VistaAdmin/listas.php" class="btn btn-outline-warning offset-10">Volver</a> 
			 <?php } ?>
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
			} else {
				if ($dato == "PM") { ?>
					<div class="container">
				<h1>Detalle del Producto Maus Pad</h1>
			<br>
				<?php if (isset($_GET["referencia"])) { ?>
					<a href="../Usuario/busqueda.php" class="btn btn-outline-warning offset-10">Volver</a>
				<?php } else { ?>
					<a href="../VistaAdmin/listas.php" class="btn btn-outline-warning offset-10">Volver</a> 
			 <?php } ?>
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
				} else {
					if ($dato == "L") { ?>
						<div class="container">
				<h1>Detalle del Producto Libreta</h1>
			<br>
				<?php if (isset($_GET["referencia"])) { ?>
						<a href="../Usuario/busqueda.php" class="btn btn-outline-warning offset-10">Volver</a>
					<?php } else { ?>
						<a href="../VistaAdmin/listas.php" class="btn btn-outline-warning offset-10">Volver</a> 
				 <?php } ?>
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
					} else {
						if ($dato == "B") {?>
							<div class="container">
				<h1>Detalle del Producto Bolsa</h1>
			<br>
				<?php if (isset($_GET["referencia"])) { ?>
					<a href="../Usuario/busqueda.php" class="btn btn-outline-warning offset-10">Volver</a>
				<?php } else { ?>
					<a href="../VistaAdmin/listas.php" class="btn btn-outline-warning offset-10">Volver</a> 
			 <?php } ?>
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
						} else{
							if ($dato == "GAD") { ?>
								<div class="container">
				<h1>Detalle del Producto Gadget</h1>
			<br>
				<?php if (isset($_GET["referencia"])) { ?>
						<a href="../Usuario/busqueda.php" class="btn btn-outline-warning offset-10">Volver</a>
					<?php } else { ?>
						<a href="../VistaAdmin/listas.php" class="btn btn-outline-warning offset-10">Volver</a> 
				 <?php } ?>
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
				}
			}
		}
	} 
	if ($dato == "N.E") { ?>
		<div class="container">
			<div class="col">
				<h1>Producto sin Detalles</h1>
				<br>
				<?php if (isset($_GET["referencia"])) { ?>
						<a href="../Usuario/busqueda.php" class="btn btn-outline-warning offset-10">Volver</a>
					<?php } else { ?>
						<a href="../VistaAdmin/listas.php" class="btn btn-outline-warning offset-10">Volver</a> 
				 <?php } ?>
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
	}
}
	?>

 <?php include_once "../VistaAdmin/pie.php" ?>