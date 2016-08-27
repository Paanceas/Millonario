
<?php
//INICIAR SESION
// session_start();

include "../Conexion/config.php";

$sql="SELECT * from tipo_identificacion";
$resultado = $conexion->query($sql);
if ($resultado->num_rows > 0)
{
  $tipoIdentificacion="";
  while ($row = $resultado->fetch_array(MYSQLI_ASSOC))
  {
    $tipoIdentificacion .=" <option value='".$row['id_tipo_identificacion']."'>".$row['tipo_identificacion']."</option>";
  }
}
else
{
  echo "No hay resultados";
}

$sql="SELECT * from programa";
$resultado = $conexion->query($sql);
if ($resultado->num_rows > 0)
{
  $programaFormacion="";
  while ($row = $resultado->fetch_array(MYSQLI_ASSOC))
  {
    $programaFormacion .=" <option value='".$row['id_programa']."'>".$row['programas']."</option>";
  }
}
else
{
  echo "No hay resultados";
}
/*----------------------------------------------------------------------------*/

    if(isset($_POST['nombres']) && isset($_POST['documento']) && isset($_POST['correo']) && isset($_POST['tipoIdentificacion']) && isset($_POST['programa']) && isset($_POST['clave']) && isset($_POST['confirm'])){

      $nombres=$_POST['nombres'];
      $documento=$_POST['documento'];
      $correo=$_POST['correo'];
      $tipoIdentificacion=$_POST['tipoIdentificacion'];
      $programa=$_POST['programa'];
      $clave=$_POST['clave'];
      $confirm=$_POST['confirm'];

      if(!empty($nombres) && !empty($documento) && !empty($correo) && !empty($tipoIdentificacion) && !empty($programa) && !empty($clave) && !empty($confirm)){

      if($clave==$confirm){

        //Consulta si ya hay un correo en la BD
        $verificarUsuario="SELECT correo FROM usuario WHERE correo ='$correo'";
        $verificaExistencia=mysqli_query($conexion, $verificarUsuario);
        if(mysqli_num_rows($verificaExistencia)>0){
          echo "el usuario ya esta registrado con este correo";
          header("location:../Vistas/formRegistro.php?error");
        }


        //Registra usuario
        $registroUsuario = "INSERT INTO usuario (id_roll, correo, clave) VALUES(2, '$correo', '$clave');";
        mysqli_set_charset($conexion, "utf8");
        if(mysqli_query($conexion, $registroUsuario)){

          //Consulta si ya hay un documento en la BD
          $verificarDocumento = "SELECT documento FROM aprendiz WHERE documento ='$documento'";
          $verificaDocumento = mysqli_query($conexion, $verificarDocumento);

          if(mysqli_num_rows($verificaDocumento)>0){
            echo "el Documento ya esta registrado";
             header("location:../Vistas/formRegistro.php?MSN=2");
          }

          //Consulta ultimo usuario registrado
          $verificaUsuario="SELECT max(u.id_usuario) from usuario u";
          $ultimoUsuario=mysqli_query($conexion, $verificaUsuario);

          //Obtiene el id del ultimo usuario
          $id_usuario = $ultimoUsuario->fetch_array(MYSQLI_NUM);


          $registroAprendiz = "INSERT INTO aprendiz (id_usuario, id_tipo_identificacion, id_programa, nombres, documento) VALUES ($id_usuario[0], '$tipoIdentificacion', '$programa', '$nombres', '$documento');";

          mysqli_set_charset($conexion, "utf8");
          if(mysqli_query($conexion, $registroAprendiz)){
            header("location:../Vistas/formRegistro.php?MSN=ok");

          }
        }else{
          die("Fallo en la inserción de Datos.".mysqli_error($conexion));
        }

      }else{
        echo 'las claves no coinciden';
        header("location:../Vistas/formRegistro.php?MSN=1");

      }


  }else{
    header("location:../Vistas/formRegistro.php?MSN=ok");

  }
  mysqli_close($conexion);
  // header('location:../Vistas/formRegistro.php');
}

?>
