<?php
include("../../model/conexion.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if(isset($_GET['codigoEvaluacion'])) {
  $data = json_decode(file_get_contents("php://input"));
  
  $codigoEvaluacion = $data->codigoEvaluacion;

$query = "SELECT * , FROM empleados emp INNER JOIN equipos equip, `edd-evaluacion-analistas-automatizadores` evaAnalistas, `edd-resultados-evaluacion-analistas-automatizadores` resultAnalistas WHERE emp.ID = equip.idEmpleado AND equip.nombreEquipo = evaAnalistas.nombreEquipo AND evaAnalistas.codigoEvaluacion = "ID DEL FRONT" AND evaAnalistas.codigoEvaluacion = resultAnalistas.codigoEvaluacion AND emp.nombreApellido LIKE resultAnalistas.`pgt1-NomAp`";

$result = mysqli_query($conection, $query);
if (!$result) {
    die('Query Failed' . mysqli_error($conection));
}
$json = array();
while ($row = mysqli_fetch_array($result)) {
    $json[] = array(
	    'ID' => $row['ID'],
        'codigoCurso' => $row['codigoCurso'],
        'fecha_hora' => $row['fecha_hora'],
        'codigoRamo' => $row['codigoRamo'],
        'hora_inicio' => $row['hora_inicio'],
        'hora_fin' => $row['hora_fin'],
        'estado' => $row['estado']
    );
}
$jsonstring = json_encode($json);
echo $jsonstring;

}else{
    echo json_encode("Error");
}