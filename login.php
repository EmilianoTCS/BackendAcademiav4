<?php
session_start();
include("model/conexion.php");
include("security/logBuilder.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


if(isset($_GET['login'])) {
	$data= json_decode(file_get_contents("php://input"));
    $idCuenta = $data->Usuario;
    $password = $data->password;

    $query = mysqli_query($conection, "SELECT idCuenta, password, nombre, tipo_usuario FROM cuentas_login where idCuenta = '$idCuenta'");
    $result = mysqli_num_rows($query);
    if ($result > 0) {
        $row = mysqli_fetch_array($query);
        $password_bd = $row['password'];
        $pass_c = sha1($password);

        if ($password_bd == $pass_c) {
            $_SESSION['idCuenta'] = $row['idCuenta'];
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['tipo_usuario'] = $row['tipo_usuario'];
            $usuario = $_SESSION['idCuenta'];
            $log = new Log("security/reports/log.txt");
            // $log->getSize();
            $log->writeLine("I", "[$usuario] Ha iniciado sesión en ******");
            $log->close();
			
			echo json_encode(['conectado'=>true]);
        } else {
            echo json_encode(['conectado'=>false]);
        }
    } else {
        echo json_encode(['conectado'=>false]);
    }
}

?>