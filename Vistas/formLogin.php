<?php
session_start();
session_destroy();
 ?>
<!doctype html>
<html lang="es">
  <head>
    <title>Juego Autoevaluación</title>
    <meta charset="utf-8">
    <?php
       @include('modalinstrucc.php');
       require('../Controlador/clases/MensajesLogin.php');

     ?>
    <link rel="stylesheet" href="../Bootstrap/css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">

      <link rel="stylesheet" href="../source/css/animate.css" media="screen" title="no title" charset="utf-8">

    <script src="../source/js/validar.js"></script>
<style>
body{
  //background: #BDD3D9;
  background: url(../source/img/fondo.png) fixed;

/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#bdd3d9+32,ffffff+100 */
//background: #bdd3d9 fixed; /* Old browsers */


}
  .form23{
    width: 455px;
    height: 700px;
    background-image: url("../source/img/pje1.png");
    background-position: center;
    background-repeat: no-repeat;
    /*background-size: cover*/
    padding: 400px 170px 0 170px;
  }
  .form23{
    width: 50%;
    margin-left: 25%;
  }
  figure{
    width: 60%;
    margin-left: 20%;
  }
</style>
  </head>
  <body>
  <figure>
    <img src="../source/img/banner.png" alt="banner juego autoevaluación" width="800">
  </figure>
  <div class="container animated zoomIn" style="width: 400px;">
    <?php
    if(isset($_GET["MSN"])){
      MensajesLogin::mensajesIngreso($_GET["MSN"]);
    }
     ?>
  </div>
  <div class="mitad_pa">
    <!-- <img src="../source/img/pje1.png" alt="Personaje juego"> -->


    <form action="../Controlador/login.php" method="post" role="form" class="form23 animated zoomInDown">

          <div class="form-group">

              <input type="email" class="form-control" name="usuario" id="usuario" placeholder="Correo (sena o misena)" size="26" required=""><br/>
              <input type="password" class="form-control" name="contrasena" id="contrasena" title="Contraseña" placeholder="Contraseña" size="26" required="" min="6"><br/><br/>
              <button type="submit" class="btn btn-sucess">
                <span class="glyphicon glyphicon-log-in"></span>Iniciar Sesión
              </button>
              <button type="button" onclick = "location='formRegistro.php'" class="btn btn-sucess">
                <span class="glyphicon glyphicon-user"></span>Registrarse
              </button>

      </div>


    </form>
  </div>

  <?php
    @include('footer.php')
  ?>
  </body>
</html>
