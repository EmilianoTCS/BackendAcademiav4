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
    $fechas = array();
    $fechasInicioFin = array();
    $json = array();

    $queryVerify = "SELECT ap.*, asist.*, eva.* from aprobacion ap, asistencias asist, evaluaciones eva WHERE ap.codigoCurso = (SELECT MAX(codigoCurso) from cursos WHERE idRamo = '$idCurso') AND asist.codigoCurso = (SELECT MAX(codigoCurso) from cursos WHERE idRamo = '$idCurso')
    AND eva.codigoCurso = (SELECT MAX(codigoCurso) from cursos WHERE idRamo = '$idCurso') AND ap.usuario = '$usuario' AND eva.usuario = '$usuario' AND asist.usuario = '$usuario' ";



    $resultadoVerify = mysqli_query($conection, $queryVerify);
    if (!$resultadoVerify) {
        die('Query Failed' . mysqli_error($conection));
    } else {

        $queryGetFechas = "SELECT inicio, fin from cursos WHERE codigoCurso = (SELECT MAX(codigoCurso) from cursos WHERE idRamo = '$idCurso')";
        $resultado = mysqli_query($conection, $queryGetFechas);
        if (!$resultado) {
            die('Query Failed' . mysqli_error($conection));
        } else {
            while ($row = mysqli_fetch_array($resultado)) {
                array_push(
                    $fechasInicioFin,
                    [
                        'fechaInicio' => $row['inicio'],
                        'fechaFin' => $row['fin']
                    ],
                );
            }
        }

        $query0 = "SELECT * from asistencias WHERE codigoCurso = (SELECT MAX(codigoCurso) from cursos WHERE idRamo = '$idCurso')";
        $result0 = mysqli_query($conection, $query0);
        if (!$result0) {
            die('Query Failed' . mysqli_error($conection));
        } else {
            while ($row0 = mysqli_fetch_array($result0)) {
                array_push(
                    $fechas,
                    [
                        'atributo' => $row0['atributo'],
                        'idCuenta' => $row0['idCuenta'],
                        'codigoCurso' => $row0['codigoCurso'],
                        'usuario' => $row0['usuario'],
                        'valor' => $row0['valor']
                    ],

                );
            }
        }

        $query1 = "SELECT COUNT(pre_requisito) from requisitos_curso WHERE idCurso = '$idCurso' AND pre_requisito != 0";
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
            if (!empty($fechasInicioFin) && !empty($fechasInicioFin)) {
                if (strtotime($fechasInicioFin[0]['fechaInicio']) > strtotime(date('Y-m-d H:i:s', time())) && strtotime(date('Y-m-d H:i:s', time())) < strtotime($fechasInicioFin[0]['fechaFin'])) {

                    $queryVerify = "SELECT * FROM asistencias WHERE usuario = '$usuario'";
                    $resultVerify = mysqli_query($conection, $queryVerify);
                    if (mysqli_num_rows($resultVerify) >= 1) {
                        array_push($json, 'errorInscripcionExistente');
                    } else {
                        $query3 = "INSERT INTO aprobacion ( idCuenta, codigoCuenta, codigoCurso, usuario, porcentaje_aprobacion) VALUES ('$idCuenta', (SELECT codigoCuenta from cuentas WHERE ID = '$idCuenta'),(SELECT MAX(codigoCurso) from cursos WHERE idRamo = '$idCurso'), '$usuario', '$porcentaje_aprobacion')";

                        $result3 = mysqli_query($conection, $query3);
                        if (!$result3) {
                            die('Query failed' . mysqli_error($conection));
                        } else {

                            $query4 = "INSERT INTO evaluaciones (idCuenta, idPersona, codigoCuenta, codigoCurso, usuario, num_evaluaciones, estado, puntaje, nota, porcentaje) VALUES ('$idCuenta',(SELECT ID from personas WHERE usuario = '$usuario'), (SELECT codigoCuenta from cuentas WHERE ID = '$idCuenta'),(SELECT MAX(codigoCurso) from cursos WHERE idRamo = '$idCurso' ), '$usuario', '1','Pendiente','0','0','0')";
                            $result4 = mysqli_query($conection, $query4);

                            if (!$result4) {
                                die('Query failed' . mysqli_error($conection));
                            } else {

                                $query5 = "UPDATE asistencias SET idPersona = (SELECT ID FROM personas WHERE usuario = '$usuario'), usuario = '$usuario' WHERE
                        codigoCurso = (SELECT MAX(codigoCurso) from cursos WHERE idRamo = '$idCurso') AND usuario = 'null'";
                                $result5 = mysqli_query($conection, $query5);

                                if (!$result5) {
                                    die('Query failed' . mysqli_error($conection));
                                } else {
                                    foreach ($fechas as $valores) {
                                        $query6 = "INSERT INTO asistencias (idCuenta, idPersona, codigoCurso, usuario, atributo, valor) VALUES ('$valores[idCuenta]','0', (SELECT MAX(codigoCurso) from cursos WHERE idRamo ='$idCurso'), 'null',
                                '$valores[atributo]', '0')";
                                        $result6 = mysqli_query($conection, $query6);

                                        if (!$result6) {
                                            die('Query Failed' . mysqli_error($conection));
                                        } else {
                                            array_push($json, 'successCreated');
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else {
                    array_push($json, 'errorRequisitos');
                }
            } else {
                array_push($json, 'errorCursoNoExiste');
            }
        } else {
            array_push($json, 'errorRequisitos');
        }
        echo json_encode(array_unique($json));
    }
} else {
    die('Query Failed' . mysqli_error($conection));
}
