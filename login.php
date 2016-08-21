<?php

session_start();

include "config.php";

$conexion=mysqli_connect($servidor, $usuario, $contrasena, $bd);
//mysqli_real_escape_string evita Inyeccion SQL (' or '1'=1) de lo contrario se loguearia son ningun problema
$usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);
$contrasena = mysqli_real_escape_string($conexion, $_POST['contrasena']);

$sql="SELECT * FROM usuario WHERE correo= '$usuario' AND clave = '$contrasena';";

$resultado=mysqli_query($conexion, $sql);
if (mysqli_num_rows($resultado)>0) {
  $_SESSION['usuario']=$usuario;
  $_SESSION['contrasena']=$contrasena;
  header("location:index.php");
}else {
  session_unset();
  session_destroy();
  header("location:formLogin.php?error");
}
mysqli_close($conn);
?>
