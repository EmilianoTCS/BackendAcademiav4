<?php
require("model/conexion.php");
$tipo_usuario = $_SESSION['tipo_usuario'];
?>


<div class="container">
    <?php if ($tipo_usuario == 'administrador') { ?>
        <form id="form_academia" action="">
            <div>
                <h2>COE - ACADEMIA</h2>
                <ul>
                    <li><a href="coe-general.php">General</a></li>
                    <li><a href="coe-cuenta.php">Cuenta</a></li>
                    <li><a href="coe-curso.php">Curso</a></li>
                    <li><a href="coe-orador.php">Orador</a></li>
                </ul>
            </div>
        </form>
    <?php } ?>
    <?php if ($tipo_usuario == 'capital_humano') { ?>
        <form id="form_academia" action="">
            <div>
                <h2>CAPITAL HUMANO</h2>
                <ul>
                    <li>Conteo General</li>
                    <li>Inversión de horas</li>
                    <li>Detalle por persona</li>
                </ul>
            </div>
        </form>
    <?php } ?>
    <?php if ($tipo_usuario == 'colaboradores') { ?>
        <h2 id="titulo_colab">COLABORADORES</h2>
        <div id="container_modulos_colaboradores">

            <div id="modulo1_colaboradores">
                <h3>Cursos activos</h3>
                <ul>
                    <li>JAVA</li>
                    <li>SELENIUM</li>
                </ul>
            </div>
            <div id="modulo2_colaboradores">
                <h3>Certificados</h3>
                <ul>
                    <li>JAVA</li>
                    <li>SELENIUM</li>
                </ul>
            </div>
            <div id="modulo3_colaboradores">
                <h3>Perfil</h3>
                <ul>
                    <li>Detalle de cursos</li>
                    <li>Reporte general</li>
                    <li>Configuración</li>
                </ul>
            </div>
        </div>
    <?php } ?>
</div>