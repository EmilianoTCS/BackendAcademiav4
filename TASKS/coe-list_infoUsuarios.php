<?php

include("../model/conexion.php");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if(isset($_GET['usuario'])) {
  $usuario = $_GET['usuario'];
	
    $query = "SELECT ap.porcentaje_aprobacion, per.usuario, ram.nombreRamo ,ram.ID, cur.codigoCurso,  if(ap.porcentaje_aprobacion > 85, 'Aprobado', 'Reprobado') as estado
              from cursos cur INNER JOIN aprobacion ap, personas per, ramos ram WHERE cur.codigoCurso = ap.codigoCurso AND cur.idRamo = ram.ID AND ap.usuario = '$usuario' group by codigoCurso";
    $result = mysqli_query($conection, $query);
    if (!$result) {
        die('Query Failed' . mysqli_error($conection));
    }

    $json = array();
    while ($row = mysqli_fetch_array($result)) {
        $json[] = array(
			'ID' => $row['ID'],
            'usuario' => $row['usuario'],
            'nombreRamo' => $row['nombreRamo'],
            'aprobacion' => $row['porcentaje_aprobacion'],
            'estado' => $row['estado']
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
} else {
    echo json_encode("Error");
}
