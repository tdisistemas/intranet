<?php

include('../../conexiones_config.php');
_bienvenido_mysql();

if (isset($_GET['acc'])) {
    if ($_GET['acc'] == 0) {
        $statusquery = "UPDATE ai_averiguaciones a SET a.status = a.aux WHERE idAveriguacion = " . $_GET['aver'];
    } else {
        $statusquery = "UPDATE ai_averiguaciones a SET a.aux = a.status, a.status = " . $_GET['acc'] . " WHERE idAveriguacion = " . $_GET['aver'];
    }
    $sql = mysql_query($statusquery);
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
