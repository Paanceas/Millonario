<?php
require('../Controlador/clases/consultasAvanzadas.php');

include "../Conexion/config.php";
if (!isset($_SESSION)) {
    session_start();
}

//mysqli_real_escape_string evita Inyeccion SQL (' or '1'=1) de lo contrario se loguearia son ningun problema
$usuario    = mysqli_real_escape_string($conexion, $_POST['usuario']);
$contrasena = mysqli_real_escape_string($conexion, $_POST['contrasena']);
$key        = ''; // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
$clave      = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $contrasena, MCRYPT_MODE_CBC, md5(md5($key))));

$sql       = "SELECT id_usuario, id_roll, correo, clave, verificaSesion FROM usuario WHERE correo= '$usuario' AND clave = '$clave';";
$resultado = mysqli_query($conexion, $sql);
$acentos   = $conexion->query("SET NAMES 'utf8'");
$row       = mysqli_fetch_array($resultado);
$consultaCorreo="SELECT correo FROM usuario where correo = '$usuario'";
$ejecutaConsultaCorreo=mysqli_query($conexion, $consultaCorreo);

if(mysqli_num_rows($ejecutaConsultaCorreo) == 1){

if (mysqli_num_rows($resultado) > 0) {

    $_SESSION['id_usuario']     = $row['id_usuario'];
    $user = $_SESSION['id_usuario'];

    $_SESSION['verificaSesion'] = $row['verificaSesion'];

    if ($row['id_roll'] == 1) {//Administrador

        $_SESSION['validacion'] = 1;
        $_SESSION['id_roll'] =1;
        if($row['verificaSesion'] == 0){//Si la sesión está cerrada ingresa automaticamente
          //Cambia estado bool inicio de sesion
          $iniciaSessionAdmin     = "UPDATE usuario SET verificaSesion = 1 where id_usuario = $user";
          $verificaSesion         = mysqli_query($conexion, $iniciaSessionAdmin);
          header("location:../Vistas/cargaMasiva");
        }else{//Si había una sesión abierta le notifica y la cierra
          $iniciaSessionAdmin     = "UPDATE usuario SET verificaSesion = 0 where id_usuario = $user";
          $verificaSesion         = mysqli_query($conexion, $iniciaSessionAdmin);
          // $_SESSION['validacion'] = 0;
          $_SESSION['verificaSesion'] = consultasAvanzadas::validarSession($_SESSION['id_usuario']);
          
          header("location: ../Vistas/index");
          $_SESSION['MSNLogin'] = 3;
        }
        //Libera memoria
        mysqli_close($conexion);
    } else if ($row['id_roll'] == 2) {//Aprendiz
        mysqli_set_charset($conexion, "utf-8");
        //Consultar el aprendiz de la sesión
        $sql             = "SELECT  r.id_roll, a.id_aprendiz, a.nombres, pr.programas, p.fecha FROM aprendiz a
        JOIN usuario u on u.id_usuario = a.id_usuario
        JOIN roll r on r.id_roll = u.id_roll
        JOIN programa pr on pr.id_programa = a.id_programa
        JOIN puntaje p on p.id_aprendiz = a.id_aprendiz
        WHERE u.id_usuario = $user and a.id_usuario = $user;";

        $resultado       = mysqli_query($conexion, $sql);
        $aprendizSession = mysqli_fetch_array($resultado);

        if ($row['verificaSesion'] == 0) {
            mysqli_set_charset($conexion, "utf-8");

            //Asignación de valores de la consulta del aprendiz
            $_SESSION['id_roll']=$aprendizSession[0];
            $_SESSION['id_aprendiz']      = $aprendizSession[1];
            $_SESSION['nombreAprendiz']   = $aprendizSession[2];
            $_SESSION['programaAprendiz'] = $aprendizSession[3];
            $nuevaFecha        = date("d/M/y H:i", strtotime($aprendizSession[4]));
            $_SESSION['fecha'] = $nuevaFecha;
            $aprendizLogueado             = $_SESSION['id_aprendiz'];
            // fin asignacion de valores

            $_SESSION['validacion']       = 1;
            //Cambia estado bool inicio de sesion
            $iniciaSessionVerify = "UPDATE usuario SET verificaSesion = 1 where id_usuario = $user";
            $verificaSesion      = mysqli_query($conexion, $iniciaSessionVerify);

            $_SESSION['verificaSesion'] = consultasAvanzadas::validarSession($_SESSION['id_usuario']);
            header("location:../Vistas/admin");
            //Libera memoria
            mysqli_close($conexion);
        } else {
            //Cierra sesión booleano
            $iniciaSessionVerify = "UPDATE usuario SET verificaSesion = 0 where id_usuario = $user";
            $verificaSesion      = mysqli_query($conexion, $iniciaSessionVerify);

            $_SESSION['verificaSesion'] = consultasAvanzadas::validarSession($_SESSION['id_usuario']);

            header("location: ../Vistas/index");
            $_SESSION['MSNLogin'] = 3;
        }
        //Libera memoria
        mysqli_close($conexion);
    }

} else {//Datos incorrectos
    session_unset();
    header("location:../Vistas/index");
    $_SESSION['MSNLogin'] = 1;
}
}else{//El correo ingresado no existe
  header("location: ../Vistas/index");
  $_SESSION['MSNLogin'] = 8;
}

mysqli_close($conexion);
?>
