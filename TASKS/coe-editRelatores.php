<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include('../model/conexion.php');
include("../security/logBuilder.php");

if (isset($_GET['editarRelatores'])) {
    $data = json_decode(file_get_contents("php://input"));
    $ID = $data->ID;
    $nombre = $data->nombre;
    $idArea = $data->idArea;

    if (!empty($nombre) && !empty($ID)) {
        $query = "CALL coe_editRelatores('$ID','$nombre','$idArea')";
        $result = mysqli_query($conection, $query);
        if (!$result) {
            die('query failed' . mysqli_error($conection));
        }
        echo json_encode("successEdited");
        // $usuario = $_session['idcuenta'];
        // $log = new log("../security/reports/log.txt");
        // $log->writeline("i", "[] ha editado los datos: [$nombre]");
        // $log->close();
    }
} else {
    echo json_encode("Error");
}
