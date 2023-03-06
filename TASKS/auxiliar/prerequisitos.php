<?php

include("../../model/conexion.php");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if (isset($_GET['ID'])) {
    $data = json_decode(file_get_contents("php://input"));
    $ID = $data->ID;

    if (!empty($ID)) {
        $query = "SELECT req.*, ram.codigoRamo, ram.nombreRamo FROM requisitos_curso req INNER JOIN ramos ram WHERE req.idCurso = '$ID'  AND req.pre_requisito = ram.ID";
        $result = mysqli_query($conection, $query);
        if (!$result) {
            die('Query Failed' . mysqli_error($conection));
        }
        $result2 = mysqli_num_rows($result);
        if ($result2 > 0) {
            $json = array();
            while ($row = mysqli_fetch_array($result)) {
                $json[] = array(
                    'ID' => $row['ID'],
                    'nombreRamo' => $row['nombreRamo'],
                    'pre_requisito' => $row['pre_requisito'],
                    'codigoRamo' => $row['codigoRamo'],
                    'fechaActualizacion' => $row['fechaActualizacion'],
                    'isActive' => $row['isActive'],
                    'Busqueda' => true,
                    'isEmpty' => false

                );
            }
            $jsonstring = json_encode($json);
            echo $jsonstring;
        } else {
            $json[] = array(
                'ID' => null,
                'nombreRamo' => null,
                'pre_requisito' => null,
                'codigoRamo' => null,
                'fechaActualizacion' => null,
                'isActive' => null,
                'Busqueda' => false,
                'isEmpty' => true
            );
            echo json_encode($json);
        }
    } else {
        $json[] = array(
            'ID' => null,
            'nombreRamo' => null,
            'pre_requisito' => null,
            'codigoRamo' => null,
            'fechaActualizacion' => null,
            'isActive' => null,
            'Busqueda' => false,
            'isEmpty' => true

        );
        echo json_encode($json);
    }
} else {
    echo json_encode("Error");
}
