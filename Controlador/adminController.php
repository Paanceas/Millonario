<?php
include "../Conexion/config.php";
// variables a utilizar
  $user = $_SESSION['id_aprendiz'];
  $puntaje = "0";
  $preguntaCorrecta = "0";
//METODO PARA CONSULTAR LA CANTIDAD DE PREGNTAS DEL juego
function totalPreguntas()
{
  include "../Conexion/config.php";
  $sql = "SELECT COUNT(p.id_pregunta) FROM pregunta p ";
  // echo "$sql</br>";
  $resultado  = mysqli_query($conexion, $sql);
  $count = mysqli_fetch_array($resultado);
  $numPregun = $count["COUNT(p.id_pregunta)"];
  return $numPregun;
}

  $sql = "SELECT MAX(ea.id_respuesta), p.puntajes FROM evaluacion_aprendiz ea INNER JOIN aprendiz a on a.id_aprendiz = ea.id_aprendiz INNER JOIN puntaje p on p.id_aprendiz = a.id_aprendiz WHERE a.id_aprendiz = $user; ";
  // echo "$sql</br>";
  $resultado  = mysqli_query($conexion, $sql);
  $datosJuego = mysqli_fetch_array($resultado);
  if ($datosJuego != NULL) {
    $puntaje = $datosJuego["puntajes"];
    $preguntaCorrecta =  $datosJuego["MAX(ea.id_respuesta)"];
    $numPregun = totalPreguntas();
  }

?>
