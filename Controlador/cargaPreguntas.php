<?php

include "../Conexion/config.php";
function randomNum(){
    $num = range(1, 4);
    shuffle($num);
    foreach ($num as $val) {
        $posiciones[] = $val;
    }
    return $posiciones;
}

/*------------------------------------*/
//
if (isset($_POST['respCorrec'])) {
  $cargarLaPregunta = $_POST['respCorrec'];
  echo $_POST['respCorrec'];

}else {
  $cargarLaPregunta = 1;
}

// function cargarLasPregunta($numeroPost, $cargarLaPregunta)
// {
// include "../Conexion/config.php";


  if ($cargarLaPregunta == 1) {

    $consultaRespuesta = "SELECT * from respuesta r JOIN pregunta p ON p.id_pregunta = r.id_pregunta";
    mysqli_set_charset($conexion, "utf8");
    $resultado         = $conexion->query($consultaRespuesta);

    mysqli_set_charset($conexion, "utf8");
    if ($resultado->num_rows > 0) {

        $respuesta = "";
        //==
        $cont      = 0;
        $preguntas = "";
        $row = $resultado->fetch_array(MYSQLI_ASSOC);

        // foreach ($row as $key => $value) {
        //   var_dump($value);
        //   var_dump($key);
        //   echo "<br/>";
        //
        // }
        // exit();
        // var_dump($row);exit;

        // while ($row = $resultado->fetch_array(MYSQLI_ASSOC)) {
          $preguntas .= " <span value='" . $row['id_pregunta'] . "'>" . $row['preguntas'] . "</span><br>";


            $arrayNumeros = array();
            $arrayNumeros = randomNum();
            foreach ($arrayNumeros as $value) {

                switch ($value) {
                    case '1':
                        $respuesta .= "<td><button name='r1' id='r1' onclick='vp(1)'>" . $row['respuesta1'] . "</button></td>";
                        break;
                    case '2':
                        $respuesta .= "<td><button name='r2' id='r2' onclick='vp(2)'>" . $row['respuesta2'] . "</button></td>";
                        break;
                    case '3':
                        $respuesta .= "<td><button name='r3' id='r3' onclick='vp(3)'>" . $row['respuesta3'] . "</button></td>";
                        break;
                    case '4':
                        $respuesta .= "<td><button name='r4'id='r4' onclick='vp(4)'>" . $row['respuesta4'] . "</button></td>";
                        break;
                }
            }
        // }
    }
      header('location: ../Vistas/juego.php');
  }else {
    header('location: ../Vistas/admin.php');
  }

// }

?>
