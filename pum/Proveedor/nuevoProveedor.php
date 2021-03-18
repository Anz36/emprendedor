<?php include_once "../VistaAdmin/main.php"; include_once "../Sessiones/funcionSession.php"; include_once "../Proveedor/funcionProveedor.php"; 
if (empty($_SESSION["codUsuario"])) {
    # Lo redireccionamos al formulario de inicio de sesión
    header("../Location: Login/formulario_login.php?mensaje=Necesita iniciar session para ingresar a la pagina protegida");
    # Y salimos del script
    exit();
}

?>
<div class="row">
	<div class="col-auto">
		<h3>Agregar Proveedor</h3>
	</div>
</div>
<div class="row">
	<div class="col-6">
		<div class="form-group">
			<form action="../Proveedor/registrarProveedor.php" method="POST">
			<label for="ruc">RUC</label>
			<input type="text" name="ruc" placeholder="RUC Empresarial" class="form-control" id="ruc" onkeypress="return numeros(event)" maxlength="11">
		</div>
	</div>
</div>
<div class="row">
	<div class="col-6">
		<div class="form-group">
			<label for="nombreProveedor">Razón Social</label>
			<input type="text" name="nombreProveedor" placeholder="Ingrese la Razón Social" class="form-control" id="razonSocial">
		</div>
	</div>
	<div class="col-6">
		<div class="form-group">
			<label for="rubro">Rubro</label>
			<input type="text" name="rubro" placeholder="Ingrese el Rubro" class="form-control" id="rubro" onkeypress="return letras(event)">
		</div>
	</div>
</div>
<div class="row">
	<div class="col-6">
		<div class="form-group">
			<label for="direccion">Dirección</label>
			<input type="text" name="direccion" placeholder="Ingrese la Dirección" class="form-control" id="direccion">
		</div>
	</div>
</div>
<br><br>

<div class="row" style="display: none;"id="divError">
	<div class="col">
		
			<div class="alert alert" style="background-color: #219D9F; color: #fff" id="error">
			</div>
		 <br>
	</div>
</div>



<div class="row">
	<div class="col">
	<input class="btn btn" type="submit" style="background-color: #219D9F; color: #fff; " onclick="return ValidarProveedor();" value="Registrar">
	</div>
</div>

<?php 
	if (isset($_GET["mensaje"])) {?> 
		<script> alert("<?php echo $_GET["mensaje"]; ?>"); </script>
	<?php } ?>
</form>
<?php include_once "../VistaAdmin/pie.php" ?>