<?php
session_start();
session_destroy();
header("location:/formLogin.php");
exit();
?>
