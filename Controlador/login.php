<?php


require('../Controlador/clases/consultasAvanzadas.php');

include "../Conexion/config.php";
session_start();

$conexion   = mysqli_connect($server, $usuario, $contrasena, $bd);
//mysqli_real_escape_string evita Inyeccion SQL (' or '1'=1) de lo contrario se loguearia son ningun problema
$usuario    = mysqli_real_escape_string($conexion, $_POST['usuario']);
$contrasena = mysqli_real_escape_string($conexion, $_POST['contrasena']);
$key='';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
$clave = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $contrasena, MCRYPT_MODE_CBC, md5(md5($key))));


$sql       = "SELECT id_usuario, id_roll, correo, clave, verificaSesion FROM usuario WHERE correo= '$usuario' AND clave = '$clave';";
$resultado = mysqli_query($conexion, $sql);
$acentos = $conexion->query("SET NAMES 'utf8'");
$row       = mysqli_fetch_array($resultado);
if (mysqli_num_rows($resultado) > 0) {

    $_SESSION['id_usuario']     = $row['id_usuario'];
    $_SESSION['usuario']        = $usuario;
    $_SESSION['contrasena']     = $contrasena;
    $_SESSION['verificaSesion'] = $row['verificaSesion'];
    if ($row['id_roll'] == 1) {

        $_SESSION['id_usuario'] = $row['id_usuario'];
        $_SESSION['validacion'] = 1;
        $_SESSION['id_roll']    = 1;
        //Cambia estado bool inicio de sesion
        $iniciaSessionAdmin = "UPDATE usuario SET verificaSesion = 1 where id_usuario = ".$_SESSION['id_usuario']."";
        $verificaSesion      = $conexion->query($iniciaSessionAdmin);
        header("location:../Vistas/cargaMasiva");
    } else if ($row['id_roll'] == 2) {
      mysqli_set_charset($conexion, "utf-8");

        $user = $_SESSION['id_usuario'];
        if ($row['verificaSesion'] == 0) {
          mysqli_set_charset($conexion, "utf-8");

            // consultar el aprendiz de la session
            $sql             = "SELECT a.id_aprendiz, a.nombres, p.programas FROM aprendiz a INNER JOIN programa p on p.id_programa = a.id_programa WHERE a.id_usuario = $user;";
            $resultado       = mysqli_query($conexion, $sql);
            $aprendizSession = mysqli_fetch_array($resultado);
            // fin de la consulta del aprendiz
            mysqli_set_charset($conexion, "utf-8");

            //Mostrar fecha última vez jugado
            $sqlFecha             = "SELECT fecha FROM puntaje p INNER JOIN aprendiz a on a.id_aprendiz = p.id_aprendiz join usuario u on u.id_usuario = a.id_usuario WHERE u.id_usuario = $user;";

            $resultadoFecha       = mysqli_query($conexion, $sqlFecha);
            $aprendizPuntaje = mysqli_fetch_array($resultadoFecha);

            $nuevaFecha = date("d/M/y H:i", strtotime($aprendizPuntaje['fecha']));
            $_SESSION['fecha']=$nuevaFecha;

            // asignacion de valores de la cosulta del aprendiz
            $_SESSION['id_aprendiz']      = $aprendizSession['id_aprendiz'];
            $aprendizLogueado=$_SESSION['id_aprendiz'];
            $_SESSION['nombreAprendiz']   = $aprendizSession['nombres'];
            $_SESSION['programaAprendiz'] = $aprendizSession['programas'];
            // fin asignacion de valores
            $_SESSION['validacion']       = 1;
            $user                         = $_SESSION['id_usuario'];

            //Cambia estado bool inicio de sesion
            $iniciaSessionVerify = "UPDATE usuario SET verificaSesion = 1 where id_usuario = $user";
            $verificaSesion      = $conexion->query($iniciaSessionVerify);

            $_SESSION['verificaSesion'] = consultasAvanzadas::validarSession($_SESSION['id_usuario']);

            header("location:../Vistas/admin");
        } else {
          //Consulta el id_aprendiz que se loguea
          $sql             = "SELECT a.id_aprendiz FROM aprendiz a WHERE a.id_usuario = $user;";
          $resultado       = mysqli_query($conexion, $sql);
          $aprendizSession = $resultado->fetch_array(MYSQLI_NUM);

          $id_aprendizSess=$aprendizSession[0];
          //Consulta antes de ingresar
          $consultaAntesDeEntrar="SELECT id_aprendiz, resCorrectas from evaluacion_aprendiz where id_aprendiz = $id_aprendizSess;";
          $ejecutaSql=$conexion->query($consultaAntesDeEntrar);

          $fila=$ejecutaSql->fetch_array(MYSQLI_NUM);

          if ($fila[1] <= 19) {
          //Si intenta entrar al mismo tiempo con dos usuarios le reinicia el puntaje a cero
            $reiniciaSql="UPDATE puntaje p, evaluacion_aprendiz e set e.resCorrectas = 0, p.puntajes = 0 where p.id_aprendiz = $id_aprendizSess and e.id_aprendiz = $id_aprendizSess";
            $reiniciaPuntaje=$conexion->query($reiniciaSql);
          }
            //Cierra sesión booleano
            $iniciaSessionVerify = "UPDATE usuario SET verificaSesion = 0 where id_usuario = $user";
            $verificaSesion      = $conexion->query($iniciaSessionVerify);

            $_SESSION['verificaSesion'] = consultasAvanzadas::validarSession($_SESSION['id_usuario']);

            header("location: ../Vistas/index");
            $_SESSION['MSNLogin']=3;
        }
    }

} else {
    session_unset();

    header("location:../Vistas/index");
    $_SESSION['MSNLogin']=1;
}

mysqli_close($conexion);
?>
