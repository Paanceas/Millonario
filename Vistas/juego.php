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
<form class="" action="../Controlador/cargaPreguntas.php" method="post">


<table border="2">
<tr><td colspan="4"><center><?php echo $preguntas; ?></center></td></tr>
<tr>
  <?php echo $respuesta; ?>
</tr>
</th>
</table>
<input type="hidden" id="respCorrec" name="respCorrec"/>
</form>
<script type="text/javascript">

  var hiddenVar = document.getElementById('respCorrec');


  function vp(num) {
    if (num == 1) {
      hiddenVar.value = num;
    }else {
      hiddenVar.value = 2;
    }
    switch (num) {
      case 1:
        alert ('muy bien esa es la correcta');
        break;
      default:
        alert ('esta mal estudie');
        break;
    }
  }
</script>
</body>
</html>
<?php
}else{
  header('location:../Vistas/formLogin.php');
}
?>
