<?php
require('../Controlador/clases/consultasAvanzadas.php');
session_start();
$_SESSION['verificaSesion'] = consultasAvanzadas::validarSession($_SESSION['id_usuario']);
$_SESSION['recuperar']      = consultasAvanzadas::recuperar($_SESSION['id_usuario']);

if ($_SESSION['verificaSesion'] == 1 && $_SESSION['validacion'] == 1 && $_SESSION['id_roll'] == 1) {
    $usuario            = $_SESSION['id_usuario'];
    //Control tiempo que lleva logueado
    $fechaActual        = date('Y-m-d H:i:s');
    $tiempoTranscurrido = (strtotime($fechaActual) - strtotime($_SESSION['fechaIngreso']));

    //Cierra sesión después de 1500 milisegundos = 25 minutos de inactividad
    if (isset($_SESSION['fechaIngreso'])) {
        if ($tiempoTranscurrido >= 1500) {
            header("location: /Controlador/logout.php");
        } else {
            $_SESSION['fechaIngreso'] = $fechaActual;
        }
    }


    if ($_SESSION['recuperar'] == 1) {
        header("location: nuevaPass");
    } else {
?>
<!DOCTYPE html>
<head>

<?php
        require("../Controlador/adminController.php");
        require('../Controlador/clases/mensajesAdmin.php');
?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

<title>Autoevaluación</title>
<link rel="stylesheet" href="../Bootstrap/css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
  <link rel="stylesheet" href="../source/css/animate.css" media="screen" title="no title" charset="utf-8">
  <link rel="stylesheet" href="../source/css/estilos.css" media="screen" title="no title">
      <link rel="stylesheet" href="../source/css/style.css" media="screen" title="no title">
      <link rel="stylesheet" href="../source/css/sweetalert.css" media="screen" title="no title">
      <link rel="stylesheet" type="text/css" href="../source/jquery.fancybox.css?v=2.1.5" media="screen" />

<link href='../source/img/favicon.ico' rel='icon' type='image/x-icon'/>

<!-- PAGINACION -->

    <link rel="stylesheet" type="text/css" href="../source/css/dataTables.bootstrap.min.css">

</head>

  <body>

    <nav class="navbar navbar-inverse navbar-juego">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <div class="navbar-header">
          <a class="navbar-brand" href="cargaMasiva" style="padding:0;">
            <img alt="sena" src="../source/img/logo_sena.png" height="90%" width="52px"/>
          </a>
        </div>
      </div>

      <div class="navbar-collapse collapse" id="bs-example-navbar-collapse-1" aria-expanded="false" style="height: 1px;">
        <ul class="nav navbar-nav">
<li><a>
  <?php
        if (sesiones() == 1) {
            echo "Hay <b>" . sesiones() . "</b> aprendiz conectado";
        } else if (sesiones() > 1) {
            echo "Hay <b>" . sesiones() . "</b> aprendices conectados";
        } else {
            echo "No hay ningún aprendiz conectado";
        }

?></a>
</li>
<li><a><?php

        echo "<b>Hora de ingreso:</b> " . $_SESSION['fechaIngresoHora'];
?></li></a>

        </ul>
        <ul class="nav navbar-nav navbar-right">
          <form class="navbar-form navbar-left" action="../Controlador/logout.php">
            <center>
              <button type="button"class="btn btn-primary" data-toggle="modal" data-target="#preguntasS">Preguntas</button>
              <button type="button"class="btn btn-primary" data-toggle="modal" data-target="#programasS">Programas</button>
              <button type="submit" class="btn btn-success" >
                SALIR <span class="glyphicon glyphicon-log-out"></span>
              </button>
          </center>
         </form>
        </ul>
      </div>
    </div>
    </nav>
    <div>


</div>

<div class="container">
<div class="table-responsive" style="font-size:13px;">
 <table id="example" class="table table-condensed table-hover dataTable table-reflow" style="text-align:left">
    <thead>
      <tr class="success">
        <th  style="width:6%;"><center>Puesto</center> </th>
        <th style="width:5%;"><center>Récord</center> </th>
        <th style="width:5%;"><center>Jugadas</center> </th>
        <th style="width:20%;"><center>Nombres</center></th>
        <th style="width:10%;"><center>Documento</center></th>
        <th style="width:15%;"><center>Correo</center></th>
        <th style="width:9%;"><center>Fecha</center></th>
        <th style="width:25%;"><center>Programa</center></th>
      </tr>
    </thead>
    <tbody>
      <?php
        echo listado();
?>
  </tbody>
  </table>
  <hr>
</div>


</div>
<footer class="footer-distributed">
  <div class="footer-left">
      <p class="footer-links">
        <a href="#">Inicio</a>
        ·
        <a class="fancybox" href="#inline1" title="Instrucciones">Instrucciones</a>
        ·
        <a href="#">Créditos</a>
      </p>
  </div>

    <div class="footer-left">
            <p class="footer-links">SENA - Centro de Gestión de Mercados, Logística y TI, Distrito Capital</p>
          </div>
                <div id="inline1" style="width:800px;display: none;">
                <h3>Instrucciones</h3>
                <img src="../source/img/instrucciones.png" width="800px"/>
                </div>
        </footer>
 <!-- Add fancyBox main JS and CSS files -->
 <!-- <script type="text/javascript" language="javascript" src="../source/js/jquery-1.12.3.js"></script> -->
 <script src="../Bootstrap/js/jquery-1.10.2.min.js"></script>
     <script src="../source/js/jquery.dataTables.min.js"></script>
     <script src="../source/js/dataTables.bootstrap.min.js"></script>

  <script src="../Bootstrap/js/bootstrap.min.js"></script>
 <script src="../source/js/sweetalert.min.js"></script>
   <?php
        if (isset($_SESSION['pregunGuardada']) && $_SESSION['pregunGuardada'] == 'pregGuardada') {
            echo "<script type='text/javascript'>";
            MensajesAdmin::subirPreguntas();
            echo "</script>";
        } else if (isset($_SESSION['archivoInval']) && $_SESSION['archivoInval'] == 2) {
            echo "<script type='text/javascript'>";
            MensajesAdmin::archivoInval();
            echo "</script>";
        }
        if (isset($_SESSION['proogramaGuar']) && $_SESSION['proogramaGuar'] == 'proogramaGuar') {
            echo "<script type='text/javascript'>";
            MensajesAdmin::subirProgramas();
            echo "</script>";
        } else if (isset($_SESSION['archivoInvalProg']) && $_SESSION['archivoInvalProg'] == 2) {
            echo "<script type='text/javascript'>";
            MensajesAdmin::archivoInval();
            echo "</script>";
        }
        $_SESSION['pregunGuardada'] = 99;

        $_SESSION['archivoInval'] = 99;

        $_SESSION['proogramaGuar'] = 99;

        $_SESSION['archivoInvalProg'] = 99;

?>
        <script>
             $(document).ready(function() {
                 $('#example').DataTable({

                     "language": {
                         "lengthMenu": "Mostar _MENU_ registros por página",
                         "info": "Mostrando página _PAGE_ de _PAGES_",
                         "infoEmpty": "No hay registros",
                         "infoFiltered": "(filtrada de _MAX_ registros)",
                         "search": "<span class='glyphicon glyphicon-search' style='font-size: 17px; color:black;'> Buscar:</span>",
                         "paginate": {
                             "next":       "Siguiente",
                             "previous":   "Anterior"
                         },
                     }
                 });
             } );

         </script>
     <!-- //////PAGINACION //////-->

<!-- VENTANAS MODALES PARA CARGA DE DATOS -->
<!-- Modal -->
  <div class="modal fade" id="preguntasS" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <form action='../Controlador/carga.php' method='post' enctype="multipart/form-data">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Subir Preguntas</h4>
        </div>
        <div class="modal-body">
             <br><center>Importar Archivo :<br> <input type='file' class='btn btn-primary' name='sel_file' size='20'><br>

        </div>
        <div class="modal-footer">
          <input type='submit' name='submit' class='btn btn-success' value='Subir preguntas'></center>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
      </div>

    </div>
  </div>
  <!-- Modal -->
    <div class="modal fade" id="programasS" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form action='../Controlador/carga.php' method='post' enctype="multipart/form-data">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Subir Programas</h4>
          </div>
          <div class="modal-body">
            <center>
               <input type='file' class='btn btn-primary' name='sel_file' size='20'><br>
             </center>
          </div>
          <div class="modal-footer">
            <input type='submit' name='submitProgramas' class='btn btn-danger' value='Subir programas'></center>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </form>
        </div>

      </div>
    </div>
 </body>
</html>
<?php
    }
} else {
    header('location:../Vistas/index');
    $_SESSION['MSNLogin'] = 2;
}
?>
