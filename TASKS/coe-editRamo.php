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
    $idRelator = $data->idRelator;

    if (!empty($ID)) {
        
        $query = "CALL coe_editRamos($ID,'$codigoRamo', '$nombreRamo', $hh_academicas, $idRelator, @p)";
        $result = mysqli_query($conection, $query);
        if (!$result) {
            die('Query Failed' . mysqli_error($conection));
        }
        $json = array();
        while ($row = mysqli_fetch_array($result)) {

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
} else {
    echo json_encode("Error");
}
