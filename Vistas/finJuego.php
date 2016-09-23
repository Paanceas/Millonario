<?php
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
    <section class="gameC">
      <article class="gameSelectFin">
        <div class="answere">
          <img src="<?php echo $path . $img ?>" alt="" style="    width: 72%; height: 311px; position: static; margin: 0% 31% 29% 15%; border-radius: 10px;"/>
        </div>
        <a href="../Vistas/admin.php" class="opcion encorefois">
          <p class="endTitle">
              Ver Puntaje
          </p>
        </a>
        <a href="../Controlador/logout.php" class="opcion encorefois">
          <p class="endTitle"><span class="glyphicon glyphicon-play" aria-hidden="true"></span> Salir</p>
        </a>
      </article>
      <article class="gameTimeFinJuego">
        <img src="../source/img/pje1.png" class="picTimFinJuego">
        <h2>Perdió</h2>
      </article>
    </section>
  </body>
</html>
<?php
}
}else{
  session_destroy();
  header('location:../Vistas/index.php?MSNLogin=2');
}

?>
