<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include('../model/conexion.php');
include("../security/logBuilder.php");

if(isset($_POST['codigoRamo'])){
    $codigoRamo = $_POST['codigoRamo'];

$query = "SELECT ram.*, per.idUsuario from ramos ram, personas per where codigoRamo = '$codigoRamo' order by relator ASC";
$result = mysqli_query($conection, $query);
if (!$result) {
    die('Query Failed' . mysqli_error($conection));
}

$json = array();
while ($row = mysqli_fetch_array($result)) {
    $json[] = array(
        'nombreRamo' => $row['nombreRamo'],
        'idCuenta' => $row['idCuenta'],
        'area' => $row['area'],
        'idUsuario' => $row['idUsuario'],
        'relator' => $row['relator']
    );
}
$jsonstring = json_encode($json);
echo $jsonstring;

}else{
    echo "error";
}
?>