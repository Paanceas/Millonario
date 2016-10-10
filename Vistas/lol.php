<?php
function lol(){
include "../Conexion/config.php";

$cantPreguntas  = "SELECT count(e.id_respuesta) from respuesta e";
$resulCantPreg  = $conexion->query($cantPreguntas);
$numeroPregunta = $resulCantPreg->fetch_array(MYSQLI_NUM);
//Genera el número rand
$aleatorio = rand(1, $numeroPregunta[0]);
echo "----> Aleatorio: ".$aleatorio."<br>";
//Acá va a almacenar el primero aleatorio que salga
$arrayPreguntas[]=$aleatorio;

for ($i=0; $i < 20; $i++) {

  $aleatorio=rand(1, $numeroPregunta[0]);
  echo "* Aleatorio: ".$aleatorio."<br>";

  //Si el número rand dentro del for ya está almacenado en el array vuelve a hacer el rand
  while(in_array($aleatorio,$arrayPreguntas)) { //buscamos que no este repetido
    $aleatorio=rand(1, $numeroPregunta[0]);
    echo "+ Aleatorio: ".$aleatorio."<br>";
  }

  $usados[] = $aleatorio;    //No esta repetido, luego guardamos el aleatorio

return $aleatorio;
}
}
echo lol();
?>
