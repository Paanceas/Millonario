<?php
if (!isset($_SESSION)) {
    session_start();
}

if ($_SESSION['validacion'] == 1 && $_SESSION['id_usuario'] > 0) {
    $usuario = $_SESSION['id_usuario'];

    function sesiones(){
      include "../Conexion/config.php";
      mysqli_set_charset($conexion, "utf8");
      $sql="SELECT count(id_usuario) FROM usuario where verificaSesion = 1";
      $ejecuta=mysqli_query($conexion, $sql);
      $sesiones=$ejecuta->fetch_array();
      $sesionesOn=$sesiones[0];
      return $sesionesOn;
    }

    function listado()
    {
        include "../Conexion/config.php";
        mysqli_set_charset($conexion, "utf8");

        $consultaListado = "select p.record, a.nombres, pr.programas, a.id_aprendiz, FIND_IN_SET(p.id_puntaje, (SELECT GROUP_CONCAT(p.id_puntaje ORDER by p.record desc, p.totalEstados asc) from puntaje p)) AS Puesto, a.documento, t.tipo_identificacion, u.correo, p.totalEstados, p.fecha from puntaje p
  join aprendiz a ON a.id_aprendiz = p.id_aprendiz
  join programa pr ON pr.id_programa = a.id_programa
  join tipo_identificacion t on t.id_tipo_identificacion = a.id_tipo_identificacion
  join usuario u where u.id_usuario = a.id_usuario
  ORDER BY p.record DESC, p.totalEstados ASC, p.puntajes, p.id_puntaje desc";

        $resultado = $conexion->query($consultaListado);
        if (mysqli_num_rows($resultado) > 0) {

            while ($listado = $resultado->fetch_array()) {
                $nuevaFecha = date("d/M/y H:i", strtotime($listado[9]));

                echo "<tr class='info'>";
                echo "<td style='text-align:center;'>";
                echo $listado[4];
                echo "</td>";
                echo "<td style='text-align:center;'>";
                echo $listado[0];
                echo "</td>";
                echo "<td style='text-align:center;'>";
                echo $listado[8];
                echo "</td>";
                echo "<td>";
                echo $listado[1];
                echo "</td>";
                echo "<td>";
                echo $listado[6] . ": " . $listado[5];
                echo "</td>";
                echo "<td>";
                echo $listado[7];
                echo "</td>";
                echo "<td>";
                echo $nuevaFecha;
                echo "</td>";
                echo "<td>";
                echo $listado[2];
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "No hay registros";
        }
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
    ORDER BY p.record DESC, p.totalEstados ASC, p.puntajes, p.id_puntaje desc LIMIT 5,10000";

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


        if (mysqli_num_rows($resUnico) > 0) {
            //Si esta fuera del los primeros 5 lo resalta de rojo

            if ($consultaUnica != null) {

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
            } else {
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
        } else {
            echo "Hay menos de 6 participantes";
        }
    }
} else {
    header('location:../Vistas/index');
    $_SESSION['MSNLogin'] = 2;
}

?>
