<?php
include("../model/conexion.php");
include "../pageCounter.php";
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$paginas = pageCounter();


for ($i = 1; $i <= $paginas['cantidad_paginas_EDDReferentes']; $i++) {
    $array[] = array(
	'paginas' => $i
	); 
}
echo json_encode($array);