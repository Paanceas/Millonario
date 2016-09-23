<?php
require('../Controlador/clases/consultasAvanzadas.php');
session_start();
$_SESSION['verificaSesion'] = consultasAvanzadas::validarSession($_SESSION['id_usuario']);
$_SESSION['recuperar']      = consultasAvanzadas::recuperar($_SESSION['id_usuario']);

if ($_SESSION['validacion'] == 1 && $_SESSION['verificaSesion'] == 1) {
    $_SESSION['clicJugarSess'] = 0;
    //Si el usuario esta en recuperar pass no lo deja salir de esa vista

    if ($_SESSION['recuperar'] == 1) {
        header("location: ../Vistas/nuevaPass.php");
    } else {
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
        include "../Controlador/adminController.php";
        require('../Controlador/clases/mensajeJuego.php');

?>
 <title>Inicio</title>
</head>
<!--Deshabiilita inspeccionar elemento <body> -->
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
</script>
<body onmousedown="anularBotonDerecho(event); oncontextmenu="return false" onkeydown="return false"">

  <!-- header barra de navegacion -->
  <nav class="navbar" style="background:#238276">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="admin.php" style="padding:0;">
          <img alt="sena" src="../source/img/logo_sena.png" height="110%" width="62px"/>
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
  <!-- fin barra de navegacion -->
  <div class="container animated flipInX">
    <?php
        if (isset($_GET["MSN"])) {
            mensajeJuego::msnJuego($_GET["MSN"]);
        }
?>
 </div>
  <!-- contenido de la pagina -->
  <div class="contenidoPag">
    <h1> Quién quiere ser Millonario </h1>
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
                    <button type="submit" name="clicJugar" class="opcion encorefois"><p><span class="glyphicon glyphicon-play" aria-hidden="true"></span> JUGAR</p></button>
                 </div>
               </div>
            </fieldset>
          </form>
        </div>
      </div>
      <div class="col-md-1"></div>
      <div class="col-md-5">
        <table class="table ta  ble-striped table-hover" style="text-align:center">
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
  <!-- fin contenido de la pagina -->


<footer class="footer">
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
</body>
</html>
<?php
    }
} else {
    session_unset();
    session_destroy();
    header("location:../Vistas/formLogin.php?MSN=3");
}

?>
