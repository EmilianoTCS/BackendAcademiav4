<?php

include("../../model/conexion.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if (isset($_GET['insertarResultadosAnalistas'])) {
    $data = json_decode(file_get_contents("php://input"));
    $nombApellido = $data->nombApellido;
    $nombApellidoAnalista = $data->nombApellidoAnalista;
    $respuestas = $data->respuestas;
    $json = array();
    $numPregunta = 2;

    $queryCodigo = "SELECT codigoEvaluacion from `edd-evaluacion-analistas-automatizadores` evaAnalistas INNER JOIN equipos equip, empleados emp WHERE evaAnalistas.nombreEquipo = equip.nombreEquipo AND equip.idEmpleado = emp.ID AND emp.nombreApellido LIKE '$nombApellido'";
    $resultCodigo = mysqli_query($conection, $queryCodigo);

    if (!$resultCodigo) {
        die('Query Failed' . mysqli_error($conection));
    } else {
        $json = array();
        while ($row = mysqli_fetch_array($resultCodigo)) {
            $codigoEvaluacion = $row['codigoEvaluacion'];
        }
    }
    for ($i = 0; $i < count($respuestas); $i++) {
        if (!empty($nombApellido) && !empty($nombApellidoAnalista) && !empty($respuestas)) {
            $numPregunta += 1;
            $query = "INSERT INTO `edd-resultados-evaluacion-analistas-automatizadores` (codigoEvaluacion, NomAp, NomApAnalista, numPregunta, resultado) VALUES ('$codigoEvaluacion', '$nombApellido', '$nombApellidoAnalista', '$numPregunta', '$respuestas[$i]') ";
            $result = mysqli_query($conection, $query);

            if (!$result) {
                die('Query Failed' . mysqli_error($conection));
            } else {
                array_push($json, "SuccessfulAnswered");
            }
        } else {
            array_push($json, "Error");
        }
    }
    echo json_encode(array_unique($json));
} else {
    echo json_encode('Error');
}
