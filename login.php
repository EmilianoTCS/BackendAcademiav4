<?php
session_start();
include("model/conexion.php");
include("security/logBuilder.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


if (isset($_GET['login'])) {
    $data = json_decode(file_get_contents("php://input"));
    $username = $data->username;
    $password = $data->password;


    function gToken($len)
    {
        $cadena = "_ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789_";
        $tkn = "";
        for ($i = 0; $i < $len; $i++) {
            $tkn .= $cadena[rand(0, $len)];
        }
        return $tkn;
    }
    $token = gToken(40);

    $query = mysqli_query($conection, "SELECT idCuenta, password, nombre, tipo_usuario FROM cuentas_login where idCuenta = '$username'");
    $result = mysqli_num_rows($query);
    if ($result > 0) {
        $row = mysqli_fetch_array($query);
        $password_bd = $row['password'];
        $pass_c = sha1($password);

        if ($password_bd == $pass_c) {
            $_SESSION['idCuenta'] = $row['idCuenta'];
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['tipo_usuario'] = $row['tipo_usuario'];
            $json[] = array(
                'statusConected' => true,
                'error' => false,
                'token' => $token,
                'username' => $row['idCuenta']
            );
            echo json_encode($json);
        } else {
            $json[] = array(
                'statusConected' => false,
                'token' => null,
                'error' => true,
                'username' => null
            );
            echo (json_encode($json));
        }
    } else {
        $json[] = array(
            'statusConected' => false,
            'token' => null,
            'username' => null,
            'error' => true
        );
        echo (json_encode($json));
    }
}
