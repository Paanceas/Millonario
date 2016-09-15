<?php
session_start();
include "../Conexion/config.php";
if ($_SESSION['id_usuario'] > 0); {
    $usuarioSesion = $_SESSION['id_usuario'];
}


$consultaSesion="UPDATE usuario SET verificaSesion = 0 where id_usuario = $usuarioSesion";
$actualizaEstado=$conexion->query($consultaSesion);


session_destroy();
header("location:../Vistas/formLogin.php");



exit();
?>
