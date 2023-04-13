<?php
session_start();
include("../model/conexion.php");
include("../security/logBuilder.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if (isset($_GET['insertarEmpleado'])) {
    $data = json_decode(file_get_contents("php://input"));
    $nombreApellido = $data->nombreApellido;
    $cargo = $data->cargo;
    $correo = $data->correo;
    $usuario = $data->usuario;
    $isActive = true;

    if (!empty($nombreApellido) && !empty($correo)) {

        $query = "INSERT INTO empleados (nombreApellido, cargo, correo, usuario, isActive, fechaActualizacion) VALUES ('$nombreApellido','$cargo','$correo','$usuario', '$isActive', current_timestamp());";
        $result = mysqli_query($conection, $query);
        if (!$result) {
            die('Query Failed' . mysqli_error($conection));
        } else {

            $querySelect = "SELECT * from empleados WHERE ID = (SELECT MAX(ID) from empleados) AND isActive = true";
            $resultSelect = mysqli_query($conection, $querySelect);
            if (!$resultSelect) {
                die('Query Failed' . mysqli_error($conection));
            } else {
                $json = array();
                while ($row = mysqli_fetch_array($resultSelect)) {
                    $json[] = array(
                        'ID' => $row['ID'],
                        'nombreApellido' => $row['nombreApellido'],
                        'cargo' => $row['cargo'],
                        'correo' => $row['correo'],
                        'usuario' => $row['usuario'],
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
