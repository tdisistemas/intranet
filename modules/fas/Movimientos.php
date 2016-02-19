<?php

include('../../conexiones_config.php');

if (isset($_GET['acc'])) {
    _bienvenido_mysql();
    decode_get2($_SERVER["REQUEST_URI"], 1);
    $cedula = _antinyeccionSQL($_GET['cedula']);
    $acc = _antinyeccionSQL($_GET['acc']);
    $mensaje = '';

    if ($acc == 'declaraciones') {
        $sqlcode = "INSERT INTO declaraciones_ARI(empleado,fecha_gen,periodo,status,carga,estimado_a,estimado_b,estimado_c,estimado_d,estimado_total,año,retencion) VALUES($cedula,NOW(),$periodo,0,$carga,$estimado_a,$estimado_b,$estimado_c,$estimado_d,$A,'$año',$monto)";
        $sql = mysql_query($sqlcode);
    }

    if ($acc == 'incluir') {
        $nombre1 = _antinyeccionSQL($_GET['nombre1']);
        $nombre2 = _antinyeccionSQL($_GET['nombre2']);
        $apellido1 = _antinyeccionSQL($_GET['apellido1']);
        $apellido2 = _antinyeccionSQL($_GET['apellido2']);
        $cedula_persona = _antinyeccionSQL($_GET['cedula_persona']);
        $fecha_nacimiento = _antinyeccionSQL($_GET['fecha_nacimiento']);
        $parentesco = _antinyeccionSQL($_GET['parentesco']);
        $motivo = _antinyeccionSQL($_GET['motivo']);
        $sexo = _antinyeccionSQL($_GET['sexo']);

        $sqlcode = "INSERT INTO fas_inclusion (primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, cedula_empleado, motivo, cedula, sexo, parentesco, fecha_nacimiento, status, fecha_creacion) "
                . "VALUES ('$nombre1', '$nombre2', '$apellido1', '$apellido2', $cedula, $motivo, $cedula_persona, '$sexo', '$parentesco', '$fecha_nacimiento', 0, now());";

        $sql = mysql_query($sqlcode);
        if($sql){
            $mensaje = "Exito";
        }else{
            $mensaje = "Error";
        }
        
        $acc = 'Verificar-Inclusiones';
    }
    if ($acc == 'incluir-registro') {
        $bandera = true;
        $json = json_decode($_GET['data']);

        mysql_query("START TRANSACTION");
        $codigoNuevo = mysql_fetch_array(mysql_query("SELECT consecutivo('RRHH','FAS'," . date('Y') . ")"));
        if ($codigoNuevo) {
            foreach ($json as $familiares) {
                $sqlcode = "UPDATE fas_inclusion SET status=1, codigo_movimiento='$codigoNuevo[0]' WHERE cedula_empleado=$cedula AND cedula= $familiares->cedula";
                $sql = mysql_query($sqlcode);

                if (!$sql) {
                    $bandera = false;
                    break;
                }
            }
        } else {
            $bandera = false;
        }

        if ($bandera) {
            mysql_query("COMMIT");
            $mensaje = 'Registro de Inclusión realizado con éxito.';
        } else {
            mysql_query("ROLLBACK");
            $mensaje = 'Error al registrar, por favor intentelo más tarde.';
        }

        $acc = 'Verificar-Inclusiones';
    }
    if ($acc == 'excluir') {
        $json = json_decode($_GET['data']);

        mysql_query("START TRANSACTION");
        $codigoNuevo = mysql_fetch_array(mysql_query("SELECT consecutivo('RRHH','FAS'," . date('Y') . ")"));
        if ($codigoNuevo) {

            foreach ($json as $familiares) {
                $sqlcode = "INSERT INTO fas_exclusion (cedula_empleado,cedula_familiar,motivo,codigo_movimiento,status,fecha_creacion) "
                        . "VALUES ($cedula, " . $familiares->cedula . ", " . $familiares->motivo . ",'$codigoNuevo[0]', 0, now())";
                $sql = mysql_query($sqlcode);
                $sqlcode2 = "UPDATE fas SET status = 1 WHERE cedula_empleado=$cedula AND cedula_familiar= $familiares->cedula";
                $sql2 = mysql_query($sqlcode2);
                if (!$sql || !$sql2) {
                    mysql_query("ROLLBACK");
                    $mensaje = 'Error al registrar, por favor intentelo más tarde.';
                    break;
                }
            }
            mysql_query("COMMIT");
            $mensaje = 'Registro de Exclusión realizado con éxito.';
            $acc = 'Verificar-Exclusiones';
        } else {
            mysql_query("ROLLBACK");
            $mensaje = 'Error al registrar, por favor intentelo más tarde.';
        }
    }
    if ($acc == 'Verificar-Exclusiones') {
        /*  Query de Verificacion  */
        $sqlSelect = "SELECT "
                . "f.id_fas,"
                . "d.cedula_familiar,"
                . "d.nombres,"
                . "d.parentesco,"
                . "f.status "
                . "FROM datos_familiares_rrhh d "
                . "left join fas f "
                . "on d.cedula_empleado=f.cedula_empleado "
                . "WHERE d.cedula_familiar=f.cedula_familiar "
                . "AND d.cedula_empleado= $cedula "
                . "AND d.parentesco!='titular' "
                . "AND f.status <= 1 ";

        $sqlConsulta = mysql_query($sqlSelect);
        $i = 0;
        $reporte = array();
        while ($result = mysql_fetch_array($sqlConsulta)) {
            $parametro = 'cedula=' . $cedula;
            $parametro .= '&fas=' . $result['id_fas'];
            $parametro .= '&cedula_familiar=' . $result['cedula_familiar'];
            $parametro .= '&nombre_familiar=' . $result['nombres'];
            $parametro .= '&parentesco=' . $result['parentesco'];
            $parametro = _desordenar($parametro);

            $reporte = array(
                array("cedulaE", $cedula)
            );

            $datos[$i] = array(
                'fas' => $result['id_fas'],
                'cedula_familiar' => $result['cedula_familiar'],
                'nombre_familiar' => $result['nombres'],
                'parentesco' => $result['parentesco'],
                'status' => $result['status'],
                'parametros' => $parametro,
                'reporte' => parametrosReporte($reporte)
            );
            $i++;
        }
        echo json_encode(array('datos' => $datos, 'campos' => $i, 'query' => $sqlSelect, 'mensaje' => $mensaje));
    }
    if ($acc == 'Verificar-Inclusiones') {
        /*  Query de Verificacion  */
        $sqlSelect = "SELECT "
                . "a.primer_nombre,"
                . "a.segundo_nombre,"
                . "a.primer_apellido,"
                . "a.segundo_apellido,"
                . "a.cedula,"
                . "a.parentesco,"
                . "b.descripcion as motivo,"
                . "a.status "
                . "FROM fas_inclusion a "
                . "INNER JOIN fas_IE_motivos b "
                . "ON a.motivo = b.id_motivo "
                . "WHERE a.cedula_empleado= $cedula "
                . "AND a.status <= 1 ";

        $sqlConsulta = mysql_query($sqlSelect);
        $i = 0;
        $reporte = array();
        while ($result = mysql_fetch_array($sqlConsulta)) {
            $parametro = 'cedula=' . $cedula;
            $parametro .= '&inclusion=' . $result['id_inclu'];
            $parametro = _desordenar($parametro);

            $reporte = array(
                array("cedulaE", $cedula)
            );

            $datos[$i] = array(
                'nombre' => $result['primer_nombre'] . ' ' . $result['segundo_nombre'] . ' ' . $result['primer_apellido'] . ' ' . $result['segundo_apellido'],
                'cedula_familiar' => $result['cedula'],
                'parentesco' => $result['parentesco'],
                'motivo' => $result['motivo'],
                'status' => $result['status'],
                'parametros' => $parametro,
                'reporte' => parametrosReporte($reporte)
            );
            $i++;
        }
        echo json_encode(array('datos' => $datos, 'campos' => $i, 'query' => $sqlSelect, 'mensaje' => $mensaje));
    }


    _adios_mysql();
}
?>