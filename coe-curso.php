<?php
// VALIDACIÓN DE SESIÓN
include("model/conexion.php");
session_start();
$nombre = $_SESSION['nombre'];

if (!isset($_SESSION['idCuenta'])) {
    header("Location: login.php");
}
include "pageCounter.php";
$paginas = pageCounter();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACADEMIA DE FORMACIÓN TSOFT</title>
    <?php include 'template/header.php' ?>
    <link rel="stylesheet" type="text/css" href="css/style.css">

</head>

<body>
    <div id="container_tabla">
        <button id="btn_registrar">Registrar curso</button>
        <input type="text" id="search_cuenta" placeholder="Buscador">
        <table id="tabla_curso">
            <thead id="list_theadCursos"></thead>
            <tbody id="list_tbodyCursos"></tbody>
        </table>
    </div>
    <div id="container_paginador">
        <ul id="paginador">
            <?php
            for ($i = 1; $i <= $paginas['cantidad_paginas_ramos']; $i++) {
                $actual = $i == 1 ? " class='actual'" : '';
                echo "<li id='boton_paginador'><a num_pagina='$i' href='#' $actual>$i</a></li>";
            }
            ?>
        </ul>
    </div>

    <div id="form_registrarRamo">
        <div class="btn_close">&times;</div>
        <h3 id="registrar">Registro de cursos</h3>
        <h3 id="actualizar">Actualizar curso</h3>
        <form id="form_agregarRamo" action="" method="post">
            <div>
                <input type="hidden" id="input_id">
                <label for="input_idCuenta">ID de laCuenta: </label>
                <select name="input_idCuenta" id="input_idCuenta">
                    <?php
                    include "model/conexion.php";
                    $query_idCuenta = mysqli_query($conection, "SELECT idCuenta from cuentas");
                    while ($row = mysqli_fetch_array($query_idCuenta)) {
                        $idCuenta = $row['idCuenta'];
                    ?>
                        <option value="<?php echo $idCuenta ?>"><?php echo $idCuenta ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div>
                <label for="input_idRamo">ID del Ramo: </label>
                <input type="text" name="input_idRamo" id="input_idRamo" placeholder="Ejemplo: JAV">
            </div>
            <div>
                <label for="input_areaRamo">Área: </label>
                <input type="text" name="input_areaRamo" id="input_areaRamo" placeholder="Ejemplo: Automatización">
            </div>
            <div>
                <label for="input_nombreCurso">Nombre del Curso: </label>
                <input type="text" name="input_nombreCurso" id="input_nombreCurso" placeholder="Ejemplo: JAVA">
            </div>
            <div>
                <label for="input_hhAcademicas">Horas académicas: </label>
                <input type="text" name="input_hhAcademicas" id="input_hhAcademicas">
            </div>
            <div>
                <label for="input_preRequisito">Pre-Requisito: </label>
                <input type="text" name="input_preRequisito" id="input_preRequisito" placeholder="Ejemplo: JAV-SEL">
            </div>
            <div>
                <label for="input_relator">Relator: </label>
                <input type="text" name="input_relator" id="input_relator">
            </div>
            <div id="button_container">
                <input type="submit" id="btn_sig" value="Siguiente">
                <input type="submit" id="btn_registrarRamo" value="Actualizar">
            </div>

        </form>
    </div>

    <div id="form_registrarCurso">
        <div class="btn_close">&times;</div>
        <h3>Registro de cursos</h1>
            <form id="form_agregarCurso" action="" method="post">
                <div>
                    <label for="input_idCuenta">ID de la Cuenta: </label>
                    <select name="input_idCuenta" id="input_idCuenta">
                        <?php
                        include "model/conexion.php";
                        $query_idCuenta = mysqli_query($conection, "SELECT idCuenta from cuentas");
                        while ($row = mysqli_fetch_array($query_idCuenta)) {
                            $idCuenta = $row['idCuenta'];
                        ?>
                            <option value="<?php echo $idCuenta ?>"><?php echo $idCuenta ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="input_idRamo">ID del Ramo: </label>
                    <select name="input_idRamo" id="input_idRamo">
                        <?php
                        include "model/conexion.php";
                        $query_ramo = mysqli_query($conection, "SELECT idRamo from ramos");
                        while ($row = mysqli_fetch_array($query_ramo)) {
                            $idRamo = $row['idRamo'];
                        ?>
                            <option value="<?php echo $idRamo ?>"><?php echo $idRamo ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="input_fechaInicio">Fecha Inicio: </label>
                    <input type="text" name="input_fechaInicio" id="input_fechaInicio" placeholder="yyyy-mm-dd">
                </div>
                <div>
                    <label for="input_fechaFin">Fecha Fin: </label>
                    <input type="text" name="input_fechaFin" id="input_fechaFin" placeholder="yyyy-mm-dd">
                </div>
                <div>
                    <label for="input_horaInicio">Hora Inicio: </label>
                    <input type="text" name="input_horaInicio" id="input_horaInicio" placeholder="HH:mm:ss">
                </div>
                <div>
                    <label for="input_horaFin">Hora Fin: </label>
                    <input type="text" name="input_horaFin" id="input_horaFin" placeholder="HH:mm:ss">
                </div>
                <div>
                    <input type="submit" class="btn_registrar" value="Registrar">
                </div>

            </form>
    </div>

    <script>
        $('#btn_registrar').click(function() {
            $('#form_registrarRamo').addClass("active");
        })
    </script>
    <script>
        $('.btn_close').click(function() {
            $('#form_registrarRamo').removeClass("active");
            $('#form_registrarCurso').removeClass("active");
        })
    </script>
    <script>
        $('#btn_sig').click(function() {
            $('#form_registrarRamo').removeClass("active");
            $('#form_registrarCurso').addClass("active");
        })
    </script>
    <script>
        $('.btn_registrar').click(function() {
            $('#form_registrarCurso').removeClass("active");
        })
    </script>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <!-- Frontend Logic -->
    <script src="js/functions.js"></script>

</body>

</html>