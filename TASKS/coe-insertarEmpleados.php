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

    if (!empty($nombreApellido) && !empty($correo)) {

        $query = "CALL coe_insertarEmpleado('$nombreApellido', '$cargo', '$correo', '$usuario')";
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


} else {
    echo json_encode("Error");
}
