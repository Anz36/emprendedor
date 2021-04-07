<?php session_start();
include_once "../Sessiones/funcionSession.php";
include_once "../Usuario/funcionUsuarios.php";
if (empty($_SESSION["codUsuario"])) {
    # Lo redireccionamos al formulario de inicio de sesión
    //header("Location: Login/formulario_login.php?mensaje=Necesita iniciar session para ingresar a la pagina protegidaaaa");
    # Y salimos del script
    exit();
}
$estadoUsuario = obtenerDatoUsuario($_SESSION["codUsuario"]);

if ($estadoUsuario->tipoUsuario == "Administrador" || $estadoUsuario->tipoUsuario == "Usuario") {
  $idPersona = idPersonal($estadoUsuario->id);
  $datoPersona = datosPersonal($idPersona);
} else {
  if ($estadoUsuario->tipoUsuario == "Proveedor") {
    $idEmpresa = idProveedor($estadoUsuario->id);
    $datoPersona = datosEmpresas($idEmpresa);
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>CRM Emprendedor</title>

  <!-- Validaciones JS  -->  
  <script src="../js/validaciones.js" type="text/javascript"></script>
  <script src="../js/validarPersonal.js" type="text/javascript"></script>
  <script src="../js/validarProveedor.js" type="text/javascript"></script>
  <script src="../js/validarAdjuntarProveedor.js" type="text/javascript"></script>

  <!-- Bootstrap Css -->
  <link href="../css/bootstrap.min.css" rel="stylesheet">

  <!-- Hoja de estilos -->
  <link href="../css/style.css" rel="stylesheet">
  <link href="../css/estilosLista.css" rel="stylesheet">

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

    <!-- Menu -->
    <div id="sidebar-container" class="bg-light border-right">
      <div class="logo">
        <img src="../img/Rincon_Emprendedor.png" alt="" width="190">        
      </div>
      <div class="menu list-group-flush">
        <?php if($estadoUsuario->tipoUsuario == "Administrador") {  ?>
        <a href="../Usuario/usuarios.php" class="list-group-item list-group-item-action  active text-muted bg-faded p-3 border-0"><i
            class="icon ion-md-apps lead mr-2"></i> Administrador</a>
    <div class="nav-item dropdown">
      <a class="nav-link dropdown-toggle text-muted bg-light p-3 border-0" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false"><i class="icon ion-md-people lead mr-2"></i> Usuarios</a>
      <div class="dropdown-menu">
      <a href="../Usuario/usuarios.php" class="list-group-item list-group-item-action text-muted bg-light p-3 border-0"><i class="icon ion-md-people lead mr-2"></i> Listar Usuario</a>
      <a href="../Usuario/nuevoUsuarios.php" class="list-group-item list-group-item-action text-muted bg-light p-3 border-0"><i class="icon ion-md-person-add lead mr-2"></i> Agregar Usuario</a>
      <a href="../Personal/nuevoPersonal.php" class="list-group-item list-group-item-action text-muted bg-light p-3 border-0"><i class="icon ion-md-person-add lead mr-2"></i> Agregar Personal</a> 
      </div>
    </div>
          <div class="nav-item dropdown">
      <a class="nav-link dropdown-toggle text-muted bg-light p-3 border-0" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false"><i class="icon ion-md-business lead mr-2"></i> Proveedor</a>
      <div class="dropdown-menu">
      <a href="../Proveedor/proveedor.php" class="list-group-item list-group-item-action text-muted bg-light p-3 border-0"><i class="icon ion-md-people lead mr-2"></i> Listar Proveedor</a>
      <a href="../Proveedor/nuevoProveedor.php" class="list-group-item list-group-item-action text-muted bg-light p-3 border-0"><i class="icon ion-md-person-add lead mr-2"></i> Agregar Proveedor</a> 
      </div>
    </div>
            <?php } else{
            if ($estadoUsuario->tipoUsuario == "Usuario") { ?>
            <a href="../VistaAdmin/listas.php" class="list-group-item list-group-item-action  active text-muted bg-faded p-3 border-0"><i
            class="icon ion-md-apps lead mr-2"></i> Usuario</a>
            <a href="../Usuario/busqueda.php" class="list-group-item list-group-item-action text-muted bg-light p-3 border-0"><i
            class="icon ion-md-search lead mr-2"></i> Busqueda de Pedido </a>
        <a href="../VistaAdmin/listas.php" class="list-group-item list-group-item-action text-muted bg-light p-3 border-0" id="alternar-menu"><i
            class="icon ion-md-people lead mr-2"></i> Vista del Rincon Emprendedor</a>
            <a href="../Producto/detalleAtencion.php" class="list-group-item list-group-item-action text-muted bg-light p-3 border-0" id="alternar-menu"><i
            class="icon ion-md-trending-up lead mr-2"></i> Atención</a>
            <a href="../Cliente/listaCliente.php" class="list-group-item list-group-item-action text-muted bg-light p-3 border-0" id="alternar-menu"><i
            class="icon ion-md-contacts lead mr-2"></i> Cliente</a>
        <a href="../Proveedor/adjuntarProveedor.php" class="list-group-item list-group-item-action text-muted bg-light p-3 border-0"><i
            class="icon ion-md-business lead mr-2"></i> Adjuntar al Proveedor</a>
        <a href="../Usuario/visualizarEnvios.php" class="list-group-item list-group-item-action text-muted bg-light p-3 border-0" id="alternar-menu"><i
            class="icon ion-md-eye lead mr-2"></i> Visualizacion de Envios</a> 
            <a href="../Email/mailProveedor.php" class="list-group-item list-group-item-action text-muted bg-light p-3 border-0"><i
            class="icon ion-md-mail lead mr-2"></i> Enviar Email </a>
      <?php  } else {
        if ($estadoUsuario->tipoUsuario == "Proveedor") { ?>
      <a href="../Proveedor/pedidoProveedor.php" class="list-group-item list-group-item-action  active text-muted bg-faded p-3 border-0"><i
            class="icon ion-md-apps lead mr-2"></i> Proveedor</a>
      <a href="../Proveedor/pedidoProveedor.php" class="list-group-item list-group-item-action text-muted bg-light p-3 border-0" id="alternar-menu"><i
            class="icon ion-md-cube lead mr-2"></i> Pedidos</a> 
      <?php
        }
      }
          } ?>
      </div>
    </div>
    <!-- Fin Menu -->

    <!-- Contenido -->
    <div id="page-content-wrapper" class="w-100 bg-light-blue">

      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <div class="container">
          <button class="btn btn-primary text-primary" id="menu-toggle">Mostrar / esconder menu</button>

          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
         <!--     <li class="nav-item active">
                <a class="nav-link text-dark" href="#">Inicio</a>
              </li> -->
              <li class="nav-item dropdown">
                <a class="nav-link text-dark dropdown-toggle" href="#" id="navbarDropdown" role="button"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 <?php echo $datoPersona->nombre; ?>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="../Usuario/perfil.php">Mi perfil</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="../Sessiones/logout.php">Cerrar sesión</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
<!-- Contenido de la Pagina -->
<div id="content" class="container-fluid p-5">
        <section class="py-3">
<script>
      $('.dropdown-toggle').dropdown();
</script>
