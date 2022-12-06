<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include("../model/conexion.php");



if (isset($_GET['pagina'])) {

    $data = json_decode(file_get_contents("php://input"));
    $num_boton = $data->num_boton;
    $cantidad_por_pagina = 6;
    $inicio = ($num_boton - 1) * $cantidad_por_pagina;
    $query = "SELECT ram.*, cur.*,
              IF(fin < date(CURRENT_DATE), 'Finalizado', IF(inicio < date(CURRENT_DATE) and CURRENT_DATE < fin, 'En curso', IF(CURRENT_DATE < inicio, 'Pendiente', ''))) as estado
              FROM cursos cur INNER JOIN ramos ram WHERE cur.codigoRamo = ram.codigoRamo AND cur.isActive = true order by cur.ID ASC LIMIT $inicio,$cantidad_por_pagina ";
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
            'fecha_hora' => $row['fecha_hora'],
            'estado' => $row['estado']
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
} else {
    $cantidad_por_pagina = 6;
    $query = "SELECT ram.*, cur.*,
          IF(fin < date(CURRENT_DATE), 'Finalizado', IF(inicio < date(CURRENT_DATE) and CURRENT_DATE < fin, 'En curso', IF(CURRENT_DATE < inicio, 'Pendiente', ''))) as estado
          FROM cursos cur INNER JOIN ramos ram 
          WHERE cur.codigoRamo = ram.codigoRamo WHERE cur.isActive = true order by cur.ID ASC LIMIT $cantidad_por_pagina ";
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
            'fecha_hora' => $row['fecha_hora'],
            'fin' => $row['fin'],
            'estado' => $row['estado']
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}