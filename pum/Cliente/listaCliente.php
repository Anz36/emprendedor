<?php include_once "../VistaAdmin/main.php";
	  include_once "../Sessiones/funcionSession.php";
	  include_once "../FuncionesExtra/funciones.php";
if (empty($_SESSION["codUsuario"])) {
    # Lo redireccionamos al formulario de inicio de sesión
    header("Location: ../Login/formulario_login.php?mensaje=Necesita iniciar session para ingresar a la pagina protegida");
    # Y salimos del script
    exit();
}
 $listaCliente = obtenerClientes();
?>
<div class="row">
 	<div class="col-auto">
 		<h3>Clientes</h3>
 	</div>
 </div>
 <div class="row">
			<div class="col">
				<nav class="navbar navbar-expand-lg navbar-light bg-light" style="border-color: #219D9F">
					  <a class="navbar-brand" href="listaCliente.php">Busqueda Por <span> &nbsp&nbsp;|</span></a>
					  <div class="collapse navbar-collapse" id="navbarColor03">
					    <ul class="navbar-nav mr-auto">
					      <li class="nav-item">
					        <a class="nav-link" href="<?php echo "../Cliente/listaCliente.php?estado=Cliente Habitual";?>">Cliente Habitual</a>
					      </li>
					      <li class="nav-item">
					        <a class="nav-link" href="<?php echo "../Cliente/listaCliente.php?estado=Cliente Emprendedor";?>">Cliente Emprendedor</a>
					      </li>
					      <li class="nav-item">
					        <a class="nav-link" href="<?php echo "../Cliente/listaCliente.php?estado=Cliente Nuevo";?>">Cliente Nuevo</a>
					      </li>
					  </ul>
					</div>
				</nav>
			</div>
	</div>
	<?php if (isset($_GET["estado"])) { ?>
	<br>
	<?php if ($_GET["estado"] == "Cliente Habitual") { ?>
	<div class="row">
		<div class="col">
			<div class="table table-hover">
				<table class="table table-striped table-responsive-xl">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nombres</th>
							<th>Email</th>
							<th>Estado</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($listaCliente as $datos){
							$estado = obtenerIdCliente($datos->customer_id);
							foreach ($estado as $Clientes) {
								if ($Clientes->Contador >= "5"){
									$pum = obtenerClientePorEstado($Clientes->customer_id);
									foreach ($pum as $pumes) {
								 ?>
						<tr>
							<td><?php echo $pumes->customer_id ?></td>
							<td><?php echo $pumes->first_name ?></td>
							<td><?php echo $pumes->email ?></td>
							<td><?php echo obtenerEstadoCliente($pumes->customer_id); ?></td>
						</tr>
					<?php 		}
							}
						}
					} ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<?php } ?>
	<?php if ($_GET["estado"] == "Cliente Emprendedor") { ?>
	<div class="row">
		<div class="col">
			<div class="table table-hover">
				<table class="table table-striped table-responsive-xl">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nombres</th>
							<th>Email</th>
							<th>Estado</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($listaCliente as $datos){
							$estado = obtenerIdCliente($datos->customer_id);
							foreach ($estado as $Clientes) {
								if ($Clientes->Contador == "3" ||  $Clientes->Contador == "4"){
									$pum = obtenerClientePorEstado($Clientes->customer_id);
									foreach ($pum as $pumes) {
								 ?>
						<tr>
							<td><?php echo $pumes->customer_id ?></td>
							<td><?php echo $pumes->first_name ?></td>
							<td><?php echo $pumes->email ?></td>
							<td><?php echo obtenerEstadoCliente($pumes->customer_id); ?></td>
						</tr>
					<?php 		}
							}
						}
					} ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<?php } ?>
	<?php if ($_GET["estado"] == "Cliente Nuevo") { ?>
	<div class="row">
		<div class="col">
			<div class="table table-hover">
				<table class="table table-striped table-responsive-xl">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nombres</th>
							<th>Email</th>
							<th>Estado</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($listaCliente as $datos){
							$estado = obtenerIdCliente($datos->customer_id);
							foreach ($estado as $Clientes) {
								if ($Clientes->Contador <= "2"){
									$pum = obtenerClientePorEstado($Clientes->customer_id);
									foreach ($pum as $pumes) {
								 ?>
						<tr>
							<td><?php echo $pumes->customer_id ?></td>
							<td><?php echo $pumes->first_name ?></td>
							<td><?php echo $pumes->email ?></td>
							<td><?php echo obtenerEstadoCliente($pumes->customer_id); ?></td>
						</tr>
					<?php 		}
							}
						}
					} ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<?php } ?>

	<?php } else { ?>
	<br>
	<div class="row">
		<div class="col">
			<div class="table table-hover">
				<table class="table table-striped table-responsive-xl">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nombres</th>
							<th>Email</th>
							<th>Estado</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($listaCliente as $lista) { ?>
						<tr>
								<td><?php echo $lista->customer_id ?></td>	
								<td><?php echo $lista->first_name." ".$lista->last_name ?></td>
								<td><?php echo $lista->email ?></td>
								<td><?php echo obtenerEstadoCliente($lista->customer_id); ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php } ?>