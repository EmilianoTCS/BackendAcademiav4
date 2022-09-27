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
        <form action="" method="POST" id="form_submit_curso">
            <div id="selector_Curso_Asist">
                <label for="input_curso_asist">Seleccione un curso:</label>
                <select name="input_curso_asist" id="input_curso_asist">
                    <?php
                    include "model/conexion.php";
                    $query_curso = mysqli_query($conection, "SELECT idCurso from asistencias group by idCurso");
                    while ($row = mysqli_fetch_array($query_curso)) {
                        $idCurso_ = $row['idCurso'];
                    ?>
                        <option value="<?php echo $idCurso_ ?>"><?php echo $idCurso_ ?></option>
                    <?php
                    }
                    $idCursoSubmit = $_POST["input_curso_asist"];
                    ?>
                </select>
            </div>
            <div id="selector_Grupo_Asist">
                <label for="input_grupo_asist">Seleccione un grupo:</label>
                <select name="input_grupo_asist" id="input_grupo_asist">
                    <?php
                    include "model/conexion.php";
                    $query_grupo = mysqli_query($conection, "SELECT Grupo from cursos group by Grupo");
                    while ($row = mysqli_fetch_array($query_grupo)) {
                        $grupo = $row['Grupo'];
                    ?>
                        <option value="<?php echo $grupo ?>"><?php echo $grupo ?></option>
                    <?php
                    }
                    $GrupoSubmit = $_POST["input_grupo_asist"];
                    ?>
                </select>
            </div>
            <input type="submit" id="btn_submit_selecciones" value="Enviar">
        </form>

        <?php if ($idCursoSubmit && $GrupoSubmit) { ?>
            <table id="tabla_asistencias">
                <thead id="list_theadAsistencias">
                    <?php
                    // RECORRER ARRAY
                    $query_fecha = mysqli_query($conection, "SELECT GROUP_CONCAT(distinct(atributo) SEPARATOR ',') FROM asistencias WHERE idCurso = '$idCursoSubmit' AND Grupo = $grupo");
                    while ($row_fecha = mysqli_fetch_array($query_fecha)) {
                        $fecha = explode(',', $row_fecha["GROUP_CONCAT(distinct(atributo) SEPARATOR ',')"]);
                    ?>
                        <tr>
                            <th>idUsuario</th>
                            <?php
                            for ($i = 0; $i < count($fecha); $i++) { ?>
                                <th style="text-align:justify; width:min-content;"><?php echo $fecha[$i]; ?></th>
                        <?php }
                        } ?>
                        </tr>
                </thead>
                <tbody id="list_tbodyAsistencias">
                    <?php
                    include "model/conexion.php";
                    $query = mysqli_query($conection, "SELECT * FROM asistencias WHERE idCurso = '$idCursoSubmit'  GROUP BY idUsuario ORDER BY idUsuario");
                    $result = mysqli_num_rows($query);
                    if ($result > 0) {
                        while ($data = mysqli_fetch_array($query)) {
                    ?>
                            <tr>
                                <td><?php echo $data["idUsuario"] ?></td>
                                <?php foreach ($fecha as $valores) { ?>
                                    <?php if ($data["valor"] == '1') { ?>
                                        <td>✔</td>
                                    <?php } elseif ($data["valor"] == '0') { ?>
                                        <td>✘</td>

                                <?php  }
                                } ?>
                            </tr>
                    <?php
                        }
                    }
                    ?>

                </tbody>
            </table>
        <?php } else { ?>
            <table id="tabla_asistencias">
                <thead id="list_theadAsistencias">
                    <?php
                    // RECORRER ARRAY
                    $query_fecha = mysqli_query($conection, "SELECT GROUP_CONCAT(distinct(atributo) SEPARATOR ',') FROM asistencias WHERE idCurso = 'BDD202110271630' AND Grupo = '1'");
                    while ($row_fecha = mysqli_fetch_array($query_fecha)) {
                        $fecha = explode(',', $row_fecha["GROUP_CONCAT(distinct(atributo) SEPARATOR ',')"]);
                    ?>
                        <tr>
                            <th>idUsuario</th>
                            <?php
                            for ($i = 0; $i < count($fecha); $i++) { ?>
                                <th style="text-align:justify; width:min-content;"><?php echo $fecha[$i]; ?></th>
                        <?php }
                        } ?>
                        </tr>
                </thead>
                <tbody id="list_tbodyAsistencias">
                    <?php
                    include "model/conexion.php";
                    $query = mysqli_query($conection, "SELECT * FROM asistencias WHERE idCurso = 'BDD202110271630' AND Grupo = '1' GROUP BY idUsuario ORDER BY idUsuario");
                    $result = mysqli_num_rows($query);
                    if ($result > 0) {
                        while ($data = mysqli_fetch_array($query)) {
                    ?>
                            <tr>
                                <td><?php echo $data["idUsuario"] ?></td>
                                <?php foreach ($fecha as $valores) { ?>
                                    <?php if ($data["valor"] == '1') { ?>
                                        <td>✔</td>
                                    <?php } elseif ($data["valor"] == '0') { ?>
                                        <td>✘</td>

                                <?php  }
                                } ?>
                            </tr>
                    <?php
                        }
                    }
                    ?>

                </tbody>
            </table>

        <?php } ?>



    </div>
</body>

</html>