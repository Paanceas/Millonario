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

</head>

  <body>
    <form class="navbar-form navbar-left" action="logout.php">

     <button type="submit" class="btn btn-success" >
      Salir <span class="glyphicon glyphicon-log-out"></span>
     </button>
    </form>
<div style="margin-top: 120px;">
  <center><h1>Importando archivo CSV</h1></center><br>
  <form action='<?php
    echo $_SERVER["PHP_SELF"];
?>' method='post' enctype="multipart/form-data">
   <br><center>Importar Archivo :<br> <input type='file' name='sel_file' size='20'><br>
   <input type='submit' name='submit' value='submit'></center>

 </div>
  </form>

 </body>
</html>

<?php

    include "../Conexion/config.php";

    if (isset($_POST['submit'])) {
        //Aquí es donde seleccionamos nuestro csv
        $fname = $_FILES['sel_file']['name'];

        echo 'Cargando nombre del archivo: ' . $fname . ' ';
        $chk_ext = explode(".", $fname);

        if (strtolower(end($chk_ext)) == "csv") {
            //si es correcto, entonces damos permisos de lectura para subir
            $filename = $_FILES['sel_file']['tmp_name'];

            $handle = fopen($filename, "r");

            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
              $consultaUltPre="SELECT max(p.id_pregunta)+1 from pregunta p";
              $resUltPreg= $conexion->query($consultaUltPre);
              $id_pregunta=$resUltPreg->fetch_array(MYSQLI_NUM);

              if($id_pregunta[0]==null){
                $id_pregunta[0]=1;
              }
                $sql = "INSERT into millonario.pregunta(id_pregunta, preguntas) values($id_pregunta[0], '$data[0]')";
                //Insertamos los datos con los valores...

                if ($data[0] == '') {
                    echo "CAMPO PREGUNTA VACIO";
                } else {
                    $res = $conexion->query($sql);

                    if ($res != false) {
                        $consultaUltimaPreg = "select max(p.id_pregunta) from pregunta p";
                        $resUltmaPregunta   = $conexion->query($consultaUltimaPreg);

                        $id_pregunta = $resUltmaPregunta->fetch_array(MYSQLI_NUM);


                        /*---------------------------RESPUESTA---------------------------*/

                        //evitar que se salten los id de las repsuestas
                        $consultaUltimaResp = "select max(r.id_respuesta)+1 from respuesta r";
                        $resUltmaRespuesta  = $conexion->query($consultaUltimaResp);

                        $id_respuesta = $resUltmaRespuesta->fetch_array(MYSQLI_NUM);

                        //SI NO HAY REGISTROS id_respuesta cuenta = 1
                        if ($id_respuesta[0] == null) {
                            // $id_respuesta       = $resUltmaRespuesta->fetch_array(MYSQLI_NUM);
                            $id_respuesta[0] = 1;
                        }

                        $sqlRespuesta = "INSERT into millonario.respuesta(id_respuesta, id_pregunta, respuesta1, respuesta2, respuesta3, respuesta4) values($id_respuesta[0], $id_pregunta[0], '$data[1]', '$data[2]', '$data[3]', '$data[4]')";
                        //Si hay una respuesta vacía borra la pregunta y la respuesta no se guarda
                        if($data[1]=='' || $data[2]=='' || $data[3]=='' || $data[4]==''){
                          $eliminaUltResp = "DELETE FROM respuesta where id_pregunta='$id_pregunta[0]'";
                          $ejecutaEliminarResp=$conexion->query($eliminaUltResp);

                          $eliminaUltPregunta =  "DELETE FROM pregunta where id_pregunta='$id_pregunta[0]'";
                          $ejecutaEliminarPreg=$conexion->query($eliminaUltPregunta);

                        }
                        // echo "<br>resulrado res:   ";

                        // var_dump($sqlRespuesta);
                        $registroRespuesta = $conexion->query($sqlRespuesta);
                      }
                    }
                  }

            //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
            fclose($handle);
            echo "<br>Importación exitosa!";
        } else {
            //si aparece esto es posible que el archivo no tenga el formato adecuado, inclusive cuando es cvs, revisarlo para             //ver si esta separado por " , "
            echo "Archivo invalido!";
        }
    }
} else {
    header('location:../Vistas/formLogin.php?MSN=2');
}
?>
