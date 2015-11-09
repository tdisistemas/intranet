<?php

include('../../conexiones_config.php');


_bienvenido_mysql();
$datos = array();
$sqlcode = "SELECT "
        . "nombre,"
        . "apellido,"
        . "cargo,"
        . "cedula,"
        . "correo_electronico,"
        . "celular,"
        . "gerencia,"
        . "telefono_habitacion "
        . "FROM datos_empleado_rrhh ";

if (is_numeric($_GET['Campo'])) {

    $sqlcode .="WHERE cedula LIKE '%" . $_GET['Campo'] . "%'";
} else {
    $cadena = explode(" ", $_GET['Campo']);
    $sqlcode .="WHERE ((CONCAT_WS(' ',nombre,apellido) LIKE '%" . $cadena[1] . "%'"
            . " AND CONCAT_WS(' ',nombre,apellido) LIKE '%" . $cadena[0] . "%')"
            . " OR CONCAT_WS(' ',nombre,apellido) LIKE '%" . $_GET['Campo'] . "%')";
}
//$sqlcode.=" AND ubicacion_laboral LIKE '%asuntos internos%' ORDER BY cedula";

$sql = mysql_query($sqlcode);
$i = 0;
while ($result = mysql_fetch_array($sql)) {
    $datos[$i] = array('nombre' => $result['nombre'] != '' ? $result['nombre'] : 'Registro en blanco!',
        'apellido' => $result['apellido'] != '' ? $result['apellido'] : 'Registro en blanco!',
        'cargo' => $result['cargo'] != '' ? $result['cargo'] : 'Registro en blanco!',
        'cedula' => $result['cedula'] != '' ? $result['cedula'] : 'Registro en blanco!',
        'celular' => $result['celular'] != '' ? $result['celular'] : 'Registro en blanco!',
        'correo' => $result['correo_electronico'] != '' ? $result['correo_electronico'] : 'Registro en blanco!',
        'telefono_habitacion' => $result['telefono_habitacion'] != '' ? $result['telefono_habitacion'] : 'Registro en blanco!');
    $i++;
}
_adios_mysql();

echo json_encode(array('datos' => $datos, 'campos' => $i, 'query' => $sqlcode));
?>