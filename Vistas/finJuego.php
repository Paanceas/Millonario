<?php
session_start();
if($_SESSION['validacion']==1 && $_SESSION['id_usuario']>0){
$usuario=$_SESSION['id_usuario'];
$_SESSION['jugar'] = 0;
var_dump($_SESSION['jugar']);
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Fin</title>
    <?php include "modalinstrucc.php"; ?>

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


    <section class="gameC">
      <article class="gameSelect">
        <div class="answere">
            <h1>¡Fin del Juego!</h1>
            <p>
              Gracias por participar
            </p>
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
      <article class="gameTime">
        <img src="../source/img/pje1.png" class="picTime">
        <h2>0:00</h2>

      </article>

    </section>


    <?php
      @include('footer.php')
    ?>
  </body>
</html>
<?php
}else{
  session_destroy();
  header('location:../Vistas/formLogin.php');
}

?>
