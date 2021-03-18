<?php 
	include_once "../VistaAdmin/main.php"; include_once "../Sessiones/funcionSession.php"; include_once "../Usuario/funcionUsuarios.php";
	if (empty($_SESSION["codUsuario"])) {
    # Lo redireccionamos al formulario de inicio de sesión
    header("Location: formulario_login.php?mensaje=Necesita iniciar session para ingresar a la pagina protegida");
    # Y salimos del script
    exit();
}

$estadoUsuario = obtenerDatoUsuario($_SESSION["codUsuario"]);
if ($estadoUsuario->tipoUsuario == "Usuario" || $estadoUsuario->tipoUsuario == "Administrador") {
	$idPersona = idPersonal($estadoUsuario->id);
  	$datoPersona = datosPersonal($idPersona);
 ?>
<div class="row">
	<div class="col">
		<h1>Mi Perfil</h1>
	</div>
</div>
<div class="row">
	<div class="col-5">
		<div class="form-group">
		<label for="nombreUsuario">Nombre</label>
		<input type="text" name="nombreUsuario" value="<?php echo $datoPersona->nombre ?>" class="form-control" readonly>
	</div>
	</div>
	<div class="col-5">
		<div class="form-group">
		<label for="apellidoUsuario">Apellido</label>
		<input type="text" name="apellidoUsuario" value="<?php echo $datoPersona->apellido ?>" class="form-control" readonly>
	</div>
	</div>
</div>
<div class="row">
	<div class="col-5">
		<div class="form-group">
		<label for="nacimientoUsuario">Nacimiento</label>
		<input type="date" name="nacimientoUsuario" value="<?php echo $datoPersona->nacimiento ?>" class="form-control" readonly>
	</div>
	</div>
</div>
<div class="row">
	<div class="col-5">
		<div class="form-group">
		<label for="correo">Correo</label>
		<input type="text" name="correo" value="<?php echo $datoPersona->correo ?>" class="form-control" readonly>
	</div>
	</div>
	<div class="col-5">
		<div class="form-group">
		<label for="celular">Celular</label>
		<input type="text" name="celular" value="<?php echo $datoPersona->telefono ?>" class="form-control" readonly>
	</div>
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
<br>
<button type="button" style="background-color: #219D9F; color: #fff" class="btn btn" data-toggle="modal" data-target="#myModal">
    Editar Perfil
</button>

  <!-- The Modal -->
  <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Editar Perfil</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
		    <div class="row">
				<div class="col-5">
					<form action="editarPerfilPersona.php" method="POST">
					<div class="form-group">
						<label for="nombreUsuario">Nombre</label>
						<input type="text" name="nombreUsuario" value="<?php echo $datoPersona->nombre ?>" class="form-control">
						<input type="text" name="id" value="<?php echo $idPersona ?>" hidden>
					</div>
				</div>
				<div class="col-5">
					<div class="form-group">
						<label for="apellidoUsuario">Apellido</label>
						<input type="text" name="apellidoUsuario" value="<?php echo $datoPersona->apellido ?>" class="form-control">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-5">
					<div class="form-group">
					<label for="nacimientoUsuario">Nacimiento</label>
					<input type="date" name="nacimientoUsuario" value="<?php echo $datoPersona->nacimiento ?>" class="form-control">
				</div>
				</div>
			</div>
			<div class="row">
				<div class="col-5">
					<div class="form-group">
					<label for="correo">Correo</label>
					<input type="text" name="correo" value="<?php echo $datoPersona->correo ?>" class="form-control">
				</div>
				</div>
				<div class="col-5">
					<div class="form-group">
					<label for="celular">Celular</label>
					<input type="text" name="celular" value="<?php echo $datoPersona->telefono ?>" class="form-control">
				</div>
				</div>
			</div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        	<button type="submit" class="btn btn" style="background-color: #219D9F; color: #fff">Guardar</button>
        	</form>
          	<button type="button" class="btn btn" style="background-color: #219D9F; color: #fff" data-dismiss="modal">Cerrar</button>
        </div>
      
      </div>
    </div>
  </div>

  <button type="button" style="background-color: #219D9F; color: #fff" class="btn btn" data-toggle="modal" data-target="#myModal1">
    Actualizar Credenciales
</button>

  <!-- The Modal -->
  <div class="modal" id="myModal1">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Editar Credenciales</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
		    <div class="row">
				<div class="col-5">
					<form action="editarCredencial.php" method="POST">
					<div class="form-group">
						<label for="nombreUsuario">Usuario</label>
						<input type="text" name="nombreUsuario" value="<?php echo $estadoUsuario->usuarioIngreso;?>" class="form-control">
					</div>
				</div>
				<div class="col-5">
					<div class="form-group">
						<label for="palabraSecretaActual">Contraseña Actual</label>
						<input type="password" name="palabraSecretaActual" value="" class="form-control">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-5">
					<div class="form-group">
					<label for="palabraSecreta">Nueva Contraseña</label>
					<input type="password" name="palabraSecreta" value="" class="form-control">
				</div>
				</div>
				<div class="col-5">
					<div class="form-group">
					<label for="palabraSecretaRepetir">Repetir Contraseña</label>
					<input type="password" name="palabraSecretaRepetir" value="" class="form-control">
					<input type="hidden" name="id" value="<?php echo $_SESSION['codUsuario']; ?>">
				</div>
				</div>
			</div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        	<button type="submit" class="btn btn" style="background-color: #219D9F; color: #fff">Guardar</button>
        	</form>
          	<button type="button" class="btn btn" style="background-color: #219D9F; color: #fff" data-dismiss="modal">Cerrar</button>
        </div>
      
      </div>
    </div>
  </div>
<?php } else {
  if ($estadoUsuario->tipoUsuario == "Proveedor") {
  	$idEmpresa = idProveedor($estadoUsuario->id);
    $datoPersona = datosEmpresas($idEmpresa);
    ?>
<div class="row">
	<div class="col">
		<h1>Mi Perfil <?php echo $datoPersona->nombre ?></h1>
	</div>
</div>
<div class="row">
	<div class="col-5">
		<div class="form-group">
		<label for="rucEmpresa">RUC</label>
		<input type="text" name="rucEmpresa" value="<?php echo $datoPersona->RUC; ?>" class="form-control" readonly>
	</div>
	</div>
</div>
<div class="row">
	<div class="col-5">
		<div class="form-group">
		<label for="nombreEmpresa">Razon Social</label>
		<input type="text" name="nombreEmpresa" value="<?php echo $datoPersona->nombre; ?>" class="form-control" readonly>
	</div>
	</div>
	<div class="col-5">
		<div class="form-group">
		<label for="rubroEmpresa">Rubro</label>
		<input type="text" name="rubroEmpresa" value="<?php echo $datoPersona->rubro; ?>" class="form-control" readonly>
	</div>
	</div>
</div>
<div class="row">
	<div class="col-6">
		<div class="form-group">
		<label for="direccion">Dirección</label>
		<input type="text" name="direccion" value="<?php echo $datoPersona->direccion; ?>" class="form-control" readonly>
	</div>
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
<br>
<button type="button" style="background-color: #219D9F; color: #fff" class="btn btn" data-toggle="modal" data-target="#myModal">
    Editar Perfil
  </button>

  <!-- The Modal -->
  <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Editar Perfil</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
		    <div class="row">
				<div class="col-5">
					<form action="editarPerfilProveedor.php" method="POST">
					<div class="form-group">
						<label for="rucEmpresa">RUC</label>
						<input type="text" name="rucEmpresa" value="<?php echo $datoPersona->RUC; ?>" class="form-control" maxlength="11">
						<input type="hidden" name="id" value="<?php echo $idEmpresa; ?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-8">
					<div class="form-group">
					<label for="nombreEmpresa">Razon Social</label>
					<input type="text" name="nombreEmpresa" value="<?php echo $datoPersona->nombre; ?>" class="form-control">
				</div>	
				</div>
			</div>
			<div class="row">
				<div class="col-8">
					<div class="form-group">
					<label for="rubroEmpresa">Rubro</label>
					<input type="text" name="rubroEmpresa" value="<?php echo $datoPersona->rubro; ?>" class="form-control">
				</div>	
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="form-group">
					<label for="direccionEmpresa">Dirección</label>
					<input type="text" name="direccionEmpresa" value="<?php echo $datoPersona->direccion; ?>" class="form-control">
				</div>
				</div>
			</div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        	<button type="submit" class="btn btn" style="background-color: #219D9F; color: #fff">Guardar</button>
        	</form>
          	<button type="button" class="btn btn" style="background-color: #219D9F; color: #fff" data-dismiss="modal">Cerrar</button>
        </div>
      
      </div>
    </div>
  </div>

  <button type="button" style="background-color: #219D9F; color: #fff" class="btn btn" data-toggle="modal" data-target="#myModal1">
    Actualizar Credenciales
</button>

  <!-- The Modal -->
  <div class="modal" id="myModal1">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Editar Credenciales</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
		    <div class="row">
				<div class="col-5">
					<form action="editarCredencial.php" method="POST">
					<div class="form-group">
						<label for="nombreUsuario">Usuario</label>
						<input type="text" name="nombreUsuario" value="<?php echo $estadoUsuario->usuarioIngreso;?>" class="form-control">
					</div>
				</div>
				<div class="col-5">
					<div class="form-group">
						<label for="palabraSecretaActual">Contraseña Actual</label>
						<input type="password" name="palabraSecretaActual" value="" class="form-control">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-5">
					<div class="form-group">
					<label for="palabraSecreta">Nueva Contraseña</label>
					<input type="password" name="palabraSecreta" value="" class="form-control">
				</div>
				</div>
				<div class="col-5">
					<div class="form-group">
					<label for="palabraSecretaRepetir">Repetir Contraseña</label>
					<input type="password" name="palabraSecretaRepetir" value="" class="form-control">
					<input type="hidden" name="id" value="<?php echo $_SESSION['codUsuario']; ?>">
				</div>
				</div>
			</div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        	<button type="submit" class="btn btn" style="background-color: #219D9F; color: #fff">Guardar</button>
        	</form>
          	<button type="button" class="btn btn" style="background-color: #219D9F; color: #fff" data-dismiss="modal">Cerrar</button>
        </div>
      
      </div>
    </div>
  </div>

    <?php }
}?> 
<?php include_once "../VistaAdmin/pie.php"; ?>