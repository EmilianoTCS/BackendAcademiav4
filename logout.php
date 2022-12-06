<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include("security/logBuilder.php");

if (isset($_GET['logout'])) {

	// $usuario = $_SESSION['idCuenta'];
	$log = new Log("security/reports/log.txt");
	// $log->writeLine("I", "[$usuario] Ha cerrado sesión");
	$log->close();
	echo json_encode([
		"statusConnected" => false,
		"failure" => false
	]);

	// session_destroy();

} else {

	echo json_encode([
		"statusConnected" => true,
		"failure" => true
	]);
}
