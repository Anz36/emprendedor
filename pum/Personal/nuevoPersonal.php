<?php include_once "../VistaAdmin/main.php"; include_once "../FuncionesExtra/funciones.php"; include_once "../Usuario/funcionUsuarios.php";
if (empty($_SESSION["codUsuario"])) {
    # Lo redireccionamos al formulario de inicio de sesión
    header("Location: ../Login/formulario_login.php?mensaje=Necesita iniciar session para ingresar a la pagina protegida");
    # Y salimos del script
    exit();
}
 ?>
 <div class="row">
 	<div class="col-auto">
 		<h3>Agregar Personal</h3>
 	</div>
 </div>
 <div class="row">
	<div class="col-6">
		<div class="form-group">
			<form action="../Personal/registrarPersonal.php" method="POST">
			<label for="nombrePersona">Nombre</label>
			<input type="text" name="nombrePersona" placeholder="Nombre Personal" class="form-control" id="nombre" onkeypress="return letras(event)">
		</div>
	</div>
	<div class="col-6">
		<div class="form-group">
			<label for="apellidoPersona">Apellido</label>
			<input type="text" name="apellidoPersona" placeholder="Apellido Personal" class="form-control" id="apellido" onkeypress="return letras(event)">
		</div>
	</div>
</div>
<div class="row">
	<div class="col-6">
		<div class="form-group">
			<label for="nacimiento">Nacimiento</label>
			<input type="date" name="nacimiento" placeholder="Ingrese la Razón Social" class="form-control" id="fecha" >
		</div>
	</div>
</div>
<div class="row">
	<div class="col-6">
		<div class="form-group">
			<label for="correo">Correo</label>
			<input type="email" name="correo" placeholder="Email" class="form-control" id="correo">
		</div>
	</div>
	<div class="col-6">
		<div class="form-group">
			<label for="celular">Celular</label>
			<input type="text" name="celular" placeholder="celular" class="form-control" id="celular" onkeypress="return numeros(event)"  maxlength="9">
		</div>
	</div>		
</div>

<br>

<div class="row" style="display: none;"id="divError">
	<div class="col">
		
			<div class="alert alert" style="background-color: #219D9F; color: #fff" id="error">
			</div>
		 <br>
	</div>
</div>


<div class="row" style="display: none;"id="divError">
	<div class="col">
			<div class="alert alert" style="background-color: #219D9F; color: #fff" id="error">
			</div>
		 <br>
	</div>
</div>

<div class="row">
	<div class="col">
	<input class="btn btn" type="submit" style="background-color: #219D9F; color: #fff; " onclick="return ValidarPersonal();" value="Registrar">
	</div>
</div>

<?php 
	if (isset($_GET["mensaje"])) {?> 
		<script> alert("<?php echo $_GET["mensaje"]; ?>"); </script>
	<?php } ?>
</form>
<?php include_once "../VistaAdmin/pie.php" ?>