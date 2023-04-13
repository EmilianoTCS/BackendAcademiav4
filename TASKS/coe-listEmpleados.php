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
  $cantidad_por_pagina = 100;
  $inicio = ($num_boton - 1) * $cantidad_por_pagina;

  $query = "SELECT * FROM empleados WHERE isActive = true LIMIT $inicio, $cantidad_por_pagina";
  $result = mysqli_query($conection, $query);
  if (!$result) {
    die('Query Failed' . mysqli_error($conection));
  }

  $json = array();
  while ($row = mysqli_fetch_array($result)) {
    $json[] = array(
	    'ID' => $row['ID'],
      'nombreApellido' => $row['nombreApellido'],
      'cargo' => $row['cargo'],
      'correo' => $row['correo'],
      'usuario' => $row['usuario'],
    );
  }
  $jsonstring = json_encode($json);
  echo $jsonstring;
} else {
  $cantidad_por_pagina = 6;
  $inicio = 0;

  $query = "SELECT * FROM empleados WHERE isActive = true LIMIT $inicio, $cantidad_por_pagina";
  $result = mysqli_query($conection, $query);
  if (!$result) {
    die('Query Failed' . mysqli_error($conection));
  }

  $json = array();
  while ($row = mysqli_fetch_array($result)) {
     $json[] = array(
        'ID' => $row['ID'],
        'nombreApellido' => $row['nombreApellido'],
        'cargo' => $row['cargo'],
        'correo' => $row['correo'],
        'usuario' => $row['usuario'],
      );
  }
  $jsonstring = json_encode($json);
  echo $jsonstring;
}
