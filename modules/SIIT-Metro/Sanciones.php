<?php

include('../../conexiones_config.php');
if (isset($_GET['acc'])) {
    _bienvenido_mysql();
    decode_get2($_SERVER["REQUEST_URI"], 1);
    $cedula = _antinyeccionSQL($_GET['cedula']);
    if ($_GET['acc'] == 'sanciones') {

        $fecha = _antinyeccionSQL($_GET['fecha']);
        $descripcion = _antinyeccionSQL($_GET['descripcion']);

        $sqlcode = "INSERT INTO ai_sanciones(empleado,fecha,fecha_sancion,descripcion) VALUES($cedula,NOW(),'$fecha','$descripcion')";
        $sql = mysql_query($sqlcode);
    }
    if ($_GET['acc'] == 'eliminar') {
        $id = $_GET['sancion'];
        $sqlcode = "UPDATE ai_sanciones SET status = 9 WHERE idSancion=$id";
        $sql = mysql_query($sqlcode);
    }

    /*  Verificacion */
    $sqlSelect = "Select idSancion,fecha_sancion,descripcion FROM ai_sanciones WHERE empleado=$cedula AND status=0 ORDER BY fecha_sancion DESC";
    $sql = mysql_query($sqlSelect);
    $i = 0;
    while ($result = mysql_fetch_array($sql)) {
        $parametro = 'cedula=' . $cedula;
        $parametro .= '&sancion=' . $result['idSancion'];
        $parametro = _desordenar($parametro);
        
        $datos[$i] = array('fecha' => $result['fecha_sancion'],
            'descripcion' => $result['descripcion'],
            'sancion' => $parametro);
        $i++;
    }
    _adios_mysql();
    echo json_encode(array('datos' => $datos, 'campos' => $i, 'query' => $sqlcode));
}
?>