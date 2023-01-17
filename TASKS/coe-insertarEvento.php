<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

session_start();
include("../model/conexion.php");
include("../security/logBuilder.php");

if (isset($_GET['insertarEvento'])) {
    $data = json_decode(file_get_contents("php://input"));
    $titulo = $data->titulo;
    $duracion = strtotime($data->duracion) - strtotime('midnight');
    $descripcion = $data->descripcion;
    $fechas = $data->fechasOrdenadas;
    $longitud = count($fechas);
    $primerElemento = reset($fechas);
    $ultimoElemento = end($fechas);


    for ($i = 0; $i < $longitud; ++$i) {
        $createDateTemporal = date_create($fechas[$i]);
        $formatTimeTemporal = date_format($createDateTemporal, 'H:i:s');
        $formatDateTemporal = date_format($createDateTemporal, 'Y-m-d');

        $hora1 = strtotime($formatTimeTemporal);
        $horaFin = date('H:i:s', $hora1 + $duracion);


        $fechaInicioTemporal = date_create($primerElemento);
        $fechaFinalTemporal = date_create($ultimoElemento);


        $queryVerify = "SELECT * FROM eventos WHERE fecha_hora = '$fechas[$i]' AND hora_inicio <= time('$formatTimeTemporal') AND hora_fin >= time('$horaFin') ";
        $resultVerify = mysqli_query($conection, $queryVerify);

        if (mysqli_num_rows($resultVerify) >= 1) {
            echo json_encode('errorRepeated');
        } else {
            $query = "INSERT INTO eventos (titulo, descripcion, fecha_hora, hora_inicio, hora_fin, isActive) VALUES ('$titulo','$descripcion', '$fechas[$i]','$formatTimeTemporal','$horaFin', true);";
            $result = mysqli_query($conection, $query);
            if (!$result) {
                die('Query Failed' . mysqli_error($conection));
            } else {
                echo json_encode("successCreated");
                // $usuario = $_SESSION['codigoCuenta'];
                // $log = new Log("../security/reports/log.txt");
                // $log->writeLine("I", " ha agregado el curso con los datos: [$codigoCuenta, $codigoCurso, $codigoRamo, $dateformat_inicio, $dateformat_fin, $horaInicio, $horaFin]");
                // $log->close();
            }
        }
    }
} else {
    echo json_encode("Error");
}
