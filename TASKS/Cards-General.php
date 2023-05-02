<?php
include("../model/conexion.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$cantidadFinalizado = 0;
$cantidadEnCurso = 0;
$cantidadPendientes = 0;
$totalAprobados = 0;
$totalCursos = 0;
$totalColaboradores = 0;
$totalAprobados = 0;



// CURSOS TERMINADOS, FINALIZADOS Y PENDIENTES

$queryEstado1 =  "CALL SP_AUX_listEstadoCurso()";
$result1 = mysqli_query($conection, $queryEstado1);
if (!$result1) {
    die('Query Failed' . mysqli_error($conection));
}
while ($data = mysqli_fetch_array($result1)) {
    $estado = $data['estado'];
    switch ($estado) {
        case 'Finalizado':
            $cantidadFinalizado++;
            break;
        case 'En curso':
            $cantidadEnCurso++;
            break;
        case 'Pendiente':
            $cantidadPendientes++;
            break;
    }
    mysqli_next_result($conection);
}




$queryTotales = "CALL SP_AUX_countTotales(@p,@p1,@p2)";
$result = mysqli_query($conection, $queryTotales);
if (!$result) {
    die('Query Failed' . mysqli_error($conection));
} else {
    $row = mysqli_fetch_array($result);
    $totalCursos = $row['OUT_totalCursos'];
    $totalColaboradores = $row['OUT_totalColaboradores'];
    $totalAprobados = $row['OUT_totalAprobados'];

    // mysqli_next_result($conection);
}




mysqli_close($conection);


// PORCENTAJE DE CURSOS
$porcentajeCursosTerminados = round((($cantidadFinalizado * 100) / $totalCursos), 2);
// PORCENTAJE DE APROBADOS
$porcentajeAprobados = round((($totalAprobados * 100) / $totalColaboradores), 2);


$json[] = array(
    'totalCursos' => $totalCursos,
    'totalColaboradores' => $totalColaboradores,
    'totalAprobados' => $porcentajeAprobados,
    'totalFinalizados' => $cantidadFinalizado,
    'totalActivos' => $cantidadEnCurso,
    'porcentajeFinalizados' => $porcentajeCursosTerminados,
    'totalPendientes' => $cantidadPendientes
);

$json_string = json_encode($json);
echo $json_string;
