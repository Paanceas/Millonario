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


<div>
<table border=2>
<th><?php echo $preguntas; ?>
  <td><?php echo $respuesta; ?></td>
</th>
</table>


</body>
</html>
<?php
}else{
  header('location:../Vistas/formLogin.php');
}
?>
