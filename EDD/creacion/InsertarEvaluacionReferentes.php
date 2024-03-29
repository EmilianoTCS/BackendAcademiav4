<?php

include("../../model/conexion.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if (isset($_GET['insertarEDDReferentes'])) {
    $data = json_decode(file_get_contents("php://input"));
    $fechaInicioTemporal = date_create($data->fechaInicio);
    $fechaFinTemporal = date_create($data->fechaFin);
    $proyecto = $data->proyecto;
    $nombreCliente = $data->nombreCliente;

    $fechaInicio = date_format($fechaInicioTemporal, 'Y-m-d');
    $fechaFin = date_format($fechaFinTemporal, 'Y-m-d');


    $fechaInicio_mod = preg_replace('/-/', '', $fechaInicio);
    $codigoEvaluacion = "EDDREF" . $fechaInicio_mod;


    if (!empty($proyecto) && !empty($fechaInicio) && !empty($data->fechaInicio) && !empty($data->fechaFin)) {

        $query = "INSERT INTO `edd-evaluacion-referentes-servicio` (codigoEvaluacion, fechaInicio, fechaFin, proyecto, nombreCliente, estado, isActive, fechaActualizacion) VALUES ('$codigoEvaluacion', '$fechaInicio', '$fechaFin', '$proyecto', '$nombreCliente', 'Inactivo', true, current_timestamp()) ";
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
