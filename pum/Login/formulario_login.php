<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>CRM Emprendedor</title>

  <!-- CSS only -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
	<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
  <!-- Hoja de estilos -->
  	<link href="../css/style.css" rel="stylesheet">

  <!-- Google fonts -->
  	<link href="https://fonts.googleapis.com/css?family=Muli:400,700&display=swap" rel="stylesheet">

  <!-- Ionic icons -->
	<link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script> 
	<script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>

<body>
	 <div class="d-flex" id="content-wrapper">
	 	<div id="content" class="container-fluid p-5" style="margin-top: 10vh">
        <section class="py-3" align="center">
        	<img src="../img/Rincon_Emprendedor.png" alt="" width="400">
        	<br><br>
        </section>
        <section class="py-4">
			<div class="container">
				<form action="login.php" method="POST">
					<div class="form-group">
						<h5 class="text-muted" align="center">ADMINISTRADOR</h5>
					</div>
					<div class="form-group">
						<label for="usuario">Usuario:</label>
						<input type="text" id="usuario" name="usuario" placeholder="Usuario" class="form-control">
					</div>
					<div class="form-group">
						<label for="palabraSecreta">Contraseña:</label>
						<input type="password" id="palabraSecreta" name="palabraSecreta" placeholder="Password" class="form-control">
					</div>
					<br>

					<?php 
						if (isset($_GET["mensaje"])) { ?>
						<div class="alert alert" style="background-color: #219D9F; color: #fff">
							<?php echo $_GET["mensaje"]; ?>
						</div>
					<?php } ?>
					<br>
					<div align="center">
						<button class="btn btn" type="submit" style="background-color: #219D9F; color: #fff">Iniciar Sessión</button>	
					</div>
				</form>	
			</div>
        </section>	
      </div>
    </div>
    <!-- Fin Page Content -->
  <!-- Bootstrap y JQuery -->
  <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script> 
  <script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

</body>
</html>

  
