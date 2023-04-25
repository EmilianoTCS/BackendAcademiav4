<?php

include("../../model/conexion.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if (isset($_GET['insertarEDDAnalistas'])) {
    $data = json_decode(file_get_contents("php://input"));
    $fechaInicioTemporal = date_create($data->fechaInicio);
    $fechaFinTemporal = date_create($data->fechaFin);
    $proyecto = $data->proyecto;
    $cliente = $data->cliente;
    $nombreEquipo = $data->nombreEquipo;
    
    $rest = strtoupper(substr($cliente, 0, 3));

    $fechaInicio = date_format($fechaInicioTemporal, 'Y-m-d');
    $fechaFin = date_format($fechaFinTemporal, 'Y-m-d');


    $fechaInicio_mod = preg_replace('/-/', '', $fechaInicio);
    $codigoEvaluacion = "EDDAN" . $fechaInicio_mod . $rest;


    if (!empty($proyecto) && !empty($fechaInicio) && !empty($data->fechaInicio) && !empty($data->fechaFin)) {
        $query = "INSERT INTO `edd-evaluacion-analistas-automatizadores` (codigoEvaluacion, fechaInicio, fechaFin, proyecto, nombreCliente,nombreEquipo, estado, isActive, fechaActualizacion) VALUES ('$codigoEvaluacion', '$fechaInicio', '$fechaFin', '$proyecto', '$cliente','$nombreEquipo', 'Inactivo', true, current_timestamp()) ";
        $result = mysqli_query($conection, $query);

        if (!$result) {
            die('Query Failed' . mysqli_error($conection));
        } else {
            echo json_encode("successCreated");
        }
    }
} else {
    echo json_encode('Error');
}
