<?php

include("../../model/conexion.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if (isset($_GET['insertarResultadosAnalistas'])) {
    $data = json_decode(file_get_contents("php://input"));
    $nombApellido= $data->nombApellido;
    $nombApellidoAnalista= $data->nombApellidoAnalista;
    $analistaComunicaEfectiva= $data->analistaComunicaEfectiva;
    $analistaRecibirCriticas= $data->analistaRecibirCriticas;
    $analistaAnticipaHechos= $data->analistaAnticipaHechos;
    $analistaMuestraIniciativa= $data->analistaMuestraIniciativa;
    $analistaProponerSoluciones= $data->analistaProponerSoluciones;
    $analistaDeterminacion= $data->analistaDeterminacion;
    $analistaNegocio= $data->analistaNegocio;
    $analistaNuevosDesafios= $data->analistaNuevosDesafios;
    $analistaDesicionesCorrectas= $data->analistaDesicionesCorrectas;
    $analistaResponsableResultados= $data->analistaResponsableResultados;
    $analistaPropiasDesiciones= $data->analistaPropiasDesiciones;
    $analistaMetodologia= $data->analistaMetodologia;
    $analistaComunicarseLibertad= $data->analistaComunicarseLibertad;
    $analistaReconocerEsfuerzo= $data->analistaReconocerEsfuerzo;
    $analistaGestionarCorrectamente= $data->analistaGestionarCorrectamente;
    $analistaCapacidadAnalitica= $data->analistaCapacidadAnalitica;
    $analistaInfluirPositivamente= $data->analistaInfluirPositivamente;
    $analistaDesempeño= $data->analistaDesempeño;
    $analistaConocimientosTecnicos= $data->analistaConocimientosTecnicos;
    $analistaConocimientosNegocio= $data->analistaConocimientosNegocio;
    $observacionesReclamos= $data->observacionesReclamos;

    if (!empty($nombApellido) && !empty($nombApellidoAnalista) && !empty($analistaComunicaEfectiva) && !empty($analistaRecibirCriticas)) {
        $query = "INSERT INTO `edd-resultados-evaluacion-analistas-automatizadores` (`pgt1-NomAp`, `pgt2-NomApAnalista`, `pgt3-NvlComunicacion`, `pgt4-CriticasPositivas`, `pgt5-AnticipaHechos`, `pgt6-MuestraIniciativa`, `pgt7-ProponerSoluciones`, `pgt8-RealizaTrabajo`,`pgt9-CapacidadAprendizaje`,`pgt10-ParticipaDesafios`,`pgt11-DecisionesCorrectas`,`pgt12-ResponsableDecisiones`,`pgt13-DecisionesPropias`,`pgt14-MetodologiaTrabajo`,`pgt15-RespetoIdeasDecisiones`,`pgt16-ReconocerEsfuerzo`,`pgt17-TrabajoBajoPresion`,`pgt18-CriticasSentidoComun`,`pgt19-InfluyePositivamente`,`pgt20-DesempeñoDelEvaluado`,`pgt21-NivelConocimientosTecnicos`,`pgt22-NivelConocimientosNegocio`,`pgt23-ObservacionesCuestionario`) VALUES ('$nombApellido', '$nombApellidoAnalista', '$analistaComunicaEfectiva', '$analistaRecibirCriticas', '$analistaAnticipaHechos','$analistaMuestraIniciativa','$analistaProponerSoluciones','$analistaDeterminacion','$analistaNegocio','$analistaNuevosDesafios','$analistaDesicionesCorrectas','$analistaResponsableResultados','$analistaPropiasDesiciones','$analistaMetodologia','$analistaComunicarseLibertad','$analistaReconocerEsfuerzo','$analistaGestionarCorrectamente','$analistaCapacidadAnalitica','$analistaInfluirPositivamente','$analistaDesempeño','$analistaConocimientosTecnicos','$analistaConocimientosNegocio','$observacionesReclamos') ";
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
