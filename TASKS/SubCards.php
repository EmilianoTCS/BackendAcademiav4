<?php
include("../model/conexion.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if (isset($_GET['usuario'])) {
    $data = json_decode(file_get_contents("php://input"));
    $usuario = $data->usuario;
    $query_total_cursos = mysqli_query($conection, "SELECT ram.nombreRamo, cur.inicio,cur.fin, cur.codigoCurso, ROUND(AVG(eva.nota),2) as promedio, eva.usuario,
												5 * (DATEDIFF(cur.fin, cur.inicio) DIV 7) + MID('0123444401233334012222340111123400012345001234550', 7 * WEEKDAY(cur.inicio) + WEEKDAY(cur.fin) + 1, 1)AS totalClases,
												IF(cur.fin < date(CURRENT_DATE), 'Finalizado', IF(eva.estado = 'Enviado' || 'Entregado', 'Activo', IF(eva.estado != 'Enviado' || 'Entregado', 'Pendiente', ''))) as estado
												FROM cursos cur INNER JOIN evaluaciones eva, ramos ram WHERE cur.idRamo = ram.ID AND cur.isActive = true AND cur.codigoCurso = eva.codigoCurso AND eva.usuario = '$usuario' GROUP BY cur.codigoCurso ORDER BY cur.ID ASC");
    $result = mysqli_num_rows($query_total_cursos);
    if ($result > 0) {
        while ($data = mysqli_fetch_array($query_total_cursos)) {
            $totalCursos[] = array(
                'codigoRamo' => $data['nombreRamo'],
                'inicio' => $data['inicio'],
                'totalClases' => $data['totalClases'],
                'promedio' => $data['promedio'],
                'estado' => $data['estado']
            );
        }
    }
    $json_encode = json_encode($totalCursos);
    echo $json_encode;
}
