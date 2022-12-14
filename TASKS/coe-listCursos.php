<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include("../model/conexion.php");

if(isset($_GET['pagina'])) {
  $data= json_decode(file_get_contents("php://input"));
  $num_boton = $data->num_boton;
  $cantidad_por_pagina = 6;
  $inicio = ($num_boton - 1) * $cantidad_por_pagina;

  $query = "SELECT ram.*, rel.nombre, rel.idArea, ar.nombreArea from ramos ram INNER JOIN relator rel, area ar, relator_ramo rel_ram WHERE ram.ID = rel_ram.idRamo AND rel.idArea = ar.ID AND rel.ID = rel_ram.idRelator AND ram.isActive = true order by ram.codigoRamo ASC LIMIT $inicio, $cantidad_por_pagina";
  $result = mysqli_query($conection, $query);
  if (!$result) {
    die('Query Failed' . mysqli_error($conection));
  }

  $json = array();
  while ($row = mysqli_fetch_array($result)) {
    $json[] = array(
	  'ID' => $row['ID'],
      'idCuenta' => $row['idCuenta'],
      'codigoRamo' => $row['codigoRamo'],
      'nombreRamo' => $row['nombreRamo'],
      'hh_academicas' => $row['hh_academicas'],
      'pre_requisito' => $row['pre_requisito'],
      'nombre' => $row['nombre'],
	  'nombreArea' => $row['nombreArea'],
	  'isActive' => $row['isActive']
    );
  }
  $jsonstring = json_encode($json);
  echo $jsonstring;
} else {
  $cantidad_por_pagina = 6;
  $inicio = 0;
  $query = "SELECT ram.*, rel.nombre, rel.idArea, ar.nombreArea from ramos ram INNER JOIN relator rel, area ar, relator_ramo rel_ram WHERE ram.ID = rel_ram.idRamo AND rel.idArea = ar.ID AND rel.ID = rel_ram.idRelator AND ram.isActive = true order by ram.codigoRamo ASC LIMIT $inicio, $cantidad_por_pagina";
  $result = mysqli_query($conection, $query);
  if (!$result) {
    die('Query Failed' . mysqli_error($conection));
  }
  $json = array();
  while ($row = mysqli_fetch_array($result)) {
    $json[] = array(
	  'ID' => $row['ID'],
      'idCuenta' => $row['idCuenta'],
      'codigoRamo' => $row['codigoRamo'],
      'nombreRamo' => $row['nombreRamo'],
      'hh_academicas' => $row['hh_academicas'],
      'pre_requisito' => $row['pre_requisito'],
      'nombre' => $row['nombre'],
	  'nombreArea' => $row['nombreArea'],
	  'isActive' => $row['isActive']
    );
  }
  $jsonstring = json_encode($json);
  echo $jsonstring;
}
