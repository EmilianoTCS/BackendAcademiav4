<?php

include("../../model/conexion.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if (isset($_GET['pagina'])) {
    $data = json_decode(file_get_contents("php://input"));
    $num_boton = $data->num_boton;
    $codigoEvaluacion = $data->codigoEvaluacion; 
    $cantidad_por_pagina = 6;
    $inicio = ($num_boton - 1) * $cantidad_por_pagina;
    
    $query = "SELECT * FROM `edd-resultado-evaluacion-analistas-automatizadores` WHERE ID != 0 AND codigoEvaluacion = '$codigoEvaluacion' order by ID ASC LIMIT $inicio,$cantidad_por_pagina";
    $result = mysqli_query($conection, $query);
    if (!$result) {
        die('Query Failed' . mysqli_error($conection));
    }
    $json = array();
    while ($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'ID' => $row['ID'],
            'codigoEvaluacion' => $row['codigoEvaluacion'],
            'NomAp' => $row['NomAp'],
            'NomApAnalista' => $row['NomApAnalista'],
            'numPregunta' => $row['numPregunta'],
            'resultado' => $row['resultado'],
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
} else {
    $data = json_decode(file_get_contents("php://input"));
    $codigoEvaluacion = $data->codigoEvaluacion; 
    $cantidad_por_pagina = 6;
    
    $query = "SELECT * FROM `edd-resultado-evaluacion-analistas-automatizadores` WHERE ID != 0 AND codigoEvaluacion = '$codigoEvaluacion' order by ID ASC LIMIT $cantidad_por_pagina";
    $result = mysqli_query($conection, $query);
    if (!$result) {
        die('Query Failed' . mysqli_error($conection));
    }
    $json = array();
    while ($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'ID' => $row['ID'],
            'codigoEvaluacion' => $row['codigoEvaluacion'],
            'NomAp' => $row['NomAp'],
            'NomApAnalista' => $row['NomApAnalista'],
            'numPregunta' => $row['numPregunta'],
            'resultado' => $row['resultado'],
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}