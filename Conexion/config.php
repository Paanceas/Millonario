<?php
$server="localhost";
$usuario="root";
$contrasena="123456";
$bd="millonario";
//funcion para conectar a la bd mysql
$conexion=mysqli_connect($server,$usuario,$contrasena, $bd);
if (!$conexion) {
  die("Fallo la conexion ".mysqli_connect_error());
}
?>
