<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
session_start();
include('../../model/conexion.php');
// include("../security/logBuilder.php");

if (isset($_GET['editarEvaluacion'])) {
    $data = json_decode(file_get_contents("php://input"));
    $ID = $data->ID;
    $fechaInicio = $data->fechaInicio;
    $fechaFin = $data->fechaFin;
    $proyecto = $data->proyecto;
    $nombreCliente = $data->nombreCliente;
    $nombreEquipo = $data->nombreEquipo;
    $estado = $data->estado;

    if (!empty($fechaInicio) && !empty($fechaFin)) {


        $query = "UPDATE `edd-evaluacion-referentes-servicio` SET fechaInicio = '$fechaInicio', fechaFin = '$fechaFin', proyecto = '$proyecto', nombreCliente = '$nombreCliente', nombreEquipo = '$nombreEquipo', estado = '$estado'
              WHERE ID = '$ID' ";
        $result = mysqli_query($conection, $query);

        if (!$result) {
            die('Query Failed' . mysqli_error($conection));
        } else {
            echo json_encode('successEdited');
        }
    }
    // $usuario = $_SESSION['idCuenta'];
    // $log = new Log("../security/reports/log.txt");
    // $log->writeLine("I", "[] ha editado los datos: [$codigoRamo, $nombreRamo, $hh_academicas]");
    // $log->close();
} else {
    echo json_encode("Error");
}
