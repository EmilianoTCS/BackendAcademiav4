<?php
include("../model/conexion.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if(isset($_GET['codigoCurso'])) {
  $codigoCurso = $_GET['codigoCurso'];

$query = "SELECT cur.*, per.usuario, ap.porcentaje_aprobacion, if(ap.porcentaje_aprobacion > 85, 'Aprobado', 'Reprobado')
          as estado from cursos cur INNER JOIN personas per, aprobacion ap 
          where cur.codigoCurso = '$codigoCurso' AND ap.codigoCurso = '$codigoCurso' AND per.usuario = ap.usuario group by usuario order by usuario ASC";
$result = mysqli_query($conection, $query);
if (!$result) {
    die('Query Failed' . mysqli_error($conection));
}

$json = array();
while ($row = mysqli_fetch_array($result)) {
    $json[] = array(
	    'ID' => $row['ID'],
        'codigoCurso' => $row['codigoCurso'],
        'horaInicio' => $row['hora_inicio'],
        'horaFin' => $row['hora_fin'],
        'usuario' => $row['usuario'],
        'aprobacion' => $row['porcentaje_aprobacion'],
        'estado' => $row['estado']
    );
}
$jsonstring = json_encode($json);
echo $jsonstring;

}else{
    echo json_encode("Error");
}
