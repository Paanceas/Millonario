<?php
session_start();
session_destroy();
header("location:../Vistas/formLogin.php");
exit();
?>
