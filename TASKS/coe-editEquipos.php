<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include('../model/conexion.php');
include("../security/logBuilder.php");

if (isset($_GET['editEquipos'])) {
    $data = json_decode(file_get_contents("php://input"));
    $ID = $data->ID;
    $nombreEquipo = $data->nombreEquipo;
    $cliente = $data->cliente;
    $nombreProyecto = $data->nombreProyecto;
    $nombreApellido = $data->nombreApellido;
    $nombreArea = $data->nombreArea;


    if (!empty($ID)) {

        $query = "CALL coe_editEquipos($ID, '$nombreEquipo', '$cliente', '$nombreProyecto','$nombreApellido','$nombreArea')";
        $result = mysqli_query($conection, $query);

        if (!$result) {
            die('Query Failed' . mysqli_error($conection));
        }

        $json = array();
        while ($row = mysqli_fetch_array($result)) {
            $json[] = array(
                'ID' => $row['ID'],
                'nombreEquipo' => $row['nombreEquipo'],
                'cliente' => $row['cliente'],
                'nombreProyecto' => $row['nombreProyecto'],
                'nombreApellido' => $row['nombreApellido'],
                'nombreArea' => $row['nombreArea'],
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
