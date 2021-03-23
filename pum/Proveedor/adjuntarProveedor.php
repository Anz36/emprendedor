<?php include_once "../VistaAdmin/main.php"; include_once "../Sessiones/funcionSession.php"; include_once "../Proveedor/funcionProveedor.php";
if (empty($_SESSION["codUsuario"])) {
    # Lo redireccionamos al formulario de inicio de sesión
    header("Location: ../Login/formulario_login.php?mensaje=Necesita iniciar session para ingresar a la pagina protegida");
    # Y salimos del script
    exit();
}
$listaProveedor = capturarProveedor();
$listaPrioridad = listarPrioridad();
 ?>
 <div class="row">
	<div class="col-auto">
		<h3>Adjuntar PDF</h3>
	</div>
</div>
<form action="../Pdf/guardarPdfProveedor.php" method="POST" enctype="multipart/form-data" id="miFormulario">
<div class="row">
		<div class="col-7">
			<div class="form-group">
				<label for="titulo">Razon</label>
				<input type="text" name="titulo" placeholder="Razon del PDF" class="form-control" id="razon">
				<input type="hidden" name="idPersona" value="<?php echo $datoPersona->id; ?>">
			</div>
		</div>
		<div class="col-3">
			<div class="form-group">
				<label for="prioridad">Prioridad</label>
				<select class="custom-select" name="prioridad">
				  <?php foreach ($listaPrioridad as $prioridad) {
				  	echo "<option value=".$prioridad->id.">".$prioridad->status."</option>";
				  } ?>
			</select>
			</div>
		</div>
</div>
<div class="row">
	<div class="col-7">
			<div class="form-group">
				<label for="descripcion">Descripción</label>
				<textarea name="descripcion" placeholder="Descripción del PDF" class="form-control"></textarea>
			</div>
	</div>
</div>
<div class="row">
	<div class="col-3">
			<div class="form-group">
				<label for="fecha">Fecha</label>
				<input type="datetime" name="fecha" class="form-control" value="<?php echo date("Y-m-d")." ".date("H:i:s"); ?>" readonly>
			</div>
	</div>
	<div class="col-7">
			<div class="form-group">
				<label for="proveedor">Proveedor</label>
			<select class="custom-select" name="proveedor">
				  <?php foreach ($listaProveedor as $proveedor) {
				  	echo "<option value=".$proveedor->id.">".$proveedor->nombre."</option>";
				  } ?>
			</select>
			</div>
	</div>
</div>
<div class="row">
	<div class="col-7">
		<div class="form-group">
   		 	<label for="archivo">Seleccione el Archivo </label>
    		<input type="file" class="form-control-file" name="archivo[]" id="archivo[]" multiple>
  	</div>
	</div>
</div>
<div class="row" style="display: none;"id="divError">
	<div class="col">
			<div class="alert alert" style="background-color: #219D9F; color: #fff" id="error">
			</div>
		 <br>
	</div>
</div>
<br>
<div class="row" >
	<div class="col">
		<input class="btn btn" type="submit" style="background-color: #219D9F; color: #fff; " onclick="return Validar();" value="Registrar" name="enviar">
	</div>
</div>
<?php 
	if (isset($_GET["mensaje"])) {?> 
		<script> alert("<?php echo $_GET["mensaje"]; ?>"); </script>
	<?php } ?>
</form>

<?php  include_once "../VistaAdmin/pie.php"; ?>