<?php

include('../../conexiones_config.php');


_bienvenido_mysql();

$sqlcode = "SELECT "
        . "nombre,"
        . "apellido,"
        . "cargo,"
        . "cedula,"
        . "correo_electronico,"
        . "celular,"
        . "telefono_habitacion "
        . "FROM datos_empleado_rrhh "
        . "WHERE cedula=" . $_GET['cedula'];

mysql_query("set names utf8");
$sql = mysql_query($sqlcode);
$result = mysql_fetch_array($sql);
_adios_mysql();

echo json_encode(array('nombre'=>$result['nombre']!='' ? $result['nombre'] : 'Registro en blanco!',
                'apellido'=>$result['apellido']!='' ? $result['apellido'] : 'Registro en blanco!',
                'cargo'=>$result['cargo']!='' ? $result['cargo'] : 'Registro en blanco!',
                'cedula'=>$result['cedula']!='' ? $result['cedula'] : 'Registro en blanco!',
                'celular'=>$result['celular']!='' ? $result['celular'] : 'Registro en blanco!',
                'correo'=>$result['correo_electronico']!='' ? $result['correo_electronico'] : 'Registro en blanco!',
                'telefono_habitacion'=>$result['telefono_habitacion']!='' ? $result['telefono_habitacion'] : 'Registro en blanco!'));
?>