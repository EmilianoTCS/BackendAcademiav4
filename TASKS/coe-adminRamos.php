<?php

include("../model/conexion.php");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


if (isset($_GET['ramos'])) {

    $query = "SELECT ID, codigoRamo, nombreRamo, isActive, fechaActualizacion, ultimoUsuario from ramos WHERE ID != 0";
    $result = mysqli_query($conection, $query);
    if (!$result) {
        die('Query Failed' . mysqli_error($conection));
    }

    $json = array();
    while ($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'ID' => $row['ID'],
            'codigoRamo' => $row['codigoRamo'],
            'nombreRamo' => $row['nombreRamo'],
            'date' => $row['fechaActualizacion'],
            'usuario' => $row['ultimoUsuario'],
            'isActive' => $row['isActive']
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
} else {
    echo json_encode("Error");
}
