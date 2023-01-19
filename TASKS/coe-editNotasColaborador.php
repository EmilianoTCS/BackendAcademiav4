<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include('../model/conexion.php');
include("../security/logBuilder.php");

if (isset($_GET['editarNotasColaborador'])) {
    $data = json_decode(file_get_contents("php://input"));
    $ID = $data->ID;
    $nota = $data->nota;
    $porcentaje = $data->porcentaje;

    if (!empty($nota) && !empty($ID)) {
        $query = "UPDATE evaluaciones SET nota = '$nota', porcentaje = '$porcentaje' WHERE ID = '$ID' ";
        $result = mysqli_query($conection, $query);

        if (!$result) {
            die('Query Failed' . mysqli_error($conection));
        }
        echo json_encode("successEdited");
    }
    // $usuario = $_SESSION['idCuenta'];
    // $log = new Log("../security/reports/log.txt");
    // $log->writeLine("I", "[usuario] ha editado los datos: [$codigoCuenta, $usuario, $nombre_completo,$area,$subgerencia,$correo]");
    // $log->close();
} else {
    echo json_encode("Error");
}
