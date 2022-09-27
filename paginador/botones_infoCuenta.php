<?php
include("../model/conexion.php");
include "../pageCounter.php";

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$paginas = pageCounter();

for ($i = 1; $i <= $paginas['cantidad_paginas_idcuenta']; $i++) {
    $actual = $i == 1 ? " class='actual'" : '';
    $array = "<li id='boton_paginador_infoCuenta'><a num_pagina='$i' href='#' $actual>$i</a></li>";
    echo $array;
}
