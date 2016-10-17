
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
              $key='';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
              $preguntaEncrip = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $data[0], MCRYPT_MODE_CBC, md5(md5($key))));
                $sql = "INSERT into millonario.pregunta(id_pregunta, preguntas) values($id_pregunta[0], '$preguntaEncrip')";
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
                        //Encripción de respuestas
                        $key='';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
                        $res1Encrip = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $data[1], MCRYPT_MODE_CBC, md5(md5($key))));
                        //-------------------------------

                        $key='';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
                        $res2Encrip = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $data[2], MCRYPT_MODE_CBC, md5(md5($key))));
                        //-------------------------------

                        $key='';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
                        $res3Encrip = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $data[3], MCRYPT_MODE_CBC, md5(md5($key))));
                        //-------------------------------

                        $key='';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
                        $res4Encrip = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $data[4], MCRYPT_MODE_CBC, md5(md5($key))));
                        //-------------------------------


                        $sqlRespuesta = "INSERT into millonario.respuesta(id_respuesta, id_pregunta, respuesta1, respuesta2, respuesta3, respuesta4) values($id_respuesta[0], $id_pregunta[0], '$res1Encrip', '$res2Encrip', '$res3Encrip', '$res4Encrip')";
                        //Si hay una respuesta vacía borra la pregunta y la respuesta no se guarda
                        if($data[1]=='' || $data[2]=='' || $data[3]=='' || $data[4]==''){
                          $eliminaUltResp = "DELETE FROM respuesta where id_pregunta='$id_pregunta[0]'";
                          $ejecutaEliminarResp=$conexion->query($eliminaUltResp);

                          $eliminaUltPregunta =  "DELETE FROM pregunta where id_pregunta='$id_pregunta[0]'";
                          $ejecutaEliminarPreg=$conexion->query($eliminaUltPregunta);

                        }

                        $registroRespuesta = $conexion->query($sqlRespuesta);
                      }
                    }
                  }

            //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
            fclose($handle);
            header("location:../Vistas/cargaMasiva");

            echo "<br>Importación exitosa!";
        } else {
            //si aparece esto es posible que el archivo no tenga el formato adecuado, inclusive cuando es cvs, revisarlo para             //ver si esta separado por " , "
            header("location:../Vistas/cargaMasiva");
            echo "Archivo invalido!";
        }
    }else if (isset($_POST['submitProgramas'])) {
        //Aquí es donde seleccionamos nuestro csv
        $fname = $_FILES['sel_file']['name'];

        echo 'Cargando nombre del archivo: ' . $fname . ' ';
        $chk_ext = explode(".", $fname);

        if (strtolower(end($chk_ext)) == "csv") {
            //si es correcto, entonces damos permisos de lectura para subir
            $filename = $_FILES['sel_file']['tmp_name'];

            $handle = fopen($filename, "r");

            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
              $consultaUltPr="SELECT max(p.id_programa)+1 from programa p";

              $resUltPr= $conexion->query($consultaUltPr);

              $id_pr=$resUltPr->fetch_array(MYSQLI_NUM);

              if($id_pr[0]==null){
                $id_pr[0]=1;
              }
                $sql = "INSERT into millonario.programa(id_programa, programas) values($id_pr[0], '$data[0]')";
                //Insertamos los datos con los valores...

                $ejecutaSql=mysqli_query($conexion, $sql);
                // var_dump($sql);exit();


                if ($data[0] == '') {
                    echo "CAMPO programa VACIO";
                }
              }

            //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
            fclose($handle);
            header("location:../Vistas/cargaMasiva");

            echo "<br>Importación exitosa!";
        } else {
            //si aparece esto es posible que el archivo no tenga el formato adecuado, inclusive cuando es cvs, revisarlo para             //ver si esta separado por " , "
            header("location:../Vistas/cargaMasiva");
            echo "Archivo invalido!";
        }
    }
    // header("location:../Vistas/cargaMasiva");

?>
