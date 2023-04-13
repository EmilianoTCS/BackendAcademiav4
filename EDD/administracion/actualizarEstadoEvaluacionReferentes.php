<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
session_start();
include('../../model/conexion.php');
// include("../security/logBuilder.php");

if (isset($_GET['actualizarEvaluacion'])) {
    $data = json_decode(file_get_contents("php://input"));
    $ID = $data->ID;
    $usuario = $data->usuario;

    if (!empty($ID)) {


        $query = "UPDATE `edd-evaluacion-referentes-servicio` SET isActive = !isActive, fechaActualizacion = current_timestamp(), ultimoUsuario = '$usuario' WHERE ID = '$ID' ";
        $result = mysqli_query($conection, $query);

        if (!$result) {
            die('Query Failed' . mysqli_error($conection));
        } else {
            $query2 = "SELECT * from `edd-evaluacion-referentes-servicio` WHERE ID = '$ID'";
            $result2 = mysqli_query($conection, $query2);
            if (!$result2) {
                die('Query Failed' . mysqli_error($conection));
            }
            $json = array();
            while ($row = mysqli_fetch_array($result2)) {
                $json[] = array(
                    'ID' => $row['ID'],
                    'codigoEvaluacion' => $row['codigoEvaluacion'],
                    'fechaInicio' => $row['fechaInicio'],
                    'fechaFin' => $row['fechaFin'],
                    'proyecto' => $row['proyecto'],
                    'nombreCliente' => $row['nombreCliente'],
                    'estado' => $row['estado'],
                    'fechaActualizacion' => $row['fechaActualizacion'],
                    'usuario' => $row['ultimoUsuario'],
                    'isActive' => $row['isActive'],
                    'successEdited' => "successEdited"
                );
            }

            $jsonstring = json_encode($json);
            echo $jsonstring;
        }
    }
    // $usuario = $_SESSION['idCuenta'];
    // $log = new Log("../security/reports/log.txt");
    // $log->writeLine("I", "[] ha editado los datos: [$codigoRamo, $nombreRamo, $hh_academicas]");
    // $log->close();
} else {
    echo json_encode("Error");
}
