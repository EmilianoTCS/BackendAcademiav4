<?php
include("../../model/conexion.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// TOTAL CURSOS
$promedio = mysqli_query($conection, "SELECT codigoCurso, num_evaluaciones, nota, AVG(nota) as promedio, porcentaje from evaluaciones where usuario = 'asagredo' GROUP BY codigoCurso, num_evaluaciones order by codigoCurso ASC");
$result = mysqli_num_rows($promedio);
if ($result > 0) {
    while ($data = mysqli_fetch_array($promedio)) {
        $totalCursos[] = array(
		'promedio' => $data['promedio'],
		'num_evaluaciones' => $data['num_evaluaciones'],
		'codigoCurso' => $data['codigoCurso'],
		'porcentaje' => $data['porcentaje'],
		'nota' => $data['nota'],
		);
    }
}
	$json_encode = json_encode($totalCursos);
	echo $json_encode;


?>