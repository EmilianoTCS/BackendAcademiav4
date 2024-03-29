<?php
set_time_limit(20);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

session_start();
include("../model/conexion.php");
include("../security/logBuilder.php");

if (isset($_GET['insertarCurso'])) {
    $data = json_decode(file_get_contents("php://input"));
    $duracion = strtotime($data->duracion) - strtotime('midnight');
    $codigoCuenta = $data->codigoCuenta;
    $idRamo = $data->idRamo;
    $fechas = $data->fechasOrdenadas;
    $longitud = count($fechas);
    $primerElemento = reset($fechas);
    $ultimoElemento = end($fechas);
    $sesionCount = 0;
    $json = array();

    $fechaInicioTemporal = date_create($primerElemento);
    $fechaFinalTemporal = date_create($ultimoElemento);

    $fechaInicio = date_format($fechaInicioTemporal, 'Y-m-d');
    $fechaFin = date_format($fechaFinalTemporal, 'Y-m-d');

    if (!empty($idRamo) && !empty($fechas)) {



        for ($i = 0; $i < $longitud; ++$i) {

            $createDateTemporal = date_create($fechas[0]);
            $formatTimeTemporal = date_format($createDateTemporal, 'H:i:s');
            $formatDateTemporal = date_format($createDateTemporal, 'Y-m-d');

            $createDateTemporalAsistencias = date_create($fechas[$i]);
            $formatDateTemporalAsistencias = date_format($createDateTemporalAsistencias, 'Y-m-d');


            $fechaInicio_mod = preg_replace('/-/', '', $formatDateTemporal);
            $horaInicio_mod = preg_replace('/:/', '', $formatTimeTemporal);

            $queryGetRamos = "SELECT codigoRamo from ramos WHERE ID = '$idRamo'";
            $resultado = mysqli_query($conection, $queryGetRamos);
            if (!$resultado) {
                die('Query Failed' . mysqli_error($conection));
            } else {
                while ($row = mysqli_fetch_array($resultado)) {
                    $codigoRamo = $row['codigoRamo'];
                }
            }


            $codigoCurso = $codigoRamo . $fechaInicio_mod . $horaInicio_mod;
            $hora1 = strtotime($formatTimeTemporal);
            $sesionCount += 1;
            $sesion = 'Sesion ' . $sesionCount;


            $horaFin = date('H:i:s', ($hora1 + $duracion));

            $queryVerify = "SELECT * FROM cursos WHERE idRamo = (SELECT ID from ramos WHERE ID = '$idRamo') AND fecha_hora = '$fechas[$i]' AND sesion = '$sesion' AND hora_inicio <= time('$formatTimeTemporal') AND hora_fin >= time('$horaFin') ";
            $resultVerify = mysqli_query($conection, $queryVerify);


            if (mysqli_num_rows($resultVerify) >= 1) {
                array_push($json, 'errorRepeated');
            } else {

                if (strtotime($primerElemento) > strtotime(date('Y-m-d H:i:s', time())) && strtotime(date('Y-m-d H:i:s', time())) < strtotime($ultimoElemento)) {

                    $query = "INSERT INTO cursos (idCuenta, idRamo, codigoCurso, fecha_hora, sesion, inicio, fin, hora_inicio, hora_fin, isActive, fechaActualizacion) VALUES ('$codigoCuenta',(SELECT ID from ramos WHERE ID = '$idRamo'), '$codigoCurso','$fechas[$i]','$sesion','$fechaInicio', '$fechaFin', '$formatTimeTemporal', '$horaFin', true, current_timestamp());";
                    $result = mysqli_query($conection, $query);


                    if (!$result) {
                        die('Query Failed' . mysqli_error($conection));
                    } else {

                        $query2 = "INSERT INTO asistencias (idCuenta, idPersona, codigoCurso, usuario, atributo, valor) VALUES ('$codigoCuenta', 0,'$codigoCurso', 'null', '$formatDateTemporalAsistencias', 0 ) ";
                        $result2 = mysqli_query($conection, $query2);

                        if (!$result2) {
                            die('Query Failed' . mysqli_error($conection));
                        } else {
                            array_push($json, 'successCreated');
                        }


                        // $usuario = $_SESSION['codigoCuenta'];
                        // $log = new Log("../security/reports/log.txt");
                        // $log->writeLine("I", " ha agregado el curso con los datos: [$codigoCuenta, $codigoCurso, $codigoRamo, $dateformat_inicio, $dateformat_fin, $horaInicio, $horaFin]");
                        // $log->close();
                    }
                } else {
                    array_push($json, 'errorFechas');
                }
            }
        }
    }
    echo json_encode(array_unique($json));
} else {
    echo json_encode("Error");
}
