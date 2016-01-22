<?php

include('../../conexiones_config.php');

function retenciones_ARI($A, $UT, $carga) {
    $K = $B = $E = $F = $G = $H = $I = $J = 0;
    $B = $A / $UT;
    $E = 774;
    $F = $B - $E;
    switch ($F) {
        case ($F <= 1000):
            $T = 6;
            $cant = 0;
            break;
        case (1000 > $F):
        case ($F <= 1500):
            $T = 9;
            $cant = 30;
            break;
        case (1500 > $F):
        case ($F <= 2000):
            $T = 12;
            $cant = 75;
            break;
        case (2000 > $F):
        case ($F <= 2500):
            $T = 16;
            $cant = 155;
            break;
        case (2500 > $F):
        case ($F <= 3000):
            $T = 20;
            $cant = 255;
            break;
        case (3000 > $F):
        case ($F <= 4000):
            $T = 24;
            $cant = 375;
            break;
        case (4000 > $F):
        case ($F <= 6000):
            $T = 29;
            $cant = 575;
            break;
        case ($F > 6000):
            $T = 34;
            $cant = 875;
            break;
    }
    $G = ($F * $T / 100) - $cant;
    $H = 10 + (10 * $carga);
    $I = $G - $H;
    $J = ($I / $B) * 100;
    $K = number_format((($I * $UT * 100) / ($A - 0)), 2);
    return $K;
}

if (isset($_GET['acc'])) {
    _bienvenido_mysql();
    decode_get2($_SERVER["REQUEST_URI"], 1);
    $cedula = _antinyeccionSQL($_GET['cedula']);
    $periodo = _antinyeccionSQL($_GET['periodo']);
    $año = _antinyeccionSQL($_GET['año']);
    $carga = _antinyeccionSQL($_GET['carga']);
    $id = _antinyeccionSQL($_GET['declaracion']);
    $UT = _antinyeccionSQL($_GET['UT']);
    $rif = _antinyeccionSQL($_GET['Rif']);
    $nombre = _antinyeccionSQL($_GET['Nombre']);
    $codigo = _antinyeccionSQL($_GET['codigo']);

    if (isset($_GET['ingreso']) && $_GET['ingreso'] != '') {
        $estimado_a = str_replace(".", "", _antinyeccionSQL($_GET['ingreso']));
        $estimado_a = str_replace(",", ".", $estimado_a);
        $estimado_a = $estimado_a < 0 ? -1 * $estimado_a : $estimado_a;
        $estimado_b = 0;
        $estimado_c = 0;
        $estimado_d = 0;
    }


    if ($_GET['acc'] == 'declaraciones') {
        $A = $estimado_a + $estimado_b + $estimado_c + $estimado_d;
        $K = retenciones_ARI($A, $UT, $carga);
        $monto = $K < 0 ? 0 : $K;
        $sqlcode = "INSERT INTO declaraciones_ARI(empleado,fecha_gen,periodo,status,carga,estimado_a,estimado_b,estimado_c,estimado_d,estimado_total,año,retencion) VALUES($cedula,NOW(),$periodo,0,$carga,$estimado_a,$estimado_b,$estimado_c,$estimado_d,$A,'$año',$monto)";
        $sql = mysql_query($sqlcode);
    }
    if ($_GET['acc'] == 'confirmar') {

        $codigo = mysql_fetch_array(mysql_query('SELECT consecutivo("RRHH","ARI",' . $año . ')'));
        $sqlcode = "UPDATE declaraciones_ARI SET status = 1, fecha_conf = NOW(), codigo = '$codigo[0]' WHERE idARI = $id";
        $sql = mysql_query($sqlcode);
    }
    if ($_GET['acc'] == 'modificar') {

        $A = $estimado_a + $estimado_b + $estimado_c + $estimado_d;
        $K = retenciones_ARI($A, $UT, $carga);
        $monto = $K < 0 ? 0 : $K;
        $sqlcode = "UPDATE declaraciones_ARI "
                . "SET carga = $carga, "
                . "estimado_a = $estimado_a, "
                . "estimado_b = $estimado_b, "
                . "estimado_c = $estimado_c, "
                . "estimado_d = $estimado_d, "
                . "retencion = $monto, "
                . "estimado_total = $A "
                . "WHERE idARI = $id";

        $sql = mysql_query($sqlcode);
    }

    /*  Verificacion */
    $sqlSelect = "Select idARI,"
            . "a.retencion,"
            . "a.fecha_gen,"
            . "a.fecha_conf,"
            . "a.periodo,"
            . "a.estimado_a,"
            . "a.estimado_b,"
            . "a.estimado_c,"
            . "a.estimado_d,"
            . "a.carga,"
            . "a.status,"
            . "a.retencion,"
            . "a.año,"
            . "b.unidad_tributaria,"
            . "a.codigo "
            . "FROM declaraciones_ARI a "
            . "INNER JOIN variables_fiscales b "
            . "ON a.periodo = b.periodo "
            . "AND a.año = b.año "
            . "WHERE a.status=1 "
            . "AND a.empleado=$cedula "
            . "AND a.periodo = $periodo "
            . "AND a.año=$año "
            . "ORDER BY fecha_gen";

    $sqlConsulta = mysql_query($sqlSelect);
    $count = mysql_num_rows($sqlConsulta);
    if ($count == 0) {
        $sqlSelect = "Select idARI,"
                . "a.retencion,"
                . "a.fecha_gen,"
                . "a.fecha_conf,"
                . "a.periodo,"
                . "a.estimado_a,"
                . "a.estimado_b,"
                . "a.estimado_c,"
                . "a.estimado_d,"
                . "a.carga,"
                . "a.status,"
                . "a.retencion,"
                . "a.año,"
                . "b.unidad_tributaria,"
                . "a.codigo "
                . "FROM declaraciones_ARI a "
                . "INNER JOIN variables_fiscales b "
                . "ON a.periodo=b.periodo "
                . "AND a.año = b.año "
                . "WHERE a.status=0 "
                . "AND a.empleado=$cedula "
                . "AND a.periodo=$periodo "
                . "AND a.año=$año "
                . "ORDER BY fecha_gen";

        $sqlConsulta = mysql_query($sqlSelect);
    }
    $i = 0;
    $confir = 0;
    $reporte = array();
    while ($result = mysql_fetch_array($sqlConsulta)) {
        $confir = 1;
        $parametro = 'cedula=' . $cedula;
        $parametro .= '&declaracion=' . $result['idARI'];
        $parametro .= '&periodo=' . $result['periodo'];
        $parametro .= '&año=' . $result['año'];
        $parametro .= '&UT=' . $result['unidad_tributaria'];
        $parametro .= '&Rif=' . $rif;
        $parametro .= '&Nombre=' . $nombre;
        $parametro .= '&codigo=' . $codigo;
        $parametro = _desordenar($parametro);


        $color = false;
        switch ($result['status']) {
            case 0: $st = "Espera";
                $titulo = "En espera.";
                break;
            case 1: $st = "Activo";
                $titulo = "Declaración Confirmada.";
                break;
        }

        if ($result['status'] == '1') {
            $confir = 2;
        }

        $datos[$i] = array('generado' => date("d-m-Y", strtotime($result['fecha_gen'])),
            'confirmado' => $result['fecha_conf'] == '0000-00-00' ? '--' : date("d-m-Y", strtotime($result['fecha_conf'])),
            'estimado' => number_format($result['estimado_a'], 2, ',', '.'),
            'monto' => $result['estimado_a'],
            'carga' => $result['carga'],
            'periodo' => $result['periodo'],
            'status' => '<span>' . iconosIntranet($st, $titulo, false, $color, false) . '</span>',
            'codigo' => $result['codigo'] == '' ? '--' : $result['codigo'],
            'retencion' => $result['retencion'],
            'declaracion' => $parametro,
        );
        $reporte = array(
            array("bs1", $result['estimado_a']),
            array("bs2", $result['estimado_b']),
            array("bs3", $result['estimado_c']),
            array("bs4", $result['estimado_d']),
            array("ano", $result['año']),
            array("ut", $result['unidad_tributaria']),
            array("codigo", $result['codigo']),
            array("periodo", $result['periodo']),
            array("rif", $rif),
            array("cf", $result['carga']),
            array("cedula", $cedula),
            array("confirmado", $result['fecha_conf'] == '0000-00-00' ? '--' : date("d-m-Y", strtotime($result['fecha_conf']))),
            array("APyNOM", $nombre)
        );
        $i++;
    }
    _adios_mysql();
    echo json_encode(array('datos' => $datos, 'campos' => $i, 'confirmado' => $confir, 'reporte' => parametrosReporte($reporte), 'resultado' => $K));
}
?>