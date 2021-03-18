<?php 
include_once "../VistaAdmin/main.php"; include_once "../Sessiones/funcionSession.php"; include_once "../Proveedor/funcionProveedor.php";

if (empty($_SESSION["codUsuario"])) {
    # Lo redireccionamos al formulario de inicio de sesión
    header("Location: ../Login/formulario_login.php?mensaje=Necesita iniciar session para ingresar a la pagina protegida");
    # Y salimos del script
    exit();    
}
$listaProveedor = capturarProveedor();
 ?>
<div class="row">
	<div class="col-auto">
		<h3>Proveedores</h3>
	</div>
</div>
<div class="row">
	<div class="table-responsive table-hover">
		<table class="table">
			<thead>
				<tr>
					<th>RUC</th>
					<th>Razon Social</th>
					<th>Rubro</th>
					<th>Dirección</th>
				</tr>
			</thead>
			<tbody>
				<?php  foreach ($listaProveedor as $listas) { ?>				
				<tr>
					<td><?php echo $listas->RUC; ?></td>
					<td><?php echo $listas->nombre; ?></td>
					<td><?php echo $listas->rubro; ?></td>
					<td><?php echo $listas->direccion; ?></td>
				</tr>
			</tbody>
		<?php } ?>
		</table>
	</div>
</div>

<?php include_once "../VistaAdmin/pie.php" ?>