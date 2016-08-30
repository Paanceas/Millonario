<?php
session_start();
if($_SESSION['validacion']==1){


 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
<?php

include "modalinstrucc.php";
@include('../Controlador/cargaPreguntas.php');

?>


	<title>Inicio</title>
</head>
<body>
<h1>Bienvenido Aprendiz</h1>
<form action="../Controlador/logout.php">
	<button type="submit" class="btn btn-primary" >Salir</button>
</form>
<div><?php echo $tipoIdentificacion; ?></div>

</body>
</html>
<?php
}else{
  header('location:../Vistas/formLogin.php');
}
?>
