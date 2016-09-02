<?php
session_start();
include "../Conexion/config.php";
function randomNum()
{
    $num = range(1, 4);
    shuffle($num);
    foreach ($num as $val) {
        $posiciones[] = $val;
    }
    return $posiciones;
}

function jugar($respuesta, $validarRes)
{
    include "../Conexion/config.php";
    if ($_SESSION['id_usuario'] > 0); {
        $usuario = $_SESSION['id_usuario'];
    }

    if ($validarRes == 1 || $validarRes == 0 ) {
    $query     = "INSERT INTO evaluacion_aprendiz(id_respuesta, id_aprendiz) VALUES ($respuesta, $usuario)";
    $resultado = $conexion->query($query);

    $query     = "SELECT max(r.id_respuesta) from evaluacion_aprendiz ep inner join respuesta r on r.id_respuesta = ep.id_respuesta where ep.id_aprendiz = $usuario;";
    $resultado = $conexion->query($query);
    $row       = $resultado->fetch_array(MYSQLI_ASSOC);

    return $row["max(r.id_respuesta)"] + 1;
  }else {
    return 0;
  }

}


/*------------------------------------*/
//
if (isset($_POST['respCorrec']) && isset($_POST['respSeleccionada']) ) {
  $cargarLaPregunta = $_POST['respCorrec'];
  $validarRespuesta= $_POST['respSeleccionada'];

} else {
    $cargarLaPregunta = 0;
    $valor            = 0;
    $validarRespuesta = 0;
}

$valor = jugar($cargarLaPregunta, $validarRespuesta);
// var_dump($id_respuestass);exit();
if ($valor > 0) {
  $consultaRespuesta = "SELECT * from respuesta r JOIN pregunta p ON p.id_pregunta = r.id_pregunta where id_respuesta=$valor";
  // var_dump($consultaRespuesta);exit();


  mysqli_set_charset($conexion, "utf8");

  $resultado = $conexion->query($consultaRespuesta);

  if ($resultado->num_rows > 0) {

      $respuesta = "";
      $preguntas = "";

      //==
      $cont         = 0;
      $arrayNumeros = array();
      $arrayNumeros = randomNum();

      while ($row = $resultado->fetch_array(MYSQLI_ASSOC)) {
          $idRespuesta = $row["id_respuesta"];
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
}else {
  header('location: ../Vistas/formRegistro.php');
}

?>
