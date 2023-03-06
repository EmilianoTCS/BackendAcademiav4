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

    $query = "SELECT rel.*, ar.nombreArea, ram.nombreRamo, ram.codigoRamo FROM relator rel INNER JOIN ramos ram, relator_ramo rel_ram , area ar WHERE rel.ID = rel_ram.idRelator AND rel.idArea = ar.ID AND rel_ram.idRamo = ram.ID AND rel.isActive = true LIMIT $inicio, $cantidad_por_pagina";
    $result = mysqli_query($conection, $query);
    if (!$result) {
        die('Query Failed' . mysqli_error($conection));
    }

    $json = array();
    while ($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'ID' => $row['ID'],
            'nombre' => $row['nombre'],
            'nombreArea' => $row['nombreArea'],
            'codigoRamo' => $row['codigoRamo'],
            'nombreRamo' => $row['nombreRamo'],
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
} else {
    $cantidad_por_pagina = 6;
    $inicio = 0;
    $query = "SELECT rel.*, ar.nombreArea, ram.nombreRamo, ram.codigoRamo FROM relator rel INNER JOIN ramos ram, relator_ramo rel_ram , area ar WHERE rel.ID = rel_ram.idRelator AND rel.idArea = ar.ID AND rel_ram.idRamo = ram.ID AND rel.isActive = true LIMIT $inicio, $cantidad_por_pagina";
    $result = mysqli_query($conection, $query);
    if (!$result) {
        die('Query Failed' . mysqli_error($conection));
    }

    $json = array();
    while ($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'ID' => $row['ID'],
            'nombre' => $row['nombre'],
            'nombreArea' => $row['nombreArea'],
            'codigoRamo' => $row['codigoRamo'],
            'nombreRamo' => $row['nombreRamo'],
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
