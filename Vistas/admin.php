<?php
session_start();
if ($_SESSION['validacion'] == 1) {
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="../Bootstrap/css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="../source/css/animate.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="../source/css/estilos.css" media="screen" title="no title">
    <!-- Add fancyBox main JS and CSS files -->
    	<script type="text/javascript" src="../source/jquery-1.10.1.min.js"></script>
    <script type="text/javascript" src="../source/jquery.fancybox.js?v=2.1.5"></script>
    <link rel="stylesheet" type="text/css" href="../source/jquery.fancybox.css?v=2.1.5" media="screen" />
<?php
    include "../Controlador/adminController.php";
?>
   <title>Inicio</title>
</head>
<body>
  <!-- header barra de navegacion -->
  <nav class="navbar" style="background:#238276">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="admin.php" style="padding:0;">
          <img alt="sena" src="../source/img/logo_sena.png" height="100%" width="60px"/>
        </a>
      </div>
      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li> <a> Bienvenido: <?php echo $_SESSION['nombreAprendiz'] ?></a> </li>
          <li> <a> Programa: <?php echo $_SESSION['programaAprendiz'] ?> </a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <form class="navbar-form navbar-left" action="../Controlador/logout.php">
           <button type="submit" class="btn btn-success" >Salir</button>
         </form>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
  <!-- fin barra de navegacion -->

  <!-- contenido de la pagina -->
  <div class="contenidoPag">
    <h1> HAGASE RICO XD XD XD </h1>
    <div class="row">
      <div class="col-md-7">
        <div class="well bs-component">
          <form class="form-horizontal" action="../Controlador/cargaPreguntas.php" method="post">
            <fieldset>
              <legend>Informacion</legend>
              <p>
                A continuacion encontraras una serie de preguntas el cual debes contestar de acuerdo a tu conocimiento, dale click en jugar y que comienze de juego XD
              </p>
             <div class="form-group">
                 <div class="col-lg-10 col-lg-offset-2">
                   <input type="hidden" id="respCorrec" name="respCorrec" value="0"/>
                   <input type="hidden" name="respSeleccionada" id="respSeleccionada" value="0"/>
                    <button type="submit" class="opcion encorefois"><p><span class="glyphicon glyphicon-play" aria-hidden="true"></span> JUGAR</p></button>
                 </div>
               </div>
            </fieldset>
          </form>
        </div>
      </div>
      <div class="col-md-1"></div>
      <div class="col-md-4">
        <table class="table table-striped table-hover" style="text-align:center">
          <thead>
            <tr class="success">
              <th>Puntaje</th>
              <th>Pregunta Actual</th>
              <th>Total Preguntas</th>
            </tr>
          </thead>
          <tbody>
            <tr >
             <td><?php echo "$puntaje"." pts"; ?></td>
             <td><?php echo "$preguntaCorrecta"; ?></td>
             <td><?php echo "$numPregun"; ?></td>
           </tr>
          </tbody>
        </table>
        <h3>has respondido el: <?php echo ($preguntaCorrecta*100)/$numPregun."%";?> </h3>
        <div class="progress progress-striped active">
          <div class="progress-bar progress-bar-success" style="width: <?php echo ($preguntaCorrecta*100)/$numPregun?>%"></div>
        </div>
      </div>
    </div>
  </div>
  <!-- fin contenido de la pagina -->


<footer>
  <a class="fancybox" href="#inline1" title="Instrucciones">Instrucciones</a>
  <div id="inline1" style="width:800px;display: none;">
  <h3>Instrucciones</h3>
  <img src="../source/img/instrucciones.png" width="800px"/>
  </div>
</footer>
<script type="text/javascript">
$(document).ready(function() {
  			$('.fancybox').fancybox();
});
</script>
</body>
</html>
<?php
} else {
    header('location:../Vistas/formLogin.php');
}
?>
