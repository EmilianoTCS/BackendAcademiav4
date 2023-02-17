<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
session_start();
include('../model/conexion.php');
include("../security/logBuilder.php");

if (isset($_GET['editarRamo'])) {
    $data = json_decode(file_get_contents("php://input"));
    $ID = $data->ID;
    $codigoRamo = $data->codigoRamo;
    $nombreRamo = $data->nombreRamo;
    $hh_academicas = $data->hh_academicas;
    $nombreRelator = $data->nombreRelator;

    if (!empty($ID)) {

        $query = "UPDATE ramos SET codigoRamo = '$codigoRamo', nombreRamo = '$nombreRamo', hh_academicas = '$hh_academicas'
                WHERE ID = '$ID' ";
        $result = mysqli_query($conection, $query);
        if (!$result) {
            die('Query Failed' . mysqli_error($conection));
        }



        $queryActualizarRelator = "UPDATE relator_ramo set idRelator = '$nombreRelator', fechaActualización = current_timestamp() WHERE idRamo = '$ID'";
        $resultActualizarRelator = mysqli_query($conection, $queryActualizarRelator);
        if (!$resultActualizarRelator) {
            die('Query Failed' . mysqli_error($conection));
        } else {
            $query2 = "SELECT ram.*, rel.nombre, rel.idArea, ar.nombreArea, cuen.codigoCuenta from ramos ram INNER JOIN relator rel, area ar, relator_ramo rel_ram, cuentas cuen WHERE ram.idCuenta = cuen.ID AND ram.ID = rel_ram.idRamo AND rel.idArea = ar.ID AND rel.ID = rel_ram.idRelator AND ram.isActive = true AND ram.ID = '$ID' order by ram.ID ASC";
            $result2 = mysqli_query($conection, $query2);
            if (!$result2) {
                die('Query Failed' . mysqli_error($conection));
            }
            $json = array();
            while ($row = mysqli_fetch_array($result2)) {

                $json[] = array(
                    'ID' => $row['ID'],
                    'codigoCuenta' => $row['codigoCuenta'],
                    'codigoRamo' => $row['codigoRamo'],
                    'nombreRamo' => $row['nombreRamo'],
                    'hh_academicas' => $row['hh_academicas'],
                    'nombre' => $row['nombre'],
                    'nombreArea' => $row['nombreArea'],
                    'isActive' => $row['isActive'],
                    'successEdited' => 'successEdited'
                );
            }
            $jsonstring = json_encode($json);
            echo $jsonstring;
        }
    }
} else {
    echo json_encode("Error");
}
