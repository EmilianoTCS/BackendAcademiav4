<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include('../model/conexion.php');
include("../security/logBuilder.php");

if (isset($_GET['editarCurso'])) {
    $data = json_decode(file_get_contents("php://input"));
    $ID = $data->ID;
    $idCuenta = $data->idCuenta;
    $idRamoEdit = $data->idRamoEdit;
    $fechaInicio = $data->fechaInicio;
    $fechaFin = $data->fechaFin;
    $horaInicio = $data->horaInicio;
    $horaFin = $data->horaFin;

    $dateformat_inicio = date("Y-m-d", strtotime($fechaInicio));
    $dateformat_fin = date("Y-m-d", strtotime($fechaFin));


    $fechaInicio_mod = preg_replace('/-/', '', $dateformat_inicio);
    $horaInicio_mod = preg_replace('/:/', '', $horaInicio);




    $queryGetRamos = "SELECT codigoRamo from ramos WHERE ID = '$idRamoEdit'";
    $resultado = mysqli_query($conection, $queryGetRamos);
    if (!$resultado) {
        die('Query Failed' . mysqli_error($conection));
    } else {
        while ($row = mysqli_fetch_array($resultado)) {
            $codigoRamo = $row['codigoRamo'];
        }
    }

    $idCurso_mod = $codigoRamo . $fechaInicio_mod . $horaInicio_mod;


    if (!empty($idRamoEdit) && !empty($ID)) {

        if (strtotime($fechaInicio) > strtotime(date('Y-m-d H:i:s', time())) && strtotime(date('Y-m-d H:i:s', time())) < strtotime($fechaFin) && strtotime($fechaInicio) < strtotime($fechaFin)) {

            $query = "UPDATE cursos SET codigoCurso = '$idCurso_mod', idCuenta = '$idCuenta', idRamo = '$idRamoEdit', inicio = '$dateformat_inicio', fin = '$dateformat_fin', hora_inicio = '$horaInicio', hora_fin = '$horaFin'
                WHERE ID = '$ID' ";
            $result = mysqli_query($conection, $query);

            if (!$result) {
                die('Query Failed' . mysqli_error($conection));
            }
            echo json_encode("successEdited");
        } else {
            echo json_encode('errorFechas');
        }
        // $usuario = $_SESSION['idCuenta'];
        // $log = new Log("../security/reports/log.txt");
        // $log->writeLine("I", "[] ha editado los datos: [$idCuenta, $codigoRamo, $fechaInicio, $fechaFin, $horaInicio, $horaFin]");
        // $log->close();
    }
} else {
    echo json_encode("Error");
}
