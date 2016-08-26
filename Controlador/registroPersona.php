<?php
//INICIAR SESION
session_start();

include "../Conexion/config.php";

$nombres=$_POST['nombres'];
$documento=$_POST['documento'];
// $tipoIdentificacion=$_POST['tipoIdentificacion'];
$correo=$_POST['correo'];
$clave=$_POST['clave'];
$confirm=$_POST['confirm'];


$sql="SELECT * from tipo_identificacion";
$resultado = $conexion->query($sql);
if ($resultado->num_rows > 0)
{
  $tipoIdentificacion="";
  while ($row = $resultado->fetch_array(MYSQLI_ASSOC))
  {
    $tipoIdentificacion .=" <option name='tipoIdentificacion' value='".$row['id_tipo_identificacion']."'>".$row['tipo_identificacion']."</option>";
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

  $conexion = mysqli_connect($server, $usuario, $contrasena, $bd);
    if(isset($nombres) && isset($documento) && isset($correo) && isset($clave) && isset($confirm)){
      if(!empty($nombres) || !empty($documento) || !empty($correo) || !empty($clave) || !empty($confirm)){

      if($clave==$confirm){

        $verificar="SELECT correo FROM usuario WHERE correo ='$correo'";
        $verificaExistencia=mysqli_query($conexion, $verificar);
        if(mysqli_num_rows($verificaExistencia)>0){
          echo "el usuario ya esta registrado con este correo";
          header("location:../Vistas/formRegistro.php?error");
        }


      $registroUsuario = "INSERT INTO usuario (id_roll, correo, clave) VALUES(2, '$correo', '$clave');";
      mysqli_set_charset($conexion, "utf8");
      if(mysqli_query($conexion, $registroUsuario)){

        $ultimoUsuario="SELECT max(id_usuario) FROM usuario";
        $verificaUsu=mysqli_query($conexion, $ultimoUsuario);

        if(mysqli_num_rows($verificaUsu)>0){
          $registroAprendiz = "INSERT INTO aprendiz (id_usuario, nombres, documento, id_tipo_identificacion) VALUES ('$resultadoUltUsu', '$nombres', '$documento', 1);";

        }else{
          die("Fallo en la inserción de Datos.".mysqli_error($conexion));
        }

      }else{
        die("Fallo en la inserción de Datos.".mysqli_error($conexion));
      }
    }else{
      echo "Las claves no coinciden";
    }


  }else{
    echo "Llene los campos";
  }
  mysqli_close($conexion);
  header('location:../Vistas/formRegistro.php');
}

?>
