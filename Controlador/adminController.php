<?php
if (!isset($_SESSION)) {
    session_start();
}

function ranking()
{
    include "../Conexion/config.php";
    $aprendiz = $_SESSION['id_aprendiz'];

    $consultaPosic = "select p.record, a.nombres, t.tipo_identificacion, a.documento, a.id_aprendiz from puntaje p
    join aprendiz a ON a.id_aprendiz = p.id_aprendiz
    join tipo_identificacion t ON t.id_tipo_identificacion = a.id_tipo_identificacion
    ORDER BY p.record DESC, p.totalEstados ASC LIMIT 5";

    $resultadoPosic = $conexion->query($consultaPosic);

    while ($row = $resultadoPosic->fetch_array()) {
        $rows[] = $row;
    }


    foreach ($rows as $row) {
        //Si el usuario logueado se encentra en el top 5 lo resalta de color azul
        if ($aprendiz == $row[4]) {
            echo "<tr class='info'>";
            echo "<td>";
            echo $row[0];
            echo "</td>";

            echo "<td>";
            echo $row[1];
            echo "</td>";

            echo "<td>";
            echo $row[2] . ": " . $row[3];
            echo "</td>";
            echo "</tr>";

        }
        //Sino lista los demás
        else {
            echo "<tr>";
            echo "<td>";
            echo $row[0];
            echo "</td>";

            echo "<td>";
            echo $row[1];
            echo "</td>";

            echo "<td>";
            echo $row[2] . ": " . $row[3];
            echo "</td>";
            echo "</tr>";
        }
    }
    //Consulta si el usuario logueado esta en el top 5
    $unicoAfuera = "select p.record, a.nombres, t.tipo_identificacion, a.documento, a.id_aprendiz from puntaje p
  join aprendiz a ON a.id_aprendiz = p.id_aprendiz
  join tipo_identificacion t ON t.id_tipo_identificacion = a.id_tipo_identificacion where a.id_aprendiz = $aprendiz";

    $resUnico = $conexion->query($unicoAfuera);

    $filaUnico = $resUnico->fetch_array(MYSQLI_NUM);
    //Si esta fuera del top lo resalta con color rojo
    if ($aprendiz == $filaUnico[4]) {
        echo "<tr class='danger'>";
        echo "<td>";
        echo $filaUnico[0];
        echo "</td>";

        echo "<td>";
        echo $filaUnico[1];
        echo "</td>";

        echo "<td>";
        echo $filaUnico[2] . ": " . $filaUnico[3];
        echo "</td>";
        echo "</tr>";

    }
}

?>
