
<?php

if (isset($_GET['t']) && $_GET['t'] == "off") {
  $timeOff = 'swal("Se agoto el tiempo", "Vuelve a jugando!", "error");';
}



session_start();
if($_SESSION['validacion']==1 && $_SESSION['id_usuario']>0){
$usuario=$_SESSION['id_usuario'];
$_SESSION['clicJugarSess'] = 0;

if ($_SESSION['recuperar'] == 1) {
    header("location: ../Vistas/nuevaPass.php");
} else {
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../Bootstrap/css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="../source/css/animate.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="../source/css/estilos.css" media="screen" title="no title">
    <link rel="stylesheet" href="../source/css/style.css" media="screen" title="no title">
    <link rel="stylesheet" href="../source/css/sweetalert.css" media="screen" title="no title">
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
  <?php
  /////////////////////////////////////////////////////////////////////
  // This is the only portion of the code you may need to change.
  // Indicate the location of your images
  $root = '';
  // use if specifying path from root
  //$root = $_SERVER['DOCUMENT_ROOT'];

  $path = '../source/img/gameOver/';

  // End of user modified section
  /////////////////////////////////////////////////////////////////////

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
          <a class="navbar-brand" href="admin.php" style="padding:0;">
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
        <ul class="nav navbar-nav navbar-right">
          <form class="navbar-form navbar-left" action="../Controlador/logout.php">

           <button type="submit" class="btn btn-success" >
            Salir <span class="glyphicon glyphicon-log-out"></span>
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
          <a href="../Vistas/admin.php" class="opcion encorefois">
            <p class="endTitle">
                Ver Puntaje
            </p>
          </a>
          <a href="../Controlador/logout.php" class="opcion encorefois">
            <p class="endTitle"><span class="glyphicon glyphicon-play" aria-hidden="true"></span> Salir</p>
          </a>
        </div>
      </div>
      <div class="gameTimeFinJuego">
        <img src="../source/img/personaje.png" class="picTimFinJuego">
        <h2>Perdió</h2>
      </div>
    </section>


    <footer class="footer-distributed">


      <div class="footer-left">

        <p class="footer-links">
          <a href="#">Inicio</a>
          ·
          <a class="fancybox" href="#inline1" title="Instrucciones">Instrucciones</a>
          ·
          <a href="#">Créditos</a>
        </p>

        <p>SENA &copy; 2016</p>
      </div>


            <div class="footer-right">

              <a href="#"><img src="../source/img/footer/icontecA.png" width="61" height="107"/></a>
              <a href="#"><img src="../source/img/footer/icontecB.png" width="79" height="106"/></a>
              <a href="#"><img src="../source/img/footer/icontecC.png" width="61" height="107"/></a>
              <a href="#"><img src="../source/img/footer/icontecD.png" width="79" height="106"/></a>

            </div>
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
    <script src="../source/js/sweetalert.min.js"></script>
    <?php

    echo '<script type="text/javascript">';
        if (isset($timeOff)) {
          echo $timeOff;
        }else {
          echo 'swal("Respuesta Incorrecta", "Vuelve a jugando!", "error");';
        }

      echo "</script>";
      ?>
  </body>
</html>
<?php
}
}else{
  session_destroy();
  header('location:../Vistas/index.php?MSNLogin=2');
}

?>
