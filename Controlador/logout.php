<?php
if (!isset($_SESSION)) {
    session_start();
}
$usuarioSesion = $_SESSION['id_usuario'];

include "../Conexion/config.php";
$verificaRol     = "SELECT id_roll from usuario where id_usuario = $usuarioSesion;";
$ejecutaConsulta = $conexion->query($verificaRol);
$rol             = $ejecutaConsulta->fetch_array(MYSQLI_ASSOC);

$actualizaBool   = "UPDATE usuario set verificaSesion = 0 where id_usuario = $usuarioSesion";
$ejecutaReinicio = $conexion->query($actualizaBool);

if ($rol['id_roll'] == 1) {
    session_destroy();

    header("location:/Vistas/index");
} else {

    if ($_SESSION['id_usuario'] > 0) {
        $usuarioSesion   = $_SESSION['id_usuario'];
        $aprendizSession = $_SESSION['id_aprendiz'];
    }

    //Actualiza el estado de la sesión a cero = no logueado
    //Actualiza las respuestas correctas que haya tenido a cero
    //Actualiza el puntaje que haya tenido a cero
    $consultaAntesDeSalir = "SELECT id_aprendiz, resCorrectas from evaluacion_aprendiz where id_aprendiz = $aprendizSession;";
    $ejecutaSql           = $conexion->query($consultaAntesDeSalir);

    $fila = $ejecutaSql->fetch_array(MYSQLI_NUM);

    if ($fila[1] <= 19) {
        $reiniciaPuntajesAprend = "UPDATE usuario u, puntaje p, evaluacion_aprendiz e SET e.resCorrectas = 0, p.puntajes = 0, u.verificaSesion = 0 where p.id_aprendiz = $aprendizSession and u.id_usuario = $usuarioSesion and e.id_aprendiz = $aprendizSession";
        $reiniciaPuntajes       = $conexion->query($reiniciaPuntajesAprend);
    }
    session_destroy();
}
header("location:../Vistas/index");

exit();
?>
