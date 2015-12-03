<?php

include('../../conexiones_config.php');
_bienvenido_mysql();
$id = _antinyeccionSQL($_GET['aver']);

$sqlcode = "UPDATE ai_averiguaciones SET ";
switch ($_GET['tipo']) {
    case 1: 
        $tipo = 'conclusion';
        $sqlcode .= $tipo;
        Break;
    case 2: 
        $tipo = 'recomendacion';
        $sqlcode .= $tipo;
        Break;
    case 3: 
        $tipo = 'decision';
        $sqlcode .= $tipo;
        Break;
    case 4: 
        $tipo = 'sanciones';
        $sqlcode .= $tipo;
        Break;
    case 5: 
        $tipo = 'otros';
        $sqlcode .= $tipo;
        Break;
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