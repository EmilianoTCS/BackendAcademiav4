<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

session_start();
include("../model/conexion.php");
include("../security/logBuilder.php");

if (isset($_GET['insertarEvento'])) {
    $data = json_decode(file_get_contents("php://input"));
    $titulo = $data->titulo;
    $descripcion = $data->descripcion;
    $fechaInicio = $data->fechaInicio;
    $fechaFin = $data->fechaFin;
    $horaInicio = $data->horaInicio;
    $horaFin = $data->horaFin;

    $dateformat_inicio = date("Y-m-d", strtotime($fechaInicio));
    $dateformat_fin = date("Y-m-d", strtotime($fechaFin));


    $fechaInicio_mod = preg_replace('/-/', '', $dateformat_inicio);
    $horaInicio_mod = preg_replace('/:/', '', $horaInicio);


    $queryVerify = "SELECT * FROM eventos WHERE fechaInicio = '$dateformat_inicio' AND fechaFin = '$dateformat_fin' AND hora_inicio <= time('$horaInicio') AND hora_fin >= time('$horaFin') ";
    $resultVerify = mysqli_query($conection, $queryVerify);

    if (mysqli_num_rows($resultVerify) >= 1) {
        echo json_encode('errorRepeated');
    } else {
        $query = "INSERT INTO eventos (titulo, descripcion, fechaInicio, fechaFin, hora_inicio, hora_fin, isActive) VALUES ('$titulo','$descripcion', '$dateformat_inicio','$dateformat_fin','$horaInicio','$horaFin', true);";
        $result = mysqli_query($conection, $query);
        if (!$result) {
            die('Query Failed' . mysqli_error($conection));
        } else {
            echo json_encode("successCreated");
            // $usuario = $_SESSION['codigoCuenta'];
            // $log = new Log("../security/reports/log.txt");
            // $log->writeLine("I", " ha agregado el curso con los datos: [$codigoCuenta, $codigoCurso, $codigoRamo, $dateformat_inicio, $dateformat_fin, $horaInicio, $horaFin]");
            // $log->close();
        }
    }
} else {
    echo json_encode("Error");
}
