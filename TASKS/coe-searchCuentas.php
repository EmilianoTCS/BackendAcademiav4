<?php

include("../model/conexion.php");

if (isset($_POST['search'])) {
    $search = $_POST['search'];

    $query = "SELECT ram.*, cur.*, per.*,
                                               if(ap.porcentaje_aprobacion > 85, 'Aprobado','Reprobado') as estado FROM ramos ram
                                               INNER JOIN cursos cur, personas per, aprobacion ap, cuentas cu
                                               WHERE (ram.idCuenta LIKE '%$search%' OR
                                               ram.nombreRamo LIKE '%$search%' OR
                                               ram.relator LIKE '%$search%' OR
                                               per.idUsuario LIKE '%$search%' OR
                                               per.nombre_completo LIKE '%$search%')
                                               group by per.nombre_completo, per.idUsuario";
                                                
    $result = mysqli_query($conection, $query);
    if (!$result) {
        die('Query Failed' . mysqli_error($conection));
    }

    $json = array();
    while ($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'idCuenta' => $row['idCuenta'],
            'nombreRamo' => $row['nombreRamo'],
            'relator' => $row['relator'],
            'idUsuario' => $row['idUsuario'],
            'nombre_completo' => $row['nombre_completo'],
            'estado' => $row['estado']
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
} else {
    echo "error";
}
?>
