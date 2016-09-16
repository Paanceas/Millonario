<?php

class consultasAvanzadas
{
  public static function validarSession($usLog)
  {
    include "../Conexion/config.php";
    $sql        = "SELECT verificaSesion FROM usuario WHERE id_usuario = '$usLog';";
    $resultado  = mysqli_query($conexion, $sql);
    $rowSesion=mysqli_fetch_array($resultado);

    $verifica=$rowSesion['verificaSesion'];

    return $verifica;
  }
  mysqli_close($conexion);
}

 ?>
