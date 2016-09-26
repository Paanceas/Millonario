<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta charset="UTF-8"/>
    <title>Autoevaluación</title>
    <link rel="stylesheet" href="../Bootstrap/css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="../source/css/animate.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="../source/css/estilos.css" media="screen" title="no title">
    <link rel="stylesheet" href="../source/css/style.css" media="screen" title="no title">
    <link rel="stylesheet" href="../source/css/sweetalert.css" media="screen" title="no title">
    <!-- <link rel="stylesheet" href="../source/css/reset.css" media="screen" title="no title"> -->
    <link rel="stylesheet" type="text/css" href="../source/jquery.fancybox.css?v=2.1.5" media="screen" />

    <!-- por el momento -->
    <link rel='stylesheet prefetch' href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'>
    <link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
    <?php
       require('../Controlador/clases/MensajesLogin.php');
      @include('../Conexion/config.php');//Conexion
      @include('../Controlador/registroPersona.php');
      require('../Controlador/clases/mensajes.php');

     ?>
  </head>
  <body>
    <header class="header">
      <img src="../source/img/header.jpg" width="100% "/>
    </header>
    <div class="container animated lightSpeedIn" style="width: 400px;">
      <?php if(isset($_GET["MSN"])){MensajesJuego::mensajesRegistroPersona($_GET["MSN"]);} ?>
    </div>
    <article class="contenedor">
      <section class="login">

                <!-- Form Module-->
        <div class="module form-module">
          <div class="toggle"><i class="fa fa-times fa-pencil"></i>
            <div class="tooltip">Registrate</div>
          </div>
          <div class="form">
            <h2>Ingresa con tu Cuenta</h2>
            <?php if(isset($_GET["MSN"])){MensajesJuego::msnJuegoS($_GET["MSN"]);} ?>
              <?php if(isset($_GET["MSN"])){Mensajes::mensajesRegistroPersona($_GET["MSN"]);} ?>
            <?php if(isset($_GET["MSNLogin"])){MensajesLogin::mensajesIngreso($_GET["MSNLogin"]); }?>
            <form action="../Controlador/login.php" method="post" role="form" class="animated zoomInDown">
              <input type="text" name="usuario" placeholder="Correo misena o sena"/>
              <input type="password" name="contrasena" placeholder="Contraseña"/>
              <button>Login</button>
            </form>
          </div>
          <div class="form">
            <h2>Crear Cuenta</h2>
            <form action="../Controlador/registroPersona.php" method="post">
              <input type="text" name="nombres" placeholder="Nombre Completo" required="true"/>
              <select class="form-control" name="tipoIdentificacion" required="true">
                <option value="null">Seleccione tipo identificación</option>
                   <?php
 									echo TipoIdentificacionCombobox();?>
              </select>
              <br/>
              <input type="text" placeholder="Número Documento" name="documento" size="40" required="true">
              <select name="programa" id ="programa" class="form-control" required="true">
                  <option value="null">Seleccione programa</option>
                  <?php echo ProgramaFormacionCombobox(); ?>
                </select>
                <br/>
                <input type="email" placeholder="Correo Sena" name="correo" id="correo" required="true">
                <input type="password" placeholder="Contraseña" name="clave" id="clave" required="true">
                <input type="password" placeholder="Confirme Contraseña" name="confirm" value="" id="clave2" required="true">
								<button type="submit" name="registrarse" class="botonRegistro">Registrar <span class="glyphicon glyphicon-user">
            </form>
          </div>
          <div class="cta"><a href="#" data-toggle="modal" data-target="#myModal">Olvidó su contraseña?</a></div>
        </div>
      </section>
      <section class="slider">
        <div id="myCarousel" class="carousel slide radius" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
              <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
              <li data-target="#myCarousel" data-slide-to="1"></li>
              <li data-target="#myCarousel" data-slide-to="2"></li>
              <li data-target="#myCarousel" data-slide-to="3"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
              <div class="item active">
                <img src="../source/img/slider/1.jpg" alt="Chania">
              </div>

              <div class="item">
                <img src="../source/img/slider/2.jpg" alt="Chania">
              </div>

              <div class="item">
                <img src="../source/img/slider/1.jpg" alt="Chania">
              </div>

              <div class="item">
                <img src="../source/img/slider/2.jpg" alt="Chania">
              </div>
            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
              <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
              <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
      </section>
    </article>



		<footer class="footer-distributed">


			<div class="footer-left">

				<p class="footer-links">
					<a href="#">Inicio</a>
					·
					<a href="#">Instrucciones</a>
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

		</footer>


    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <form action="../Controlador/recuperarPass.php" method="post">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Recuperar Contraseña</h4>
          </div>
          <div class="modal-body">

              <div class="form-group">
                <label for="correo">Ingresa tu correo:</label>
                <input type="email" name="correo" id="correo" placeholder="Correo (sena o misena)" class="form-control" >
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" name="recuperar" class="btn btn-lg btn-success">Enviar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          </div>
        </div>

      </div>
    </form>
    </div>



    <!-- Add fancyBox main JS and CSS files -->
    <script src="../Bootstrap/js/jquery-1.10.2.min.js"></script>
    <script src="../Bootstrap/js/bootstrap.min.js"></script>
    <script src="../source/js/bootstrap-notify.min.js"></script>
    <script src="../source/js/sweetalert.min.js"></script>
      <!-- <script type="text/javascript" src="../source/jquery-1.10.1.min.js"></script> -->
    <script type="text/javascript" src="../source/jquery.fancybox.js?v=2.1.5"></script>
    <script type="text/javascript" src="../source/js/index.js"></script>






  </body>
</html>
