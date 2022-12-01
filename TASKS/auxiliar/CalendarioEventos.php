<?php

include("../../model/conexion.php");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if (isset($_GET['Eventos'])) {

    $query = "SELECT ID,titulo,descripcion,fecha_hora, TIMEDIFF(hora_fin, hora_inicio) as duracion FROM eventos WHERE isActive = true";
    $result = mysqli_query($conection, $query);
    if (!$result) {
        die('Query Failed' . mysqli_error($conection));
    }

    $json = array();
    while ($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'ID' => $row['ID'],
            'titulo' => $row['titulo'],
            'descripcion' => $row['descripcion'],
            'fecha_hora' => $row['fecha_hora'],
            'duracion' => $row['duracion']
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
} else {
    echo json_encode("Error");
}
