<?php

include("../model/conexion.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if (isset($_GET['pagina'])) {
  $data= json_decode(file_get_contents("php://input"));
  $num_boton = $data->num_boton;
  $cantidad_por_pagina = 6;
  $inicio = ($num_boton - 1) * $cantidad_por_pagina;

  $query = "SELECT * FROM clientes WHERE isActive = true LIMIT $inicio, $cantidad_por_pagina";
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
      'referente' => $row['referente'],
      'correoReferente' => $row['correoReferente'],
      'cargoReferente' => $row['cargoReferente'],
      'telefonoReferente' => $row['telefonoReferente']
    );
  }
  $jsonstring = json_encode($json);
  echo $jsonstring;
} else {
  $cantidad_por_pagina = 6;
  $inicio = 0;

  $query = "SELECT * FROM clientes WHERE isActive = true LIMIT $inicio, $cantidad_por_pagina";
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
      'referente' => $row['referente'],
      'correoReferente' => $row['correoReferente'],
      'cargoReferente' => $row['cargoReferente'],
      'telefonoReferente' => $row['telefonoReferente']
    );
  }
  $jsonstring = json_encode($json);
  echo $jsonstring;
}
