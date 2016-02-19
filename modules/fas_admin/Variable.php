<?php

include('../../conexiones_config.php');

if (isset($_GET['empleado']) && $_GET['empleado'] != '') {

    $estatus = _dameestatus($_GET['empleado']);
    if ($estatus != 1) {
        $respuesta = '';
        $estatus = 'Error';
        
    } else {
        $variable = array(
            array('cedulaE', $_GET['empleado'])
        );
        $respuesta = parametrosReporte($variable);
        $estatus = 'OK';
    }
    echo json_encode(array('respuesta' => $respuesta, 'estatus' => $estatus));
}
?>