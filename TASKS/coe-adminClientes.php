<?php

include("../model/conexion.php");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


if (isset($_GET['clientes'])) {

    $query = "CALL coe_adminClientes()";
    $result = mysqli_query($conection, $query);
    if (!$result) {
        die('Query Failed' . mysqli_error($conection));
    }

    $json = array();
    while ($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'ID' => $row['ID'],
            'tipo_cliente' => $row['tipo_cliente'],
            'nombreCliente' => $row['nombreCliente'],
            'correoReferente' => $row['correoReferente'],
            'telefonoReferente' => $row['telefonoReferente'],
            'date' => $row['fechaActualizacion'],
            'usuario' => $row['ultimoUsuario'],

            'isActive' => $row['isActive']
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
} else {
    echo json_encode("Error");
}
