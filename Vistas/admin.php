<?php
session_start();
if ($_SESSION['validacion'] == 1 && $_SESSION['id_roll'] == 1 ) {
?>
<!DOCTYPE html>
<html>
<head>
<?php
    include "modalinstrucc.php";
?>
   <title>Inicio</title>
</head>
<body>
<h1>Bienvenido Administrador</h1>
<form action="../Controlador/logout.php">
    <button type="submit" >Salir</button>
</form>

</body>
</html>
<?php
} else {
    header('location:../Vistas/formLogin.php');
}
?>
