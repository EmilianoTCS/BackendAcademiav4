<?php
session_start();
// $nombre = $_SESSION['nombre'];

if(!isset($_SESSION['idCuenta'])){
    header("Location: login.php");
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACADEMIA DE FORMACIÓN TSOFT</title>
    <?php include 'template/header.php' ?>
</head>
<?php include 'template/scripts.php' ?>

<body>
    <div id="idex_background">
        <?php include 'template/modulos.php' ?>
    </div>
</body>

</html>