<?php

include('../../conexiones_config.php');
_bienvenido_mysql();

if (isset($_GET['acc'])) {
    if ($_GET['acc'] == 'Buscar') {
        $datos = array();
        $sqlcode = "SELECT "
                . "a.nombre,"
                . "a.apellido,"
                . "a.cargo,"
                . "a.cedula,"
                . "a.correo_electronico,"
                . "a.celular,"
                . "a.gerencia,"
                . "c.perfil,"
                . "b.usuario_int,"
                . "a.telefono_habitacion "
                . "FROM datos_empleado_rrhh a "
                . "INNER JOIN usuario_bkp b ON a.cedula=b.usuario "
                . "INNER JOIN autenticacion c ON a.cedula=c.cedula ";

        if (is_numeric($_GET['Campo'])) {

            $sqlcode .="WHERE a.cedula LIKE '%" . $_GET['Campo'] . "%'";
        } else {
            $cadena = explode(" ", $_GET['Campo']);
            $sqlcode .="WHERE ((CONCAT_WS(' ',a.nombre,a.apellido) LIKE '%" . $cadena[1] . "%'"
                    . " AND CONCAT_WS(' ',a.nombre,a.apellido) LIKE '%" . $cadena[0] . "%')"
                    . " OR CONCAT_WS(' ',a.nombre,a.apellido) LIKE '%" . $_GET['Campo'] . "%')";
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
                'usuario' => $result['usuario_int'] != '' ? $result['usuario_int'] : 'Registro en blanco!',
                'perfil' => $result['perfil'] != '' ? $result['perfil'] : 'Registro en blanco!',
                'telefono_habitacion' => $result['telefono_habitacion'] != '' ? $result['telefono_habitacion'] : 'Registro en blanco!');
            $i++;
        }
        _adios_mysql();
        echo json_encode(array('datos' => $datos, 'campos' => $i, 'query' => $sqlcode));
    }

    if ($_GET['acc'] == 'Verificar') {

        $sqlVerificar = "SELECT id_invest FROM ai_investigadores WHERE cedula_invest=" . $_GET['Campo'];
        $sqlQuery = mysql_query($sqlVerificar);
        $respuestaVer = mysql_fetch_array($sqlQuery);
        if ($respuestaVer) {
            echo '0';
        } else {
            echo '1';
        }
    }
}
?>