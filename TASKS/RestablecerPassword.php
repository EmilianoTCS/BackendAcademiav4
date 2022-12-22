<?php
include('../model/conexion.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



if (isset($_GET['restablecerPassword'])) {
    $data = json_decode(file_get_contents("php://input"));
    $correo = $data->correo;
    $ID = $data->ID;
    $password = $data->password;
    $passSha1 = sha1($password);

    $queryVerify = "SELECT * from cuentas_login WHERE ID = '$ID'";
    $resultVerify = mysqli_query($conection, $queryVerify);

    if ($resultVerify) {
        $rowVerify = mysqli_fetch_array($resultVerify);
    }
    $oldPass = $rowVerify['password'];

    if ($oldPass === $passSha1) {
        echo json_encode(["message" => "repeatedPassword"]);
    } else {
        $query = "UPDATE cuentas_login SET password = '$passSha1' WHERE ID = '$ID' AND correo = '$correo'";
        $result = mysqli_query($conection, $query);

        if (!$result) {
            die(json_encode('Query Failed.'));
        } else {
            echo json_encode(["message" => "successEditedPassword"]);
        }
    }
} else {
    echo json_encode("Error");
}
