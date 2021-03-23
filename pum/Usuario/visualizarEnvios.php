<?php include_once "../VistaAdmin/main.php"; include_once "../Sessiones/funcionSession.php"; include_once "../Proveedor/funcionProveedor.php";
if (empty($_SESSION["codUsuario"])) {
    # Lo redireccionamos al formulario de inicio de sesión
    header("Location: ../Login/formulario_login.php?mensaje=Necesita iniciar session para ingresar a la pagina protegida");
    # Y salimos del script
    exit();
}
$listaProveedor = obtenerDatosProveedores($datoPersona->id);
?>
<div class="row">
	<div class="col-auto">
		<h3>
			Visualizacion de Envios Adjuntos PDF
		</h3>
	</div>
</div>
<div class="row">
	<div class="col">
		<?php foreach ($listaProveedor as $lista) { 
			$listasDatos = obtenerDatosEnvios($lista->id);
			foreach ($listasDatos as $datos) { 
				$estadoPrioridad = $datos->id_status;
				?>
			<div class="accordion-main">
			    <div class="list-accordion">
			        <div class="item">
			            <button class="btn-item">
			            	<span>
			            		Razon :  <?php echo $lista->titulo; ?>
			            		<span class="badge rounded-pill bg-light text-dark" style="font-weight: bold;"> <?php  echo obtenerStatusDocumento($estadoPrioridad); ?></span>
			            	</span>
			            </button>
			    <div class="accordion-content">
			    	<div class="row">
			    		<div class="container py-2">
			    			<div class="col-3">
			    				<h6>Fecha</h6> 
			    				<input type="datetime" name="fecha" value="<?php echo $lista->fecha; ?>" class="form-control" readonly>
			    			</div>
			    		</div>
			    	</div>
			    	<div class="row">
			    		<div class="container py3">
			    			<div class="col">
			    			<h5>Visualizacion o Descargas del PDF <span class="badge rounded-pill bg-light text-dark" style="font-weight: bold;"> <?php echo $datos->visulizaciones ?></span></h5>	
			    			</div>
			    		</div>
			    	</div>
			    </div>
			</div>
		</div>
	</div>
	<?php }
	} ?>
</div>

</div>

</div>
<?php include_once "../VistaAdmin/pie.php" ?>