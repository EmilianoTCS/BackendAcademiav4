<?php
session_start();
include("../model/conexion.php");
include("../security/logBuilder.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if (isset($_GET['insertarPrerequisito'])) {
    $data = json_decode(file_get_contents("php://input"));
    $idCurso = $data->CursoaConsultar;
    $prerequisito = $data->PrerequisitoAInsertar;
    $isActive = true;
    date_default_timezone_set("America/Argentina/Buenos_Aires");
    $date = date('Y-m-d H:i:s');

    $query = "INSERT INTO requisitos_curso (ID,idCurso, pre_requisito, isActive, fechaActualizacion) VALUES ('','$idCurso','$prerequisito','$isActive', '$date');";
    $result = mysqli_query($conection, $query);
    if (!$result) {
        die('Query Failed' . mysqli_error($conection));
    } else {
        // $usuario = $_SESSION['codigoCuenta'];
        // $log = new Log("../security/reports/log.txt");
        // $log->writeLine("I", "[usuario] ha agregado un colaborador con los datos [$tipo_cliente, $nombreCliente, $referente, $correoReferente, $telefonoReferente, $cargoReferente]");
        // $log->close();
        echo json_encode("successCreated");
    }
} else {
    echo json_encode("Error");
}
