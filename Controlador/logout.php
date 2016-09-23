<?php
session_start();
include "../Conexion/config.php";
if ($_SESSION['id_usuario'] > 0); {
    $usuarioSesion = $_SESSION['id_usuario'];
    $aprendizSession = $_SESSION['id_aprendiz'];
}
session_destroy();
//Actualiza el estado de la sesión a cero = no logueado
$cierraSessionVerify="UPDATE usuario SET verificaSesion = 0 where id_usuario = $usuarioSesion";
$verificaSesion=$conexion->query($cierraSessionVerify);

//Actualiza las respuestas correctas que haya tenido a cero
$reiniciaResCorrec="UPDATE evaluacion_aprendiz SET resCorrectas = 0 where id_aprendiz = $aprendizSession";
$ejecutaReinicioi=$conexion->query($reiniciaResCorrec);

//Actualiza el puntaje que haya tenido a cero
$actualizaPuntaje = "UPDATE puntaje SET puntajes =  0 where id_aprendiz = $aprendizSession";
$ejecutaSql       = $conexion->query($actualizaPuntaje);

header("location:../Vistas/index.php");

exit();
?>
