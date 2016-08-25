<?php
//INICIAR SESION
session_start();

include "../Conexion/config.php";

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

$conexion = mysqli_connect($server, $usuario, $contrasena, $bd);
    if(isset($correo) && isset($clave) && isset($confirm)){
      if(!empty($correo) || !empty($clave) || !empty($confirm)){

      if($clave==$confirm){

        $verificar="SELECT correo FROM usuario WHERE correo ='$correo'";
        $verificaExistencia=mysqli_query($conexion, $verificar);
        if(mysqli_num_rows($verificaExistencia)>0){
          echo "el usuario ya esta registrado con este correo";
          header("location:../Vistas/formRegistro.php?error");
        }


      $sql = "INSERT INTO usuario (id_roll, correo, clave) VALUES(2, '$correo', '$clave');";
      mysqli_set_charset($conexion, "utf8");
      if(mysqli_query($conexion, $sql)){
        echo "Datos Insertados Correctamente.";
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
