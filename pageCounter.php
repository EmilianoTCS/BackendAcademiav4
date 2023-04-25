<?php


function pageCounter()
{
    $Cantidad_por_pagina = 6;
    include("model/conexion.php");
    // CONTADOR PARA CUENTAS
    $queryCounter1 = "SELECT count(ID) as total_registros_cuenta FROM `cursos` WHERE isActive = true ";
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
    $queryCounter7 = "SELECT COUNT(nombreRamo) as total_nombreRamo from ramos WHERE isActive = true ";
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
    $queryCounter8 = "SELECT COUNT(ID) as total_clientes from CLIENTES";
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
    $queryCounter10 = "SELECT COUNT(nota) as total_evaluacionesNoFilter FROM evaluaciones GROUP BY num_evaluaciones";
    $resultCounter10 = mysqli_query($conection, $queryCounter10);
    if (!$resultCounter10) {
        die('Query Failed' . mysqli_error($conection));
    } else {
        while ($rowCounter10 = mysqli_fetch_array($resultCounter10)) {
            $totalRegistros_evaluaciones = $rowCounter10['total_evaluacionesNoFilter'];
            $cantidad_paginas_evaluaciones = ceil($totalRegistros_evaluaciones / $Cantidad_por_pagina);
        }
    }

    // CONTADOR PARA EDD REFERENTES---------------------------
    $queryCounter11 = "SELECT COUNT(ID) as total_EDDReferentes FROM `edd-evaluacion-referentes-servicio` WHERE isActive = true AND ID != 0";
    $resultCounter11 = mysqli_query($conection, $queryCounter11);
    if (!$resultCounter11) {
        die('Query Failed' . mysqli_error($conection));
    } else {
        while ($rowCounter11 = mysqli_fetch_array($resultCounter11)) {
            $totalRegistros_EDDReferentes = $rowCounter11['total_EDDReferentes'];
            $cantidad_paginas_EDDReferentes = ceil($totalRegistros_EDDReferentes / $Cantidad_por_pagina);
        }
    }

    // CONTADOR PARA EDD ANALISTAS---------------------------
    $queryCounter12 = "SELECT COUNT(ID) as total_EDDAnalistas FROM `edd-evaluacion-analistas-automatizadores` WHERE isActive = true AND ID != 0";
    $resultCounter12 = mysqli_query($conection, $queryCounter12);
    if (!$resultCounter12) {
        die('Query Failed' . mysqli_error($conection));
    } else {
        while ($rowCounter12 = mysqli_fetch_array($resultCounter12)) {
            $totalRegistros_EDDAnalistas = $rowCounter12['total_EDDAnalistas'];
            $cantidad_paginas_EDDAnalistas = ceil($totalRegistros_EDDAnalistas / $Cantidad_por_pagina);
        }
    }

    // CONTADOR PARA PROYECTOS---------------------------
    $queryCounter13 = "SELECT COUNT(ID) as total_proyectos FROM `proyectos` WHERE isActive = true AND ID != 0";
    $resultCounter13 = mysqli_query($conection, $queryCounter13);
    if (!$resultCounter13) {
        die('Query Failed' . mysqli_error($conection));
    } else {
        while ($rowCounter13 = mysqli_fetch_array($resultCounter13)) {
            $totalRegistros_proyectos = $rowCounter13['total_proyectos'];
            $cantidad_paginas_proyectos = ceil($totalRegistros_proyectos / $Cantidad_por_pagina);
        }
    }
    // CONTADOR PARA EQUIPOS---------------------------
    $queryCounter14 = "SELECT COUNT(ID) as total_equipos FROM `equipos` WHERE isActive = true AND ID != 0";
    $resultCounter14 = mysqli_query($conection, $queryCounter14);
    if (!$resultCounter14) {
        die('Query Failed' . mysqli_error($conection));
    } else {
        while ($rowCounter14 = mysqli_fetch_array($resultCounter14)) {
            $totalRegistros_equipos = $rowCounter14['total_equipos'];
            $cantidad_paginas_equipos = ceil($totalRegistros_equipos / $Cantidad_por_pagina);
        }
    }
    // CONTADOR PARA EMPLEADOS---------------------------
    $queryCounter15 = "SELECT COUNT(ID) as total_empleados FROM `empleados` WHERE isActive = true AND ID != 0";
    $resultCounter15 = mysqli_query($conection, $queryCounter15);
    if (!$resultCounter15) {
        die('Query Failed' . mysqli_error($conection));
    } else {
        while ($rowCounter15 = mysqli_fetch_array($resultCounter15)) {
            $totalRegistros_empleados = $rowCounter15['total_empleados'];
            $cantidad_paginas_empleados = ceil($totalRegistros_empleados / $Cantidad_por_pagina);
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
        'cantidad_paginas_evaluaciones' => $cantidad_paginas_evaluaciones,
        'cantidad_paginas_EDDReferentes' => $cantidad_paginas_EDDReferentes,
        'cantidad_paginas_EDDAnalistas' => $cantidad_paginas_EDDAnalistas,
        'cantidad_paginas_proyectos' => $cantidad_paginas_proyectos,
        'cantidad_paginas_equipos' => $cantidad_paginas_equipos,
        'cantidad_paginas_empleados' => $cantidad_paginas_empleados,

    ];
}
