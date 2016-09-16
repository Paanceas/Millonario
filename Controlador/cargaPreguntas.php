<?php

session_start();
include "../Conexion/config.php";
if ($_SESSION['id_aprendiz'] > 0); {
    $aprendiz = $_SESSION['id_aprendiz'];
}
function cerrarSesionEstado(){
  include "../Conexion/config.php";
  if ($_SESSION['id_usuario'] > 0); {
      $usuarioSesion = $_SESSION['id_usuario'];
  }
  $consultaSesion="UPDATE usuario SET verificaSesion = 0 where id_usuario = $usuarioSesion";
  $actualizaEstado=$conexion->query($consultaSesion);
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

Function randPregunta()
{
    include "../Conexion/config.php";

    $cantPreguntas  = "SELECT count(e.id_respuesta) from respuesta e";
    $resulCantPreg  = $conexion->query($cantPreguntas);
    $numeroPregunta = $resulCantPreg->fetch_array(MYSQLI_NUM);

    $num = range(1, $numeroPregunta[0]);

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
        $aprendiz = $_SESSION['id_aprendiz'];
    }
    //Consulta si ya hay un registro del usuario
    $consultaResCorrectas = "SELECT * FROM evaluacion_aprendiz where id_aprendiz = $aprendiz";
    $resContador          = $conexion->query($consultaResCorrectas);

    //Si no hay realiza el registro
    if (mysqli_num_rows($resContador) <= 0) {

        $registroHas  = "INSERT INTO evaluacion_aprendiz(id_respuesta, id_aprendiz, resCorrectas) VALUES ($respuesta, $aprendiz, 1);";
        $resultadoHas = $conexion->query($registroHas);
    }



    //Si es correcta actualiza puntaje y suma +1 a la res correcta
    if ($validarRes == 1 || $validarRes == 0) {
        if ($validarRes == 1) {
            //Actualiza el puntaje
            $intento          = "SELECT * from puntaje where id_aprendiz = $aprendiz";
            $resultadoIntento = $conexion->query($intento);

            while ($rowPuntaje = $resultadoIntento->fetch_array(MYSQLI_ASSOC)) {

                $puntajes         = $rowPuntaje['puntajes'];
                $record = $rowPuntaje['record'];
                $nuevo            = $puntajes + 100; // obtenemos el valor de 'puntajes' y le añadimos los puntos ganados

                $actualizaPuntaje = "UPDATE puntaje SET puntajes =  '" . $nuevo . "' where id_aprendiz = $aprendiz";
                $ejecutaSql       = $conexion->query($actualizaPuntaje);

                // $puntajes         = $rowPuntaje['puntajes'];
                var_dump($nuevo);

                if($nuevo > $record){
                  $recordNuevo            = $record + 100;
                  $actualizaRecord= "UPDATE puntaje SET record =  '" . $recordNuevo . "' where id_aprendiz = $aprendiz";
                  $ejecutaSqlRecord       = $conexion->query($actualizaRecord);
                }
            }

            // //Actualiza si el puntaje nuevo es mayor all record
            // while ($rowRecord=$resultadoIntento->fetch_array(MYSQLI_ASSOC)) {
            //   $record           = $rowRecord['record'];
            //   $puntajes         = $rowPuntaje['puntajes'];
            //
            //   if($puntajes > $record){
            //
            //     $recordNuevo            = $puntajes;
            //     $actualizaRecord= "UPDATE puntaje SET record =  '" . $recordNuevo . "' where id_aprendiz = $aprendiz";
            //     $ejecutaSqlRecord       = $conexion->query($actualizaRecord);
            //
            //   }
            //   var_dump($ejecutaSqlRecord);exit();
            // }

            while ($rowResCorrectas = $resContador->fetch_array(MYSQLI_ASSOC)) {
                $resCorrectas          = $rowResCorrectas['resCorrectas'];
                $nuevoResC             = $resCorrectas + 1; // obtenemos el valor de 'resCorrectas' y le añadimos mas una pregunta correcta
                $actualizaresCorrectas = "UPDATE evaluacion_aprendiz SET resCorrectas =  '" . $nuevoResC . "' where id_aprendiz = $aprendiz;";
                $ejecutaResCorrecta    = $conexion->query($actualizaresCorrectas);
            }


        }

    } else {
      $actualizaPuntaje = "UPDATE puntaje SET puntajes = 0 where id_aprendiz = $aprendiz";
      $ejecutaSql       = $conexion->query($actualizaPuntaje);
        return 0;
    }
    //Muestra pregunta al azar
    $aleatoria = randPregunta();

    $query     = "SELECT r.id_respuesta from respuesta r where r.id_respuesta = $aleatoria[0];";
    $resultado = $conexion->query($query);
    $row       = $resultado->fetch_array(MYSQLI_ASSOC);

    return $row['id_respuesta'];
}
function validaIntento()
{
    include '../Conexion/config.php';
    if ($_SESSION['id_aprendiz'] > 0); {
        $aprendiz = $_SESSION['id_aprendiz'];
    }
    //Consulta si hay intentos disponibles
    $intentos        = "SELECT estado from puntaje where id_aprendiz = $aprendiz";
    $consultaIntento = $conexion->query($intentos);
    $ValorEstado     = $consultaIntento->fetch_array(MYSQLI_NUM);

    if ($ValorEstado[0] <= 1) {
        $nuevoEstado     = $ValorEstado[0] + 1; // obtenemos el valor de 'estado' y le añadimos un intento
        $actualizaEstado = "UPDATE puntaje SET estado =  '" . $nuevoEstado . "' where id_aprendiz = $aprendiz";
        $ejecutaSql      = $conexion->query($actualizaEstado);
        // var_dump($ejecutaSql);exit();
        return $ValorEstado[0];
    } else {
        // echo "perdiste ".$ValorEstado[0]." intenos";exit();
        return $ValorEstado[0];
    }
}
/*------------------------------------*/

//No entra al juego sino le da en el botón jugar
if (isset($_POST['clicJugar'])) {
    $_POST['clicJugar']        = 1;
    $_SESSION['clicJugarSess'] = 1;
    if ($_POST['clicJugar'] == 1) {
        $clic = $_POST['clicJugar'];
    }
}else {
    $_POST['clicJugar'] = 0;
    header('location: ../Vistas/admin.php?MSN=4');
}


if (isset($_POST['intento'])) {
    $intento = $_POST['intento'];
    if ($intento == 1) {
        $validarInenrod       = validaIntento($intento);
        $_SESSION['intentos'] = $validarInenrod;
    }
}
if (isset($_POST['respCorrec']) && isset($_POST['respSeleccionada'])) {
    $cargarLaPregunta = $_POST['respCorrec'];
    $validarRespuesta = $_POST['respSeleccionada'];
} else {
    $cargarLaPregunta = 0;
    $valor            = 0;
    $validarRespuesta = 0;
}

$valor = jugar($cargarLaPregunta, $validarRespuesta);

if ($valor > 0) {
    $consultaRespuesta = "SELECT * from respuesta r JOIN pregunta p ON p.id_pregunta = r.id_pregunta where id_respuesta=$valor";

    mysqli_set_charset($conexion, "utf8");
    $resultado = $conexion->query($consultaRespuesta);

    //Verifica el campo resCorrectas
    $controlLimite   = "SELECT resCorrectas FROM evaluacion_aprendiz where id_aprendiz = $aprendiz";
    $resultadoLimite = $conexion->query($controlLimite);


    //Captura el valor del campo resCorrectas de acuerdo al aprendiz logueado
    $resPCorrecLimite = $resultadoLimite->fetch_array(MYSQLI_ASSOC);
    $rowLimite        = $resPCorrecLimite['resCorrectas'];

    //Control Si hay un jugador con cantidad respondidas correctas 15 gana y nadie mas puede jugar
    $controlGanador   = "SELECT * FROM evaluacion_aprendiz where resCorrectas >= 15";
    $resultadoGanador = $conexion->query($controlGanador);

    //Si ya hay un ganador y el aprendiz logueado es el ganador
    if ($resultadoGanador == true && $rowLimite >=15 ) {
      //Actualiza todos los demas que esten jugando a cero y termina el juego
      $reiniciaResCorrec="UPDATE evaluacion_aprendiz SET resCorrectas = 0 where id_aprendiz != $aprendiz";
      $ejecutaReinicio=$conexion->query($reiniciaResCorrec);
    }

    //Verifica si hay algún ganador
    if(mysqli_num_rows($resultadoGanador) > 0){
      $_SESSION['verificaGanador']=1;
      header("location: ../Vistas/admin.php?MSN=5");
    }else{
      $_SESSION['verificaGanador']=0;


    if ($resultado->num_rows > 0) {
        $respuesta = "";
        $preguntas = "";

        //==================
        $cont         = 0;
        $arrayNumeros = array();
        $arrayNumeros = randomNum();

        $arrayPregunta = array();
        $arrayPregunta = randPregunta();

        while ($row = $resultado->fetch_array(MYSQLI_ASSOC)) {
            $idRespuesta = $row["id_respuesta"];

            $preguntas .= " <span value='" . $row['id_pregunta'] . "'>" . $row['preguntas'] . "</span><br>";

            foreach ($arrayNumeros as $value) {
                switch ($value) {
                    case '1':
                        $respuesta .= "<td><button class='opcion encorefois' name='r1' id='r1' onclick='vp(1)'><p>" . $row['respuesta1'] . "</p></button> </td>";
                        break;
                    case '2':
                        $respuesta .= " <td><button class='opcion encorefois' name='r2' id='r2' onclick='vp(2)'>" . $row['respuesta2'] . "</button> </td>";
                        break;
                    case '3':
                        $respuesta .= " <td><button class='opcion encorefois'  name='r3' id='r3' onclick='vp(3)'>" . $row['respuesta3'] . "</button></td> ";
                        break;
                    case '4':
                        $respuesta .= "<td><button class='opcion encorefois'  name='r4'id='r4' onclick='vp(4)'>" . $row['respuesta4'] . "</button> </td>";
                        break;
                }
            }
        }
        header('location: ../Vistas/juego.php');
    } else {
        header('location: ../Vistas/admin.php?MSN=1');
    }
  }
} else {
  //Si se equivoca las resCorrectas vuelven a cero
  $reiniciaResCorrec="UPDATE evaluacion_aprendiz SET resCorrectas = 0 where id_aprendiz = $aprendiz";
  $ejecutaReinicioi=$conexion->query($reiniciaResCorrec);

    $_SESSION['jugar'] = 0;
    header('location: ../Vistas/finJuego.php');
}

?>
