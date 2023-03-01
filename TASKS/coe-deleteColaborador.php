<?php
session_start();
include('../model/conexion.php');
include("../security/logBuilder.php");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if (isset($_GET['delete'])) {
  $ID = $_GET['delete'];
  $query = "UPDATE personas SET isActive = false WHERE ID = '$ID'";
  $result = mysqli_query($conection, $query);

  if (!$result) {
    die('Query Failed.' . mysqli_error($conection));
  } else {
    // $usuario = $_SESSION['idCuenta'];
    //   $log = new Log("../security/reports/log.txt");
    // $log->writeLine("I", "[usuario] Ha eliminado el colaborador [usuario] en [COE -");
    //   $log->close();
    echo json_encode("successDeleted");
  }
} else {
  echo json_encode("Error");
}
