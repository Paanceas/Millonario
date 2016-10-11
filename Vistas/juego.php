<?php
require('../Controlador/clases/consultasAvanzadas.php');

session_start();

$_COOKIE['ID'] = session_id();
if($_COOKIE['ID'] != session_id()){
  header("location:index");
}
if (isset($_SESSION['resCor']) && $_SESSION['resCor'] == 1 ) {
$bien = 'swal("Respuesta Correcta", "continua jugando!", "success");';
}

$_SESSION['verificaSesion'] = consultasAvanzadas::validarSession($_SESSION['id_usuario']);

if($_SESSION['validacion']==1 && $_SESSION['id_usuario'] > 0 && $_SESSION['verificaSesion'] == 1){
$usuario=$_SESSION['id_usuario'];
//Clic en jugar
if($_SESSION['clicJugarSess'] != 1){
  header('location:../Vistas/admin');
  $_SESSION['MSN']=4;
}


//Valida intentos
if ($_SESSION['intentos'] <= 1 && $_SESSION['verificaGanador'] != 1) {

 ?>
<!DOCTYPE html>
<html>
<head>
  <meta content="charset=utf-8"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="../Bootstrap/css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="../source/css/animate.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="../source/css/estilos.css" media="screen" title="no title">
    <link rel="stylesheet" href="../source/css/style.css" media="screen" title="no title">
      <link rel="stylesheet" href="../source/css/sweetalert.css" media="screen" title="no title">

    <link rel="stylesheet" type="text/css" href="../source/jquery.fancybox.css?v=2.1.5" media="screen" />

<?php
include "modalinstrucc.php";
@include('../Controlador/cargaPreguntas.php');
?>
	<title>Inicio</title>
  <link href='../source/img/favicon.ico' rel='icon' type='image/x-icon'/>

</head>
<!--Deshabiilita inspeccionar elemento <body> -->

<script type="text/javascript">

//Deshabiilita clic derecho de toda la pagina
// document.onmousedown=anularBotonDerecho;
// document.oncontextmenu=new Function("return false");
//
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

setTimeout ("location.href='finJuego'", 30000);


</script>
<body onLoad="timer()">

<!--  onmousedown="anularBotonDerecho(event); oncontextmenu="return false" onkeydown="return false"" -->
  <nav class="navbar navbar-inverse navbar-juego">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <div class="navbar-header">
        <a class="navbar-brand" href="admin" style="padding:0;">
          <img alt="sena" src="../source/img/logo_sena.png" height="90%" width="52px"/>
        </a>
      </div>
    </div>

    <div class="navbar-collapse collapse" id="bs-example-navbar-collapse-1" aria-expanded="false" style="height: 1px;">
      <ul class="nav navbar-nav">
        <li> <a>   Bienvenid@: <span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php
      echo $_SESSION['nombreAprendiz'];
  ?></a> </li>
        <li> <a> Programa: <span class="glyphicon glyphicon-education" aria-hidden="true"></span>   <?php
      echo $_SESSION['programaAprendiz'];
  ?> </a></li>
      </ul>

    </div>
  </div>
  </nav>

<form class="" action="../Controlador/cargaPreguntas.php" method="post">

  <div class="vistaJuego">
    <div class="tiempoJuego">
      <h2 class="titulo"><div id="contador"></div><h2>
    </div>
    <div style="font-size: 33px;">
    <?php echo $resultadoAGanar; ?>
  </div>
    <div class="pregunta">
      <?php echo utf8_encode($preguntas); ?>
    </div>
  </div>
  <div class="vistaJuego">
    <?php echo utf8_encode($respuesta); ?>
  </div>



<input type="text" id="respCorrec" name="respCorrec" value="<?php echo $idRespuesta ?>"/>
<input type="text" name="respSeleccionada" id="respSeleccionada" />

</form>


<br><br>
<footer class="footer-distributed">


  <div class="footer-left">


      <p class="footer-links">
        <a href="#">Inicio</a>
        ·
        <a class="fancybox" href="#inline1" title="Instrucciones">Instrucciones</a>
        ·
        <a href="#">Créditos</a>
      </p>


    </div>

    <div class="footer-left">
            <p class="footer-links">SENA - Centro de Gestión de Mercados, Logística y TI, Distrito Capital</p>
          </div>
                <div id="inline1" style="width:800px;display: none;">
                <h3>Instrucciones</h3>
                <img src="../source/img/instrucciones.png" width="800px"/>
                </div>
        </footer>


<script type="text/javascript">
  function vp(num) {
    $selectAnswer = document.getElementById("respSeleccionada");
    $selectAnswer.value = num;

    // switch (num) {
    //   case 1:
    //     swal("Respuesta Correcta", "continua jugando!", "success");
    //     break;
    //   default:
    //     swal("Respuesta Incorrecta", "Vuelve a jugando!", "error");
    //     break;
    // }
  }

  function timer(){
  var t=setTimeout("timer()",900);
  document.getElementById('contador').innerHTML = ''+i--+" ";

  if (i==-1){
    document.getElementById('contador').innerHTML = 'FIN';
    clearTimeout(t);
    location.href='finJuego';
    <?php $_SESSION['resCor']=2; ?>
  }

}
i=30;


</script>
<!-- Add fancyBox main JS and CSS files -->
<script src="../Bootstrap/js/jquery-1.10.2.min.js"></script>
<script src="../Bootstrap/js/bootstrap.min.js"></script>
<script src="../source/js/sweetalert.min.js"></script>
<script src="../source/js/sweetalert.min.js"></script>
  <!-- <script type="text/javascript" src="../source/jquery-1.10.1.min.js"></script> -->
<script type="text/javascript" src="../source/jquery.fancybox.js?v=2.1.5"></script>

<?php
  if (isset($bien)||isset($mal)) {
    if (isset($bien)) {
      $imprimir = $bien;
    }else {
      $imprimir = $mal;
    }
    echo '<script type="text/javascript">';
    echo $imprimir;
    echo "</script>";
  }
  $_SESSION['r1']=0;
 ?>
 <div>
   <div>
 <script type="text/javascript">
 setTimeout ("location.href='finJuego'", 29999);

 </script>
</div>
 </div>
</body>
</html>
<?php

  }else {
      header('location:../Vistas/admin');
      $_SESSION['MSN']=2;
  }


}else{
  header('location:../Vistas/index');
  $_SESSION['MSNLogin']=2;
}
?>
