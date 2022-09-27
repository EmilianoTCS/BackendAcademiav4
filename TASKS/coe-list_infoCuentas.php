<?php
include("../model/conexion.php");

// if (isset($_POST['idCuenta'])) {
//     $idCuenta_ = $_POST['idCuenta'];
    if (isset($_POST['num_boton'])) {
        $num_boton = $_POST['num_boton'];
        $cantidad_por_pagina = 10;
        $inicio = ($num_boton - 1) * $cantidad_por_pagina;
        $query = "SELECT * from aprobacion WHERE idCuenta = 'fondo_esperanza' group by idUsuario, idCurso LIMIT $inicio, $cantidad_por_pagina";
        $result = mysqli_query($conection, $query);
        if (!$result) {
            die('Query Failed' . mysqli_error($conection));
        }

        $json = array();
        while ($row = mysqli_fetch_array($result)) {
            $json[] = array(
                'idCuenta' => $row['idCuenta'],
                'idUsuario' => $row['idUsuario'],
                'idCurso' => $row['idCurso'],
                'aprobacion' => $row['porcentaje_aprobacion']
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    } else {
        $cantidad_por_pagina = 10;
        $inicio = 0;
        $query = "SELECT * from aprobacion WHERE idCuenta = 'fondo_esperanza' group by idUsuario, idCurso LIMIT $inicio, $cantidad_por_pagina";
        $result = mysqli_query($conection, $query);
        if (!$result) {
            die('Query Failed' . mysqli_error($conection));
        }

        $json = array();
        while ($row = mysqli_fetch_array($result)) {
            $json[] = array(
                'idCuenta' => $row['idCuenta'],
                'idUsuario' => $row['idUsuario'],
                'idCurso' => $row['idCurso'],
                'aprobacion' => $row['porcentaje_aprobacion']
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
// } else {
//     echo "error";
// }
