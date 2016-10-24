<?php
require('../Controlador/clases/consultasAvanzadas.php');

if (!isset($_SESSION)) {
    session_start();
}

$_COOKIE['ID'] = session_id();
if ($_COOKIE['ID'] != session_id()) {
    header("location:index");
}
if (isset($_SESSION['resCor']) && $_SESSION['resCor'] == 1) {
    $bien = 'swal("Respuesta Correcta", "continua jugando!", "success");';
}
//Si refresca la página pierde
if (isset($_SESSION['respuestaSelecciionada']) && $_SESSION['respuestaSelecciionada'] == 0) {
    $_SESSION['resCor'] = 4;
    echo '<script type="text/javascript">';
    echo "location.href='finJuego';";
    echo '</script>';
    exit();
}

$_SESSION['verificaSesion'] = consultasAvanzadas::validarSession($_SESSION['id_usuario']);

if ($_SESSION['validacion'] == 1 && $_SESSION['id_usuario'] > 0 && $_SESSION['verificaSesion'] == 1) {
    $usuario = $_SESSION['id_usuario'];
    //Clic en jugar
    if ($_SESSION['clicJugarSess'] != 1) {
        header('location:../Vistas/admin');
        $_SESSION['MSN'] = 4;
    }

    //Valida intentos
    if ($_SESSION['intentos'] <= 1 && $_SESSION['verificaGanador'] != 1) {



?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta content="charset=utf-8"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="../Bootstrap/css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="../source/css/animate.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="../source/css/estilos.css" media="screen" title="no title">
    <link rel="stylesheet" href="../source/css/style.css" media="screen" title="no title">
    <link rel="stylesheet" href="../source/css/sweetalert.css" media="screen" title="no title">
    <link rel="stylesheet" href="../source/css/font-awesome.min.css" media="screen" title="no title">
    <script src="../source/js/got.js"></script>
    <style media="screen">
    .estrellas{
      background-color: rgba(36, 147, 109, 0.52);
      border-radius: 30px;
      margin: 5px 10% 10px 10%;
      padding: 5px;
      width: 80%;
    }
    .estrellas .fa{
      color: rgb(0, 255, 140);
      font-size: 3em;
      width: 5%;
    }
    </style>
    <link rel="stylesheet" type="text/css" href="../source/jquery.fancybox.css?v=2.1.5" media="screen" />

<?php
        include "modalinstrucc.php";
        @include('../Controlador/cargaPreguntas.php');
?>
   <title>Inicio</title>
  <link href='../source/img/favicon.ico' rel='icon' type='image/x-icon'/>

</head>


<div>
<script type="text/javascript">
setTimeout('tr()', 30001);
function tr(){
 location.href='finJuego';
}
</script>
</div>
<div>
  <div>
  <div>
<script type="text/javascript">

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
</div>
</div>
</div>

<body onLoad="timer()" onmousedown="anularBotonDerecho(event); oncontextmenu="return false" onkeydown="return false"">
  <audio src="../source/sonidos/<?php echo rand(98,99).".mp3" ?>" loop="true" preload autoplay="true"></audio>


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
        <li> <a>   <b>Bienvenid@:</b> <span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php
        echo $_SESSION['nombreAprendiz'];
?></a> </li>
        <li> <a> <b>Programa: </b><span class="glyphicon glyphicon-education" aria-hidden="true"></span>   <?php
        echo $_SESSION['programaAprendiz'];
?> </a></li>
      </ul>

    </div>
  </div>
  </nav>
  <div class="estrellas">
<?php
        $cont = 20 - $resultadoAGanar;
        for ($i = 0; $i < $cont; $i++) {
            echo '<i class="fa fa-check-circle-o animated zoomInRight" aria-hidden="true"></i>';
        }
        for ($i = 0; $i < $resultadoAGanar; $i++) {
            echo '<i class="fa fa-circle-o animated zoomInRight" aria-hidden="true"></i>';
        }
?>
</div>


<form class="" action="../Controlador/cargaPreguntas.php" method="post">
  <div class="vistaJuego">
    <div class="tiempoJuego">
      <h2 class="titulo"><div id="contador">
        <img src="../source/img/personaje2.png" width="100%" />
      </div><h2>
    </div>
    <div style="font-size: 33px;">
  </div>
    <div class="pregunta">
      <?php
        echo utf8_encode($preguntas);
        ?>
   </div>
  </div>
  <div class="vistaJuego">
    <?php
        echo utf8_encode($respuesta);
?>
 </div>

<input type="hidden" id="respCorrec" name="respCorrec" value="<?php
        echo $idRespuesta;
?>"/>
<input type="hidden" name="respSeleccionada" id="respSeleccionada" />
<input type="hidden" name="searchQuestion" value="oki"/>

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

<div>
  <div>
<script type="text/javascript">

  function vp(num) {
    $selectAnswer = document.getElementById("respSeleccionada");
    $selectAnswer.value = num;
  }

  function timer(){
  var t=setTimeout("timer()",900);
  document.getElementById('contador').innerHTML = ''+i--+" ";

  if (i==-1){
    document.getElementById('contador').innerHTML = 'FIN';
    clearTimeout(t);
    location.href='finJuego';
    <?php
        $_SESSION['resCor'] = 2;
?>
 }
}
i=30;

</script>

</div>
</div>
<!-- Add fancyBox main JS and CSS files -->
<script src="../Bootstrap/js/jquery-1.10.2.min.js"></script>
<script src="../Bootstrap/js/bootstrap.min.js"></script>
<script src="../source/js/sweetalert.min.js"></script>
<script src="../source/js/sweetalert.min.js"></script>
  <!-- <script type="text/javascript" src="../source/jquery-1.10.1.min.js"></script> -->
<script type="text/javascript" src="../source/jquery.fancybox.js?v=2.1.5"></script>

<?php

        if (isset($bien) || isset($mal)) {
            if (isset($bien)) {
                $imprimir = $bien;
            } else {
                $imprimir = $mal;
            }
            echo '<script type="text/javascript">';
            echo $imprimir;
            echo "</script>";
        }
        $_SESSION['r1'] = 0;
?>


 <div>
 <div>
   <div>
     <div>
     <div>
 <script>
    setTimeout('tr()', 30001);
  function tr(){
      location.href='finJuego';
    }
 </script>
 </div>
</div>
</div>
</div>
</div>


</body>

</div>
</html>
<?php
        //Apenas ingresa la convierte a cero sesión de recarga
        if ($_SESSION['respuestaSelecciionada'] == 2) {
            $_SESSION['respuestaSelecciionada'] = 0;
        }

    } else {
        header('location:../Vistas/admin');
        $_SESSION['MSN'] = 2;
    }

} else {
    header('location:../Vistas/index');
    $_SESSION['MSNLogin'] = 2;
}
?>
