<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
session_start();
include('../model/conexion.php');
include("../security/logBuilder.php");

if (isset($_GET['editarRamo'])) {
    $data = json_decode(file_get_contents("php://input"));
    $ID = $data->ID;
    $codigoRamo = $data->codigoRamo;
    $nombreRamo = $data->nombreRamo;
    $hh_academicas = $data->hh_academicas;

    $query = "UPDATE ramos SET codigoRamo = '$codigoRamo', nombreRamo = '$nombreRamo', hh_academicas = '$hh_academicas'
              WHERE ID = '$ID' ";
    $result = mysqli_query($conection, $query);

    if (!$result) {
        die('Query Failed' . mysqli_error($conection));
    }
    echo json_encode("successEdited");
    // $usuario = $_SESSION['idCuenta'];
    // $log = new Log("../security/reports/log.txt");
    // $log->writeLine("I", "[] ha editado los datos: [$codigoRamo, $nombreRamo, $hh_academicas]");
    // $log->close();
} else {
    echo json_encode("Error");
}
