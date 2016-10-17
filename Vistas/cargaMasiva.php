<?php
require('../Controlador/clases/consultasAvanzadas.php');
session_start();
$_SESSION['verificaSesion'] = consultasAvanzadas::validarSession($_SESSION['id_usuario']);
$_SESSION['recuperar']      = consultasAvanzadas::recuperar($_SESSION['id_usuario']);

if ($_SESSION['verificaSesion'] == 1 && $_SESSION['validacion'] == 1 && $_SESSION['id_roll'] == 1) {
    $usuario = $_SESSION['id_usuario'];

    if ($_SESSION['recuperar'] == 1) {
        header("location: nuevaPass");
    } else {
?>
<!DOCTYPE html>
<head>

<?php
        include "../Controlador/adminController.php";
?>
<meta charset="utf-8">
<link rel="stylesheet" href="../Bootstrap/css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">

<link rel="stylesheet" href="../source/css/estilos.css" media="screen" title="no title">

<title>Administración</title>

<link href='../source/img/favicon.ico' rel='icon' type='image/x-icon'/>

<!-- PAGINACION -->
<script type="text/javascript" language="javascript" src="../source/js/jquery-1.12.3.js">
        </script>
    <script type="text/javascript" language="javascript" src="../source/js/jquery.dataTables.min.js">
    </script>
        <script type="text/javascript" language="javascript" src="../source/js/dataTables.bootstrap.min.js">
        </script>
        <link rel="stylesheet" type="text/css" href="../source/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../source/css/dataTables.bootstrap.min.css">


        <script>
            $(document).ready(function() {
                $('#example').DataTable({

                    "language": {
                        "lengthMenu": "Mostar _MENU_ registros por página",
                        "info": "Mostrando página _PAGE_ de _PAGES_",
                        "infoEmpty": "No hay registros",
                        "infoFiltered": "(filtrada de _MAX_ registros)",
                        "search": "<span class='glyphicon glyphicon-search' style='font-size: 17px; color:black;'>Buscar:</span>",
                        "paginate": {
                            "next":       "Siguiente",
                            "previous":   "Anterior"
                        },
                    }
                });
            } );

        </script>
    <!-- //////PAGINACION //////-->

</head>

  <body>
    <form class="navbar-form navbar-left" action="../Controlador/logout.php">

     <button type="submit" class="btn btn-success" >
      SALIR <span class="glyphicon glyphicon-log-out"></span>
     </button>
    </form>

    <?php
    echo "Hay <b>" .sesiones()."</b> aprendices conectados";
?>
 <table id="example" class="table table-condensed table-hover dataTable" style="text-align:left">
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
  <div style="margin-top: 120px;">
    <center><h1>Importando archivo CSV</h1></center><br>
    <form action='../Controlador/carga.php' method='post' enctype="multipart/form-data">
     <br><center>Importar Archivo :<br> <input type='file' name='sel_file' size='20'><br>
     <input type='submit' name='submit' value='Subir preguntas'></center>

   </div>

    </form>
    <form action='../Controlador/carga.php' method='post' enctype="multipart/form-data">
     <br><center>Importar Archivo programas:<br> <input type='file' name='sel_file' size='20'><br>
     <input type='submit' name='submitProgramas' value='Subir programas'></center>

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
