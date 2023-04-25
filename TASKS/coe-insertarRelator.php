<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include("../model/conexion.php");
include("../security/logBuilder.php");
if (isset($_GET['insertarRelator'])) {
    $data = json_decode(file_get_contents("php://input"));
    $area = $data->area;
    $nombre = $data->nombre;

    if (!empty($area) && !empty($nombre)) {
        $query = "CALL coe_insertarRelator('$area', '$nombre')";
        $result = mysqli_query($conection, $query);
        if (!$result) {
            die('Query Failed' . mysqli_error($conection));
        } else {

            echo json_encode('successCreated');
        }
    }

    // $usuario = $_SESSION['idCuenta'];
    // $log = new Log("../security/reports/log.txt");
    // $log->writeLine("I", "[] ha agregado el orador con los datos: [$area, $nombre]");
    // $log->close();


} else {
    echo json_encode("Error");
}
