<?php

session_start();
include "../Conexion/config.php";
if ($_SESSION['id_aprendiz'] > 0); {
    $usuario = $_SESSION['id_aprendiz'];
}

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
    if ($_SESSION['id_aprendiz'] > 0); {
        $usuario = $_SESSION['id_aprendiz'];
    }
    //Si es correcta actualiza puntaje
    if($validarRes==1){
      $intento="SELECT * from puntaje where id_aprendiz = $usuario";
      $resultadoIntento=$conexion->query($intento);
      while($rowPuntaje=$resultadoIntento->fetch_array(MYSQLI_ASSOC)){
            $puntajes= $rowPuntaje['puntajes'];
            $nuevo = $puntajes + 1000; // obtenemos el valor de 'puntajes' y le añadimos los puntos ganados
            $actualizaPuntaje = "UPDATE puntaje SET puntajes =  '".$nuevo."' where id_aprendiz = $usuario";
            $ejecutaSql=$conexion->query($actualizaPuntaje);
            // var_dump($ejecutaSql);exit();
          }
    }

    if ($validarRes == 1 || $validarRes == 0 ) {
    $registroHas     = "INSERT INTO evaluacion_aprendiz(id_respuesta, id_aprendiz) VALUES ($respuesta, $usuario);";
    $resultadoHas = $conexion->query($registroHas);

    $query     = "SELECT max(r.id_respuesta) from evaluacion_aprendiz ep inner join respuesta r on r.id_respuesta = ep.id_respuesta where ep.id_aprendiz = $usuario;";
    $resultado = $conexion->query($query);
    $row       = $resultado->fetch_array(MYSQLI_ASSOC);

    $query = "";

    return $row["max(r.id_respuesta)"] + 1;

  }else {
    return 0;
  }
}
function validaIntento(){
  include '../Conexion/config.php';
  if ($_SESSION['id_aprendiz'] > 0); {
      $usuario = $_SESSION['id_aprendiz'];
  }
  $intentos="SELECT estado from puntaje where id_aprendiz = $usuario";
  $consultaIntento=$conexion->query($intentos);
  $ValorEstado       = $consultaIntento->fetch_array(MYSQLI_NUM);

    if($ValorEstado[0] <= 1){
          $nuevoEstado = $ValorEstado[0] + 1; // obtenemos el valor de 'estado' y le añadimos un intento
          $actualizaEstado = "UPDATE puntaje SET estado =  '".$nuevoEstado."' where id_aprendiz = $usuario";
          $ejecutaSql=$conexion->query($actualizaEstado);
          // var_dump($ejecutaSql);exit();
          return $ValorEstado[0];
      }else {
          // echo "perdiste ".$ValorEstado[0]." intenos";exit();
          return $ValorEstado[0];
      }


}
/*------------------------------------*/
//

if (isset($_POST['clicJugar'])) {
  $_POST['clicJugar']=1;
  $_SESSION['clicJugarSess']=1;
  if ($_POST['clicJugar'] == 1) {
    $clic=$_POST['clicJugar'];
    }
}else {
  $_POST['clicJugar']=0;
  header('location: ../Vistas/admin.php?MSN=4');
}
// var_dump($_POST['clicJugar']);exit();

if (isset($_POST['intento'])) {
    $intento=$_POST['intento'];
    if ($intento == 1) {
      $validarInenrod= validaIntento($intento);
      $_SESSION['intentos'] = $validarInenrod;

  }
}
if (isset($_POST['respCorrec']) && isset($_POST['respSeleccionada']) ) {
  $cargarLaPregunta = $_POST['respCorrec'];
  $validarRespuesta= $_POST['respSeleccionada'];
}else {
      $cargarLaPregunta = 0;
      $valor            = 0;
      $validarRespuesta = 0;
  }


$valor = jugar($cargarLaPregunta, $validarRespuesta);

if ($valor > 0) {

  $consultaRespuesta = "SELECT * from respuesta r JOIN pregunta p ON p.id_pregunta = r.id_pregunta where id_respuesta=$valor";

  mysqli_set_charset($conexion, "utf8");

  $resultado = $conexion->query($consultaRespuesta);

  //Control el lilmite de ultima pregunta
  $ultimaPregunta="SELECT max(r.id_respuesta) from respuesta r;";
  $resultadoUltPregunta=$conexion->query($ultimaPregunta);
  // $filaUltimaPregunta       = $resultadoUltPregunta->fetch_array(MYSQLI_NUM);


  // var_dump($filaUltimaPregunta);exit();

  if ($resultado->num_rows > 0) {
      if($resultado>=$resultadoUltPregunta){
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
                      $respuesta .= " <button class='opcion encorefois' name='r1' id='r1' onclick='vp(1)'><p>" . $row['respuesta1'] . "</p></button> ";
                      break;
                  case '2':
                      $respuesta .= " <button class='opcion encorefois' name='r2' id='r2' onclick='vp(2)'>" . $row['respuesta2'] . "</button> ";
                      break;
                  case '3':
                      $respuesta .= " <button class='opcion encorefois'  name='r3' id='r3' onclick='vp(3)'>" . $row['respuesta3'] . "</button> ";
                      break;
                  case '4':
                      $respuesta .= " <button class='opcion encorefois'  name='r4'id='r4' onclick='vp(4)'>" . $row['respuesta4'] . "</button> ";
                      break;
              }
          }
      }
  }else{
    $_SESSION['jugar']=0;

    header('location: ../Vistas/finJuego.php');

  }
  header('location: ../Vistas/juego.php');

}
else {
  header('location: ../Vistas/admin.php?MSN=1');

}
}else {
  $_SESSION['jugar']=0;
  header('location: ../Vistas/finJuego.php');
}

?>
