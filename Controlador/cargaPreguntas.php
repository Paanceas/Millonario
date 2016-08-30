<?php
//INICIAR SESION
// session_start();
include "../Conexion/config.php";

$sql       = "SELECT * from pregunta";
$resultado = $conexion->query($sql);
mysqli_set_charset($conexion, "utf8");

if ($resultado->num_rows > 0) {
    $tipoIdentificacion = "";
    while ($row = $resultado->fetch_array(MYSQLI_ASSOC)) {
        $tipoIdentificacion .= " <option value='" . $row['id_programa'] . "'>" . $row['preguntas'] . "</option>";
    }
}

?>
