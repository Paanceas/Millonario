<?php
require('../Controlador/clases/consultasAvanzadas.php');
session_start();
include "../Conexion/config.php";

$_SESSION['verificaSesion'] = consultasAvanzadas::validarSession($_SESSION['id_usuario']);
$_SESSION['recuperar']      = consultasAvanzadas::recuperar($_SESSION['id_usuario']);

if ($_SESSION['validacion'] == 1 && $_SESSION['verificaSesion'] == 1) {
    $_SESSION['clicJugarSess'] = 0;

    //Si el usuario esta en recuperar pass no lo deja salir de esa vista
    if ($_SESSION['recuperar'] == 1) {

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
    // @include('modalinstrucc.php');

    require('../Controlador/clases/mensajesRecuperarPass.php');

     ?>
     <link rel="stylesheet" href="../Bootstrap/css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">

       <link rel="stylesheet" href="../source/css/animate.css" media="screen" title="no title" charset="utf-8">
    <title>Nueva Clave</title>
    <link href='../source/img/favicon.ico' rel='icon' type='image/x-icon'/>

  </head>
  <body>
    <header class="header">
      <img src="../source/img/header.jpg" width="100% "/>
    </header>

    <article class="container">
      <div class="margenes">
        <div class="module form-module">

            <h1 style="text-align:center;color:#238276;">Cambio de Contraseña</h1>

        <div class="formRecuperar">
          <?php
          if(isset($_SESSION["MSN"])){
            mensajesRecuperarPass::recuperarPass($_SESSION["MSN"]);
          }
           ?>

          <form  action="../Controlador/recuperarPass.php" method="post" class="animated zoomIn">
            <input type="password" class="form-control" placeholder="Contraseña Nueva" name="clave" class="inp02" id="clave" required="true">
            <input type="password" class="form-control" placeholder="Confirme Contraseña" name="confirm" class="inp02" id="clave2" required="true">
            <button type="submit" class="btn btn-success btn-lg" name="nuevaPass" class="botonRegistro">Actualizar <span class="glyphicon glyphicon-refresh"> </span></button>
          </form>

      </div>
        </div>
      </div>
    </article>

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
<?php
    } else {
        header("location: admin");
    }
} else {
    session_unset();
    session_destroy();
    header("location:../Vistas/index");
    $_SESSION['MSNLogin']=2;
}
?>
