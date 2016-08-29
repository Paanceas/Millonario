<?php
//INICIAR SESION
// session_start();
include "../Conexion/config.php";

$sql       = "SELECT * from tipo_identificacion";
$resultado = $conexion->query($sql);
if ($resultado->num_rows > 0) {
    $tipoIdentificacion = "";
    while ($row = $resultado->fetch_array(MYSQLI_ASSOC)) {
        $tipoIdentificacion .= " <option value='" . $row['id_tipo_identificacion'] . "'>" . $row['tipo_identificacion'] . "</option>";
    }
} else {
    echo "No hay resultados";
}
$sql       = "SELECT * from programa";
$resultado = $conexion->query($sql);
if ($resultado->num_rows > 0) {
    $programaFormacion = "";
    while ($row = $resultado->fetch_array(MYSQLI_ASSOC)) {
        $programaFormacion .= " <option value='" . $row['id_programa'] . "'>" . $row['programas'] . "</option>";
    }
} else {
    echo "No hay resultados";
}
/*----------------------------------------------------------------------------*/
if (isset($_POST['nombres']) && isset($_POST['documento']) && isset($_POST['correo']) && isset($_POST['tipoIdentificacion']) && isset($_POST['programa']) && isset($_POST['clave']) && isset($_POST['confirm'])) {
    $nombres            = $_POST['nombres'];
    $documento          = $_POST['documento'];
    $correo             = $_POST['correo'];
    $tipoIdentificacion = $_POST['tipoIdentificacion'];
    $programa           = $_POST['programa'];
    $clave              = $_POST['clave'];
    $confirm            = $_POST['confirm'];

    //Validacion con Expresiones regulares
    $patronNombres   = "/^([a-zA-Z ñáéíóú.]{2,60})$/";
    $patronDocumento = "/^[0-9]{6,12}+$/";
    $patronCorreo    = "/^([a-zA-Z0-9_.+-])*\@(([misena-sena]+)\.)+([edu])+\.([co])+$/";
    $patronClave     = "/^[^ ][0-9a-zA-ZÁáÀàÉéÈèÍíÌìÓóÒòÚúÙùÑñüÜ.,¡!¿?\s]+$/";

    //Valida todos lo campos
    if (empty($nombres) && empty($documento) && empty($correo) && !empty($tipoIdentificacion) && empty($programa) && empty($clave) && empty($confirm)) {
        header("location:../Vistas/formRegistro.php?MSN=1");
    }
    //Valida nombre
    elseif (!preg_match($patronNombres, $nombres)) {
        if (empty($nombres)) {
            header("location:../Vistas/formRegistro.php?MSN=2");
        } else {
            header("location:../Vistas/formRegistro.php?MSN=2.1");
        }
    }
    //Valida documento
        elseif (!preg_match($patronDocumento, $documento)) {
        if (empty($documento)) {
            header("location:../Vistas/formRegistro.php?MSN=3");
        } else {
            header("location:../Vistas/formRegistro.php?MSN=3.1");
        }
    }
    //Valida correo
        elseif (!preg_match($patronCorreo, $correo)) {
        if (empty($correo) || $correo == "") {
            header("location:../Vistas/formRegistro.php?MSN=4");
        } else {
            header("location:../Vistas/formRegistro.php?MSN=4.1");
        }
    }
    //Valida clave
        elseif (!preg_match($patronClave, $clave)) {
        if (empty($clave)) {
            header("location:../Vistas/formRegistro.php?MSN=5");
        } else {
            header("location:../Vistas/formRegistro.php?MSN=5.1");
        }
    }
    //Valida confirm
        elseif (!preg_match($patronClave, $confirm)) {
        if (empty($confirm)) {
            header("location:../Vistas/formRegistro.php?MSN=5");
        } else {
            header("location:../Vistas/formRegistro.php?MSN=5.1");
        }
    } else {
        //Confirma clave
        if ($clave == $confirm) {
            //Consulta si ya hay un correo en la BD
            $verificarUsuario   = "SELECT correo FROM usuario WHERE correo ='$correo'";
            $verificaExistencia = mysqli_query($conexion, $verificarUsuario);
            if (mysqli_num_rows($verificaExistencia) > 0) {
                header("location:../Vistas/formRegistro.php?MSN=7");
            }
            //Registra usuario
            $registroUsuario = "INSERT INTO usuario (id_roll, correo, clave) VALUES(2, '$correo', '$clave');";


            mysqli_set_charset($conexion, "utf8");
            if (mysqli_query($conexion, $registroUsuario)) {
                //Consulta si ya hay un documento en la BD
                $verificarDocumento = "SELECT documento FROM aprendiz WHERE documento ='$documento'";
                $verificaDocumento  = mysqli_query($conexion, $verificarDocumento);
                if (mysqli_num_rows($verificaDocumento) > 0) {
                    header("location:../Vistas/formRegistro.php?MSN=8");
                }
                //Consulta ultimo usuario registrado
                $verificaUsuario  = "SELECT max(u.id_usuario) from usuario u";
                $ultimoUsuario    = mysqli_query($conexion, $verificaUsuario);
                //Obtiene el id del ultimo usuario
                $id_usuario       = $ultimoUsuario->fetch_array(MYSQLI_NUM);
                $registroAprendiz = "INSERT INTO aprendiz (id_usuario, id_tipo_identificacion, id_programa, nombres, documento) VALUES ($id_usuario[0], '$tipoIdentificacion', '$programa', '$nombres', '$documento');";
                mysqli_set_charset($conexion, "utf8");
                if (mysqli_query($conexion, $registroAprendiz)) {
                    header("location:../Vistas/formRegistro.php?MSN=ok");
                } else {
                    header("location:../Vistas/formRegistro.php?MSN=okno");

                }
            } else {
                die("Fallo en la inserción de Datos." . mysqli_error($conexion));
            }
        } else {
            header("location:../Vistas/formRegistro.php?MSN=6");
        }
        mysqli_close($conexion);
    }
    // header('location:../Vistas/formRegistro.php');
}

?>
