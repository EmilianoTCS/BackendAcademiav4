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
    $idCuenta = $data->idCuenta;
    $codigoRamo = $data->codigoRamo;
    $nombreRamo = $data->nombreRamo;
    $hh_academicas = $data->hh_academicas;
    $prerequisito = $data->prerequisito;
    $nombreRelator = $data->nombreRelator;

    $queryVerify = "SELECT * FROM ramos WHERE codigoRamo = '$codigoRamo' AND idCuenta = '$idCuenta' AND hh_academicas = $hh_academicas AND nombreRamo = '$nombreRamo'";
    $resultVerify = mysqli_query($conection, $queryVerify);


    if (mysqli_num_rows($resultVerify) >= 1) {
        echo json_encode('errorRegisterRepeated');
    } else {

        $query = "INSERT INTO ramos (idCuenta, codigoRamo, nombreRamo, hh_academicas, pre_requisito) VALUES ('$idCuenta','$codigoRamo','$nombreRamo','$hh_academicas','', true, 'empty');";
        $result = mysqli_query($conection, $query);
        if (!$result) {
            die('Query Failed' . mysqli_error($conection));
        } else {
            //SELECCIONA EL ID DEL RAMO RECIÉN INSERTADO
            $SelectUltimoRamo = "SELECT ID FROM ramos WHERE codigoRamo = '$codigoRamo' AND idCuenta = '$idCuenta' AND hh_academicas = $hh_academicas AND nombreRamo = '$nombreRamo'";
            $resultUltimoRamo = mysqli_query($conection, $SelectUltimoRamo);
            if (!$resultUltimoRamo) {
                die('Query Failed' . mysqli_error($conection));
            } else {
                $rowUltimoRamo = mysqli_fetch_array($resultUltimoRamo);
                $ultimoRamo = $rowUltimoRamo['ID'];
                //------------------------------
                $queryInsertRelator = "INSERT INTO relator_ramo (idRelator, idRamo, isActive, fechaActualización) VALUES ('$nombreRelator','$ultimoRamo', '1', '0000-00-00 00:00:00') ";
                $resultRelator = mysqli_query($conection, $queryInsertRelator);
                if (!$resultRelator) {
                    die('Query Failed' . mysqli_error($conection));
                } else {
                    $queryPreRequisito = "INSERT INTO requisitos_curso (idCurso, pre_requisito, isActive, fechaActualizacion) VALUES ('$ultimoRamo','$prerequisito', '1', '0000-00-00 00:00:00') ";
                    $resultPreRequisito = mysqli_query($conection, $queryPreRequisito);
                    if (!$resultPreRequisito) {
                        die('Query Failed' . mysqli_error($conection));
                    } else {
                        echo json_encode("successCreated");
                    }
                }
            }
            // $usuario = $_SESSION['codigoCuenta'];
            // $log = new Log("../security/reports/log.txt");
            // $log->writeLine("I", "[usuario] ha agregado el ramo con los datos: [$codigoCuenta, $codigoRamo, $nombreCurso, $hh_academicas, $pre_requsito, $relator]");
            // $log->close();
        }
    }
} else {
    echo json_encode("Error");
}
