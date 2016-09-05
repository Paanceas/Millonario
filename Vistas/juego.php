<?php
session_start();
if($_SESSION['validacion']==1 && $_SESSION['id_usuario']>0){
$usuario=$_SESSION['id_usuario'];
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="../source/css/estilos.css" media="screen" title="no title">

<?php
include "modalinstrucc.php";
@include('../Controlador/cargaPreguntas.php');
?>
	<title>Inicio</title>
</head>
<body onLoad="timer()" onmousedown="anularBotonDerecho(event); oncontextmenu="return false" onkeydown="return false"">
<h1>Bienvenido Aprendiz</h1>
<button type="submit" onclick = "location='../Controlador/logout.php'" class="btn btn-primary" >Salir</button>
<div>

<form class="" action="../Controlador/cargaPreguntas.php" method="post">

  <article class="gameTimeJuego">
    <img src="../source/img/pje1.png" class="picTimeJuego">
    <h2><div id="contador"></div><h2>

  </article>
<table border="0" style="margin-top: 290px; color:black;">
<tr><td colspan="4">
  <div class="contenidoPregunta">
<center><?php echo $preguntas; ?></center>
</div></td></tr>
<tr>
  <?php echo $respuesta; ?>
</tr>

</table>



<input type="hidden" id="respCorrec" name="respCorrec" value="<?php echo $idRespuesta ?>"/>
<input type="hidden" name="respSeleccionada" id="respSeleccionada" />
</form>
<script type="text/javascript">
document.oncontextmenu=inhabilitar;
//Deshabiilita clic derecho de toda la pagina
document.onmousedown=anularBotonDerecho;
document.oncontextmenu=new Function("return false");
function inhabilitar(){
   	alert ("Esta función está inhabilitada.\n\nPerdonen las molestias.")
   	return false
}
function anularBotonDerecho(e) {
 if (navigator.appName == 'Netscape'
       && (e.which == 3 || e.which == 2)){
   alert(sMensaje);
   return false;
 } else if (navigator.appName == 'Microsoft Internet Explorer'
       && (event.button == 2)) {
   alert(sMensaje);
 }
}
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
    alert('Su Tiempo se acabó');
    location.href='finJuego.php';
  }
}
i=60;

</script>
</body>
</html>
<?php
}else{
  header('location:../Vistas/formLogin.php');
}
?>
