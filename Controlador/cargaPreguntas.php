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
}else {
  $cargarLaPregunta = 1;
}
// $verifi  = "SELECT min(r.id_respuesta) from respuesta r";
//
// $can        = $conexion->query($verifi);
// $canAr       = $can->fetch_array(MYSQLI_NUM);
//

  if ($cargarLaPregunta == 1) {


    $consultaRespuesta = "SELECT * from respuesta r JOIN pregunta p ON p.id_pregunta = r.id_pregunta ";


    mysqli_set_charset($conexion, "utf8");
    $resultado         = $conexion->query($consultaRespuesta);

    if ($resultado->num_rows > 0) {

        $respuesta = "";
        $preguntas = "";

        //==
        $cont      = 0;
        $arrayNumeros = array();
        $arrayNumeros = randomNum();

        while($row = $resultado->fetch_array(MYSQLI_ASSOC)){

          $preguntas .= " <span value='" . $row['id_pregunta'] . "'>" . $row['preguntas'] . "</span><br>";
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
        }

    }

    header('location: ../Vistas/juego.php');

    }
      else {
    header('location: ../Vistas/admin.php');
  }


?>
