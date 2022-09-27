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
  
  $query = "DELETE FROM evaluaciones WHERE ID = '$ID'";

  $result = mysqli_query($conection, $query);

  if (!$result) {
    die(json_encode('Query Failed.'));
  }
  echo json_encode("Success");
  // $usuario = $_SESSION['idCuenta'];
  $log = new Log("../security/reports/log.txt");
  $log->writeLine("I", "[] ha eliminado el curso: [ de ]");
  $log->close();
} else {
  echo json_encode("Error");
}
