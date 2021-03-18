<?php include_once "../VistaAdmin/main.php"; include_once "../Sessiones/funcionSession.php"; include_once "../Proveedor/funcionProveedor.php";
if (empty($_SESSION["codUsuario"])) {
    # Lo redireccionamos al formulario de inicio de sesión
    header("Location: ../Login/formulario_login.php?mensaje=Necesita iniciar session para ingresar a la pagina protegida");
    # Y salimos del script
    exit();
}
$idProveedor = capturarIdProveedor($_SESSION["codUsuario"]);
$listaProveedor = obtenerProveedoresPdf($idProveedor);

?>
<div class="row">
	<div class="col-auto">
		<h3>Pedidos</h3>
	</div>	
</div>
		<div class="row">
							<div class="col">
								<?php 
								if (isset($_GET["mensaje"])) { ?>
									<div class="alert alert" style="background-color: #219D9F; color: #fff">
										<?php echo $_GET["mensaje"]; ?>
									</div>
								 <?php } ?>
								 <br>
							</div>
		</div>
<div class="row">
	<div class="col">
		<?php foreach ($listaProveedor as $lista) { ?>
			<div class="accordion-main">
			    <div class="list-accordion">
			        <div class="item">
			            <button class="btn-item">
			            	<span>
			            		Razon :  <?php echo $lista->titulo; ?>
			            	</span>
			            </button>
			    <div class="accordion-content">
			    	<div class="row">
			    		<div class="container">
			    			<div class="col-3">
			    				<h5>Prioridad <span class="badge rounded-pill bg-light text-dark" style="font-weight: bold;"> <?php echo obtenerStatusDocumento($lista->id_status) ?></span></h5>
			    				
			    			</div>
			    			<div class="col-3">
			    				<h6>Fecha</h6> 
			    				<input type="datetime" name="fecha" value="<?php echo $lista->fecha; ?>" class="form-control" readonly>
			    			</div>
			    		</div>
			    	</div>
			    	<div class="row">
			    		<div class="container">
			    			<div class="col">
				    			<h5>Descripción</h5>
				    			<textarea name="descripcion" style="width: 100%;" rows="5" readonly=""><?php echo $lista->descripcion ?></textarea>				
			    			</div>			    			
			    		</div>
			    	</div>
			    	<div class="row">
			    		<div class="container">
			    			<h5>Documentos</h5>
			    			<p>Nombre del Documento : <?php echo $lista->nombreArchivo; ?></p>
			    			<a href="<?php echo "../Pdf/pdfProveedor.php?id=". $idProveedor."&nombre=".$lista->nombreArchivo; ?>"><i class="icon ion-md-document lead mr-5"></i></a>
			    		</div>
			    	</div>
			    </div>
			</div>
		</div>
	</div>
		<?php } ?>
	</div>
</div>


<?php include_once "../VistaAdmin/pie.php"; ?>
