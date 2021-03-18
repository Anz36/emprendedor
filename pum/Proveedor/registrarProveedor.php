<?php include_once "../Proveedor/funcionProveedor.php";

	$ruc = $_POST["ruc"];
	$nombre = $_POST["nombreProveedor"];
	$rubro = $_POST["rubro"];
	$direccion = $_POST["direccion"];

	if (empty($_POST["ruc"])) {
		header("Location: ../Proveedor/nuevoProveedor.php?mensaje=Ingrese el RUC, faltan datos");
		exit;
	}else {
		if (empty($_POST["nombreProveedor"])) {
		header("Location: ../Proveedor/nuevoProveedor.php?mensaje=Ingrese la Razón Social, faltan datos");
		exit;
	} else {
		if (empty($_POST["rubro"])) {
		header("Location: ../Proveedor/nuevoProveedor.php?mensaje=Ingrese el Rubro, faltan datos");
		exit;
	}
	}
	}
	
	$existe = existeProveedor($ruc);
	if ($existe) {
		header("Location: ../Proveedor/nuevoProveedor.php?mensaje=El RUC ya existe.");
		exit;
	}
		$registradoCorrectamente = registrarProveedor($ruc,$nombre,$rubro,$direccion);
		if ($registradoCorrectamente) {
			    header("Location: ../Proveedor/nuevoProveedor.php?mensaje=Registro completado.");
			} else {
			    header("Location: ../Proveedor/nuevoProveedor.php?mensaje=Error al ingresar los datos, intentelo denuevo.");
			}


 ?>