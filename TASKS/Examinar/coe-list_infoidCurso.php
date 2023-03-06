<?php
include("../../model/conexion.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if(isset($_GET['codigoCurso'])) {
  $data = json_decode(file_get_contents("php://input"));
  
  $codigoCurso = $data->codigoCurso;

$query = "SELECT *, IF(fin < date(CURRENT_DATE), 'Finalizado', IF(inicio < date(CURRENT_DATE) and CURRENT_DATE < fin, 'En curso', IF(CURRENT_DATE < inicio, 'Pendiente', ''))) as estado FROM cursos WHERE codigoCurso = '$codigoCurso' ";
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
