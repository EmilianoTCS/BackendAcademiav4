<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

session_start();
include("../model/conexion.php");
include("../security/logBuilder.php");

if (isset($_GET['insertarProyecto'])) {
    $data = json_decode(file_get_contents("php://input"));
    $nombreProyecto = $data->nombreProyecto;
    $cliente = $data->cliente;
    $cuentaJP = $data->cuentaJP;
    $servicio = $data->servicio;
    $isActive = true;


    if (!empty($nombreProyecto) && !empty($cliente)) {

        $query = "INSERT INTO proyectos (nombreProyecto, cliente, cuentaJP, servicio, isActive, fechaActualizacion) VALUES ('$nombreProyecto','$cliente','$cuentaJP','$servicio','$isActive', current_timestamp());";
        $result = mysqli_query($conection, $query);
        if (!$result) {
            die('Query Failed' . mysqli_error($conection));
        } else {

            $querySelect = "SELECT * from proyectos WHERE ID = (SELECT MAX(ID) from proyectos) AND isActive = true";
            $resultSelect = mysqli_query($conection, $querySelect);
            if (!$resultSelect) {
                die('Query Failed' . mysqli_error($conection));
            } else {
                $json = array();
                while ($rowSelect = mysqli_fetch_array($resultSelect)) {
                    $json[] = array(
                        'ID' => $rowSelect['ID'],
                        'nombreProyecto' => $rowSelect['nombreProyecto'],
                        'cliente' => $rowSelect['cliente'],
                        'cuentaJP' => $rowSelect['cuentaJP'],
                        'servicio' => $rowSelect['servicio'],
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
