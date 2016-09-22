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

    echo $pass;

    //Clave encliptada
    $claveEncriptada = md5($pass);

    if (isset($_POST['correo'])) {
        $correo = strtolower($_POST['correo']);

        //Verifica si el correo ingresado existe
        $sqlExiste  = "SELECT id_usuario, correo FROM usuario where correo= '$correo';";
        $ejecutaSql = $conexion->query($sqlExiste);

        if (mysqli_num_rows($ejecutaSql) > 0) {

                $mensaje = '<html>
                <head>
                <title>Restablece tu contraseña</title>
                </head>
                <body>
                <p>Hemos recibido una petición para restablecer la contraseña de tu cuenta.</p>
                <p>Tu nueva Contraseña es: '. $pass .'</p>
                </body>
                </html>';

                $cabeceras = 'MIME-Version: 1.0' . "\r\n";
                $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $cabeceras .= 'From: Codedrinks <ejemplo@misena.edu.co>' . "\r\n";
                // Se envia el correo al usuario
                mail($correo, "Recuperar contraseña", $mensaje, $cabeceras);

                if(mail($correo, "Recuperar contraseña", $mensaje, $cabeceras)){
                  $actualizaClave = "UPDATE usuario SET clave = '$claveEncriptada', recuperar = 1 where correo = '$correo';";
                  $ejecutaSql     = $conexion->query($actualizaClave);
                  if ($ejecutaSql == true) {
                    //Ingresa
                    header("location: ../Vistas/formLogin.php?MSN=7");
                  }else{
                    //No se pudo actualizar la clave
                    header("location: ../Vistas/nuevaPass.php?MSN=3");
                  }
                }else {
                  //NO SE PUDO ENVIAR EL CORREO
                    header("location:../Vistas/formLogin.php?MSN=5");
                }
        } else {
          //El correo no existe
            header("location: /Millonario/Vistas/formLogin.php?MSN=6");
        }
    }
    //Si le da clic en nueva Clave-------
} else if (isset($_POST['nuevaPass'])) {

    if (isset($_POST['clave']) && isset($_POST['confirm'])) {
        $clave   = $_POST['clave'];
        $confirm = $_POST['confirm'];

        $patronClave = "/^[^ ][0-9a-zA-ZÁáÀàÉéÈèÍíÌìÓóÒòÚúÙùÑñüÜ.,¡!¿?\s]{5,60}+$/";

        if (empty($clave) && empty($confirm) || $clave == '' && $confirm == '') {
            header("location:../Vistas/nuevaPass.php?MSN=3");
        }
        //Valida clave
        elseif (!preg_match($patronClave, $clave)) {
            if (empty($clave)) {
                header("location:../Vistas/nuevaPass.php?MSN=1");
            } else {
                header("location:../Vistas/nuevaPass.php?MSN=1.1");
            }
        }
        //Valida confirm
            elseif (!preg_match($patronClave, $confirm)) {
            if (empty($confirm)) {
                header("location:../Vistas/nuevaPass.php?MSN=1");
            } else {
                header("location:../Vistas/nuevaPass.php?MSN=1.1");
            }
        }
        //Termina Validacion de campos y expresiones regulares
        else {
            //Obtiene el id del Usuario logueado
            $usuarioSesion = $_SESSION['id_usuario'];

            //Confirma clave
            if ($clave == $confirm) {
                $clave = md5($_POST['clave']);

                //Actualiza la clave a la del usuario y el estado a cero
                $sql        = "UPDATE usuario SET clave = '$clave', recuperar = 0 where id_usuario = $usuarioSesion";
                $ejecutaSql = $conexion->query($sql);
                header("location: ../Vistas/admin.php");
            } else {
                header("location: ../Vistas/nuevaPass.php?MSN=2");
            }
        }
    }
} else {
    header("location: ../Vistas/formLogin.php");
}

?>
