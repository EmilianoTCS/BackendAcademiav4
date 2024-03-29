<?php
session_start();
include("../model/conexion.php");
include("../security/logBuilder.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if (isset($_GET['insertarCliente'])) {
    $data = json_decode(file_get_contents("php://input"));
    $tipo_cliente = $data->tipo_cliente;
    $nombreCliente = $data->nombreCliente;
    $referente = $data->referente;
    $correoReferente = $data->correoReferente;
    $telefonoReferente = $data->telefonoReferente;
    $cargoReferente = $data->cargoReferente;
    $isActive = true;

    if (!empty($nombreCliente) && !empty($correoReferente)) {

        $query = "INSERT INTO clientes (tipo_cliente, nombreCliente, referente, correoReferente, telefonoReferente, cargoReferente, isActive, fechaActualizacion) VALUES ('$tipo_cliente','$nombreCliente','$referente','$correoReferente','$telefonoReferente','$cargoReferente', '$isActive', current_timestamp());";
        $result = mysqli_query($conection, $query);
        if (!$result) {
            die('Query Failed' . mysqli_error($conection));
        } else {

            $querySelect = "SELECT * from clientes WHERE ID = (SELECT MAX(ID) from clientes) AND isActive = true";
            $resultSelect = mysqli_query($conection, $querySelect);
            if (!$resultSelect) {
                die('Query Failed' . mysqli_error($conection));
            } else {
                $json = array();
                while ($rowSelect = mysqli_fetch_array($resultSelect)) {
                    $json[] = array(
                        'ID' => $rowSelect['ID'],
                        'tipo_cliente' => $rowSelect['tipo_cliente'],
                        'nombreCliente' => $rowSelect['nombreCliente'],
                        'referente' => $rowSelect['referente'],
                        'correoReferente' => $rowSelect['correoReferente'],
                        'cargoReferente' => $rowSelect['cargoReferente'],
                        'telefonoReferente' => $rowSelect['telefonoReferente'],
                        'successCreated' => 'successCreated'
                    );
                }
                $jsonstring = json_encode($json);
                echo $jsonstring;
            }
            // $usuario = $_SESSION['codigoCuenta'];
            // $log = new Log("../security/reports/log.txt");
            // $log->writeLine("I", "[usuario] ha agregado un colaborador con los datos [$tipo_cliente, $nombreCliente, $referente, $correoReferente, $telefonoReferente, $cargoReferente]");
            // $log->close();
        }
    }
} else {
    echo json_encode("Error");
}
