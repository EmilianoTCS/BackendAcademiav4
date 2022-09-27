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
    <?php include 'template/scripts.php' ?>
</head>

<body>
    <div id="container_tabla">
        <input type="text" id="search_cuenta" placeholder="Buscador">
        <a id="href_asistencias" href="coe-asistencias.php">Asistencias</a>
        <a id="action_href_colaboradores" href="#">Colaboradores</a>
        <a id="insert_colaborador" href="#">Registrar colaborador</a>
        <a id="insert_orador" href="#">Registrar orador</a>
        <table id="tabla_orador">
            <thead id="list_theadOrador"></thead>
            <tbody id="list_tbodyOrador"></tbody>
        </table>
    </div>
    <div id="container_paginador">
        <ul id="paginador">
            <?php
            for ($i = 1; $i <= $paginas['cantidad_paginas_relator']; $i++) {
                $actual = $i == 1 ? " class='actual'" : '';
                echo "<li id='boton_paginador'><a num_pagina='$i' href='#' $actual>$i</a></li>";
            }
            ?>
        </ul>
    </div>
    <div id="form_registrarColaborador">
        <div class="btn_close">&times;</div>
        <h3>Registro de Colaboradores</h1>
            <form id="form_agregarColaborador" action="" method="post">
                <input type="hidden" id="input_Usuario">
                <div>
                    <label for="input_idCuenta_Colaborador">ID de la Cuenta: </label>
                    <select name="input_idCuenta_Colaborador" id="input_idCuenta_Colaborador">
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
                    <label for="input_nombreCompleto">Nombre Completo: </label>
                    <input type="text" name="input_nombreCompleto" id="input_nombreCompleto">
                </div>
                <div>
                    <i id="icon_info" class="bi bi-info-circle-fill">
                        <div id="triangulo_der"></div>
                        <div id="container_info">
                            <span class="info_idColaborador">Tip: El ID está conformado por la primera letra del nombre seguido por su apellido.</span>
                        </div>
                    </i>
                </div>
                <div id="container_idUsuario">
                    <label for="input_idUsuario">ID del Usuario: </label>
                    <input type="text" name="input_idUsuario" id="input_idUsuario" placeholder="Primer letra + Apellido">
                </div>
                <div>
                    <label for="input_areaColaborador">Área: </label>
                    <input type="text" name="input_areaColaborador" id="input_areaColaborador" placeholder="Seguridad">
                </div>
                <div>
                    <label for="input_subgerenciaColaborador">Subgerencia: </label>
                    <input type="text" name="input_subgerenciaColaborador" id="input_subgerenciaColaborador" placeholder="Infraestructura y producción TI">
                </div>
                <div>
                    <i id="icon_info" class="bi bi-info-circle-fill">
                        <div id="triangulo_der"></div>
                        <div id="container_info">
                            <span class="info_idColaborador">Tip: El correo está formado por el idUsuario + @dominio.</span>
                        </div>
                    </i>
                    <label for="input_correoColaborador">Correo: </label>
                    <input type="text" name="input_correoColaborador" id="input_correoColaborador" placeholder="IDUSUARIO@DOMINIO.COM">
                </div>
                <div>
                    <input type="submit" id="btn_registrar" value="Registrar">
                </div>
            </form>
    </div>
    <div id="form_registrarOrador">
        <div class="btn_close">&times;</div>
        <h3 id="registrar">Registro de Oradores</h3>
        <form id="form_agregarOrador" action="" method="post">
            <div>
                <label for="input_relator">Relator: </label>
                <input type="text" name="input_relator" id="input_relator">
            </div>
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
            <div id="button_container">
                <input type="submit" id="btn_registrar" value="Registrar">
            </div>

        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <!-- Frontend Logic -->
    <script src="js/functions.js"></script>

    <script>
         $('#insert_orador').click(function() {
            $('#form_registrarOrador').addClass("active");
        })
        $('.btn_close').click(function() {
            $('#form_registrarOrador').removeClass("active");
        })

        $('#action_href_colaboradores').click(function() {
            $('#insert_colaborador').addClass("active");
        })
        $('#action_href_colaboradores').click(function() {
            $('#insert_orador').addClass("hide");
        })
        $('#action_href_colaboradores').click(function() {
            $('#insert_orador').addClass("hide");
        })
        $('#insert_colaborador').click(function() {
            $('#form_registrarColaborador').addClass("active");
            $('#container_idUsuario').removeClass("hide");
            $('#container_idUsuario').addClass("active");
            $('#insert_orador').addClass("hide");
        })
        $('.btn_close').click(function() {
            $('#form_registrarColaborador').removeClass("active");
        })
    </script>
</body>

</html>