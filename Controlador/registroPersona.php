<?php
include "../Conexion/config.php";
if (!isset($_SESSION)) {
    session_start();
}
function TipoIdentificacionCombobox()
{
    //Carga select tipo identificacion
    include "../Conexion/config.php";
    $sql       = "SELECT * from tipo_identificacion";
    $resultado = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($resultado) > 0) {
        $tipoIdentificacionSelect = "";
        while ($row = $resultado->fetch_array(MYSQLI_ASSOC)) {
            $tipoIdentificacionSelect .= " <option value='" . $row['id_tipo_identificacion'] . "'>" . $row['tipo_identificacion'] . "</option>";
        }
    } else {
        $tipoIdentificacionSelect .= "<option value='null'>No hay registros</option>";
    }
    return $tipoIdentificacionSelect;
    mysqli_close($conexion);
}

function ProgramaFormacionCombobox()
{
    //Carga select programa
    include "../Conexion/config.php";
    $sql       = "SELECT * from programa order by programas asc";
    $acentos   = mysqli_query($conexion, "SET NAMES 'utf8'");
    $resultado = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($resultado) > 0) {
        $programaFormacionSelect = "";
        while ($row = $resultado->fetch_array(MYSQLI_ASSOC)) {
            $programaFormacionSelect .= " <option value='" . $row['id_programa'] . "'>" . $row['programas'] . "</option>";
        }
    } else {
        $programaFormacionSelect .= "<option value='null'>No hay registros</option>";
    }
    return $programaFormacionSelect;
    mysqli_close($conexion);
}

/*----------------------------------------------------------------------------*/
if (isset($_POST['nombres']) && isset($_POST['documento']) && isset($_POST['correo']) && isset($_POST['tipoIdentificacion']) && isset($_POST['programa'])) {

    $nombres            = $_POST['nombres'];
    $documento          = $_POST['documento'];
    $correo             = strtolower($_POST['correo']);
    $tipoIdentificacion = $_POST['tipoIdentificacion'];
    $programa           = $_POST['programa'];

    //Validacion con Expresiones regulares
    $patronNombres   = "/^([a-zA-Z ZÁáÀàÉéÈèÍíÌìÓóÒòÚúÙùÑñüÜ.]{10,60})$/";
    $patronDocumento = "/^[0-9]{6,12}+$/";
    $patronCorreo    = "/^([a-z0-9_.+-])*\@(([misena|sena]+)\.)+([edu])+\.([co])+$/";
    $patronTI        = "/^[0-9]{1,10}+$/";
    $patronPrograma  = "/^[0-9]{1,10}+$/";

    //Valida todos lo campos
    if (empty($nombres) && empty($documento) && empty($correo) && !empty($tipoIdentificacion) && empty($programa)) {
        header("location:../Vistas/index");
        $_SESSION['MSN'] = 1;
    }
    //Valida nombre
    elseif (!preg_match($patronNombres, $nombres)) {
        if (empty($nombres)) {
            header("location:../Vistas/index");
            $_SESSION['MSN'] = 2;
        } else {
            header("location:../Vistas/index");
            $_SESSION['MSN'] = 21;
        }
    }
    //Valida TI
        elseif (!preg_match($patronTI, $tipoIdentificacion)) {
        if (empty($tipoIdentificacion)) {
            header("location:../Vistas/index");
            $_SESSION['MSN'] = 9;
        } else {
            header("location:../Vistas/index");
            $_SESSION['MSN'] = 91;
        }
    }
    //Valida documento
        elseif (!preg_match($patronDocumento, $documento)) {
        if (empty($documento)) {
            header("location:../Vistas/index");
            $_SESSION['MSN'] = 3;
        } else {
            header("location:../Vistas/index");
            $_SESSION['MSN'] = 31;

        }
    }
    //Valida TI
        elseif (!preg_match($patronPrograma, $programa)) {
        if (empty($programa)) {
            header("location:../Vistas/index");
            $_SESSION['MSN'] = 10;
        } else {
            header("location:../Vistas/index");
            $_SESSION['MSN'] = 101;
        }
    }
    //Valida correo
        elseif (!preg_match($patronCorreo, $correo)) {
        if (empty($correo) || $correo == "") {
            header("location:../Vistas/index");
            $_SESSION['MSN'] = 4;
        } else {
            header("location:../Vistas/index");
            $_SESSION['MSN'] = 41;
        }
    } //Termina Validacion de campos y expresiones regulares
    else {

        //Consulta si ya hay un correo en la BD
        $verificarUsuario   = "SELECT correo FROM usuario WHERE correo ='$correo'";
        $verificaExistencia = mysqli_query($conexion, $verificarUsuario);
        if (mysqli_num_rows($verificaExistencia) > 0) {
            header("location:../Vistas/index");
            $_SESSION['MSN'] = 7;
        }

        //Consulta si ya hay un documento en la BD
        $verificarDocumento = "SELECT documento FROM aprendiz WHERE documento ='$documento'";
        $verificaDocumento  = mysqli_query($conexion, $verificarDocumento);
        if (mysqli_num_rows($verificaDocumento) > 0) {
            header("location:../Vistas/index");
            $_SESSION['MSN'] = 8;
        } else { //Todo está bien y envía correo y luego registra el usuario
            //Codigo random que genera para enviar contraseña
            $cadena = "ABCDEFGHIJKLMNOPQRSTVWXYZ0123456789";
            $pass   = '';

            $longitudCadena = strlen($cadena);

            for ($i = 0; $i < 10; $i++) {
                $aleatorio = rand(1, $longitudCadena);
                $pass .= substr($cadena, $aleatorio, 1);
            }
            //Estructura del correo
            $mensaje = '<html>
                <head>
                <title>Bienvenid@</title>
                </head>
                <body>
                <p><b>Hola ' . $nombres . '!</b></p>
                <p>Te has registrado exitosamente,</p>
                <p>Tu cuenta es: <h2>' . $correo . '</h2> </p>
                <p>Tu contraseña es: <h2>' . $pass . '</h2> </p>
                <p>Al ingresar vas a tener que asignar una nueva clave personal.</p>
                ** Por favor no responder a este correo. **
                </body>
                </html>';

            $cabeceras = 'MIME-Version: 1.0' . "\r\n";
            $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $cabeceras .= 'From: Registro <ejemplo@misena.edu.co>' . "\r\n";

            //Clave encliptada
            $key             = ''; // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
            $claveEncriptada = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $pass, MCRYPT_MODE_CBC, md5(md5($key))));

            $registroUsuario = "INSERT INTO usuario (id_roll, correo, clave) VALUES(2, '$correo', '$claveEncriptada');";

            mysqli_set_charset($conexion, "utf8");
            if (mysqli_query($conexion, $registroUsuario)) {
                $actualizaClave   = "UPDATE usuario SET recuperar = 1 where correo = '$correo';";
                $ejecutaSql       = mysqli_query($conexion, $actualizaClave);
                //Consulta ultimo usuario registrado
                $verificaUsuario  = "SELECT id_usuario from usuario u where correo = '$correo'";
                $ultimoUsuario    = mysqli_query($conexion, $verificaUsuario);
                //Obtiene el id del ultimo usuario
                $id_usuario       = $ultimoUsuario->fetch_array(MYSQLI_NUM);
                $registroAprendiz = "INSERT INTO aprendiz (id_usuario, id_tipo_identificacion, id_programa, nombres, documento) VALUES ($id_usuario[0], '$tipoIdentificacion', '$programa', '$nombres', '$documento');";

                if (mysqli_query($conexion, $registroAprendiz)) {
                    //Consulta ultimo aprendiz registrado
                    $verificaAprendiz = "SELECT id_aprendiz from aprendiz a where documento = '$documento'";
                    $ultimoAprendiz   = mysqli_query($conexion, $verificaAprendiz);
                    $id_aprendiz      = $ultimoAprendiz->fetch_array(MYSQLI_NUM);
                    //Registra el puntaje
                    $fecha            = date('Y-m-d H:i:s');
                    $validaPuntaje    = "INSERT INTO puntaje (id_aprendiz, puntajes, estado, record, fecha) VALUES($id_aprendiz[0], 0, 0, 0, '$fecha')";

                    $registroPuntaje = mysqli_query($conexion, $validaPuntaje);
                    // Se envia el correo al usuario

                    if (mail($correo, "Registro exitoso!", $mensaje, $cabeceras)) {
                        header("location:../Vistas/index");
                        $_SESSION['ok'] = 123;
                    } else {
                        //NO SE PUDO ENVIAR EL CORREO
                        header("location:../Vistas/index");
                        $_SESSION['MSNLogin'] = 5;
                    }

                } else {
                    //Si hay algún error elimina el usuario registrado
                    $eliminaUsuario = "DELETE FROM usuario where correo = '$correo';";
                    $ejecutaElimina = mysqli_query($conexion, $eliminaUsuario);
                    header("location:../Vistas/index");
                    $_SESSION['MSN'] = 'error';
                }
            } else {
                die("Fallo en la inserción de Datos." . mysqli_error($conexion));
            }
        }
        mysqli_close($conexion);
    }
}

?>
