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


// $sql       = "SELECT * from pregunta";
// mysqli_set_charset($conexion, "utf8");
// $resultado = $conexion->query($sql);
// if ($resultado->num_rows > 0) {
//     $preguntas = "";
//
//     $row = $resultado->fetch_array(MYSQLI_ASSOC);
//     $preguntas .= " <span value='" . $row['id_pregunta'] . "'>" . $row['preguntas'] . "</span><br>";
//
// }

//Captura el id de la pregunta
// $sql       = "SELECT id_pregunta from pregunta";
// mysqli_set_charset($conexion, "utf8");
// $resultado = $conexion->query($sql);
// if ($resultado->num_rows > 0) {
//
//     $row = $resultado->fetch_array(MYSQLI_ASSOC);
//         $preguntaID = $row['id_pregunta'];
//
// }




$consultaRespuesta = "SELECT * from respuesta r JOIN pregunta p ON p.id_pregunta = r.id_pregunta ";
$resultado         = $conexion->query($consultaRespuesta);
mysqli_set_charset($conexion, "utf8");
if ($resultado->num_rows > 0) {


    $respuesta = "";
    //==
    $cont      = 0;

    while ($row = $resultado->fetch_array(MYSQLI_ASSOC)) {
      $preguntas = "";
      $row = $resultado->fetch_array(MYSQLI_ASSOC);
      $preguntas .= " <span value='" . $row['id_pregunta'] . "'>" . $row['preguntas'] . "</span><br>";

        $arrayNumeros = array();
        $arrayNumeros = randomNum();
        foreach ($arrayNumeros as $value) {

            switch ($value) {
                case '1':
                    $respuesta .= "<button name='r1' id='r1'>" . $row['respuesta1'] . "</button>";
                    break;
                case '2':
                    $respuesta .= "<button name='r2' id='r2'>" . $row['respuesta2'] . "</button>";
                    break;
                case '3':
                    $respuesta .= "<button name='r3' id='r3'>" . $row['respuesta3'] . "</button>";
                    break;
                case '4':
                    $respuesta .= "<button name='r4'id='r4'>" . $row['respuesta4'] . "</button>";
                    break;
            }
        }
    }
}


?>
