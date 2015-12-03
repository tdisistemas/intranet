<?php

include('../../conexiones_config.php');
_bienvenido_mysql();

if (isset($_GET['acc'])) {
    if ($_GET['acc'] == 0) {
        $statusquery = "UPDATE ai_averiguaciones a SET a.status = a.aux WHERE idAveriguacion = " . $_GET['aver'];
    } else {
        if ($_GET['acc'] == 3) {
            $sqlConsulta = "SELECT tipo_origen, origen FROM ai_averiguaciones WHERE idAveriguacion = " . $_GET['aver'];
            $sqlquery = mysql_query($sqlConsulta);
            $rowConsulta = mysql_fetch_array($sqlquery);
            if ($rowConsulta['tipo_origen'] == '1') {
                $tabla = "ai_denuncias";
                $campo = "idDenuncia";
            } else {
                $tabla = "ai_oficios";
                $campo = "idOficio";
            }
            $sqlStatusOrigen = "UPDATE " . $tabla . " SET status=2 WHERE " . $campo . "=" . $rowConsulta['origen'];
            mysql_query($sqlStatusOrigen);
        }
        $statusquery = "UPDATE ai_averiguaciones a SET a.aux = a.status, a.status = " . $_GET['acc'] . ",a.fecha_st_" . $_GET['acc'] . "=NOW() WHERE idAveriguacion = " . $_GET['aver'];
    }
    mysql_query($statusquery);
    switch ($_GET['acc']) {
        case 0:
            $mensaje = "Retomada";
            break;
        case 1:
            $mensaje = "Puesta en Revisión";
            break;
        case 2:
            $mensaje = "Remitida";
            Break;
        case 3:
            $mensaje = "Finalizada";
            Break;
        case 9:
            $mensaje = "Archivada";
            break;
    }
    echo $mensaje;
}
?>
