<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include("../model/conexion.php");



if (isset($_GET['pagina'])) {
	
	$data= json_decode(file_get_contents("php://input"));
    $num_boton = $data->num_boton;
    $cantidad_por_pagina = 6;
    $inicio = ( $num_boton - 1 ) * $cantidad_por_pagina = 6;
    ;
    $query = "SELECT ram.*, cur.*,
          IF(fin < date(CURRENT_DATE), 'Finalizado', IF(inicio < date(CURRENT_DATE) and CURRENT_DATE < fin, 'En curso', IF(CURRENT_DATE < inicio, 'Pendiente', ''))) as estado
          FROM cursos cur INNER JOIN ramos ram ON ram.ID = cur.idRamo AND cur.idCuenta = ram.idCuenta WHERE cur.isActive = true LIMIT $inicio,$cantidad_por_pagina";
    $result = mysqli_query($conection, $query);
    if (!$result) {
        die('Query Failed' . mysqli_error($conection));
    }
    $json = array();
    while ($row = mysqli_fetch_array($result)) {
        $json[] = array(
			'ID' => $row['ID'],
            'codigoCuenta' => $row['codigoCuenta'],
            'codigoCurso' => $row['codigoCurso'],
            'nombreRamo' => $row['nombreRamo'],
            'inicio' => $row['inicio'],
            'fin' => $row['fin'],
            'estado' => $row['estado']
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
} else {
    $num_boton = 0;
    $cantidad_por_pagina = 6;
    $query = "SELECT ram.*, cur.*,
          IF(fin < date(CURRENT_DATE), 'Finalizado', IF(inicio < date(CURRENT_DATE) and CURRENT_DATE < fin, 'En curso', IF(CURRENT_DATE < inicio, 'Pendiente', ''))) as estado
          FROM cursos cur INNER JOIN ramos ram ON ram.ID = cur.idRamo AND cur.idCuenta = ram.idCuenta WHERE cur.isActive = true LIMIT $num_boton, $cantidad_por_pagina";
    $result = mysqli_query($conection, $query);
    if (!$result) {
        die('Query Failed' . mysqli_error($conection));
    }
    $json = array();
    while ($row = mysqli_fetch_array($result)) {
        $json[] = array(
			'ID' => $row['ID'],
            'codigoCuenta' => $row['codigoCuenta'],
            'codigoCurso' => $row['codigoCurso'],
            'nombreRamo' => $row['nombreRamo'],
            'inicio' => $row['inicio'],
            'fin' => $row['fin'],
            'estado' => $row['estado']
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
