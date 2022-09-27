<?php
include("model/conexion.php");
// session_start();
// $nombre = $_SESSION['nombre'];

// if (!isset($_SESSION['idCuenta'])) {
    // header("Location: login.php");
// }
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
<!-- QUERYS PARA CONTAR -->
<?php
// TOTAL CURSOS
$query_total_cursos = mysqli_query($conection, "SELECT count(distinct(idCurso)) FROM cursos");
$result = mysqli_num_rows($query_total_cursos);
if ($result > 0) {
    while ($data = mysqli_fetch_array($query_total_cursos)) {
        $totalCursos = $data['count(distinct(idCurso))'];
    }
}
// TOTAL COLABORADORES
$query_total_colaboradores = mysqli_query($conection, "SELECT count(distinct(idUsuario)) FROM personas");
$result = mysqli_num_rows($query_total_colaboradores);
if ($result > 0) {
    while ($data = mysqli_fetch_array($query_total_colaboradores)) {
        $totalColaboradores = $data['count(distinct(idUsuario))'];
    }
}
// TOTAL APROBADOS
$totalAprobados = 0;
$query_total_aprobados = mysqli_query($conection, "SELECT if(porcentaje_aprobacion > 85, 'Aprobado','Reprobado') as estado FROM aprobacion");
$result = mysqli_num_rows($query_total_aprobados);
if ($result > 0) {
    while ($data = mysqli_fetch_array($query_total_aprobados)) {
        $estado = $data['estado'];
        if ($estado == 'Aprobado') {
            $totalAprobados++;
        }
    }
}

//CURSOS TERMINADOS
$cantidadFinalizado = 0;
$queryEstado1 = mysqli_query($conection, "SELECT IF(fin < date(CURRENT_DATE), 'Finalizado', '') as estado from cursos");
$result1 = mysqli_num_rows($queryEstado1);
if ($result1 > 0) {
    while ($data = mysqli_fetch_array($queryEstado1)) {
        $estado = $data['estado'];
        if ($estado == 'Finalizado') {
            $cantidadFinalizado++;
        }
    }
}
//CURSOS EN CURSO
$cantidadEnCurso = 0;
$queryEstado2 = mysqli_query($conection, "SELECT IF(inicio < date(CURRENT_DATE) and CURRENT_DATE < fin, 'En curso', '') as estado from cursos");
$result2 = mysqli_num_rows($queryEstado2);
if ($result2 > 0) {
    while ($data = mysqli_fetch_array($queryEstado2)) {
        $estado = $data['estado'];
        if ($estado == 'En curso') {
            $cantidadEnCurso++;
        }
    }
}
//CURSOS PENDIENTES
$cantidadPendientes = 0;
$queryEstado3 = mysqli_query($conection, "SELECT IF(CURRENT_DATE < inicio, 'Pendiente', '') as estado from cursos");
$result3 = mysqli_num_rows($queryEstado3);
if ($result3 > 0) {
    while ($data = mysqli_fetch_array($queryEstado3)) {
        $estado = $data['estado'];
        if ($estado == 'Pendiente') {
            $cantidadPendientes++;
        }
    }
}

// PORCENTAJE DE CURSOS
$porcentajeCursosTerminados = ($cantidadFinalizado * 100) / $totalCursos;
// PORCENTAJE DE APROBADOS
$porcentajeAprobados = ($totalAprobados * 100) / $totalColaboradores;

?>

<body>
    <div class="container">
        <section id="container_cards">
            <div id="coe_carta">
                <div class="card-header">Cursos</div>
                <div class="card-body">
                    <h2 class="card-title"><?php echo $totalCursos ?></h2>
                    <p class="card-text">Total</p>
                </div>
            </div>
            <div id="coe_carta">
                <div class="card-header">colaboradores</div>
                <div class="card-body">
                    <h2 class="card-title"><?php echo $totalColaboradores ?></h2>
                    <p class="card-text">Total</p>
                </div>
            </div>
            <div id="coe_carta">
                <div class="card-header">cursos</div>
                <div class="card-body">
                    <h2 class="card-title"><?php echo $cantidadFinalizado ?></h2>
                    <p class="card-text">finalizados</p>
                </div>
            </div>
            <div id="coe_carta">
                <div class="card-header">porcentaje</div>
                <div class="card-body">
                    <h2 class="card-title"><?php echo $porcentajeCursosTerminados ?></h2>
                    <p class="card-text">finalizados</p>
                </div>
            </div>
            <div id="coe_carta">
                <div class="card-header">porcentaje</div>
                <div class="card-body">
                    <h2 class="card-title"><?php echo $porcentajeAprobados ?></h2>
                    <p class="card-text">aprobados</p>
                </div>
            </div>
            <div id="coe_carta">
                <div class="card-header">cursos</div>
                <div class="card-body">
                    <h2 class="card-title"><?php echo $cantidadEnCurso ?></h2>
                    <p class="card-text">activos</p>
                </div>
            </div>
            <div id="coe_carta">
                <div class="card-header">pendientes</div>
                <div class="card-body">
                    <h2 class="card-title"><?php echo $cantidadPendientes ?></h2>
                    <p class="card-text">Total</p>
                </div>
            </div>
        </section>



        <!-- CODIGO CANVAS -->
        <section id="containers_canvas">
            <div id="canvas">
                <canvas id="GraficoBar"></canvas>
            </div>
            <div id="canvas2">
                <canvas id="GraficoPie"></canvas>
            </div>
            <script>
                // COLORES RBG
                function generarNumero(numero) {
                    return (Math.random() * numero).toFixed(0);
                }

                function colorRGB() {
                    var coolor = "(" + generarNumero(255) + "," + generarNumero(255) + "," + generarNumero(255) + ")";
                    return "rgb" + coolor;
                }
                var colores = [];
                for (let i = 0; i < <?php echo $totalCursos ?>; i++) {
                    colores.push(colorRGB());
                }

                // DECLARACION DE CONSTANTES PARA EL CANVAS
                const GraficoBar = document.getElementById('GraficoBar').getContext('2d');
                const GraficoPie = document.getElementById('GraficoPie').getContext('2d');
                const etiquetas = ['Finalizado', 'En curso', 'Pendiente'];
                const Datos = {
                    label: 'Cantidad',
                    data: [<?php echo $cantidadFinalizado ?>, <?php echo $cantidadEnCurso ?>, <?php echo $cantidadPendientes ?>],
                    backgroundColor: colores,
                    borderColor: colores,
                    borderWidth: 1,
                    datalabels: {
                        anchor: 'center',
                        color: 'white',
                        font: {
                            size: 18
                        }
                    }
                };
                // CANVAS
                new Chart(GraficoBar, {
                    type: 'bar',
                    data: {
                        labels: etiquetas,
                        datasets: [
                            Datos,
                        ]
                    },
                    plugins: [ChartDataLabels],
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
                new Chart(GraficoPie, {
                    type: 'polarArea',
                    data: {
                        labels: etiquetas,
                        datasets: [
                            Datos,
                        ]
                    },
                    plugins: [ChartDataLabels],
                    options: {
                        legends: {
                            labels: {
                                display: true,
                                position: 'chartArea',
                                align: 'center'
                            }
                        },
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }

                });
            </script>
        </section>
    </div>

</body>

</html>