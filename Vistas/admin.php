<?php
require('../Controlador/clases/consultasAvanzadas.php');
session_start();

$_SESSION['verificaSesion'] = consultasAvanzadas::validarSession($_SESSION['id_usuario']);
$_SESSION['recuperar']      = consultasAvanzadas::recuperar($_SESSION['id_usuario']);

if ($_SESSION['validacion'] == 1 && $_SESSION['verificaSesion'] == 1) {
    $_SESSION['clicJugarSess'] = 0;

    //Control tiempo de logueo
    $fechaActual=date('Y-m-d H:i:s');
    $tiempoTranscurrido = (strtotime($fechaActual) - strtotime($_SESSION['fechaIngreso']));
    //Hora Ingreso
    $fechaSoloHora = date('H:i', strtotime($_SESSION['fechaIngreso']));
    //Cierra sesión después de 3600 milisegundos = 60 minutos de inactividad
    if (isset($_SESSION['fechaIngreso'])) {
      if($tiempoTranscurrido >= 1500){
        header("location: /Controlador/logout.php");
      }else{
        $_SESSION['fechaIngreso']=$fechaActual;
      }
    }

    if ($_SESSION['id_roll'] == 1) {
      header("location: cargaMasiva");
    }
    //Si el usuario esta en recuperar pass no lo deja salir de esa vista
    if ($_SESSION['recuperar'] == 1) {
        header("location: ../Vistas/nuevaPass");
    } else {
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8"/>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

  <title>Autoevaluación</title>
  <link rel="stylesheet" href="../Bootstrap/css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="../source/css/animate.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="../source/css/estilos.css" media="screen" title="no title">
        <link rel="stylesheet" href="../source/css/style.css" media="screen" title="no title">
    <link rel="stylesheet" type="text/css" href="../source/jquery.fancybox.css?v=2.1.5" media="screen" />


<?php
        include "../Controlador/adminController.php";
        require('../Controlador/clases/mensajeJuego.php');

?>
<link href='../source/img/favicon.ico' rel='icon' type='image/x-icon'/>

</head>

<script type="text/javascript">
document.oncontextmenu=inhabilitar;

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
</script>
<body onmousedown="anularBotonDerecho(event); oncontextmenu="return false" onkeydown="return false"" >
  <audio src="../source/sonidos/intro.mp3" preload autoplay="true"></audio>

<!-- barra de navegacion -->
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
<li> <a> <b>Último juego:</b> <?php echo $_SESSION['fecha']; ?> </a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <form class="navbar-form navbar-left" action="../Controlador/logout.php">
        <center>
          <button type="submit" class="btn btn-success" >
            SALIR <span class="glyphicon glyphicon-log-out"></span>
          </button>
      </center>
     </form>
    </ul>
  </div>
</div>
</nav>

  <!-- fin barra de navegacion -->
  <div class="container animated flipInX">
    <?php
        if (isset($_SESSION["MSN"])) {
            mensajeJuego::msnJuego($_SESSION["MSN"]);
        }
?>
 </div>
  <!-- contenido de la pagina -->
  <div class="contenidoPag">
    <h1> Quién quiere ser Ganador </h1>
    <div class="row">
      <div class="col-md-7">
        <div class="well bs-component">
          <form class="form-horizontal" action="../Controlador/cargaPreguntas.php" method="post">
            <fieldset>
              <legend>Información</legend>
              <p>
                A continuación encontrarás una serie de preguntas el cual debes contestar de acuerdo a tu conocimiento, dale click en Jugar y buena suerte.
              </p>
             <div class="form-group">
                 <div class="col-lg-10 col-lg-offset-2">
                   <input type="hidden" id="respCorrec" name="respCorrec" value="0"/>
                   <input type="hidden" name="respSeleccionada" id="respSeleccionada" value="0"/>
                   <input type="hidden" name="intento" id="intento" value="1"/>
                   <input type="hidden" name="searchQuestion" value="ok"/>
                    <button type="submit" name="clicJugar" class="opcion encorefois" ><p><span class="glyphicon glyphicon-play" aria-hidden="true"></span> JUGAR</p></button>
                 </div>
               </div>
            </fieldset>
          </form>
        </div>
      </div>
      <div class="col-md-1"></div>
      <div class="col-md-5">
        <h3 style="margin-top:-5px; text-align:center;">Ranking</h3>
        <div class="table-responsive" style="font-size:13px;">
          <table class="table table-hover" style="text-align:center">
            <thead>
              <tr class="success">
                <th><center>Puesto</center> </th>
                <th><center>Récord</center> </th>
                <th><center>Nombres</center></th>
                <th><center>Programa</center></th>
              </tr>
            </thead>
            <tbody>
              <?php echo ranking() ?>
            </tbody>
          </table>
        </div>
     </div>
  </div>

  </div>
  <!-- fin contenido de la pagina -->


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

<!-- <footer class="footer-distributed">


  <div class="footer-left">

    <p class="footer-links">
      <a href="#">Inicio</a>
      ·
      <a href="#">Instrucciones</a>
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
        </footer> -->


</body>
</html>
<?php
    }
} else {
    session_unset();
    header("location:index");
    $_SESSION['MSNLogin']=2;
}

?>
