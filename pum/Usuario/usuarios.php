<?php 	
		include_once "../VistaAdmin/main.php";
		include_once "../Sessiones/funcionSession.php";
		include_once "funcionUsuarios.php";

if (empty($_SESSION["codUsuario"])) {
    # Lo redireccionamos al formulario de inicio de sesión
    header("Location: ../Login/formulario_login.php?mensaje=Necesita iniciar session para ingresar a la pagina protegida");
    # Y salimos del script
    exit();
}

		$listaUsuarios = obtenerUsuarios();
 ?>
 
<div class="row">
	<div class="col-auto">
		<h3>Usuarios</h3>
	</div>
</div>
<div class="row">
	<div class="table-responsive table-hover">
		<table class="table">
			<thead>
				<tr>
					<th>Usuario</th>
					<th>Estado Usuario</th>
					<th>Tipo Usuario</th>
				</tr>
			</thead>
			<tbody>
				<?php  foreach ($listaUsuarios as $listas) { ?>
				<tr>
					<td><?php echo $listas->usuarioIngreso; ?></td>
					<td><?php echo estadoUsuario($listas->estadoUsuario); ?></td>
					<td><?php echo $listas->tipoUsuario; ?></td>
				</tr>
			</tbody>
		<?php } ?>
		</table>
	</div>
</div>
<?php include_once "../VistaAdmin/pie.php" ?>