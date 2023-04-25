<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include('../model/conexion.php');
include("../security/logBuilder.php");

if (isset($_GET['editarCliente'])) {
    $data = json_decode(file_get_contents("php://input"));
    $ID = $data->ID;
    $tipo_cliente = $data->tipo_cliente;
    $nombreCliente = $data->nombreCliente;
    $referente = $data->referente;
    $correoReferente = $data->correoReferente;
    $telefonoReferente = $data->telefonoReferente;
    $cargoReferente = $data->cargoReferente;

    if (!empty($ID)) {

        $query = "CALL coe_editClientes('$ID', '$tipo_cliente', '$nombreCliente', '$referente', '$correoReferente', '$telefonoReferente', '$cargoReferente')";
        $result = mysqli_query($conection, $query);

        if (!$result) {
            die('Query Failed' . mysqli_error($conection));
        }
        $json = array();
        while ($rowSelect = mysqli_fetch_array($result)) {
            $json[] = array(
                'ID' => $rowSelect['ID'],
                'tipo_cliente' => $rowSelect['tipo_cliente'],
                'nombreCliente' => $rowSelect['nombreCliente'],
                'referente' => $rowSelect['referente'],
                'correoReferente' => $rowSelect['correoReferente'],
                'cargoReferente' => $rowSelect['cargoReferente'],
                'telefonoReferente' => $rowSelect['telefonoReferente'],
                'successEdited' => 'successEdited'
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
    // $usuario = $_SESSION['idCuenta'];
    // $log = new Log("../security/reports/log.txt");
    // $log->writeLine("I", "[usuario] ha editado los datos: []");
    // $log->close();

} else {
    echo json_encode("Error");
}
