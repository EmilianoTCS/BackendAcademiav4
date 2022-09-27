<?php

include("../../model/conexion.php");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if(isset($_GET['idCurso'])) {

    $query = "SELECT cur.ID, cur.isActive, ram.codigoRamo, ram.nombreRamo FROM cursos cur INNER JOIN ramos ram WHERE cur.idRamo = ram.ID AND cur.isActive = true AND ram.isActive = true ORDER BY ram.nombreRamo";
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
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
} else {
    echo json_encode("Error");
}
