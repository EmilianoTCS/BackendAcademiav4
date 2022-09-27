<?php
include("../model/conexion.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// TOTAL CURSOS
$query_total_cursos = mysqli_query($conection, "SELECT count(distinct(ID)) FROM cursos");
$result = mysqli_num_rows($query_total_cursos);
if ($result > 0) {
    while ($data = mysqli_fetch_array($query_total_cursos)) {
        $totalCursos = $data['count(distinct(ID))'];
    }
}
// TOTAL COLABORADORES
$query_total_colaboradores = mysqli_query($conection, "SELECT count(distinct(ID)) FROM personas");
$result = mysqli_num_rows($query_total_colaboradores);
if ($result > 0) {
    while ($data = mysqli_fetch_array($query_total_colaboradores)) {
        $totalColaboradores = $data['count(distinct(ID))'];
    }
}
// TOTAL APROBADOS
$totalAprobados = 0;
$query_total_aprobados = mysqli_query($conection, "SELECT if(porcentaje_aprobacion > 85, 'Aprobado','Reprobado') as estado FROM aprobacion");
$result = mysqli_num_rows($query_total_aprobados);
if ($result > 0) {
    while ($data = mysqli_fetch_array($query_total_aprobados)) {
        $estado = $data['estado'];
        if ($estado == 'Aprobado') {
            $totalAprobados++;
        }
    }
}

//CURSOS TERMINADOS
$cantidadFinalizado = 0;
$queryEstado1 = mysqli_query($conection, "SELECT IF(fin < date(CURRENT_DATE), 'Finalizado', '') as estado from cursos");
$result1 = mysqli_num_rows($queryEstado1);
if ($result1 > 0) {
    while ($data = mysqli_fetch_array($queryEstado1)) {
        $estado = $data['estado'];
        if ($estado == 'Finalizado') {
            $cantidadFinalizado++;
        }
    }
}
//CURSOS EN CURSO
$cantidadEnCurso = 0;
$queryEstado2 = mysqli_query($conection, "SELECT IF(inicio < date(CURRENT_DATE) and CURRENT_DATE < fin, 'En curso', '') as estado from cursos");
$result2 = mysqli_num_rows($queryEstado2);
if ($result2 > 0) {
    while ($data = mysqli_fetch_array($queryEstado2)) {
        $estado = $data['estado'];
        if ($estado == 'En curso') {
            $cantidadEnCurso++;
        }
    }
}
//CURSOS PENDIENTES
$cantidadPendientes = 0;
$queryEstado3 = mysqli_query($conection, "SELECT IF(CURRENT_DATE < inicio, 'Pendiente', '') as estado from cursos");
$result3 = mysqli_num_rows($queryEstado3);
if ($result3 > 0) {
    while ($data = mysqli_fetch_array($queryEstado3)) {
        $estado = $data['estado'];
        if ($estado == 'Pendiente') {
            $cantidadPendientes++;
        }
    }
}

// PORCENTAJE DE CURSOS
$porcentajeCursosTerminados = ($cantidadFinalizado * 100) / $totalCursos;
// PORCENTAJE DE APROBADOS
$porcentajeAprobados = ($totalAprobados * 100) / $totalColaboradores;



$json[] = array(
    'totalCursos' => $totalCursos,
    'totalColaboradores' => $totalColaboradores,
    'totalAprobados' => $totalAprobados,
    'totalFinalizados' => $cantidadFinalizado,
    'totalActivos' => $cantidadEnCurso,
	'porcentajeFinalizados' => $porcentajeCursosTerminados,
    'totalPendientes' => $cantidadPendientes
);

$json_string = json_encode($json);
echo $json_string;

?>