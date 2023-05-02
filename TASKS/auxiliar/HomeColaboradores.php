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


	$queryTotales = "CALL SP_AUX_countTotalesDatosAlumnos('$usuario',@p0,@p1,@p2,@p3)";
	$result = mysqli_query($conection, $queryTotales);
	if (!$result) {
		die('Query Failed' . mysqli_error($conection));
	} else {
		$row = mysqli_fetch_array($result);
		$porcentajeTotal = $row['OUT_porcentajeTotal'];
		$totalPendientes = $row['OUT_totalPendientes'];
		$totalFinalizados = $row['OUT_totalFinalizados'];
		$Promedio = $row['OUT_Promedio'];

		// mysqli_next_result($conection);
	}



	mysqli_close($conection);


	$json[] = array(
		'porcentajeTotal' => $porcentajeTotal,
		'totalPendientes' => $totalPendientes,
		'totalFinalizados' => $totalFinalizados,
		'Promedio' => $Promedio

	);



	$json_encode = json_encode($json);
	echo $json_encode;
}
