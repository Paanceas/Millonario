<?php
//INICIAR SESION
// session_start();
include "../Conexion/config.php";
//Carga select tipo identificacion
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

//Carga select programa
$sql       = "SELECT * from programa order by programas asc";
$resultado = $conexion->query($sql);
if ($resultado->num_rows > 0) {
    $programaFormacionSelect = "";
    while ($row = $resultado->fetch_array(MYSQLI_ASSOC)) {
        $programaFormacionSelect .= " <option value='" . $row['id_programa'] . "'>" . $row['programas'] . "</option>";
    }
} else {
  $programaFormacionSelect .= "<option value='null'>No hay registros</option>";

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
    $patronNombres   = "/^([a-zA-Z ZÁáÀàÉéÈèÍíÌìÓóÒòÚúÙùÑñüÜ.]{2,60})$/";
    $patronDocumento = "/^[0-9]{6,12}+$/";
    $patronCorreo    = "/^([a-zA-Z0-9_.+-])*\@(([misena-sena]+)\.)+([edu])+\.([co])+$/";
    $patronClave     = "/^[^ ][0-9a-zA-ZÁáÀàÉéÈèÍíÌìÓóÒòÚúÙùÑñüÜ.,¡!¿?\s]{5,60}+$/";
    $patronTI        = "/^[0-9]{1,10}+$/";
    $patronPrograma  = "/^[0-9]{1,10}+$/";

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
    //Valida TI
        elseif (!preg_match($patronTI, $tipoIdentificacion)) {
        if (empty($tipoIdentificacion)) {
            header("location:../Vistas/formRegistro.php?MSN=9");
        } else {
            header("location:../Vistas/formRegistro.php?MSN=9.1");
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
    //Valida TI
        elseif (!preg_match($patronPrograma, $programa)) {
        if (empty($programa)) {
            header("location:../Vistas/formRegistro.php?MSN=10");
        } else {
            header("location:../Vistas/formRegistro.php?MSN=10.1");
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
    }
    //Termina Validacion de campos y expresiones regulares
    else {
        //Confirma clave
        if ($clave == $confirm) {

            //Consulta si ya hay un correo en la BD
            $verificarUsuario   = "SELECT correo FROM usuario WHERE correo ='$correo'";
            $verificaExistencia = mysqli_query($conexion, $verificarUsuario);
            if (mysqli_num_rows($verificaExistencia) > 0) {
                header("location:../Vistas/formRegistro.php?MSN=7");
            }

            //Consulta si ya hay un documento en la BD
            $verificarDocumento = "SELECT documento FROM aprendiz WHERE documento ='$documento'";
            $verificaDocumento  = mysqli_query($conexion, $verificarDocumento);
            if (mysqli_num_rows($verificaDocumento) > 0) {
                header("location:../Vistas/formRegistro.php?MSN=8");
            } else {
                //Registra usuario
                $registroUsuario = "INSERT INTO usuario (id_roll, correo, clave) VALUES(2, '$correo', '$clave');";
            }


            mysqli_set_charset($conexion, "utf8");
            if (mysqli_query($conexion, $registroUsuario)) {

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
                    header("location:../Vistas/formRegistro.php?MSN=error");

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
