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
    $query = "SELECT ram.*, rel.nombre FROM ramos ram INNER JOIN relator rel, relator_ramo rel_ram WHERE ram.ID = '$ID' AND rel_ram.idRelator = rel.ID AND rel_ram.idRamo = ram.ID";
    $result = mysqli_query($conection, $query);

    if (!$result) {
        die('Query Failed' . mysqli_error($conection));
    }
    $json = array();
    while ($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'ID' => $row['ID'],
            'codigoRamo' => $row['codigoRamo'],
            'nombreRamo' => $row['nombreRamo'],
            'nombre' => $row['nombre'],
            'pre_requisitos' => $row['pre_requisito'],
            'hh_academicas' => $row['hh_academicas']
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
} else {
    echo json_encode("Error");
}
