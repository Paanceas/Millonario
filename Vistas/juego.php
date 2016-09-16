<?php
// require('../Controlador/clases/consultasAvanzadas.php');
session_start();
// $_SESSION['verificaSesion'] = consultasAvanzadas::validarSession($_SESSION['id_usuario']);
// var_dump($_SESSION['verificaSesion']);
if($_SESSION['validacion']==1 && $_SESSION['id_usuario'] > 0){
$usuario=$_SESSION['id_usuario'];
//Clic en jugar
if($_SESSION['clicJugarSess'] != 1){
  header('location:../Vistas/admin.php?MSN=4');
}


//Valida intentos
if ($_SESSION['intentos'] <= 1 && $_SESSION['verificaGanador'] != 1) {

 ?>
<!DOCTYPE html>
<html>
<head>
  <meta content="charset=utf-8"/>

  <link rel="stylesheet" href="../Bootstrap/css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="../source/css/animate.css" media="screen" title="no title" charset="utf-8">
    <!-- <link rel="stylesheet" href="../source/css/estilos.css" media="screen" title="no title"> -->

    <link rel="stylesheet" type="text/css" href="../source/jquery.fancybox.css?v=2.1.5" media="screen" />

<?php
include "modalinstrucc.php";
@include('../Controlador/cargaPreguntas.php');
?>
	<title>Inicio</title>
</head>
<!--Deshabiilita inspeccionar elemento <body> -->
<script type="text/javascript">

//Deshabiilita clic derecho de toda la pagina
document.onmousedown=anularBotonDerecho;
document.oncontextmenu=new Function("return false");

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
</script>
<body onLoad="timer()" onmousedown="anularBotonDerecho(event); oncontextmenu="return false" onkeydown="return false"">

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
          <li> <a>   Bienvenid@: <span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php
    echo $_SESSION['nombreAprendiz'];
  ?></a> </li>
          <li> <a> Programa: <span class="glyphicon glyphicon-education" aria-hidden="true"></span>   <?php
    echo $_SESSION['programaAprendiz'];
  ?> </a></li>
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
<form class="" action="../Controlador/cargaPreguntas.php" method="post">



  <div class="contenidoPagJuego">
    <article class="gameTimeJuego">
      <img src="../source/img/pje1.png" class="picTimeJuego">
      <h2><div id="contador"></div><h2>
    </article>
<table border="2" style="margin-top: 288px; width: 99%">
<tr><td colspan="4"><center><h2><?php echo $preguntas; ?></h2></center></td></tr>
<tr>
  <h1><?php echo $respuesta; ?></h1>
</tr>
</th>
</table>
</div>

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
    alert('Su Tiempo se acabó');
    location.href='finJuego.php';
  }

}
i=60;


</script>

</body>
</html>
<?php

  }else {
      header('location:../Vistas/admin.php?MSN=2');
  }


}else{
  header('location:../Vistas/formLogin.php?MSN=2');
}
?>
