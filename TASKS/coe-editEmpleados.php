<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include('../model/conexion.php');
include("../security/logBuilder.php");

if (isset($_GET['editEmpleados'])) {
    $data = json_decode(file_get_contents("php://input"));
    $ID = $data->ID;
    $nombreApellido = $data->nombreApellido;
    $cargo = $data->cargo;

    if (!empty($ID)) {

        $query = "CALL coe_editEmpleados('$ID','$nombreApellido','$cargo')";
        $result = mysqli_query($conection, $query);

        if (!$result) {
            die('Query Failed' . mysqli_error($conection));
        }
        $json = array();
        while ($row = mysqli_fetch_array($result)) {
            $json[] = array(
                'ID' => $row['ID'],
                'nombreApellido' => $row['nombreApellido'],
                'cargo' => $row['cargo'],
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
