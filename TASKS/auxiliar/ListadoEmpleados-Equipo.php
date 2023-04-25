<?php

include("../../model/conexion.php");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if (isset($_GET['listadoEmpleados'])) {
    $data = json_decode(file_get_contents("php://input"));
    $nombreEquipo = $data->nombreEquipo;

    $query = "SELECT emp.* from empleados emp INNER JOIN equipos equip WHERE emp.ID = equip.idEmpleado AND equip.nombreEquipo = '$nombreEquipo' AND emp.isActive = true";
    $result = mysqli_query($conection, $query);
    if (!$result) {
        die('Query Failed' . mysqli_error($conection));
    }

    $json = array();
    while ($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'nombreApellido' => $row['nombreApellido'],
            'correo' => $row['correo'],
            'ID' => $row['ID']
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
} else {
    echo json_encode("Error");
}
