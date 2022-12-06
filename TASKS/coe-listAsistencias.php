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
    $fecha = $data->fecha;

    $query = "SELECT ID, usuario, valor from asistencias WHERE idCurso = '$ID' AND atributo = '$fecha' group by usuario";
    $result = mysqli_query($conection, $query);

    if (!$result) {
        die('Query Failed' . mysqli_error($conection));
    }
    $json = array();
    while ($row = mysqli_fetch_array($result)) {

        $json[] = array(
            'ID' => $row['ID'],
            'usuario' => $row['usuario'],
            'valor' => $row['valor'],
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
} else {
    echo json_encode("Error");
}
