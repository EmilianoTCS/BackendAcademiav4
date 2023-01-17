<?php

include("../../model/conexion.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if (isset($_GET['NotasColaboradores'])) {
	$data = json_decode(file_get_contents("php://input"));
	$idCurso = $data->idCursosSelected;
	$usuario = $data->usuarioSelected;


	if (empty($data->num_boton)) {
		$num_boton = 1;
	} else {
		$num_boton = $data->num_boton;
	}


	$cantidad_por_pagina = 10;
	$inicio = ($num_boton - 1) * $cantidad_por_pagina;

	switch ([$idCurso, $usuario]) {
		case ['', '']:
			$query1 = "SELECT eva.ID, eva.usuario, eva.codigoCurso, eva.num_evaluaciones, eva.nota, ROUND(AVG(eva.nota),2) as promedio, eva.porcentaje from evaluaciones eva INNER JOIN ramos ram, cursos cur WHERE eva.codigoCurso = cur.codigoCurso AND cur.idRamo = ram.ID GROUP BY eva.num_evaluaciones, eva.usuario, eva.codigoCurso order by eva.codigoCurso ASC LIMIT $inicio, $cantidad_por_pagina";
			$result1 = mysqli_query($conection, $query1);
			if (!$result1) {
				die('Query Failed' . mysqli_error($conection));
			} else {

				while ($row1 = mysqli_fetch_array($result1)) {
					$json[] = array(
						'ID' => $row1['ID'],
						'usuario' => $row1['usuario'],
						'codigoCurso' => $row1['codigoCurso'],
						'num_evaluaciones' => $row1['num_evaluaciones'],
						'nota' => $row1['nota'],
						'promedio' => $row1['promedio'],
						'porcentaje' => $row1['porcentaje'],
						'isEmpty' => false
					);
				}
				$json_encode = json_encode($json);
				echo $json_encode;
			}

			break;
		case [!empty($idCurso), '']:
			$query1 = "SELECT eva.ID, eva.usuario, eva.codigoCurso, eva.num_evaluaciones, eva.nota, ROUND(AVG(eva.nota),2) as promedio, eva.porcentaje from evaluaciones eva INNER JOIN ramos ram, cursos cur WHERE eva.codigoCurso = cur.codigoCurso AND cur.codigoRamo = ram.codigoRamo AND ram.ID = '$idCurso' GROUP BY eva.usuario, eva.num_evaluaciones order by eva.codigoCurso ASC LIMIT $inicio, $cantidad_por_pagina";
			$result1 = mysqli_query($conection, $query1);
			if (!$result1) {
				die('Query Failed' . mysqli_error($conection));
				// echo json_encode("error");
			} else {
				if (mysqli_num_rows($result1) > 1) {
					while ($row1 = mysqli_fetch_array($result1)) {
						$json[] = array(
							'ID' => $row1['ID'],
							'usuario' => $row1['usuario'],
							'codigoCurso' => $row1['codigoCurso'],
							'num_evaluaciones' => $row1['num_evaluaciones'],
							'nota' => $row1['nota'],
							'promedio' => $row1['promedio'],
							'porcentaje' => $row1['porcentaje'],
							'isEmpty' => false
						);
					}
					$json_encode = json_encode($json,);
					echo $json_encode;
				} else {
					$json[] = array('isEmpty' => true);
					echo json_encode($json);
				}
			}
			break;

		case ['', !empty($usuario)]:
			$query1 = "SELECT eva.ID, eva.usuario, eva.codigoCurso, eva.num_evaluaciones, eva.nota, ROUND(AVG(eva.nota),2) as promedio, eva.porcentaje from evaluaciones eva INNER JOIN ramos ram, cursos cur WHERE eva.codigoCurso = cur.codigoCurso AND cur.idRamo = ram.ID AND eva.usuario = '$usuario' group by eva.codigoCurso, eva.num_evaluaciones order by eva.codigoCurso ASC LIMIT $inicio, $cantidad_por_pagina";
			$result1 = mysqli_query($conection, $query1);
			if (!$result1) {
				die('Query Failed' . mysqli_error($conection));
			} else {
				if (mysqli_num_rows($result1) > 1) {

					while ($row1 = mysqli_fetch_array($result1)) {
						$json[] = array(
							'ID' => $row1['ID'],
							'usuario' => $row1['usuario'],
							'codigoCurso' => $row1['codigoCurso'],
							'num_evaluaciones' => $row1['num_evaluaciones'],
							'nota' => $row1['nota'],
							'promedio' => $row1['promedio'],
							'porcentaje' => $row1['porcentaje'],
							'isEmpty' => false

						);
					}
					$json_encode = json_encode($json);
					echo $json_encode;
				} else {

					$json[] = array('isEmpty' => true);
					echo json_encode($json);
				}
			}
			break;
		case [!empty($idCurso), !empty($usuario)]:
			$query1 = "SELECT eva.ID, eva.usuario, eva.codigoCurso, eva.num_evaluaciones, eva.nota, ROUND(AVG(eva.nota),2) as promedio, eva.porcentaje from evaluaciones eva INNER JOIN ramos ram, cursos cur WHERE eva.codigoCurso = cur.codigoCurso AND cur.idRamo = ram.ID AND eva.usuario = '$usuario' AND ram.ID = '$idCurso' GROUP BY eva.num_evaluaciones order by eva.codigoCurso ASC LIMIT $inicio, $cantidad_por_pagina";
			$result1 = mysqli_query($conection, $query1);
			if (!$result1) {
				die('Query Failed' . mysqli_error($conection));
			} else {
				if (mysqli_num_rows($result1) > 1) {

					while ($row1 = mysqli_fetch_array($result1)) {
						$json[] = array(
							'ID' => $row1['ID'],
							'usuario' => $row1['usuario'],
							'codigoCurso' => $row1['codigoCurso'],
							'num_evaluaciones' => $row1['num_evaluaciones'],
							'nota' => $row1['nota'],
							'promedio' => $row1['promedio'],
							'porcentaje' => $row1['porcentaje'],
							'isEmpty' => false
						);
					}
					$json_encode = json_encode($json);
					echo $json_encode;
				} else {
					$json[] = array('isEmpty' => true);
					echo json_encode($json);
				}
			}
			break;
	}
} else {
	$cantidad_por_pagina = 10;
	$inicio = 0;
	$query1 = "SELECT eva.ID, eva.usuario, eva.codigoCurso, eva.num_evaluaciones, eva.nota, ROUND(AVG(eva.nota),2) as promedio, eva.porcentaje from evaluaciones eva INNER JOIN ramos ram, cursos cur WHERE eva.codigoCurso = cur.codigoCurso AND cur.idRamo = ram.ID GROUP BY eva.num_evaluaciones, eva.usuario, eva.codigoCurso order by eva.codigoCurso ASC LIMIT $inicio, $cantidad_por_pagina";
	$result1 = mysqli_query($conection, $query1);
	if (!$result1) {
		die('Query Failed' . mysqli_error($conection));
	} else {
		if (mysqli_num_rows($result1) > 1) {

			while ($row1 = mysqli_fetch_array($result1)) {
				$json[] = array(
					'ID' => $row1['ID'],
					'usuario' => $row1['usuario'],
					'codigoCurso' => $row1['codigoCurso'],
					'num_evaluaciones' => $row1['num_evaluaciones'],
					'nota' => $row1['nota'],
					'promedio' => $row1['promedio'],
					'porcentaje' => $row1['porcentaje'],
					'isEmpty' => false

				);
			}
			echo json_encode(['isEmpty' => true]);
		} else {
			echo json_encode(['isEmpty' => true]);
		}
	}
}
