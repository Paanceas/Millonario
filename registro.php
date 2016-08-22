<?php

include 'config.php';

function eje()
{
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


?>
