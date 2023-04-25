<?php
  session_start();
  include('../model/conexion.php');
  include("../security/logBuilder.php");
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Headers: access");
  header("Access-Control-Allow-Methods: GET,POST");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

  if (isset($_GET['updateStateEmpleados'])) {
    $data = json_decode(file_get_contents("php://input"));
    $ID = $data->ID;
    $usuario = $data->usuario;

    date_default_timezone_set("America/Argentina/Buenos_Aires");
    $date = date('Y-m-d H:i:s');
    $query = "CALL coe_updateStateEmpleados($ID, '$usuario')";
    $result = mysqli_query($conection, $query);

    if (!$result) {
      die(json_encode('Query Failed.'));
    }
    
    $json = array();
    while ($row = mysqli_fetch_array($result)) {

      $json[] = array(
        'ID' => $row['ID'],
        'nombreApellido' => $row['nombreApellido'],
        'cargo' => $row['cargo'],
        'correo' => $row['correo'],
        'usuario' => $row['usuario'],  
        'date' => $row['fechaActualizacion'],
        'ultimoUsuario' => $row['ultimoUsuario'],
        'isActive' => $row['isActive'],
        'successEdited' => "successEdited",
        'successEnabled' => "successEnabled",

      );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
    // $usuario = $_SESSION['idCuenta'];
    // $log = new Log("../security/reports/log.txt");
    // $log->writeLine("I", "[] ha cambiado el estado del curso: [ de ]");
    // $log->close();
  } else {
    echo json_encode("Error");
  }
