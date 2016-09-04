<?php
session_start();
if($_SESSION['validacion']==1 && $_SESSION['id_usuario']>0){
$usuario=$_SESSION['id_usuario'];
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Fin</title>
    <?php include "modalinstrucc.php"; ?>

  </head>
  <body>

    <section class="gameC">
      <article class="gameSelect">
        <div class="answere">
            <h1>¡Perdiste!</h1>
            <p>
              Gracias por jugar
            </p>
        </div>

        <a href="../Controlador/logout.php" class="opcion encorefois">
          <p class="endTitle">
              Salir
          </p>
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
  header('location:../Vistas/formLogin.php');
}
session_destroy();

?>
