<?php
// VALIDACIÓN DE SESIÓN
include("model/conexion.php");
session_start();
$nombre = $_SESSION['nombre'];

if (!isset($_SESSION['idCuenta'])) {
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
    <?php include 'template/scripts.php' ?>
</head>

<body>
    <div id="container_tabla">
        <input type="text" id="search_cuenta" placeholder="Buscador">
        <a href="TASKS/coe-list_infoAsistencias.php">Asistencias</a>
        <table id="tabla_asistencias">
            <thead></thead>
            <?php
            // RECORRER ARRAY
            $query_fecha = mysqli_query($conection, "SELECT GROUP_CONCAT(distinct(atributo) SEPARATOR ',') FROM asistencias WHERE idCurso = 'JAV202107261630'");
            while ($row_fecha = mysqli_fetch_array($query_fecha)) {
                $fecha = explode(',', $row_fecha["GROUP_CONCAT(distinct(atributo) SEPARATOR ',')"]);
            ?>
                <th>idUsuario</th>
                <?php
                for ($i = 0; $i < count($fecha); $i++) { ?>
                    <th style="text-align:justify; width:min-content;"><?php echo $fecha[$i]; ?></th>
            <?php }
            } ?>
            <tbody id="list_tbodyOrador"></tbody>
            <?php
                include "model/conexion.php";
                $query = mysqli_query($conection, "SELECT * FROM asistencias WHERE idCurso = 'JAV202107261630'  GROUP BY idUsuario ORDER BY idUsuario");
                $result = mysqli_num_rows($query);
                if ($result > 0) {
                    while ($data = mysqli_fetch_array($query)) {
                ?>
                        <tr>
                            <td><?php echo $data["idUsuario"] ?></td>
                            <?php foreach ($fecha as $valores) { ?>
                                <?php if ($data["valor"] == '1') { ?>
                                    <td style="text-align: left;">✔</td>
                                <?php } elseif ($data["valor"] == '0') { ?>
                                    <td style="text-align: left;">✘</td>

                            <?php  }
                            } ?>
                            <td>
                                <a class="link_edit" href="editarEvaluaciones.php?idUsuario=<?php echo $data['idUsuario'] ?>&idCurso=<?php echo $data['idCurso'] ?>">Editar</a>
                                |
                                <a class="link_delete" href="eliminarEvaluaciones.php?idUsuario=<?php echo $data['idUsuario'] ?>&evaluaciones=<?php echo $data['evaluaciones'] ?>">Eliminar</a>
                            </td>
                        </tr>
                <?php
                    }
                }
                ?>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <!-- Frontend Logic -->
    <script src="js/functions.js"></script>
</body>

</html>