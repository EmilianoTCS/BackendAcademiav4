<?php

function pageCounter()
{
    $Cantidad_por_pagina = 6;
    include("model/conexion.php");
    // CONTADOR PARA CUENTAS
    $queryCounter1 = "SELECT count(ID) as total_registros_cuenta FROM `cursos` WHERE isActive= true ";
    $resultCounter1 = mysqli_query($conection, $queryCounter1);
    if (!$resultCounter1) {
        die('Query Failed' . mysqli_error($conection));
    } else {
        while ($rowCounter1 = mysqli_fetch_array($resultCounter1)) {
            $totalRegistros_cuenta = $rowCounter1['total_registros_cuenta'];
            $cantidad_paginas_cuenta = ceil($totalRegistros_cuenta / $Cantidad_por_pagina);
        }
    }
    // CONTADOR PARA CURSOS
    $queryCounter2 = "SELECT COUNT(ID) as total_ramos from ramos WHERE isActive = true ";
    $resultCounter2 = mysqli_query($conection, $queryCounter2);
    if (!$resultCounter2) {
        die('Query Failed' . mysqli_error($conection));
    } else {
        while ($rowCounter2 = mysqli_fetch_array($resultCounter2)) {
            $totalRegistros_ramos = $rowCounter2['total_ramos'];
            $cantidad_paginas_ramos = ceil($totalRegistros_ramos / $Cantidad_por_pagina);
        }
    }
    // CONTADOR PARA RELATOR
    $queryCounter3 = "SELECT COUNT(ram.ID) as total_relator, rel.* from ramos ram INNER JOIN relator rel, relator_ramo rel_ram WHERE ram.ID = rel_ram.idRamo AND rel.ID = rel_ram.idRelator AND rel.isActive = true";
    $resultCounter3 = mysqli_query($conection, $queryCounter3);
    if (!$resultCounter3) {
        die('Query Failed' . mysqli_error($conection));
    } else {
        while ($rowCounter3 = mysqli_fetch_array($resultCounter3)) {
            $totalRegistros_relator = $rowCounter3['total_relator'];
            $cantidad_paginas_relator = ceil($totalRegistros_relator / $Cantidad_por_pagina);
        }
    }
    // CONTADOR PARA USUARIOS/COLABORADORES -- CONTADOR PARA INFO RAMO
    $queryCounter4 = "SELECT COUNT(ID) as total_usuarios from personas WHERE isActive";
    $resultCounter4 = mysqli_query($conection, $queryCounter4);
    if (!$resultCounter4) {
        die('Query Failed' . mysqli_error($conection));
    } else {
        while ($rowCounter4 = mysqli_fetch_array($resultCounter4)) {
            $totalRegistros_usuarios = $rowCounter4['total_usuarios'];
            $cantidad_paginas_usuarios = ceil($totalRegistros_usuarios / $Cantidad_por_pagina);
        }
    }
    // CONTADOR PARA INFOCUENTAS
    $queryCounter5 = "SELECT COUNT(ID) as total_cuentas from aprobacion";
    $resultCounter5 = mysqli_query($conection, $queryCounter5);
    if (!$resultCounter5) {
        die('Query Failed' . mysqli_error($conection));
    } else {
        while ($rowCounter5 = mysqli_fetch_array($resultCounter5)) {
            $totalRegistros_cuentas = $rowCounter5['total_cuentas'];
            $cantidad_paginas_idcuentas = ceil($totalRegistros_cuentas / 10);
        }
    }
    // CONTADOR PARA CURSOS
    $queryCounter6 = "SELECT COUNT(ID) as total_cursos from cursos";
    $resultCounter6 = mysqli_query($conection, $queryCounter6);
    if (!$resultCounter6) {
        die('Query Failed' . mysqli_error($conection));
    } else {
        while ($rowCounter6 = mysqli_fetch_array($resultCounter6)) {
            $totalRegistros_cursos = $rowCounter6['total_cursos'];
            $cantidad_paginas_cursos = ceil($totalRegistros_cursos / $Cantidad_por_pagina);
        }
    }

    // CONTADOR PARA INFO RELATOR
    $queryCounter7 = "SELECT COUNT(nombreRamo) as total_nombreRamo from ramos";
    $resultCounter7 = mysqli_query($conection, $queryCounter7);
    if (!$resultCounter7) {
        die('Query Failed' . mysqli_error($conection));
    } else {
        while ($rowCounter7 = mysqli_fetch_array($resultCounter7)) {
            $totalRegistros_nombreRamo = $rowCounter7['total_nombreRamo'];
            $cantidad_paginas_infoRelator = ceil($totalRegistros_nombreRamo / 2);
        }
    }
    // CONTADOR PARA CLIENTES
    $queryCounter8 = "SELECT COUNT(ID) as total_clientes from CLIENTES WHERE isActive = true";
    $resultCounter8 = mysqli_query($conection, $queryCounter8);
    if (!$resultCounter8) {
        die('Query Failed' . mysqli_error($conection));
    } else {
        while ($rowCounter8 = mysqli_fetch_array($resultCounter8)) {
            $totalRegistros_clientes = $rowCounter8['total_clientes'];
            $cantidad_paginas_clientes = ceil($totalRegistros_clientes / $Cantidad_por_pagina);
        }
    }

    // CONTADOR PARA INFO CURSOS
    $queryCounter9 = "SELECT DISTINCT(COUNT(per.usuario)) as total_usuarios FROM personas per INNER JOIN aprobacion ap WHERE per.isActive = true AND per.usuario = ap.usuario AND ap.codigoCurso = 'JAV202107261630' ";
    $resultCounter9 = mysqli_query($conection, $queryCounter9);
    if (!$resultCounter9) {
        die('Query Failed' . mysqli_error($conection));
    } else {
        while ($rowCounter9 = mysqli_fetch_array($resultCounter9)) {
            $totalRegistros_infoCursos = $rowCounter9['total_usuarios'];
            $cantidad_paginas_infoCursos = ceil($totalRegistros_infoCursos / $Cantidad_por_pagina);
        }
    }
    // CONTADOR PARA NOTAS---------------------------
    // SIN FILTROS
    $queryCounter10 = "SELECT COUNT(ID) as total_evaluacionesNoFilter FROM evaluaciones";
    $resultCounter10 = mysqli_query($conection, $queryCounter10);
    if (!$resultCounter10) {
        die('Query Failed' . mysqli_error($conection));
    } else {
        while ($rowCounter10 = mysqli_fetch_array($resultCounter10)) {
            $totalRegistros_evaluaciones = $rowCounter10['total_evaluacionesNoFilter'];
            $cantidad_paginas_evaluaciones = ceil($totalRegistros_evaluaciones / $Cantidad_por_pagina);
        }
    }



    return [
        'cantidad_paginas_infoCursos' => $cantidad_paginas_infoCursos,
        'cantidad_paginas_clientes' => $cantidad_paginas_clientes,
        'cantidad_paginas_infoRelator' => $cantidad_paginas_infoRelator,
        'cantidad_paginas_cursos' => $cantidad_paginas_cursos,
        'cantidad_paginas_idcuenta' => $cantidad_paginas_idcuentas,
        'cantidad_paginas_cuenta' => $cantidad_paginas_cuenta,
        'cantidad_paginas_ramos' => $cantidad_paginas_ramos,
        'cantidad_paginas_relator' => $cantidad_paginas_relator,
        'cantidad_paginas_usuarios' => $cantidad_paginas_usuarios,
        'cantidad_paginas_evaluaciones' => $cantidad_paginas_evaluaciones
    ];
}
