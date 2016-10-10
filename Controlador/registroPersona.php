<?php
include "../Conexion/config.php";
session_start();
function TipoIdentificacionCombobox(){
  //Carga select tipo identificacion
include "../Conexion/config.php";
$sql       = "SELECT * from tipo_identificacion";
$resultado = $conexion->query($sql);
if ($resultado->num_rows > 0) {
    $tipoIdentificacionSelect = "";
    while ($row = $resultado->fetch_array(MYSQLI_ASSOC)) {
        $tipoIdentificacionSelect .= " <option value='" . $row['id_tipo_identificacion'] . "'>" . $row['tipo_identificacion'] . "</option>";
    }
} else {
    $tipoIdentificacionSelect .= "<option value='null'>No hay registros</option>";
}
return $tipoIdentificacionSelect;
}

function ProgramaFormacionCombobox(){
  //Carga select programa

  include "../Conexion/config.php";
$sql       = "SELECT * from programa order by programas asc";
$acentos = $conexion->query("SET NAMES 'utf8'");
$resultado = $conexion->query($sql);
if ($resultado->num_rows > 0) {
    $programaFormacionSelect = "";
    while ($row = $resultado->fetch_array(MYSQLI_ASSOC)) {
        $programaFormacionSelect .= " <option value='" . $row['id_programa'] . "'>" . $row['programas'] . "</option>";
    }
} else {
  $programaFormacionSelect .= "<option value='null'>No hay registros</option>";
}
return $programaFormacionSelect;
}

/*----------------------------------------------------------------------------*/
if (isset($_POST['nombres']) && isset($_POST['documento']) && isset($_POST['correo']) && isset($_POST['tipoIdentificacion']) && isset($_POST['programa']) && isset($_POST['clave']) && isset($_POST['confirm'])) {
    $nombres            = $_POST['nombres'];
    $documento          = $_POST['documento'];
    $correo             = strtolower($_POST['correo']);
    $tipoIdentificacion = $_POST['tipoIdentificacion'];
    $programa           = $_POST['programa'];
    $clave              = $_POST['clave'];
    $confirm            = $_POST['confirm'];


    //Validacion con Expresiones regulares
    $patronNombres   = "/^([a-zA-Z ZÁáÀàÉéÈèÍíÌìÓóÒòÚúÙùÑñüÜ.]{2,60})$/";
    $patronDocumento = "/^[0-9]{6,12}+$/";
    $patronCorreo    = "/^([a-z0-9_.+-])*\@(([misena-sena]+)\.)+([edu])+\.([co])+$/";
    $patronClave     = "/^[^ ][0-9a-zA-ZÁáÀàÉéÈèÍíÌìÓóÒòÚúÙùÑñüÜ.,¡!¿?\s]{5,60}+$/";
    $patronTI        = "/^[0-9]{1,10}+$/";
    $patronPrograma  = "/^[0-9]{1,10}+$/";

    //Valida todos lo campos
    if (empty($nombres) && empty($documento) && empty($correo) && !empty($tipoIdentificacion) && empty($programa) && empty($clave) && empty($confirm)) {
        header("location:../Vistas/index.php");
        $_SESSION['MSN']=1;
    }
    //Valida nombre
    elseif (!preg_match($patronNombres, $nombres)) {
        if (empty($nombres)) {
            header("location:../Vistas/index.php");
            $_SESSION['MSN']=2;
        } else {
            header("location:../Vistas/index.php");
            $_SESSION['MSN']=21;
        }
    }
    //Valida TI
        elseif (!preg_match($patronTI, $tipoIdentificacion)) {
        if (empty($tipoIdentificacion)) {
            header("location:../Vistas/index.php");
            $_SESSION['MSN']=9;
        } else {
            header("location:../Vistas/index.php");
            $_SESSION['MSN']=91;
        }
    }
    //Valida documento
        elseif (!preg_match($patronDocumento, $documento)) {
        if (empty($documento)) {
            header("location:../Vistas/index.php");
            $_SESSION['MSN']=3;
        } else {
            header("location:../Vistas/index.php");
            $_SESSION['MSN']=31;

        }
    }
    //Valida TI
        elseif (!preg_match($patronPrograma, $programa)) {
        if (empty($programa)) {
            header("location:../Vistas/index.php");
            $_SESSION['MSN']=10;
        } else {
            header("location:../Vistas/index.php");
            $_SESSION['MSN']=101;
        }
    }
    //Valida correo
        elseif (!preg_match($patronCorreo, $correo)) {
        if (empty($correo) || $correo == "") {
            header("location:../Vistas/index.php");
            $_SESSION['MSN']=4;
        } else {
            header("location:../Vistas/index.php");
            $_SESSION['MSN']=41;
        }
    }
    //Valida clave
        elseif (!preg_match($patronClave, $clave)) {
        if (empty($clave)) {
            header("location:../Vistas/index.php");
            $_SESSION['MSN']=5;
        } else {
            header("location:../Vistas/index.php?");
            $_SESSION['MSN']=51;
        }
    }
    //Valida confirm
        elseif (!preg_match($patronClave, $confirm)) {
        if (empty($confirm)) {
            header("location:../Vistas/index.php");
            $_SESSION['MSN']=5;
        } else {
            header("location:../Vistas/index.php");
            $_SESSION['MSN']=51;
        }
    }
    //Termina Validacion de campos y expresiones regulares
    else {
        //Confirma clave
        if ($clave == $confirm) {

            //Consulta si ya hay un correo en la BD
            $verificarUsuario   = "SELECT correo FROM usuario WHERE correo ='$correo'";
            $verificaExistencia = mysqli_query($conexion, $verificarUsuario);
            if (mysqli_num_rows($verificaExistencia) > 0) {
                header("location:../Vistas/index.php");
                $_SESSION['MSN']=7;
            }

            //Consulta si ya hay un documento en la BD
            $verificarDocumento = "SELECT documento FROM aprendiz WHERE documento ='$documento'";
            $verificaDocumento  = mysqli_query($conexion, $verificarDocumento);
            if (mysqli_num_rows($verificaDocumento) > 0) {
                header("location:../Vistas/index.php");
                $_SESSION['MSN']=8;
            } else {
                //Registra usuario
                $key='';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
                $claveEncrip = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $_POST['clave'], MCRYPT_MODE_CBC, md5(md5($key))));
                $clave              = $claveEncrip;
                $registroUsuario = "INSERT INTO usuario (id_roll, correo, clave) VALUES(2, '$correo', '$clave');";
            }


            mysqli_set_charset($conexion, "utf8");
            if (mysqli_query($conexion, $registroUsuario)) {

                //Consulta ultimo usuario registrado
                $verificaUsuario  = "SELECT id_usuario from usuario u where correo = '$correo'";
                $ultimoUsuario    = mysqli_query($conexion, $verificaUsuario);
                //Obtiene el id del ultimo usuario
                $id_usuario       = $ultimoUsuario->fetch_array(MYSQLI_NUM);
                $registroAprendiz = "INSERT INTO aprendiz (id_usuario, id_tipo_identificacion, id_programa, nombres, documento) VALUES ($id_usuario[0], '$tipoIdentificacion', '$programa', '$nombres', '$documento');";

                if (mysqli_query($conexion, $registroAprendiz)) {
                  //Consulta ultimo aprendiz registrado
                  $verificaAprendiz = "SELECT id_aprendiz from aprendiz a where documento = '$documento'";
                  $ultimoAprendiz    = mysqli_query($conexion, $verificaAprendiz);
                  $id_aprendiz       = $ultimoAprendiz->fetch_array(MYSQLI_NUM);
                  //Registra el puntaje
                  $fecha=date('Y-m-d');
                  $validaPuntaje="INSERT INTO puntaje (id_aprendiz, puntajes, estado, record, fecha) VALUES($id_aprendiz[0], 0, 0, 0, '$fecha')";

                  $registroPuntaje=$conexion->query($validaPuntaje);

                  header("location:../Vistas/index.php");
                  $_SESSION['ok']=123;
                } else {
                    header("location:../Vistas/index.php");
                    $_SESSION['MSN']='error';
                }
            } else {
                die("Fallo en la inserción de Datos." . mysqli_error($conexion));
            }
        } else {
            header("location:../Vistas/index.php");
            $_SESSION['MSN']=6;
        }
        mysqli_close($conexion);
    }
}



?>
