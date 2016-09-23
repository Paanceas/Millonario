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
    <meta charset="utf-8">
    <?php
    // @include('modalinstrucc.php');

    require('../Controlador/clases/mensajesRecuperarPass.php');

     ?>
     <link rel="stylesheet" href="../Bootstrap/css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">

       <link rel="stylesheet" href="../source/css/animate.css" media="screen" title="no title" charset="utf-8">
    <title>Nueva Clave</title>
  </head>
  <body>
    <div class="container animated lightSpeedIn" style="width: 400px;">
      <?php
      if(isset($_GET["MSN"])){
        mensajesRecuperarPass::recuperarPass($_GET["MSN"]);
      }
       ?>
    </div>
    <form  action="../Controlador/recuperarPass.php" method="post">
      <input type="password" placeholder="Contraseña Nueva" name="clave" class="inp02" id="clave">
      <input type="password" placeholder="Confirme Contraseña" name="confirm" class="inp02" id="clave2">
      <button type="submit" name="nuevaPass" class="botonRegistro"><span class="glyphicon glyphicon-refresh"> </span> Actualizar</button>
    </form>
  </body>
</html>
<?php
    } else {
        header("location: admin.php");
    }
} else {
    session_unset();
    session_destroy();
    header("location:../Vistas/index.php?MSNLogin=3");
}
?>
