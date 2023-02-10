 <?php
session_start();
include('../model/conexion.php');
include("../security/logBuilder.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if (isset($_GET['updateStateClientes'])) {
  $data = json_decode(file_get_contents("php://input"));
  $ID = $data->ID;
  $usuario = $data->usuario;

  date_default_timezone_set("America/Argentina/Buenos_Aires");
  $date = date('Y-m-d H:i:s');
  $query = "UPDATE clientes SET isActive = !isActive, fechaActualizacion = '$date', ultimoUsuario = '$usuario' WHERE ID = '$ID'";
  $result = mysqli_query($conection, $query);

  if (!$result) {
    die(json_encode('Query Failed.'));
  }
  $query2 = "SELECT ID, tipo_cliente, nombreCliente, correoReferente, telefonoReferente, isActive, fechaActualizacion,ultimoUsuario from clientes WHERE ID = '$ID'";
  $result2 = mysqli_query($conection, $query2);
  if (!$result2) {
    die('Query Failed' . mysqli_error($conection));
  }
  $json = array();
  while ($row = mysqli_fetch_array($result2)) {

    $json[] = array(
      'ID' => $row['ID'],
      'tipo_cliente' => $row['tipo_cliente'],
      'nombreCliente' => $row['nombreCliente'],
      'correoReferente' => $row['correoReferente'],
      'telefonoReferente' => $row['telefonoReferente'],
      'date' => $row['fechaActualizacion'],
      'usuario' => $row['ultimoUsuario'],
      'isActive' => $row['isActive'],
      'successEdited' => "successEdited"
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
