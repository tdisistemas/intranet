<?php

include('../../conexiones_config.php');
decode_get2($_SERVER["REQUEST_URI"], 1);
$id = _antinyeccionSQL($_GET['id']);
$origen = _antinyeccionSQL($_GET['Origen']);

_bienvenido_mysql();
$datos = array();

if (isset($_GET['acc']) && $_GET['acc'] != '') {

    if ($_GET['acc'] == 'Verificar') {

        $sqlInvol = "SELECT "
                . "a.idAutores,"
                . "a.cedula,"
                . "c.nombre,"
                . "c.apellido,"
                . "c.cargo,"
                . "c.gerencia,"
                . "c.ext_telefonica "
                . "FROM ai_autores a "
                . "INNER JOIN ai_averiguaciones b ON a.idAveriguacion = b.idAveriguacion "
                . "INNER JOIN datos_empleado_rrhh c ON c.cedula = a.cedula "
                . "WHERE a.idAveriguacion = " . $id;

        $sqlqueryInv = mysql_query($sqlInvol);

        $i = 0;
        while ($Involucrado = mysql_fetch_array($sqlqueryInv)) {
            $cedula = $Involucrado['cedula'];
            $nombreInvo = $Involucrado['nombre'] . ' ' . $Involucrado['apellido'];
            $cargo = $Involucrado['cargo'];
            $gerencia = $Involucrado['gerencia'];
            $extension = $Involucrado['ext_telefonica'];
            $parametros2 = 'cedula=' . $cedula;
            $parametros2 .= '&Origen=' . $origen;
            $parametros2 .= '&autor=' .$Involucrado['idAutores'];
            $parametros2 .= '&id=' .$id;
            $parametros2 = _desordenar($parametros2);

            $datos[$i] = array('nombre' => $nombreInvo != '' ? $nombreInvo : 'Registro en blanco!',
                'cargo' => $cargo != '' ? $cargo : 'Registro en blanco!',
                'extencion' => $extension != 0 ? $extension : '<label>*** No posee extención registrada ***</label>',
                'gerencia' => $gerencia != '' ? $gerencia : 'Registro en blanco!',
                'parametros' => $parametros2,
                'cedula' => $cedula != '' ? $cedula : 'Registro en blanco!');
            $i++;
        }

        echo json_encode(array('datos' => $datos, 'campos' => $i, 'query' => $sqlInvol));
    }

    if ($_GET['acc'] == 'BuscadorAutores') {
        $dato = $_GET['buscar'];
        $datos = array();
        $sqlcode = "SELECT "
                . "nombre,"
                . "apellido,"
                . "cargo,"
                . "cedula,"
                . "correo_electronico,"
                . "celular,"
                . "telefono_habitacion "
                . "FROM datos_empleado_rrhh ";

        if (is_numeric($dato)) {

            $sqlcode .="WHERE cedula LIKE '%" . $dato . "%'";
        } else {
            $cadena = explode(" ", $dato);
            $sqlcode .="WHERE (CONCAT_WS(' ',nombre,apellido) LIKE '%" . $cadena[1] . "%'"
                    . " AND CONCAT_WS(' ',nombre,apellido) LIKE '%" . $cadena[0] . "%')"
                    . " OR CONCAT_WS(' ',nombre,apellido) LIKE '%" . $dato . "%'";
        }
        $sqlcode.=' ORDER BY cedula';

        $sql = mysql_query($sqlcode);
        $i = 0;
        while ($result = mysql_fetch_array($sql)) {
            $datos[$i] = array('nombre' => $result['nombre'] . ' ' . $result['apellido'],
                'cedula' => $result['cedula']);
            $i++;
        }

        echo json_encode($datos);
    }

    if ($_GET['acc'] == 'NuevoAutor') {

        $cedula = $_GET['Involucrado'];
        $datos = array();
        $sqlcode = "INSERT INTO ai_autores (idAveriguacion, cedula) VALUES($id, $cedula)";
        $sql = mysql_query($sqlcode);
        if ($sql) {
            $mensaje = 'Involucrado registrado con éxito.';
        } else {
            $mensaje = 'Error al registrar involucrado.';
        }
        echo $mensaje;
    }
    
    if ($_GET['acc'] == 'BorrarAutor') {
        $idAutores = $_GET['autor'];
        $sqlcode = "DELETE FROM ai_autores WHERE idAutores = $idAutores";
        $sql = mysql_query($sqlcode);
        if ($sql) {
            $mensaje = 'Involucrado registrado con éxito.';
        } else {
            $mensaje = 'Error al registrar involucrado.';
        }
        echo $mensaje;
    }
}
_adios_mysql();
?>