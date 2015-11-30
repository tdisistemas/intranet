<?php

include('../../conexiones_config.php');
_bienvenido_mysql();
$id = _antinyeccionSQL($_GET['aver']);

$sqlcode = "UPDATE ai_averiguaciones SET ";
if ($_GET['tipo'] == 1) {
    $tipo = 'conclusion';
    $sqlcode .= $tipo;
} else {
    $tipo = 'recomendacion';
    $sqlcode .= $tipo;
}
$sqlcode .="='" . $_GET['dato'] . "' WHERE idAveriguacion=" . $id;
$sql = mysql_query($sqlcode);

/*  Verificacion */
$sqlSelect = 'Select ' . $tipo . ' FROM ai_averiguaciones WHERE idAveriguacion=' . $id;
$sql = mysql_query($sqlSelect);
$result = mysql_fetch_array($sql);
_adios_mysql();
echo $result[$tipo];
?>