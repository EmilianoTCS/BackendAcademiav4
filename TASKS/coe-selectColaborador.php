<?php

include('../model/conexion.php');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


if (isset($_GET['ID'])) {
    $data = json_decode(file_get_contents("php://input"));
    $ID = $data->ID;
    $query = "CALL coe_selectColaborador($ID)";
    $result = mysqli_query($conection, $query);

    if (!$result) {
        die('Query Failed' . mysqli_error($conection));
    }
    $json = array();
    while ($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'ID' => $row['ID'],
            'nombre_completo' => $row['nombre_completo'],
            'usuario' => $row['usuario'],
            'area' => $row['area'],
            'idCuenta' => $row['idCuenta'],
            'subgerencia' => $row['subgerencia'],
            'correo' => $row['correo']
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
} else {
    echo json_encode("Error");
}
