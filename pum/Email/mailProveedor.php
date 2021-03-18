<?php include_once "../VistaAdmin/main.php"; include_once "../FuncionesExtra/funciones.php"; include_once "../Proveedor/funcionProveedor.php";
	require ('../libreria/Mailer/PHPMailer.php');
if (empty($_SESSION["codUsuario"])) {
    # Lo redireccionamos al formulario de inicio de sesión
    header("Location: ../Login/formulario_login.php?mensaje=Necesita iniciar session para ingresar a la pagina protegida");
    # Y salimos del script
    exit();
}
 ?>
  <div class="row">
 	<div class="col-auto">
 		<h3>Enviar Email</h3>
 	</div>
 </div>
<div class="row">
	<div class="col-6">
		<form action="../Email/enviarEmail.php" method="POST">
		<label for="paraEmail">Para </label>
		<input type="Email" name="paraEmail" placeholder="Email" class="form-control">
	</div>
</div>
<div class="row">
	<div class="col-6">
		<label for="paraAsunto">Asunto </label>
		<input type="text" name="paraAsunto" placeholder="Asunto Email" class="form-control">
	</div>
</div>
<div class="row">
	<div class="col-6">
		<label for="paraMensaje">Mensaje</label>
		<textarea name="paraMensaje" placeholder="Mensaje Email" class="form-control"></textarea>
	</div>
</div>
<br>
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
	<div class="col-6">
		<button type="submit" class="btn btn" style="background-color: #219D9F; color: #fff" name="enviar">Enviar</button>
	</div>
</div>
</form>
