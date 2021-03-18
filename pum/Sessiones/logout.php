<?php 
	session_start();
	session_destroy();
	header("Location:../Login/formulario_login.php");
 ?>