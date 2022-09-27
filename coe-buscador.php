<?php
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
    <title>Listado de Personas</title>
    <?php include "template/header.php";
    include "model/conexion.php";
    ?>
</head>
<?php include 'template/scripts.php' ?>

<body>
    <section id="container">
        <?php $busqueda = $_REQUEST['busqueda'] ?>
        <h1>Lista de personas</h1>
        <a href="registrarPersonas.php" class="btn_new">Registrar Persona</a>
        <form id="Form_edit" action="" method="">
        <table>
            <tr>
                <th>idCurso</th>
                <th>idUsuario</th>
                <th>Evaluaciones</th>
                <th>Porcentaje de aprobación</th>
                <th>Operaciones</th>
            </tr>
            <?php
          

            $query = mysqli_query($conection, "SELECT cur.idCurso,per.idUsuario, eva.evaluaciones, apro.porcentaje_aprobacion FROM personas per 
                                                                            INNER JOIN cursos cur, evaluaciones eva,aprobacion apro
                                                                            WHERE (per.idUsuario LIKE '%$busqueda%' OR
                                                                            cur.idCurso LIKE '%$busqueda%' OR
                                                                            eva.evaluaciones LIKE '%$busqueda%' OR
                                                                            apro.porcentaje_aprobacion LIKE '%$busqueda%')");
            $result = mysqli_num_rows($query);
            if ($result > 0) {
                while ($data = mysqli_fetch_array($query)) {
            ?>
                    <tr>
                        <td><a href=""><?php echo $data["idCurso"] ?></a></td>
                        <td><?php echo $data["idUsuario"] ?></td>
                        <td><?php echo $data["evaluaciones"] ?></td>
                        <td><?php echo $data["porcentaje_aprobacion"] ?></td>
                        <td>
                            <a class="link_edit" href="editarPersonas.php?id=<?php echo $data["idUsuario"]; ?>">Editar</a>
                            |
                            <a class="link_delete" href="eliminarPersonas.php?id=<?php echo $data["idUsuario"]; ?>">Eliminar</a>
                        </td>
                    </tr>
            <?php
                }
            }
            ?>
        </table>
        </form>
        
    </section>
</body>

</html>