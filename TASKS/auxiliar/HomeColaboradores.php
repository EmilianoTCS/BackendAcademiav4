<?php
include("../../model/conexion.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// TOTAL PORCENTAJE
if (isset($_GET['usuario'])) {
    $data = json_decode(file_get_contents("php://input"));
    $usuario = $data->usuario;
$queryPorcentaje = mysqli_query($conection, "SELECT ROUND((COUNT(ap.porcentaje_aprobacion)* 100) / (SELECT COUNT(ID) from ramos),1) as porcentaje from aprobacion ap WHERE ap.porcentaje_aprobacion > 90 AND ap.usuario = '$usuario'");
$result = mysqli_num_rows($queryPorcentaje);
if ($result > 0) {
    while ($data = mysqli_fetch_array($queryPorcentaje)) {
        $porcentajeTotal = $data['porcentaje'];
    }
}
// TOTAL PENDIENTES

$subQuery1 = "SELECT COUNT(ram.ID) as totalFinalizados from ramos ram 
											 INNER JOIN cursos cur, evaluaciones eva 
											 WHERE ram.ID = cur.idRamo AND cur.codigoCurso = eva.codigoCurso AND eva.estado = 'Enviado' AND eva.usuario = 'asagredo'";

// $backup = "SELECT COUNT(ram.ID) as totalPendientes from ramos ram 
											 // INNER JOIN cursos cur, evaluaciones eva 
											 // WHERE ram.ID = cur.idRamo AND cur.codigoCurso = eva.codigoCurso AND eva.estado = 'NO envia trabajo' AND eva.usuario = 'asagredo'");""



$queryPendientes = mysqli_query($conection, "SELECT round(count(ID) - (SELECT COUNT(ram.ID) as totalFinalizados from ramos ram 
											 INNER JOIN cursos cur, evaluaciones eva 
											 WHERE ram.ID = cur.idRamo AND cur.codigoCurso = eva.codigoCurso AND eva.estado = 'Enviado' AND eva.usuario = '$usuario')) as totalPendientes from ramos"); 
$result2 = mysqli_num_rows($queryPendientes);
if ($result2 > 0) {
    while ($data2 = mysqli_fetch_array($queryPendientes)) {
        $totalPendientes = $data2['totalPendientes'];
    }
}


// TOTAL FINALIZADOS
$queryFinalizados = mysqli_query($conection, "SELECT COUNT(ram.ID) as totalFinalizados from ramos ram 
											 INNER JOIN cursos cur, evaluaciones eva 
											 WHERE ram.ID = cur.idRamo AND cur.codigoCurso = eva.codigoCurso AND eva.estado = 'Enviado' AND eva.usuario = '$usuario'");
$result3 = mysqli_num_rows($queryFinalizados);
if ($result3 > 0) {
    while ($data3 = mysqli_fetch_array($queryFinalizados)) {
        $totalFinalizados = $data3['totalFinalizados'];
    }
}
// PROMEDIO
$queryPromedio = mysqli_query($conection, "SELECT ROUND(AVG(nota),1) as promedio from evaluaciones WHERE usuario = '$usuario'");
$result4 = mysqli_num_rows($queryPromedio);
if ($result4 > 0) {
    while ($data4 = mysqli_fetch_array($queryPromedio)) {
        $Promedio = $data4['promedio'];
    }
}



	$json[] = array(
	'porcentajeTotal' => $porcentajeTotal,
	'totalPendientes' => $totalPendientes,
	'totalFinalizados' => $totalFinalizados,
	'Promedio' => $Promedio
	
	);


	$json_encode = json_encode($json);
	echo $json_encode;
}
