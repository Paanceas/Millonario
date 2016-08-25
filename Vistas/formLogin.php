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
      @include('modalinstrucc.php')
    ?>

    <script src="../source/js/validar.js"></script>

  </head>
  <body>
  <figure>
    <img src="../source/img/banner.png" alt="banner juego autoevaluación" width="800">
  </figure>

  <section>
    <img src="../source/img/pje1.png" alt="Personaje juego">

    <div class="container">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">
            <div class="panel-heading headline1">Comienza Aquí:</div>
              <div class="panel-body">
                <form action="../Controlador/login.php" method="post">
                  <div class="form-group">
                    <div class="col-md-6">
                      <input type="email" class="form-control" name="usuario" id="usuario" placeholder="Correo (sena o misena)" size="26" required="">
                      <input type="password" class="form-control" name="contrasena" id="contrasena" title="Contraseña" placeholder="Contraseña" size="26" required="" min="6">
                      <button type="submit" class="btn btn-primary">
                       </i>Iniciar Sesión
                      </button>
                    </div>
                  </div>
                </form>
              </div>
          </div>
        </div>
      </div>
    </div>

  </section>

  <?php
    @include('footer.php')
  ?>
  </body>
</html>
