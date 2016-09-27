<?php
if (!isset($_SESSION)) {
    session_start();
}

function ranking()
{
    include "../Conexion/config.php";
    mysqli_set_charset($conexion, "utf8");

    $aprendiz = $_SESSION['id_aprendiz'];

    //Consulta el Top 5
    $consultaTop = "select p.record, a.nombres, pr.programas, a.id_aprendiz, FIND_IN_SET(p.id_puntaje, (SELECT GROUP_CONCAT(p.id_puntaje ORDER by p.record desc, p.totalEstados asc) from puntaje p)) AS Puesto from puntaje p
    join aprendiz a ON a.id_aprendiz = p.id_aprendiz
    join programa pr ON pr.id_programa = a.id_programa
    ORDER BY p.record DESC, p.totalEstados ASC, p.puntajes, p.id_puntaje desc LIMIT 5";

    $resultadoTop = $conexion->query($consultaTop);

    while ($topMejores = $resultadoTop->fetch_array()) {
        $totalRegistros[] = $topMejores;
    }

    //-----------------
    //Consulta de los que están fuera del Top 5
    $unico = "select p.record, a.nombres, pr.programas, a.id_aprendiz, FIND_IN_SET(p.id_puntaje, (SELECT GROUP_CONCAT(p.id_puntaje ORDER by p.record desc, p.totalEstados asc) from puntaje p)) AS Puesto from puntaje p
    join aprendiz a ON a.id_aprendiz = p.id_aprendiz
    join programa pr ON pr.id_programa = a.id_programa
    ORDER BY p.record DESC, p.totalEstados ASC LIMIT 5,10000";

    $resUnico = $conexion->query($unico);

    while ($consultaUnica = $resUnico->fetch_array()) {
        $totalUnicos[] = $consultaUnica;
    }

    foreach ($totalRegistros as $topMejores) {

        //Si el aprendiz logueado esta en el Top 5
        if ($aprendiz == $topMejores[3]) {
            echo "<tr class='info'>";
            echo "<td>";
            echo $topMejores[4];
            echo "</td>";
            echo "<td>";
            echo $topMejores[0];
            echo "</td>";
            echo "<td>";
            echo $topMejores[1];
            echo "</td>";
            echo "<td>";
            echo $topMejores[2];
            echo "</td>";
            echo "</tr>";
        } //Sino pinta los demás
        else {
            echo "<tr>";
            echo "<td>";
            echo $topMejores[4];
            echo "</td>";
            echo "<td>";
            echo $topMejores[0];
            echo "</td>";
            echo "<td>";
            echo $topMejores[1];
            echo "</td>";
            echo "<td>";
            echo $topMejores[2];
            echo "</td>";
            echo "</tr>";
        }
    }


    if(mysqli_num_rows($resUnico) > 0){
    //Si esta fuera del los primeros 5 lo resalta de rojo
    if($consultaUnica != null ){
      var_dump($totalUnicos);exit();
      foreach ($totalUnicos as $consultaUnica) {
          if ($aprendiz == $consultaUnica[3]) {
              echo "<tr class='danger'>";
              echo "<td>";
              echo $consultaUnica[4];
              echo "</td>";
              echo "<td>";
              echo $consultaUnica[0];
              echo "</td>";
              echo "<td>";
              echo $consultaUnica[1];
              echo "</td>";
              echo "<td>";
              echo $consultaUnica[2];
              echo "</td>";
              echo "</tr>";
          }
      }
    }else{
      foreach ($totalUnicos as $consultaUnica) {
          if ($aprendiz == $consultaUnica[3]) {
              echo "<tr class='danger'>";
              echo "<td>";
              echo $consultaUnica[4];
              echo "</td>";
              echo "<td>";
              echo $consultaUnica[0];
              echo "</td>";
              echo "<td>";
              echo $consultaUnica[1];
              echo "</td>";
              echo "<td>";
              echo $consultaUnica[2];
              echo "</td>";
              echo "</tr>";
          }
      }
    }
  }else{
    echo "Hay menos de 6 participantes";
  }


}


?>
