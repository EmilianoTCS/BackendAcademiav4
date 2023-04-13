<?php

include("../../model/conexion.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if (isset($_GET['listadoEvaluaciones'])) {

    $query = "SELECT * FROM `edd-evaluacion-referentes-servicio` WHERE ID != 0 order by ID";
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
            'estado' => $row['estado'],
            'fechaActualizacion' => $row['fechaActualizacion'],
            'usuario' => $row['ultimoUsuario'],
            'isActive' => $row['isActive']
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
