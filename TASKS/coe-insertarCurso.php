<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

session_start();
include("../model/conexion.php");
include("../security/logBuilder.php");

if (isset($_GET['insertarCurso'])) {
    $data= json_decode(file_get_contents("php://input"));
    $codigoCuenta = $data->codigoCuenta;
    $codigoRamo = $data->codigoRamo;
    $fechaInicio = $data->fechaInicio;
    $fechaFin = $data->fechaFin;
    $horaInicio = $data->horaInicio;
    $horaFin = $data->horaFin;

    $dateformat_inicio = date("Y-m-d", strtotime($fechaInicio));
    $dateformat_fin = date("Y-m-d", strtotime($fechaFin));


    $fechaInicio_mod = preg_replace('/-/', '', $dateformat_inicio);
    $horaInicio_mod = preg_replace('/:/', '', $horaInicio);

    $codigoCurso = $codigoRamo . $fechaInicio_mod . $horaInicio_mod;

    $query = "INSERT INTO cursos (codigoCuenta, codigoCurso, codigoRamo, inicio, fin, hora_inicio, hora_fin) VALUES ('$codigoCuenta','$codigoCurso','$codigoRamo','$dateformat_inicio','$dateformat_fin','$horaInicio','$horaFin');";
    $result = mysqli_query($conection, $query);
    if (!$result) {
        die('Query Failed' . mysqli_error($conection));
    } else {
		echo json_encode("success");
        // $usuario = $_SESSION['codigoCuenta'];
        $log = new Log("../security/reports/log.txt");
	$log->writeLine("I", " ha agregado el curso con los datos: [$codigoCuenta, $codigoCurso, $codigoRamo, $dateformat_inicio, $dateformat_fin, $horaInicio, $horaFin]");
        $log->close();
    }
} else {
    echo json_encode("failed");
}
