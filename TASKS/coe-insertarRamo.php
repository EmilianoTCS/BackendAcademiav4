<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include("../model/conexion.php");
include("../security/logBuilder.php");
if (isset($_GET['insertarRamo'])) {
    $data = json_decode(file_get_contents("php://input"));
    $codigoCuenta = $data->codigoCuenta;
    $codigoRamo = $data->codigoRamo;
    $area = $data->area;
    $nombreCurso = $data->nombreCurso;
    $hh_academicas = $data->hh_academicas;
    $pre_requisito = $data->pre_requisito;
    $relator = $data->relator;

    $query = "INSERT INTO ramos (codigoCuenta,codigoRamo,area, nombreRamo, hh_academicas, pre_requisito, relator) VALUES ('$codigoCuenta','$codigoRamo','$area','$nombreCurso','$hh_academicas','$pre_requisito', '$relator');";
    $result = mysqli_query($conection, $query);
    if (!$result) {
        die('Query Failed' . mysqli_error($conection));
    } else {
        echo json_encode("successCreated");
        // $usuario = $_SESSION['codigoCuenta'];
        // $log = new Log("../security/reports/log.txt");
        // $log->writeLine("I", "[usuario] ha agregado el ramo con los datos: [$codigoCuenta, $codigoRamo, $nombreCurso, $hh_academicas, $pre_requsito, $relator]");
        // $log->close();
    }
} else {
    echo json_encode("Error");
}
