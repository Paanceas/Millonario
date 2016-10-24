<?php
session_start();

if(isset($_SESSION['verificaSesion'] ) && $_SESSION['verificaSesion']  == 1){

  header('location: admin');
}else {
 ?>
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
      require('../Conexion/config.php');//Conexion
      require('../Controlador/registroPersona.php');
      require('../Controlador/clases/mensajes.php');

     ?>
     <link href='../source/img/favicon.ico' rel='icon' type='image/x-icon'/>
  </head>
  <body>
    <style type="text/css">
      input {
        border-radius:10px;
      }
      button {
        border-radius:5px;
      }
    </style>
    <style type="text/css" media="screen">
    [data-tip] {
    position:relative;

  }
  [data-tip]:before {
    content:'';
    /* hides the tooltip when not hovered */
    display:block;
    content:'';
    display:block;
    border-top: 5px solid transparent;
    border-right: 5px solid transparent;
    border-bottom: 5px solid transparent;

    border-left : 5px solid #1a1a1a;
    position:absolute;
    top:15px;
    left:-10px;
    z-index:8;
    font-size:0;
    line-height:0;
    width:0;
    height:0;
    position:absolute;

  }
  [data-tip]:after {
    display:block;
    content:attr(data-tip);
    position:absolute;
    top:7px;
    left:-99px;
    padding:5px 8px;
    background:#1a1a1a;
    color:#fff;
    z-index:9;
    font-size: 1.30em;
    height:25px;
    line-height:18px;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    white-space:nowrap;
    word-wrap:normal;
  }
  [data-tip]:hover:before,
  [data-tip]:hover:after {
    display:block;
  }

  /*Fecha Nacimiento*/
  [dataF-tip] {
  position:relative;

}
[dataF-tip]:before {
  content:'';
  /* hides the tooltip when not hovered */
  display:none;
  content:'';
  display:none;
  border-left: 5px solid transparent;
  border-right: 5px solid transparent;
  border-top: 5px solid #1a1a1a;
  position:absolute;
  top:0px;
  left:84px;
  z-index:8;
  font-size:0;
  line-height:0;
  width:0;
  height:0;
  position:absolute;

}
[dataF-tip]:after {
  display:none;
  content:attr(dataF-tip);
  position:absolute;
  top:-25px;
  left:12px;
  padding:5px 8px;
  background:#1a1a1a;
  color:#fff;
  z-index:9;
  font-size: 1.3em;
  height:25px;
  line-height:18px;
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;
  white-space:nowrap;
  word-wrap:normal;
}
[dataF-tip]:hover:before,
[dataF-tip]:hover:after {
  display:block;
}
    </style>
    <header class="header">
      <img src="../source/img/header.jpg" width="100% "/>
    </header>

    <article class="contenedor">
      <section class="login">

                <!-- Form Module-->
        <div class="module form-module">
          <div class="toggle" data-tip="Regístrate"><i class="fa fa-times fa-pencil"></i>
            <div class="tooltip">Registrate</div>
          </div>
          <div class="form">
            <h2>Ingresa con tu Cuenta</h2>
            <?php if(isset($_SESSION["MSN"])){MensajesJuego::mensajesRegistroPersona($_SESSION["MSN"]);} ?>

            <?php if(isset($_SESSION["MSNLogin"])){MensajesLogin::mensajesIngreso($_SESSION["MSNLogin"]); }?>
            <form action="../Controlador/login.php" method="post" role="form" class="animated zoomInDown">
              <input type="email" name="usuario" placeholder="Correo misena o sena" required="true" />
              <input type="password" name="contrasena" placeholder="Contraseña" required="true"/>
              <button>INGRESAR <span class="glyphicon glyphicon-log-in" style="font-size: 15px;"></button>
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
              <input type="text" placeholder="Número Documento" name="documento" required="true">
              <div dataF-tip="Fecha de Nacimiento">
                <input type="date" name="fechaNac" min="1950-01-01" max="<?php echo date('Y-m-d'); ?>" required="true">
              </div>
              <select name="programa" id ="programa" class="form-control" required="true">
                  <option value="null">Seleccione programa</option>
                  <?php echo ProgramaFormacionCombobox(); ?>
                </select>
                <br/>
                <input type="email" placeholder="Correo Sena" name="correo" id="correo" required="true">
								<button type="submit" name="registrarse" class="botonRegistro">REGISTRARSE <span class="glyphicon glyphicon-user">
            </form>
          </div>
          <div class="cta"><a href="#" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-info-sign" style="font-size: 13px;"></span><b> ¿Olvidó su contraseña?</b></a></div>
        </div>
      </section>
      <section class="slider">
        <div id="myCarousel" class="carousel slide radius" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
              <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
              <li data-target="#myCarousel" data-slide-to="1"></li>
              <!-- <li data-target="#myCarousel" data-slide-to="2"></li>
              <li data-target="#myCarousel" data-slide-to="3"></li> -->
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">


              <div class="item ">
                <img src="../source/img/slider/3.jpg" alt="Chania" style="height: 422px; width: 100%;">
              </div>

              <div class="item active">
                <img src="../source/img/slider/ingles.png" alt="Chania" style="height: 422px;">
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
                <input type="email" name="correo" id="correo" placeholder="Correo (sena o misena)" class="form-control" required="true"></br>
                <label for="documento">Ingresa los últimos 4 dígitos del documento:</label>
                <input type="password" name="documento" maxlength="4" id="documento" placeholder="4 últimos dígitos de tu Número de Documento" class="form-control" required="true">
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" name="recuperar" class="btn btn-success"><span class="glyphicon glyphicon-envelope" style="font-size: 15px;"></span> Enviar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"> <span class="glyphicon glyphicon-remove-circle" style="font-size: 15px;"></span> Cerrar</button>
          </div>
        </div>

      </div>
    </form>
    </div>

    <!-- Add fancyBox main JS and CSS files -->
    <script src="../Bootstrap/js/jquery-1.10.2.min.js"></script>
    <script src="../Bootstrap/js/bootstrap.min.js"></script>
    <script src="../source/js/sweetalert.min.js"></script>
    <script src="../source/js/index.js"></script>


    <?php
    if (isset($_SESSION['ok']) && $_SESSION['ok'] == 123) {
      echo "<script type='text/javascript'>";
      MensajesJuego::exito();
      echo "</script>";
   }
   if (isset($_SESSION["MSNLogin"]) && $_SESSION["MSNLogin"] == "7") {
     echo "<script type='text/javascript'>";
     MensajesLogin::exitoCorreoEnvio();
     echo "</script>";
   }

     ?>
  </body>
</html>
<?php session_destroy();

}  ?>
