<?php
session_start();

if (isset($_SESSION['resCor']) && $_SESSION['resCor'] == 2 ) {
  $timeOff = 'swal("Se agotó el tiempo", "Vuelve a intentarlo!", "error");';
}elseif (isset($_SESSION['resCor']) && $_SESSION['resCor'] == 4 ) {
  $recarga = 'swal("No recargues la página", "Menos un intento!", "error");';
}


if($_SESSION['validacion']==1 && $_SESSION['id_usuario']>0 && $_SESSION['id_roll'] == 2){
$usuario=$_SESSION['id_usuario'];
$_SESSION['clicJugarSess'] = 0;

if ($_SESSION['recuperar'] == 1) {
    header("location: ../Vistas/nuevaPass");
} else {
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="../Bootstrap/css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="../source/css/animate.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="../source/css/estilos.css" media="screen" title="no title">
    <link rel="stylesheet" href="../source/css/style.css" media="screen" title="no title">
    <link rel="stylesheet" href="../source/css/sweetalert.css" media="screen" title="no title">
    <link href='../source/img/favicon.ico' rel='icon' type='image/x-icon'/>

    <title>Fin</title>
    <?php include "modalinstrucc.php"; ?>

  </head>
  <style type="text/css">
.gameTimeFinJuego{
  width: 400px;
height: 587px;
float: left;
position: relative;
}
.gameTimeFinJuego  h2{
  position: absolute;
  top:305px;
  left: 97px;
  font-family: 'Metrophobic', Arial, serif;
  color: #fff;
  font-size: 40px;
  background: #238276;
}

.gameSelectFin{
  width:800px;
  height: 600px;
  float: left;
}

.picTimFinJuego{
  width:260px;
  margin: 55px 0 0 20px;
}
  </style>


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
  <?php
  $root = '';
  $path = '../source/img/gameOver/';



  function getImagesFromDir($path) {
      $images = array();
      if ( $img_dir = @opendir($path) ) {
          while ( false !== ($img_file = readdir($img_dir)) ) {
              // checks for gif, jpg, png
              if ( preg_match("/(\.gif|\.jpg|\.png|\.jpeg)$/", $img_file) ) {
                  $images[] = $img_file;
              }
          }
          closedir($img_dir);
      }
      return $images;
  }

  function getRandomFromArray($ar) {
      mt_srand( (double)microtime() * 1000000 ); // php 4.2+ not needed
      $num = array_rand($ar);
      return $ar[$num];
  }

  // Obtain list of images from directory
  $imgList = getImagesFromDir($root . $path);

  $img = getRandomFromArray($imgList);

  ?>
  <body onmousedown="anularBotonDerecho(event); oncontextmenu="return false" onkeydown="return false"">
    <audio src="../source/sonidos/<?php echo rand(1,2).".mp3" ?>" preload autoplay="true"></audio>
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
          <li> <a>   <b>Bienvenid@: </b><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php
        echo $_SESSION['nombreAprendiz'];
    ?></a> </li>
          <li> <a> <b>Programa:</b> <span class="glyphicon glyphicon-education" aria-hidden="true"></span>   <?php
        echo $_SESSION['programaAprendiz'];
    ?> </a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <form class="navbar-form navbar-left" action="../Controlador/logout.php">

           <button type="submit" class="btn btn-success" >
            SALIR <span class="glyphicon glyphicon-log-out"></span>
           </button>
         </form>
        </ul>
      </div>
    </div>
    </nav>

      <!-- fin barra de navegacion -->


    <section class="gameC">
      <div class="gameSelectFin">
        <div class="answere">
          <img src="<?php echo $path . $img ?>" alt="" style="    width: 72%; height: 311px; position: static; margin: 0% 31% 29% 15%; border-radius: 10px;"/>
        </div>
        <div class="finDelJuego" style="display:flex">
          <a href="../Vistas/admin" class="opcion encorefois">
            <p class="endTitle"><span class="glyphicon glyphicon-play" aria-hidden="true"></span>
                Ver Puntaje
            </p>
          </a>
          <a href="../Controlador/logout.php" class="opcion encorefois">
            <p class="endTitle"> Salir <span class="glyphicon glyphicon-log-out"></span></p>
          </a>
        </div>
      </div>
      <div class="gameTimeFinJuego">
        <img src="../source/img/personaje.png" class="picTimFinJuego">
        <h2>Perdió</h2>
      </div>
    </section>


    <!-- <footer class="footer-distributed">

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
    </footer> -->


    <!-- Add fancyBox main JS and CSS files -->
    <script src="../Bootstrap/js/jquery-1.10.2.min.js"></script>
    <script src="../Bootstrap/js/bootstrap.min.js"></script>
      <!-- <script type="text/javascript" src="../source/jquery-1.10.1.min.js"></script> -->
    <script type="text/javascript" src="../source/jquery.fancybox.js?v=2.1.5"></script>
    <script src="../source/js/sweetalert.min.js"></script>
    <?php

    echo '<script type="text/javascript">';
        if (isset($timeOff)) {
          echo $timeOff;
        }else if (isset($recarga)){
        echo $recarga;
        }
        else {
          echo 'swal("Respuesta Incorrecta!", "vuelve a intentarlo!", "error");';
        }

      echo "</script>";
      ?>
  </body>
</html>
<?php
}
}else{
  header('location:../Vistas/index');
  $_SESSION["MSNLogin"]=2;
}

?>
