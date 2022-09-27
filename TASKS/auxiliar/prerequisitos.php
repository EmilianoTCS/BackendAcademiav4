<?php

include("../../model/conexion.php");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if(isset($_GET['ID'])) {
	$ID = $_GET['ID'];

    $query = "SELECT req.*, cur.codigoRamo, ram.nombreRamo FROM requisitos_curso req INNER JOIN cursos cur, ramos ram WHERE req.idCurso = '$ID'  AND req.pre_requisito = cur.ID AND cur.idRamo = ram.ID";
    $result = mysqli_query($conection, $query);
    if (!$result) {
        die('Query Failed' . mysqli_error($conection));
    }

    $json = array();
    while ($row = mysqli_fetch_array($result)) {
        $json[] = array(
			'ID' => $row['ID'],
			'nombreRamo' => $row['nombreRamo'],
			'pre_requisito' => $row['pre_requisito'],
			'codigoRamo' => $row['codigoRamo'],
			'fechaActualizacion' => $row['fechaActualizacion'],
			'isActive' => $row['isActive'],
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
} else {
    echo json_encode("Error");
}
