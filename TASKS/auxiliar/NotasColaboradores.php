<?php

include("../../model/conexion.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if(isset($_GET['NotasColaboradores'])) {
  $data= json_decode(file_get_contents("php://input"));
  $idCurso = $data->idCursosSelected;
  $usuario = $data->usuarioSelected;
  
  
  if(empty($data->num_boton)){
	  $num_boton = 1;
  }else{
	  $num_boton = $data->num_boton;
  }
  
  
  $cantidad_por_pagina = 10;
  $inicio = ($num_boton - 1) * $cantidad_por_pagina;

  switch ([$idCurso, $usuario]) {
	  case ['','']:
			$query1 = "SELECT ID, usuario, codigoCurso, num_evaluaciones, nota, ROUND(AVG(nota),2) as promedio, porcentaje from evaluaciones GROUP BY num_evaluaciones, usuario, codigoCurso order by codigoCurso ASC LIMIT $inicio, $cantidad_por_pagina";
					$result1 = mysqli_query($conection, $query1);
					if (!$result1) {
					die('Query Failed' . mysqli_error($conection));
					}else{
					while ($row1 = mysqli_fetch_array($result1)) {
					$json[] = array(
					'ID' => $row1['ID'],
					'usuario' => $row1['usuario'],
					'codigoCurso' => $row1['codigoCurso'],
					'num_evaluaciones' => $row1['num_evaluaciones'],
					'nota' => $row1['nota'],
					'promedio' => $row1['promedio'],
					'porcentaje' => $row1['porcentaje']
					);
				}
				$json_encode = json_encode($json);
				echo $json_encode;
			}
		break;
		case [!empty($idCurso), '']:
		$query1 = "SELECT ID, usuario, codigoCurso, num_evaluaciones, nota, ROUND(AVG(nota),2) as promedio, porcentaje from evaluaciones WHERE idCurso = '$idCurso' GROUP BY usuario, num_evaluaciones order by codigoCurso ASC LIMIT $inicio, $cantidad_por_pagina";
			$result1 = mysqli_query($conection, $query1);
			if (!$result1) {
				die('Query Failed' . mysqli_error($conection));
			}else{
				while ($row1 = mysqli_fetch_array($result1)) {
					$json[] = array(
					'ID' => $row1['ID'],
					'usuario' => $row1['usuario'],
					'codigoCurso' => $row1['codigoCurso'],
					'num_evaluaciones' => $row1['num_evaluaciones'],
					'nota' => $row1['nota'],
					'promedio' => $row1['promedio'],
					'porcentaje' => $row1['porcentaje']
					);
				}
				$json_encode = json_encode($json);
				echo $json_encode;
			}
		break;
		
		case ['', !empty($usuario)]:
			$query1 = "SELECT ID, usuario, codigoCurso, num_evaluaciones, nota, ROUND(AVG(nota),2) as promedio, porcentaje from evaluaciones WHERE usuario = '$usuario' group by codigoCurso, num_evaluaciones order by codigoCurso ASC LIMIT $inicio, $cantidad_por_pagina";
			$result1 = mysqli_query($conection, $query1);
			if (!$result1) {
				die('Query Failed' . mysqli_error($conection));
			}else{
				while ($row1 = mysqli_fetch_array($result1)) {
					$json[] = array(
					'ID' => $row1['ID'],
					'usuario' => $row1['usuario'],
					'codigoCurso' => $row1['codigoCurso'],
					'num_evaluaciones' => $row1['num_evaluaciones'],
					'nota' => $row1['nota'],
					'promedio' => $row1['promedio'],
					'porcentaje' => $row1['porcentaje']
					);
				}
				$json_encode = json_encode($json);
				echo $json_encode;
			}
		break;
		case [!empty($idCurso), !empty($usuario)]:
			$query1 = "SELECT ID, usuario, codigoCurso, num_evaluaciones, nota, ROUND(AVG(nota),2) as promedio, porcentaje from evaluaciones WHERE usuario = '$usuario' AND idCurso = '$idCurso' GROUP BY num_evaluaciones order by codigoCurso ASC LIMIT $inicio, $cantidad_por_pagina";
			$result1 = mysqli_query($conection, $query1);
			if (!$result1) {
				die('Query Failed' . mysqli_error($conection));
			}else{
				while ($row1 = mysqli_fetch_array($result1)) {
					$json[] = array(
					'ID' => $row1['ID'],
					'usuario' => $row1['usuario'],
					'codigoCurso' => $row1['codigoCurso'],
					'num_evaluaciones' => $row1['num_evaluaciones'],
					'nota' => $row1['nota'],
					'promedio' => $row1['promedio'],
					'porcentaje' => $row1['porcentaje']
					);
				}
				$json_encode = json_encode($json);
				echo $json_encode;
			}
		break;
		
		
	}

} else {
	$cantidad_por_pagina = 10;
	$inicio = 0;
	$query1 = "SELECT ID, usuario, codigoCurso, num_evaluaciones, nota, ROUND(AVG(nota),2) as promedio, porcentaje from evaluaciones GROUP BY num_evaluaciones, usuario, codigoCurso order by codigoCurso ASC LIMIT $inicio, $cantidad_por_pagina";
	$result1 = mysqli_query($conection, $query1);
	if (!$result1) {
	die('Query Failed' . mysqli_error($conection));
	}else{
	while ($row1 = mysqli_fetch_array($result1)) {
	$json[] = array(
					'ID' => $row1['ID'],
					'usuario' => $row1['usuario'],
					'codigoCurso' => $row1['codigoCurso'],
					'num_evaluaciones' => $row1['num_evaluaciones'],
					'nota' => $row1['nota'],
					'promedio' => $row1['promedio'],
					'porcentaje' => $row1['porcentaje']
					);
				}
				$json_encode = json_encode($json);
				echo $json_encode;
}}