<?php
include("../model/conexion.php");
include "../pageCounter.php";
$paginas = pageCounter();

for ($i = 1; $i <= $paginas['cantidad_paginas_infoRelator']; $i++) {
    $actual = $i == 1 ? " class='actual'" : '';
    $array = "<li id='boton_paginador_infoRelator'><a num_pagina='$i' href='#' $actual>$i</a></li>";
    echo $array;
}
