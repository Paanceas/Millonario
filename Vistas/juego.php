<?php
session_start();
if($_SESSION['validacion']==1 && $_SESSION['id_usuario']>0){
$usuario=$_SESSION['id_usuario'];
//Clic en jugar
var_dump($_SESSION['jugar']);
if($_SESSION['jugar'] === 1){



//Valida intentos
if ($_SESSION['intentos'] <= 1) {
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta content="charset=utf-8"/>

  <link rel="stylesheet" href="../Bootstrap/css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="../source/css/animate.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="../source/css/estilos.css" media="screen" title="no title">

    <link rel="stylesheet" type="text/css" href="../source/jquery.fancybox.css?v=2.1.5" media="screen" />

<?php
include "modalinstrucc.php";
@include('../Controlador/cargaPreguntas.php');
?>
	<title>Inicio</title>
</head>
<body onLoad="timer()" onmousedown="anularBotonDerecho(event); oncontextmenu="return false" onkeydown="return false"">
  <!-- header barra de navegacion -->
  <nav class="navbar" style="background:#238276">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="admin.php" style="padding:0;">
          <img alt="sena" src="../source/img/logo_sena.png" height="100%" width="60px"/>
        </a>
      </div>
      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li> <a> Bienvenido: <?php echo $_SESSION['nombreAprendiz'] ?></a> </li>
          <li> <a> Programa: <?php echo $_SESSION['programaAprendiz'] ?> </a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <form class="navbar-form navbar-left" action="../Controlador/logout.php">

           <button type="submit" class="btn btn-success" >
            Salir <span class="glyphicon glyphicon-log-out"></span>
           </button>
         </form>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
  <!-- fin barra de navegacion -->
<div class="gameSelect">
<form class="" action="../Controlador/cargaPreguntas.php" method="post">


    <div class="answere">
      <h1><?php echo $preguntas; ?><h1>

    <?php echo $respuesta; ?>
  </div>

<input type="hidden" id="respCorrec" name="respCorrec" value="<?php echo $idRespuesta ?>"/>
<input type="hidden" name="respSeleccionada" id="respSeleccionada" />
<input type="hidden" name="jugar" id="jugar" value="1"/>

</form>
  </div>

<div class="gameTime">
  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
</div>


<footer>
  <a class="fancybox" href="#inline1" title="Instrucciones">Instrucciones</a>
  <div id="inline1" style="width:800px;display: none;">
  <h3>Instrucciones</h3>
  <img src="../source/img/instrucciones.png" width="800px"/>
  </div>
</footer>
<!-- Add fancyBox main JS and CSS files -->
<script src="../Bootstrap/js/jquery-1.10.2.min.js"></script>
<script src="../Bootstrap/js/bootstrap.min.js"></script>
  <!-- <script type="text/javascript" src="../source/jquery-1.10.1.min.js"></script> -->
<script type="text/javascript" src="../source/jquery.fancybox.js?v=2.1.5"></script>
<script type="text/javascript">
$(document).ready(function() {
  			$('.fancybox').fancybox();
});
</script>
<script type="text/javascript">
document.oncontextmenu=inhabilitar;
//Deshabiilita clic derecho de toda la pagina
document.onmousedown=anularBotonDerecho;
document.oncontextmenu=new Function("return false");
// function inhabilitar(){
//    	alert ("Esta función está inhabilitada.\n\nPerdonen las molestias.")
//    	return false
// }
// function anularBotonDerecho(e) {
//  if (navigator.appName == 'Netscape'
//        && (e.which == 3 || e.which == 2)){
//    alert(sMensaje);
//    return false;
//  } else if (navigator.appName == 'Microsoft Internet Explorer'
//        && (event.button == 2)) {
//    alert(sMensaje);
//  }
// }
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

//   function timer(){
//   var t=setTimeout("timer()",1000);
//   document.getElementById('contador').innerHTML = ''+i--+" ";
//   if (i==-1){
//     document.getElementById('contador').innerHTML = 'FIN';
//     clearTimeout(t);
//     alert('Su Tiempo se acabó');
//     location.href='finJuego.php';
//   }
// }
// i=2;

</script>
</body>
</html>
<?php

  }else {
      header('location:../Vistas/admin.php?MSN=2');
  }
}else {
  $_SESSION['jugar']=1;
header('location:../Vistas/admin.php?MSN=3');
}

}else{
  header('location:../Vistas/formLogin.php');
}
?>
