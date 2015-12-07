<?php

include('../../conexiones_config.php');
_bienvenido_mysql();

if (isset($_GET['acc'])) {
    if ($_GET['acc'] == 'Aver') {
        $datos = array();

        $sqlcodemain = "SELECT "
                . "a.idAveriguacion,"
                . "a.fecha,"
                . "a.fecha_st_1,"
                . "a.fecha_st_2,"
                . "a.fecha_st_3,"
                . "a.fecha_st_9,"
                . "a.tipo_origen,"
                . "e.nombre,"
                . "e.apellido,"
                . "a.status AS st_ave,"
                . "b.codigo AS cod_den,"
                . "c.codigo AS cod_org,"
                . "a.codigo_ave "
                . "FROM ai_averiguaciones a "
                . "LEFT JOIN ai_denuncias b ON a.origen = b.idDenuncia AND a.tipo_origen = 1 "
                . "LEFT JOIN ai_oficios c ON a.origen = c.idOficio AND a.tipo_origen = 2 "
                . "INNER JOIN ai_investigadores d ON a.investigador = d.id_invest "
                . "INNER JOIN datos_empleado_rrhh e ON d.cedula_invest = cedula "
                . "WHERE 1";

        if (isset($_GET['investigador']) && $_GET['investigador'] != '') {
            $sqlcodemain .= " AND a.investigador =" . $_GET['investigador'];
        }
        if (isset($_GET['origen']) && $_GET['origen'] != '') {
            $sqlcodemain .= " AND a.tipo_origen =" . $_GET['origen'];
        }
        if (isset($_GET['sitio']) && $_GET['sitio'] != '') {
            $sqlcodemain .= " AND a.sitio_suceso ='" . $_GET['sitio'] . "'";
        }
        if (isset($_GET['remitido']) && $_GET['remitido'] != '') {
            $sqlcodemain .= " AND a.remitido =" . $_GET['remitido'];
        }
        if (isset($_GET['estatus']) && $_GET['estatus'] != '') {
            $sqlcodemain .= " AND a.status =" . $_GET['estatus'];
        }
        if (isset($_GET['Fecha']) && $_GET['Fecha'] != '') {
            if ($_GET['Fecha'] == '0') {
                $varFecha = "a.fecha";
            } else {
                $varFecha = "a.fecha_st_" . $_GET['Fecha'];
            }
            if (isset($_GET['FechaDesde']) && $_GET['FechaDesde'] != '') {
                $sqlcodemain .= " AND " . $varFecha . " >= '" . $_GET['FechaDesde'] . "'";
            }
            if (isset($_GET['FechaHasta']) && $_GET['FechaHasta'] != '') {
                $sqlcodemain .= " AND " . $varFecha . " <= '" . $_GET['FechaHasta'] . "'";
            }
            $sqlcodemain .= " AND " . $varFecha . " <> '0000-00-00'";
        }

        $sqlMain = mysql_query($sqlcodemain);

        $i = 0;
        while ($result = mysql_fetch_array($sqlMain)) {
            switch ($result['st_ave']) {
                case 0: $st = "check";
                    $color = "#8B8B8B";
                    $titulo = "En progreso.";
                    break;
                case 1: $st = "edit";
                    $color = "#8B8B8B";
                    $titulo = "En revisión.";
                    break;
                case 2: $st = "sign-out";
                    $color = "#8B8B8B";
                    $titulo = "Remitida.";
                    Break;
                case 3: $st = "lock";
                    $color = "#8B8B8B";
                    $titulo = "Finalizada.";
                    Break;
                case 9: $st = "lock";
                    $color = "red";
                    $titulo = "Archivada.";
                    break;
            }
            $datos[$i] = array('codigo_ave' => $result['codigo_ave'],
                'origen' => $result['tipo_origen'] == '1' ? $result['cod_den'] : $result['cod_org'],
                'fecha' => $result['fecha'],
                'fecha_st_1' => $result['fecha_st_1'] == '0000-00-00' ? "-" : $result['fecha_st_1'],
                'fecha_st_2' => $result['fecha_st_2'] == '0000-00-00' ? "-" : $result['fecha_st_2'],
                'fecha_st_3' => $result['fecha_st_3'] == '0000-00-00' ? "-" : $result['fecha_st_3'],
                'fecha_st_9' => $result['fecha_st_9'] == '0000-00-00' ? "-" : $result['fecha_st_9'],
                'status' => array($st,$color,$titulo),
                'investigador' => $result['nombre'] . ' ' . $result['apellido']);
            $i++;
        }
        _adios_mysql();
        echo json_encode(array('datos' => $datos, 'campos' => $i, 'query' => $sqlcode));
    }
}
?>