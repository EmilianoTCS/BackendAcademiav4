<?php

include("../../model/conexion.php");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if (isset($_GET['Cursos'])) {

    $query = "CALL SP_AUX_listCursosCalendario()";
    $result = mysqli_query($conection, $query);
    if (!$result) {
        die('Query Failed' . mysqli_error($conection));
    }

    $json = array();
    while ($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'ID' => $row['ID'],
            'inicio' => $row['inicio'],
            'fin' => $row['fin'],
            'codigoCurso' => $row['codigoCurso'],
            'hora_inicio' => $row['hora_inicio'],
            'hora_fin' => $row['hora_fin'],
            'codigoRamo' => $row['codigoRamo'],
            'fecha_hora' => $row['fecha_hora'],
            'duracion' => $row['duracion'],
            'nombreRamo' => $row['nombreRamo'],

        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
} else {
    echo json_encode("Error");
}
