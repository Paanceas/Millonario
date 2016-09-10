<?php
session_start();
include "../Conexion/config.php";
$conexion   = mysqli_connect($servidor, $usuario, $contrasena, $bd);
//mysqli_real_escape_string evita Inyeccion SQL (' or '1'=1) de lo contrario se loguearia son ningun problema
$usuario    = mysqli_real_escape_string($conexion, $_POST['usuario']);
$contrasena = mysqli_real_escape_string($conexion, $_POST['contrasena']);
$sql        = "SELECT id_usuario, id_roll, correo, clave FROM usuario WHERE correo= '$usuario' AND clave = '$contrasena';";
$resultado  = mysqli_query($conexion, $sql);
$row        = mysqli_fetch_array($resultado);
if (mysqli_num_rows($resultado) > 0) {
    session_start();
    $_SESSION['id_usuario'] = $row['id_usuario'];
    $_SESSION['usuario']    = $usuario;
    $_SESSION['contrasena'] = $contrasena;
    if ($row['id_roll'] == 1) {
        session_start();
        $_SESSION['id_usuario'] = $row['id_usuario'];
        $_SESSION['validacion'] = 1;
        $_SESSION['id_roll']    = 1;
        header("location:../Controlador/carga.php");
    } else if ($row['id_roll'] == 2) {
        $user = $row['id_usuario'];
        // consultar el aprendiz de la session
        $sql = "SELECT a.id_aprendiz, a.nombres, p.programas FROM aprendiz a INNER JOIN programa p on p.id_programa = a.id_programa WHERE a.id_usuario = $user;";
        $resultado  = mysqli_query($conexion, $sql);
        $aprendizSession = mysqli_fetch_array($resultado);
        // fin de la consulta del aprendiz

        session_start();

        // asignacion de valores de la cosulta del aprendiz
        $_SESSION['id_aprendiz'] = $aprendizSession['id_aprendiz'];
        $_SESSION['nombreAprendiz'] = $aprendizSession['nombres'];
        $_SESSION['programaAprendiz'] = $aprendizSession['programas'];
        // fin asignacion de valores
        $_SESSION['validacion'] = 1;
        $_SESSION['id_usuario'] = $user;
        header("location:../Vistas/admin.php");
    }
} else {
    session_unset();
    session_destroy();
    header("location:../Vistas/formLogin.php?MSN=1");
}
mysqli_close($conexion);
?>
