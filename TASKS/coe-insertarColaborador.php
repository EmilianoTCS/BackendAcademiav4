<?php
session_start();
include("../model/conexion.php");
include("../security/logBuilder.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if (isset($_GET['insertarColaborador'])) {
    $data = json_decode(file_get_contents("php://input"));
    $idCuenta = $data->idCuenta;
    $nombre_completo = $data->nombre_completo;
    $usuario = $data->usuario;
    $area = $data->area;
    $subgerencia = $data->subgerencia;
    $correo = $data->correo;

    if (!empty($nombre_completo) && !empty($usuario)) {

        $query = "INSERT INTO personas (idCuenta, nombre_completo, usuario, area, subgerencia, correo, isActive, fechaActualizacion) VALUES ('$idCuenta','$nombre_completo','$usuario','$area','$subgerencia','$correo', true, current_timestamp());";
        $result = mysqli_query($conection, $query);
        if (!$result) {
            die('Query Failed' . mysqli_error($conection));
        } else {
            // $usuario = $_SESSION['codigoCuenta'];
            // $log = new Log("../security/reports/log.txt");
            // $log->writeLine("I", "[usuario] ha agregado un colaborador con los datos [$codigoCuenta, $nombre_completo, $usuario, $area, $subgerencia, $correo]");
            // $log->close();
            echo json_encode("successCreated");
        }
    }
} else {
    echo json_encode("Error");
}
