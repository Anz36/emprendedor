<?php

use function Sodium\compare;

include_once "../VistaAdmin/main.php"; include_once "../Sessiones/funcionSession.php"; include_once "funcionUsuarios.php"; 
if (empty($_SESSION["codUsuario"])) {
    # Lo redireccionamos al formulario de inicio de sesión
    header("Location: ../Login/formulario_login.php?mensaje=Necesita iniciar session para ingresar a la pagina protegida");
    # Y salimos del script
    exit();
}

	$personaNatural = obtenerPersonas();
	$personaEmpresa = obtenerProveedores();
?>
<div class="row">
	<div class="col-auto">
		<h3>Agregar Usuarios</h3>
	</div>
</div>
<div class="row">
	
	<div class="col-6">
		<div class="form-group">
			<form action="../Usuario/registrarUsuario.php" method="POST">
			<label for="personaNatural">Personal</label>
			<select class="custom-select" name="personaNatural">
				  <option selected value="NULL">...</option>
				  <?php foreach ($personaNatural as $personas) {
				  	echo "<option value=".$personas->id.">".$personas->nombre." ".$personas->apellido."</option>";
				  } ?>
			</select>
		</div>
	</div>
	<div class="col-6">
		<div class="form-group">
			<label for="personaEmpresa">Empresas</label>
			<select class="custom-select" name="personaEmpresa">
				  <option selected value="NULL">...</option>
				  <?php foreach ($personaEmpresa as $personas) {
				  	echo "<option value=".$personas->id.">".$personas->nombre." ".$personas->apellido."</option>";
				  } ?>
			</select>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-4">
		<label for="nombreUsuario">Usuario</label>
		<input type="text" name="nombreUsuario" placeholder="Nombre del Usuario" class="form-control" onkeypress="return letras(event)" id="usuario">
		<br>
	</div>
	<div class="col-4">
		<label for="nombreUsuario">Estado</label>
		<select name="estadoUsuario" class="custom-select">
			<option value="1" selected>Activo</option>
			<option value="0">Desactivado</option>
		</select>		
	</div>
	<div class="col-4">
		<label for="nombreUsuario">Tipo de Usuario</label>
		<select name="tipoUsuario" class="custom-select">
			<option value="Usuario" selected>Usuario</option>
			<option value="Proveedor">Proveedor</option>
			<option value="Administrador">Administrador</option>
		</select>		
	</div>
</div>
<div class="row"> 
	<div class="col-6">
		<label for="palabraSecreta">Contraseña</label>
		<input type="password" name="palabraSecreta" placeholder="Ingrese Contraseña" class="form-control" id="pass1">
	</div>
	<div class="col-6">
		<label for="palabraSecretaValidar">Repetir Contraseña</label>
		<input type="password" name="palabraSecretaValidar" placeholder="Repita Contraseña" class="form-control" id="pass2">
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
<br>

<div class="row" >
	<div class="col">
		<input class="btn btn" type="submit" style="background-color: #219D9F; color: #fff; " onclick="return ValidarUsuario();" value="Registrar">
	</div>
</div>




		<?php 
		if (isset($_GET["mensaje"])) {?> 
				<script> alert("<?php echo $_GET["mensaje"]; ?>"); </script>
		<?php } ?>






</form>
<?php include_once "../VistaAdmin/pie.php" ?>