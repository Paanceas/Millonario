<?php
if (!isset($_SESSION)) {
    session_start();
}
include "../Conexion/config.php";
//Si le da clic en recuperar-------
if (isset($_POST['recuperar'])) {

    //Codigo random que genera para recuperar la contraseña
    $cadena = "ABCDEFGHIJKLMNOPQRSTVWXYZ0123456789";
    $pass   = '';

    $longitudCadena = strlen($cadena);

    for ($i = 0; $i < 10; $i++) {
        $aleatorio = rand(1, $longitudCadena);
        $pass .= substr($cadena, $aleatorio, 1);
    }

    //Clave encliptada
    $key             = ''; // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
    $claveEncriptada = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $pass, MCRYPT_MODE_CBC, md5(md5($key))));

    if (isset($_POST['correo']) && isset($_POST['documento'])) {
        $correo    = mysql_real_escape_string(strtolower($_POST['correo']));
        $documento = mysql_real_escape_string($_POST['documento']);

        $verificaRol     = "SELECT r.id_roll FROM roll r JOIN usuario u on u.id_roll = r.id_roll WHERE u.correo = '$correo';";
        $ejecutaVerifica = mysqli_query($conexion, $verificaRol);
        $filaRoll        = mysqli_fetch_array($ejecutaVerifica);

        if ($filaRoll[0] == 1) { //Verifica si es Administrador
            $sqlExisteAdm = "SELECT u.id_usuario, u.correo FROM usuario u WHERE correo = '$correo'";
            $ejecutaSql   = $conexion->query($sqlExisteAdm);
        } else { //Es Aprendiz
            //Verifica si el correo ingresado existe
            $documentoA4Digitos = substr($documento, -4);
            //Ùltimos 4 dìgitos de la BD
            $verificaDigitos    = "SELECT substr(documento,-4) FROM aprendiz a join usuario u on u.id_usuario = a.id_usuario where u.correo = '$correo';";
            $ejecutaVerifica    = mysqli_query($conexion, $verificaDigitos);
            $ultimos4Dig        = mysqli_fetch_array($ejecutaVerifica);
            //Si el documento ingresado es igual al de la DB realiza consulta
            if ($ultimos4Dig[0] == $documentoA4Digitos) {
                $sqlExiste  = "SELECT u.id_usuario, u.correo, a.documento FROM usuario u JOIN aprendiz a ON a.id_usuario = u.id_usuario where correo = '$correo';";
                $ejecutaSql = $conexion->query($sqlExiste);
            }
        }

        if (mysqli_num_rows($ejecutaSql) > 0) {

            $mensaje = '<html>
                <head>
                <title>Restablece tu contraseña</title>
                </head>
                <body>
                <img src="http://autoevaluacion.datasena.com/source/img/header.jpg" style="width:100%"/>
                <div style="padding:15px; border-radius:10px; background:rgb(238, 239, 232);border-right:2px solid black">
                <p><b>HOLA!</b></p>
                <p>Hemos recibido una petición para restablecer la contraseña de tu cuenta.</p>
                <p>Tu nueva Contraseña es: <b>' . $pass . '</b> </p>
                </div>
                <p>************************************************</p>
                <p>** Por favor no responder a este correo. **</p>
                <p>************************************************</p>
                </body>
                </html>';

            $cabeceras = 'MIME-Version: 1.0' . "\r\n";
            $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $cabeceras .= 'From: Recuperación Clave <ejemplo@misena.edu.co>' . "\r\n";
            // Se envia el correo al usuario

            if (mail($correo, "Recuperar contraseña", $mensaje, $cabeceras)) {
                $actualizaClave = "UPDATE usuario SET clave = '$claveEncriptada', recuperar = 1 where correo = '$correo';";
                $ejecutaSql     = $conexion->query($actualizaClave);
                if ($ejecutaSql == true) {
                    //Ingresa
                    header("location: ../Vistas/index");
                    $_SESSION['MSNLogin'] = 7;
                } else {
                    //No se pudo actualizar la clave
                    header("location: ../Vistas/nuevaPass");
                    $_SESSION['MSNLogin'] = 3;
                }
            } else {
                //NO SE PUDO ENVIAR EL CORREO
                header("location:../Vistas/index");
                $_SESSION['MSNLogin'] = 5;
            }
        } else {
            //El correo o documento no existe
            header("location: ../Vistas/index");
            $_SESSION['MSNLogin'] = 6;
        }
    }
    //Si le da clic en nueva Clave-------
} else if (isset($_POST['nuevaPass'])) {

    if (isset($_POST['clave']) && isset($_POST['confirm'])) {
        $clave   = mysql_real_escape_string($_POST['clave']);
        $confirm = mysql_real_escape_string($_POST['confirm']);

        $patronClave = "/^[^ ][0-9a-zA-ZÁáÀàÉéÈèÍíÌìÓóÒòÚúÙùÑñüÜ.,¡!¿?\s]{5,60}+$/";

        if (empty($clave) && empty($confirm) || $clave == '' && $confirm == '') {
            header("location:../Vistas/nuevaPass");
            $_SESSION['MSN'] = 3;
        }
        //Valida clave
        elseif (!preg_match($patronClave, $clave)) {
            if (empty($clave)) {
                header("location:../Vistas/nuevaPass");
                $_SESSION['MSN'] = 1;
            } else {
                header("location:../Vistas/nuevaPass");
                $_SESSION['MSN'] = 11;
            }
        }
        //Valida confirm
            elseif (!preg_match($patronClave, $confirm)) {
            if (empty($confirm)) {
                header("location:../Vistas/nuevaPass");
                $_SESSION['MSN'] = 1;
            } else {
                header("location:../Vistas/nuevaPass");
                $_SESSION['MSN'] = 11;

            }
        }
        //Termina Validacion de campos y expresiones regulares
        else {
            //Obtiene el id del Usuario logueado
            $usuarioSesion = $_SESSION['id_usuario'];

            //Confirma clave
            if ($clave == $confirm) {
                $key   = ''; // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
                $clave = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $_POST['clave'], MCRYPT_MODE_CBC, md5(md5($key))));

                //Actualiza la clave a la del usuario y el estado a cero
                $sql        = "UPDATE usuario SET clave = '$clave', recuperar = 0 where id_usuario = $usuarioSesion";
                $ejecutaSql = $conexion->query($sql);
                if ($filaRoll[0] == 1) {
                    header("location: ../Vistas/cargaMasiva");
                } else {
                    header("location: ../Vistas/admin");
                }
            } else {
                header("location: ../Vistas/nuevaPass");
                $_SESSION['MSN'] = 2;
            }
        }
    }
} else {
    header("location: ../Vistas/index");
}
mysqli_close($conexion);
?>
