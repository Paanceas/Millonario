<?php
session_start();
if($_SESSION['validacion']==1 && $_SESSION['id_usuario']>0){
$usuario=$_SESSION['id_usuario'];
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
<body onLoad="timer()">
<h1>Bienvenido Aprendiz</h1>
<button type="submit" onclick = "location='../Controlador/logout.php'" class="btn btn-primary" >Salir</button>
<div>
<form class="" action="../Controlador/cargaPreguntas.php" method="post">


<table border="2" style="margin-top: 180px;">
<tr><td colspan="4"><center><?php echo $preguntas; ?></center></td></tr>



<tr>
  <?php echo $respuesta; ?>
</tr>
</th>
</table>



<article class="gameTime">
  <img src="../source/img/pje1.png" class="picTime">
  <h2><div id="contador"></div><h2>

</article>

<input type="hidden" id="respCorrec" name="respCorrec" value="<?php echo $idRespuesta ?>"/>
<input type="hidden" name="respSeleccionada" id="respSeleccionada" />
</form>
<script type="text/javascript">
  function vp(num) {
    $selectAnswer = document.getElementById("respSeleccionada");
    $selectAnswer.value = num;
    switch (num) {
      case 1:
        alert ('Correcto!!');
        break;
      default:
        alert ('Respuesta Incorrecta');
        break;
    }
  }

  function timer(){
  var t=setTimeout("timer()",1000);
  document.getElementById('contador').innerHTML = ''+i--+" ";
  if (i==-1){
    document.getElementById('contador').innerHTML = 'FIN';
    clearTimeout(t);
    alert('perdio');
  }
}
i=2;

</script>
</body>
</html>
<?php
}else{
  header('location:../Vistas/formLogin.php');
}
?>
