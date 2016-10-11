<?php
session_start();
include "../Conexion/config.php";
if ($_SESSION['id_aprendiz'] > 0) {
    $aprendiz = $_SESSION['id_aprendiz'];
}

function cerrarSesionEstado()
{
    include "../Conexion/config.php";
    if ($_SESSION['id_usuario'] > 0) {
        $usuarioSesion = $_SESSION['id_usuario'];
    }
    $consultaSesion  = "UPDATE usuario SET verificaSesion = 0 where id_usuario = $usuarioSesion";
    $actualizaEstado = $conexion->query($consultaSesion);
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

function randomNumPregunta($vector)
{
    $num = rand(1,4);
    while(in_array($num,$vector)) { //buscamos que no este repetido
      $num=rand(1, 4);
    }
    return $num;
}

function randPregunta()
{
    include "../Conexion/config.php";

    $cantPreguntas  = "SELECT count(e.id_respuesta) from respuesta e";
    $resulCantPreg  = $conexion->query($cantPreguntas);
    $numeroPregunta = $resulCantPreg->fetch_array(MYSQLI_NUM);

    //Genera el número rand
    $aleatorio = rand(1, $numeroPregunta[0]);

    $arrayPreguntas[]=$aleatorio;

    for ($i=0; $i < 20; $i++) {

      $aleatorio=rand(1, $numeroPregunta[0]);

      //Si el número rand dentro del for ya está almacenado en el array vuelve a hacer el rand
      while(in_array($aleatorio,$arrayPreguntas)) { //buscamos que no este repetido
        $aleatorio=rand(1, $numeroPregunta[0]);
      }

      $usados[] = $aleatorio;    //No esta repetido, luego guardamos el aleatorio

    }
    return $usados;

}


function jugar($respuesta, $validarRes)
{
    include "../Conexion/config.php";

    if ($_SESSION['id_aprendiz'] > 0); {
        $aprendiz = $_SESSION['id_aprendiz'];
    }
    //Consulta el contador que permite saber cuántas preguntas le faltan para ganar
    $consultaResCorrectas = "SELECT * FROM evaluacion_aprendiz where id_aprendiz = $aprendiz";
    $resContador          = $conexion->query($consultaResCorrectas);

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

                $puntajes = $rowPuntaje['puntajes'];
                $record   = $rowPuntaje['record'];
                $nuevo    = $puntajes + 100; // obtenemos el valor de 'puntajes' y le añadimos los puntos ganados

                $actualizaPuntaje = "UPDATE puntaje SET puntajes =  '" . $nuevo . "' where id_aprendiz = $aprendiz";
                $ejecutaSql       = $conexion->query($actualizaPuntaje);

                if ($nuevo > $record) {
                    $recordNuevo      = $record + 100;
                    $actualizaRecord  = "UPDATE puntaje SET record =  '" . $recordNuevo . "' where id_aprendiz = $aprendiz";
                    $ejecutaSqlRecord = $conexion->query($actualizaRecord);
                }
            }

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
    $intentos        = "SELECT * from puntaje where id_aprendiz = $aprendiz";
    $consultaIntento = $conexion->query($intentos);
    $ValorEstado     = $consultaIntento->fetch_array(MYSQLI_ASSOC);

    //Fecha que esta guardada
    $ValorEstado['fecha'];
    //FECHA LOCAL DATE
    $fechaActualizacion = date('Y-m-d');

    //Si la fecha guardada es diferente a la fecha de hoy actualiza intentos
    if ($ValorEstado['fecha'] != $fechaActualizacion) {
        $actualizaFecha    = "UPDATE puntaje SET fecha = '$fechaActualizacion', estado = 1, totalEstados = 1 where id_aprendiz = $aprendiz";
        $ejecutaActualizac = $conexion->query($actualizaFecha);

        //Incrementa total Estados
        $nuevoTotalEstados = $ValorEstado['totalEstados'] + 1;
        $actualizaTotalEst = "UPDATE puntaje SET totalEstados = '" . $nuevoTotalEstados . "' where id_aprendiz = $aprendiz";
        $ejecutaSql        = $conexion->query($nuevoTotalEstados);

    } else {
        if ($ValorEstado['estado'] <= 1) {
            //Total estados
            $nuevoTotalEstados = $ValorEstado['totalEstados'] + 1;

            $nuevoEstado     = $ValorEstado['estado'] + 1; // obtenemos el valor de 'estado' y le añadimos un intento
            $actualizaEstado = "UPDATE puntaje SET estado =  '" . $nuevoEstado . "', totalEstados = '" . $nuevoTotalEstados . "'  where id_aprendiz = $aprendiz";
            $ejecutaSql      = $conexion->query($actualizaEstado);

            return $ValorEstado['estado'];
        } else {

            return $ValorEstado['estado'];
        }
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
    header('location: ../Vistas/juego');
} else {
    $_POST['clicJugar'] = 0;
    header('location: ../Vistas/admin');
    $_SESSION['MSN']=4;
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

if($_SESSION["numeroCorrecto"] == $_POST['respSeleccionada'])
    {
    $validarRespuesta = 1;
  }
  else if($_SESSION["numeroCorrecto"] != $_POST['respSeleccionada'] && $_POST['respSeleccionada'] != 0){
    $validarRespuesta = 2;
    $_SESSION['resCor']=0;
  }
} else {
    $cargarLaPregunta = 0;
    $valor            = 0;
    $validarRespuesta = 0;

}


//Información en pleno juego al usuario cuantas le faltan para ganar
$consultaAGanar = "SELECT resCorrectas FROM evaluacion_aprendiz where id_aprendiz = $aprendiz";
$resFaltantes          = $conexion->query($consultaAGanar);
$filaResCorr=$resFaltantes->fetch_array();
//Resultado que está guardado en la BD
$aGanar=$filaResCorr['resCorrectas'];
$resultadoAGanar=20-$aGanar;


$valor = jugar($cargarLaPregunta, $validarRespuesta);
$vector=array();

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
    $controlGanador   = "SELECT * FROM evaluacion_aprendiz where resCorrectas >= 20";
    $resultadoGanador = $conexion->query($controlGanador);

    //Si ya hay un ganador y el aprendiz logueado es el ganador
    if ($resultadoGanador == true && $rowLimite >= 20) {
        //Actualiza todos los demas que esten jugando a cero y termina el juego
        $reiniciaResCorrec = "UPDATE evaluacion_aprendiz SET resCorrectas = 0 where id_aprendiz != $aprendiz";
        $ejecutaReinicio   = $conexion->query($reiniciaResCorrec);
        //Actualiza el puntaje a 0 para que no lleguen dos puntajes al tiempo
        $actualizaPuntaje  = "UPDATE puntaje SET puntajes =  0 where id_aprendiz != $aprendiz";
        $ejecutaSql        = $conexion->query($actualizaPuntaje);
    }

    //Verifica si hay algún ganador
    if (mysqli_num_rows($resultadoGanador) > 0) {
        $_SESSION['verificaGanador'] = 1;
        header("location: ../Vistas/admin");
        $_SESSION['MSN']=5;
    } else {
        $_SESSION['verificaGanador'] = 0;

        if ($resultado->num_rows > 0) {
            $respuesta = "";
            $preguntas = "";

            //==================
            $cont         = 0;
            $arrayNumeros = array();
            $arrayNumeros = randomNum();

            // $arrayPregunta = array();
            $arrayPregunta = randPregunta();

            while ($row = $resultado->fetch_array(MYSQLI_ASSOC)) {
                $idRespuesta    = $row["id_respuesta"];
                $key            = ''; // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar

                $preguntaDesenc = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($row['preguntas']), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
                $preguntas .= " <span value='" . $row['id_pregunta'] . "'>" . $preguntaDesenc . "</span><br>";

                foreach ($arrayNumeros as $value) {
                    switch ($value) {
                        case '1':
                            $key        = ''; // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
                            $vector[0]=randomNumPregunta($vector);
                            $res1Desenc = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($row['respuesta1']), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
                            $respuesta .= "<td><button class='btn-juego' onclick='vp($vector[0])'><p>" . $res1Desenc . "</p></button> </td>";
                            $_SESSION["numeroCorrecto"]=$vector[0];
                            break;

                        case '2':
                        $vector[1]=randomNumPregunta($vector);
                            $res2Desenc = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($row['respuesta2']), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
                            $respuesta .= " <td><button class='btn-juego' onclick='vp($vector[1])'>" . $res2Desenc . "</button> </td>";
                            break;

                        case '3':
                        $vector[2]=randomNumPregunta($vector);
                            $res3Desenc = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($row['respuesta3']), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
                            $respuesta .= " <td><button class='btn-juego'  onclick='vp($vector[2])'>" . $res3Desenc . "</button></td> ";
                            break;

                        case '4':
                        $vector[3]=randomNumPregunta($vector);
                            $res4Desenc = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($row['respuesta4']), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
                            $respuesta .= "<td><button class='btn-juego'  onclick='vp($vector[3])'>" . $res4Desenc . "</button> </td>";
                            break;
                    }
                }
            }
            if ($validarRespuesta == 1) {
              //respuesta correcta
                header('location: ../Vistas/juego');
                $_SESSION['resCor']=1;
            }
            //respuesta incorrecta
            else if ($validarRespuesta > 1) {
                header('location: ../Vistas/finJuego');
                $_SESSION['resCor']=0;
            }
            //No muestra nada porque es la primera pregunta
            else {
                header('location: ../Vistas/juego');
                $_SESSION['resCor']=3;
            }
        } else {
            header('location: ../Vistas/admin');
        }
    }
} else {
    //Si se equivoca las resCorrectas vuelven a cero
    $reiniciaResCorrec = "UPDATE evaluacion_aprendiz SET resCorrectas = 0 where id_aprendiz = $aprendiz";
    $ejecutaReinicioi  = $conexion->query($reiniciaResCorrec);
    $_SESSION['jugar'] = 0;
    header('location: ../Vistas/finJuego');
}

?>
