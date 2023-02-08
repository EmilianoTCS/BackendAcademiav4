<?php

include("../../model/conexion.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if (isset($_GET['ID'])) {

    $data = json_decode(file_get_contents("php://input"));
    $ID = $data->IDEvaluacion;

    $query = "SELECT * FROM `edd-evaluacion-referentes-servicio` WHERE ID = '$ID' AND isActive = true order by ID";
    $result = mysqli_query($conection, $query);
    if (!$result) {
        die('Query Failed' . mysqli_error($conection));
    }
    $json = array();
    while ($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'ID' => $row['ID'],
            'codigoEvaluacion' => $row['codigoEvaluacion'],
            'fechaInicio' => $row['fechaInicio'],
            'fechaFin' => $row['fechaFin'],
            'proyecto' => $row['proyecto'],
            'nombreCliente' => $row['nombreCliente'],
            'nombreEquipo' => $row['nombreEquipo'],
            'estado' => $row['estado']
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
