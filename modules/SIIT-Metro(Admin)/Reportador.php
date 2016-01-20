<?php

include('../../conexiones_config.php');
_bienvenido_mysql();

if (isset($_GET['acc'])) {
    if ($_GET['acc'] == 'Aver') {
        $datos = array();

        $json = json_decode($_GET["campos"], true);

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

        if (isset($json['investigador']) && $json['investigador'] != '') {
            $sqlcodemain .= " AND a.investigador =" . $json['investigador'];
        }
        if (isset($json['origen']) && $json['origen'] != '') {
            $sqlcodemain .= " AND a.tipo_origen =" . $json['origen'];
        }
        if (isset($json['sitio']) && $json['sitio'] != '') {
            $sqlcodemain .= " AND a.sitio_suceso ='" . $json['sitio'] . "'";
        }
        if (isset($json['remitido']) && $json['remitido'] != '') {
            $sqlcodemain .= " AND a.remitido =" . $json['remitido'];
        }
        if (isset($json['estatus']) && $json['estatus'] != '') {
            $sqlcodemain .= " AND a.status =" . $json['estatus'];
        }
        if (isset($json['Fecha']) && $json['Fecha'] != '') {
            if ($json['Fecha'] == '0') {
                $varFecha = "a.fecha";
            } else {
                $varFecha = "a.fecha_st_" . $json['Fecha'];
            }
            if (isset($json['FechaDesde']) && $json['FechaDesde'] != '') {
                $sqlcodemain .= " AND " . $varFecha . " >= '" . $json['FechaDesde'] . "'";
            }
            if (isset($json['FechaHasta']) && $json['FechaHasta'] != '') {
                $sqlcodemain .= " AND " . $varFecha . " <= '" . $json['FechaHasta'] . "'";
            }
            $sqlcodemain .= " AND " . $varFecha . " <> '0000-00-00'";
        }
        $sqlMain = mysql_query($sqlcodemain);

        $i = 0;
        while ($result = mysql_fetch_array($sqlMain)) {
            $color = false;
            switch ($result['st_ave']) {
                case 0: $st = "Activo";
                    $titulo = "En progreso.";
                    break;
                case 1: $st = "Editar";
                    $titulo = "En revisión.";
                    break;
                case 2: $st = "Enviar";
                    $titulo = "Remitida.";
                    Break;
                case 3: $st = "Cerrar";
                    $titulo = "Finalizada.";
                    Break;
                case 9: $st = "Archivar";
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
                'fecha_st_9' => $result['fecha_st_9'] == '0000-00-00' || $result['st_ave'] != '9' ? "-" : $result['fecha_st_9'],
                'status' => '<span>' . iconosIntranet($st, $titulo, false, $color, false) . '</span>',
                'investigador' => $result['nombre'] . ' ' . $result['apellido']);
            $i++;
        }
        $reporte = array(
            array("Query", $sqlcodemain),
            array("img1", '../../src/images/cabecera.png'),
            array("img2", '../../src/images/piepagina.png')
        );
        _adios_mysql();
        echo json_encode(array('datos' => $datos, 'query' => parametrosReporte($reporte)));
    }
    if ($_GET['acc'] == 'Org') {

        $json = json_decode($_GET["campos"], true);

        if ($json['origen'] == '1') {
            $datos = array();

            $sqlcodemain = "SELECT "
                    . "d.fecha,"
                    . "d.denunciante,"
                    . "d.tipo,"
                    . "d.status,"
                    . "d.descripcion,"
                    . "de.nombre,"
                    . "de.cedula,"
                    . "d.codigo,"
                    . "de.apellido "
                    . "FROM ai_denuncias d "
                    . "INNER JOIN datos_empleado_rrhh de ON d.denunciante = de.cedula "
                    . "WHERE 1";

            if (isset($json['tipo']) && $json['tipo'] != '') {
                $sqlcodemain .= " AND d.tipo ='" . $json['tipo'] . "'";
            }
            if (isset($json['estatus']) && $json['estatus'] != '') {
                $sqlcodemain .= " AND d.status =" . $json['estatus'];
            }
            if (isset($json['OrigenDesde']) && $json['OrigenDesde'] != '') {
                $sqlcodemain .= " AND d.fecha >= '" . $json['OrigenDesde'] . "'";
            }
            if (isset($json['OrigenHasta']) && $json['OrigenHasta'] != '') {
                $sqlcodemain .= " AND d.fecha <= '" . $json['OrigenHasta'] . "'";
            }

            $sqlMain = mysql_query($sqlcodemain);

            $i = 0;
            while ($result = mysql_fetch_array($sqlMain)) {
                $color = false;
                switch ($result['status']) {
                    case 0: $st = "Espera";
                        $titulo = "En espera.";
                        break;
                    case 1: $st = "Activo";
                        $titulo = "Averiguación Abierta.";
                        break;
                    case 2: $st = "Cerrar";
                        $titulo = "Averiguación Finalizada.";
                        Break;
                    case 9: $st = "Eliminar";
                        $color = 'red';
                        $titulo = "Descartada.";
                        break;
                }
                $datos[$i] = array('codigo' => $result['codigo'],
                    'fecha' => $result['fecha'],
                    'tipo' => $result['tipo'],
                    'descripcion' => $result['descripcion'],
                    'status' => '<span>' . iconosIntranet($st, $titulo, false, $color, false) . '</span>',
                    'denunciante' => $result['nombre'] . ' ' . $result['apellido']);
                $i++;
            }
            $reporte = array(
                array("Query", $sqlcodemain),
                array("img1", '../../src/images/cabecera.png'),
                array("img2", '../../src/images/piepagina.png')
            );
            _adios_mysql();
            echo json_encode(array('datos' => $datos, 'query' => parametrosReporte($reporte)));
        }
        if ($json['origen'] == '2') {
            $datos = array();

            $sqlcodemain = "SELECT "
                    . "d.fecha,"
                    . "d.tipo,"
                    . "d.status,"
                    . "d.descripcion,"
                    . "d.codigo "
                    . "FROM ai_oficios d "
                    . "WHERE 1";

            if (isset($json['tipo']) && $json['tipo'] != '') {
                $sqlcodemain .= " AND d.tipo ='" . $json['tipo'] . "'";
            }
            if (isset($json['estatus']) && $json['estatus'] != '') {
                $sqlcodemain .= " AND d.status =" . $json['estatus'];
            }
            if (isset($json['OrigenDesde']) && $json['OrigenDesde'] != '') {
                $sqlcodemain .= " AND d.fecha >= '" . $json['OrigenDesde'] . "'";
            }
            if (isset($json['OrigenHasta']) && $json['OrigenHasta'] != '') {
                $sqlcodemain .= " AND d.fecha <= '" . $json['OrigenHasta'] . "'";
            }

            $sqlMain = mysql_query($sqlcodemain);

            $i = 0;
            while ($result = mysql_fetch_array($sqlMain)) {
                $color = false;
                switch ($result['status']) {
                    case 0: $st = "Espera";
                        $titulo = "En espera.";
                        break;
                    case 1: $st = "Activo";
                        $titulo = "Averiguación Abierta.";
                        break;
                    case 2: $st = "Cerrar";
                        $titulo = "Averiguación Finalizada.";
                        Break;
                    case 9: $st = "Eliminar";
                        $color = "red";
                        $titulo = "Descartada.";
                        break;
                }
                $datos[$i] = array('codigo' => $result['codigo'],
                    'fecha' => $result['fecha'],
                    'tipo' => $result['tipo'],
                    'descripcion' => $result['descripcion'],
                    'status' => '<span>' . iconosIntranet($st, $titulo, false, $color, false) . '</span>');
                $i++;
            }
            $reporte = array(
                array("Query", $sqlcodemain),
                array("img1", '../../src/images/cabecera.png'),
                array("img2", '../../src/images/piepagina.png')
            );
            _adios_mysql();
            echo json_encode(array('datos' => $datos, 'query' => parametrosReporte($reporte)));
        }
    }
}
?>