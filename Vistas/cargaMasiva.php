<?php
session_start();
if ($_SESSION['validacion'] == 1 && $_SESSION['id_usuario'] > 0 && $_SESSION['id_roll'] == 1) {
    $usuario = $_SESSION['id_usuario'];
?>
<!DOCTYPE html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="../Bootstrap/css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">

<link rel="stylesheet" href="../source/css/estilos.css" media="screen" title="no title">

<title>Carga Preguntas</title>
<link href='../source/img/favicon.ico' rel='icon' type='image/x-icon'/>

</head>

  <body>
    <form class="navbar-form navbar-left" action="../Controlador/logout.php">

     <button type="submit" class="btn btn-success" >
      Salir <span class="glyphicon glyphicon-log-out"></span>
     </button>
    </form>
<div style="margin-top: 120px;">
  <center><h1>Importando archivo CSV</h1></center><br>
  <form action='../Controlador/carga.php' method='post' enctype="multipart/form-data">
   <br><center>Importar Archivo :<br> <input type='file' name='sel_file' size='20'><br>
   <input type='submit' name='submit' value='submit'></center>

 </div>
  </form>

 </body>
</html>
<?php } else {
    header('location:../Vistas/index');
    $_SESSION['MSNLogin']=2;
} ?>
