<?php

include("../model/conexion.php");

if(isset($_POST['relator'])){
    $relator = $_POST['relator'];

$query = "SELECT * from ramos where relator = '$relator' order by relator ASC";
$result = mysqli_query($conection, $query);
if (!$result) {
    die('Query Failed' . mysqli_error($conection));
}

$json = array();
while ($row = mysqli_fetch_array($result)) {
    $json[] = array(
        'relator' => $row['relator'],
        'area' => $row['area'],
        'idCuenta' => $row['idCuenta'],
        'nombreRamo' => $row['nombreRamo']
    );
}
$jsonstring = json_encode($json);
echo $jsonstring;

}else{
    echo "error";
}
?>