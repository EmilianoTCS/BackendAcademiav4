<?php

include("../model/conexion.php");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if (isset($_GET['inscripcionCurso'])) {
    $data = json_decode(file_get_contents("php://input"));
    $idCuenta = $data->idCuenta;
    $usuario = $data->usuario;
    $idCurso = $data->idCurso;
    $codigoCurso = "";
    $codigoCuenta = "";
    $porcentaje_aprobacion = "0";

    $query1 = "SELECT COUNT(pre_requisito) from requisitos_curso WHERE idCurso = '$idCurso'";
    $result1 = mysqli_query($conection, $query1);
    if (!$result1) {
        die('Query Failed' . mysqli_error($conection));
    } else {
        while ($row1 = mysqli_fetch_array($result1)) {
            $total_pre_requisitos = $row1['COUNT(pre_requisito)'];
        }
    }

    $query2 = "SELECT COUNT(req.pre_requisito) FROM requisitos_curso req 
			  INNER JOIN aprobacion ap, personas per, ramos ram, cursos cur
			  WHERE req.pre_requisito = ram.ID AND ram.ID = cur.idRamo AND cur.codigoCurso = ap.codigoCurso AND ap.porcentaje_aprobacion > 85 AND per.ID = ap.idPersona AND per.usuario = '$usuario' AND req.idCurso = '$idCurso'";
    $result2 = mysqli_query($conection, $query2);
    if (!$result2) {
        die('Query Failed' . mysqli_error($conection));
    } else {
        while ($row2 = mysqli_fetch_array($result2)) {
            $total_pre_requisitosUsuario = $row2['COUNT(req.pre_requisito)'];
        }
    }


    if ($total_pre_requisitosUsuario >= $total_pre_requisitos) {
        // $query3 = "INSERT INTO aprobacion (ID, idCuenta, idCurso, codigoCuenta, codigoCurso, usuario, porcentaje_aprobacion) VALUES (, '$idCuenta', '$idCurso', '$codigoCuenta','$codigoCurso', '$usuario', '$porcentaje_aprobacion')";
        // $result3 = mysqli_query($conection, $query2);
        // if (!$result3) {
        //     die('Query failed' . mysqli_error($conection));
        // } else {
        //     echo json_encode('successCreated');
        // }
        echo json_encode([
            'TotalPreRequisitosCumplidos' => $total_pre_requisitosUsuario,
            'TotalPreRequisitos' => $total_pre_requisitos,
            'message' => 'errorRequisitos'
        ]);
    } else {
        echo json_encode([
            'TotalPreRequisitosCumplidos' => $total_pre_requisitosUsuario,
            'TotalPreRequisitos' => $total_pre_requisitos,
            'message' => 'errorRequisitos'
        ]);
    }
} else {
    echo json_encode("Error");
}
