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

	<button type="submit" onclick = "location='../Controlador/logout.php'" class="btn btn-primary" >Salir</button>


<div><?php echo $preguntas; ?></div>
<div><?php echo $respuesta; ?></div>

</body>
</html>
<?php
}else{
  header('location:../Vistas/formLogin.php');
}
?>
