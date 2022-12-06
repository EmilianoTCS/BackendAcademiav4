<?php

session_start();
include('../model/conexion.php');
include("../security/logBuilder.php");


if (isset($_POST)) {
  $idRamo = $_POST['idRamo'];
  $nombreRamo = $_POST['nombreRamo'];
  $relator = $_POST['relator'];
  $idCuenta = $_POST['idCuenta'];

  $query = "DELETE FROM ramos WHERE idCuenta = '$idCuenta' AND idRamo = '$idRamo' AND nombreRamo = '$nombreRamo' AND relator = '$relator'";

  $result = mysqli_query($conection, $query);

  if (!$result) {
    die('Query Failed.' . mysqli_error($conection));
  }
  // $usuario = $_SESSION['idCuenta'];
  // $log = new Log("../security/reports/log.txt");
  // $log->writeLine("I", "[$usuario] ha eliminado el orador: [$relator de $nombreRamo]");
  // $log->close();
} else {
  echo json_encode("Error");
}
