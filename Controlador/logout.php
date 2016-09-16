<?php
session_start();
include "../Conexion/config.php";
if ($_SESSION['id_usuario'] > 0); {
    $usuarioSesion = $_SESSION['id_usuario'];
}
session_destroy();
$cierraSessionVerify="UPDATE usuario SET verificaSesion = 0 where id_usuario = $usuarioSesion";
$verificaSesion=$conexion->query($cierraSessionVerify);

header("location:../Vistas/formLogin.php");

exit();
?>
