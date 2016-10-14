<?php
session_start();
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
    //CLAVE RANDOM-------- que envia al correro

    //Clave encliptada
    $key='';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
    $claveEncriptada = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $pass, MCRYPT_MODE_CBC, md5(md5($key))));

    if (isset($_POST['correo']) && isset($_POST['documento'])) {
        $correo = strtolower($_POST['correo']);
        $documento = $_POST['documento'];

        //Verifica si el correo ingresado existe
        $sqlExiste  = "SELECT u.id_usuario, u.correo, a.documento FROM usuario u JOIN aprendiz a ON a.id_usuario = u.id_usuario
        where correo = '$correo' and documento = '$documento';";
        $ejecutaSql = $conexion->query($sqlExiste);

        if (mysqli_num_rows($ejecutaSql) > 0) {

                $mensaje = '<html>
                <head>
                <title>Restablece tu contraseña</title>
                </head>
                <body>
                <p>Hemos recibido una petición para restablecer la contraseña de tu cuenta.</p>
                <p>Tu nueva Contraseña es: <h2>'. $pass .'</h2> </p>

                Por favor no responda a este correo.
                </body>
                </html>';

                $cabeceras = 'MIME-Version: 1.0' . "\r\n";
                $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $cabeceras .= 'From: Recuperación Clave <ejemplo@misena.edu.co>' . "\r\n";
                // Se envia el correo al usuario

                if(mail($correo, "Recuperar contraseña", $mensaje, $cabeceras)){
                  $actualizaClave = "UPDATE usuario SET clave = '$claveEncriptada', recuperar = 1 where correo = '$correo';";
                  $ejecutaSql     = $conexion->query($actualizaClave);
                  if ($ejecutaSql == true) {
                    //Ingresa
                    header("location: ../Vistas/index");
                    $_SESSION['MSNLogin']=7;
                  }else{
                    //No se pudo actualizar la clave
                    header("location: ../Vistas/nuevaPass");
                    $_SESSION['MSNLogin']=3;
                  }
                }else {
                  //NO SE PUDO ENVIAR EL CORREO
                    header("location:../Vistas/index");
                    $_SESSION['MSNLogin']=5;
                }
        } else {
          //El correo no existe
            header("location: /Millonario/Vistas/index");
            $_SESSION['MSNLogin']=6;
        }
    }
    //Si le da clic en nueva Clave-------
} else if (isset($_POST['nuevaPass'])) {

    if (isset($_POST['clave']) && isset($_POST['confirm'])) {
        $clave   = $_POST['clave'];
        $confirm = $_POST['confirm'];

        $patronClave = "/^[^ ][0-9a-zA-ZÁáÀàÉéÈèÍíÌìÓóÒòÚúÙùÑñüÜ.,¡!¿?\s]{5,60}+$/";

        if (empty($clave) && empty($confirm) || $clave == '' && $confirm == '') {
            header("location:../Vistas/nuevaPass");
            $_SESSION['MSN']=3;
        }
        //Valida clave
        elseif (!preg_match($patronClave, $clave)) {
            if (empty($clave)) {
                header("location:../Vistas/nuevaPass");
                $_SESSION['MSN']=1;
            } else {
                header("location:../Vistas/nuevaPass");
                $_SESSION['MSN']=11;

            }
        }
        //Valida confirm
            elseif (!preg_match($patronClave, $confirm)) {
            if (empty($confirm)) {
                header("location:../Vistas/nuevaPass");
                $_SESSION['MSN']=1;
            } else {
                header("location:../Vistas/nuevaPass");
                $_SESSION['MSN']=11;

            }
        }
        //Termina Validacion de campos y expresiones regulares
        else {
            //Obtiene el id del Usuario logueado
            $usuarioSesion = $_SESSION['id_usuario'];

            //Confirma clave
            if ($clave == $confirm) {
              $key='';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
              $clave = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $_POST['clave'], MCRYPT_MODE_CBC, md5(md5($key))));


                //Actualiza la clave a la del usuario y el estado a cero
                $sql        = "UPDATE usuario SET clave = '$clave', recuperar = 0 where id_usuario = $usuarioSesion";
                $ejecutaSql = $conexion->query($sql);
                header("location: ../Vistas/admin");
            } else {
                header("location: ../Vistas/nuevaPass");
                $_SESSION['MSN']=2;
            }
        }
    }
} else {
    header("location: ../Vistas/index");
}
mysqli_close($conexion);
?>
