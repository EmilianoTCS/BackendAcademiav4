<?php
include("../model/conexion.php");
include "../pageCounter.php";
$paginas = pageCounter();

for ($i = 1; $i <= $paginas['cantidad_paginas_usuarios']; $i++) {
    $actual = $i == 1 ? " class='actual'" : '';
    $array = "<li id='boton_paginador_colab'><a num_pagina='$i' href='#' $actual>$i</a></li>";
    echo $array;
}
