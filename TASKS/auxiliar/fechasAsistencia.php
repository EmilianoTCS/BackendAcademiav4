<?php

include('../../model/conexion.php');

header("Access-Control-Allow-Origin: *");	
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


if(isset($_GET['ID'])) {
	$ID = $_GET['ID'];

    $query = "SELECT ID, atributo as fechas from asistencias WHERE idCurso = '$ID' group by atributo";
    $result = mysqli_query($conection, $query);

    if (!$result) {
        die('Query Failed' . mysqli_error($conection));
    }
    $json = array();
    while ($row = mysqli_fetch_array($result)) {

			$json[] = array(
		  'fechas'=> $row["fechas"],
		  'ID'=> $row["ID"] 
		  );
        
      
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
	
} else {
    echo json_encode("Error");
}
