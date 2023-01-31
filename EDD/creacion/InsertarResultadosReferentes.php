<?php

include("../../model/conexion.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if (isset($_GET['insertarResultadosReferentes'])) {
    $data = json_decode(file_get_contents("php://input"));
    $nombApellido= $data->nombApellido;
    $nombApellidoClienteEvaluado= $data->nombApellidoClienteEvaluado;
    $nivelComunicacionCE= $data->nivelComunicacionCE;
    $criticasFundamentadasCE= $data->criticasFundamentadasCE;
    $decisionesObjetivamenteCE= $data->decisionesObjetivamenteCE;
    $responsableDeResultadosCE= $data->responsableDeResultadosCE;
    $comunicarConLibertadCE= $data->comunicarConLibertadCE;
    $reconocerEsfuerzoCE= $data->reconocerEsfuerzoCE;
    $conocimientoNegocioCE= $data->conocimientoNegocioCE;
    $gestionarOrganizarCE= $data->gestionarOrganizarCE;
    $actividadesEncomendadasCE= $data->actividadesEncomendadasCE;
    $influirGrupoTrabajoCE= $data->influirGrupoTrabajoCE;
    $indiqueReclamosEtcCE= $data->indiqueReclamosEtcCE;
    $nombApellidoReferenteTSoft= $data->nombApellidoReferenteTSoft;
    $apoyoRefTSoft= $data->apoyoRefTSoft;
    $actividadesEncomendadasRef= $data->actividadesEncomendadasRef;
    $poseeConocimientosRef= $data->poseeConocimientosRef;
    $participacionJefeProyecto= $data->participacionJefeProyecto;
    $apoyoJefeProyecto= $data->apoyoJefeProyecto;
    $indiqueReclamosEtc= $data->indiqueReclamosEtc;


    if (!empty($nombApellido) && !empty($nombApellidoClienteEvaluado) && !empty($nivelComunicacionCE) && !empty($criticasFundamentadasCE)) {

        $query = "INSERT INTO `edd-resultados-evaluacion-referentes-servicio` (`pgt1-NomAp`, `pgt2-NomApRef`, `pgt3-NvlComunicacion`, `pgt4-CriticasFundamentadas`, `pgt5-DecisionesCorrectas`, `pgt6-ResponsableDecisiones`, `pgt7-RespetoIdeasDecisiones`, `pgt8-ReconocerEsfuerzo`,`pgt9-ConocimientosAptos`,`pgt10-CapacidadGestion`,`pgt11-SeguimientoOptimo`,`pgt12-InfluyePositivamente`,`pgt13-ObservacionesCliente`,`pgt14-NomApRefTSOFT`,`pgt15-ApoyoRefTSOFT`,`pgt16-SeguimientoRefTSOFT`,`pgt17-ConocimientosAptosRefTSOFT`,`pgt18-ParticipacionJefeProyecto`,`pgt19-ApoyoJefeProyecto`,`pgt20-ObservacionesCuestionario`) VALUES ('$nombApellido', '$nombApellidoClienteEvaluado', '$nivelComunicacionCE', '$criticasFundamentadasCE', '$decisionesObjetivamenteCE','$responsableDeResultadosCE','$comunicarConLibertadCE','$reconocerEsfuerzoCE','$conocimientoNegocioCE','$gestionarOrganizarCE','$actividadesEncomendadasCE','$influirGrupoTrabajoCE','$indiqueReclamosEtcCE','$nombApellidoReferenteTSoft','$apoyoRefTSoft','$actividadesEncomendadasRef','$poseeConocimientosRef','$participacionJefeProyecto','$apoyoJefeProyecto','$indiqueReclamosEtc') ";
        $result = mysqli_query($conection, $query);

        if (!$result) {
            die('Query Failed' . mysqli_error($conection));
        } else {
            echo json_encode("successCreated");
        }
    }
} else {
    echo json_encode('Error');
}
