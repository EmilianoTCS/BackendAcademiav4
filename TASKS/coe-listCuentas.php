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

    $query = "SELECT ram.nombreRamo, cur.*, cuen.codigoCuenta, IF(cur.fin < date(CURRENT_DATE), 'Finalizado', IF(cur.inicio <= date(CURRENT_DATE) and CURRENT_DATE <= cur.fin, 'En curso', IF(CURRENT_DATE < cur.inicio, 'Pendiente', ''))) as estado FROM cursos cur INNER JOIN ramos ram, cuentas cuen WHERE cur.idCuenta = cuen.ID AND cur.idRamo = ram.ID AND cur.isActive = true order by cur.ID ASC LIMIT $inicio , $cantidad_por_pagina ";
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
            'sesion' => $row['sesion'],
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
    $query = "SELECT ram.nombreRamo, cur.*, cuen.codigoCuenta,
            IF(cur.fin < date(CURRENT_DATE), 'Finalizado', IF(cur.inicio < date(CURRENT_DATE) and CURRENT_DATE < cur.fin, 'En curso', IF(CURRENT_DATE < cur.inicio, 'Pendiente', ''))) as estado
            FROM cursos cur INNER JOIN ramos ram, cuentas cuen
            WHERE cur.idCuenta = cuen.idRamo AND cur.ID = ram.ID AND cur.isActive = true order by cur.ID ASC LIMIT $cantidad_por_pagina ";
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
            'sesion' => $row['sesion'],
            'inicio' => $row['inicio'],
            'fecha_hora' => $row['fecha_hora'],
            'fin' => $row['fin'],
            'estado' => $row['estado']
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
