<?php

include('../../conexiones_config.php');

if (isset($_GET['acc'])) {
    _bienvenido_mysql();
    decode_get2($_SERVER["REQUEST_URI"], 1);
    $cedula = _antinyeccionSQL($_GET['cedula']);
    $acc = _antinyeccionSQL($_GET['acc']);
    $mensaje = '';


    if ($acc == 'Editables') {
        $campo = strtoupper(_antinyeccionSQL($_GET['campo']));
        $tipo = _antinyeccionSQL($_GET['tipo']);
        $id = _antinyeccionSQL($_GET['evento']);

        if ($tipo == 1) {
            $variable = 'diagnostico';
        } else {
            $variable = 'procedimiento';
        }

        $sqlcode = "UPDATE fas_eventos SET $variable = '$campo' WHERE id_evento = $id";

        $sql = mysql_query($sqlcode);
        if ($sql) {
            $sqlVerificar = "SELECT $variable FROM fas_eventos WHERE id_evento = $id";
            $sqlVer = mysql_fetch_array(mysql_query($sqlVerificar));

            $datos = $sqlVer[$variable];
            $mensaje = 'Exito';
        } else {
            $mensaje = "Error";
        }
    }
    if ($acc == 'incluir') {
        $cedula_beneficiario = _antinyeccionSQL($_GET['beneficiario']);
        $diagnostico = strtoupper(_antinyeccionSQL($_GET['diagnostico']));
        $procedimiento = strtoupper(_antinyeccionSQL($_GET['procedimiento']));
        $servicio = _antinyeccionSQL($_GET['servicio']);
        $especialidad = _antinyeccionSQL($_GET['especialidad']);

        $sqlcode = "INSERT INTO fas_eventos (cedula_empleado, cedula_beneficiario, diagnostico, procedimiento, servicio, especialidad, fecha_creacion, status) "
                . "VALUES ($cedula, $cedula_beneficiario, '$diagnostico', '$procedimiento', $servicio, $especialidad, now(),0);";

        $sql = mysql_query($sqlcode);
        if ($sql) {
            $mensaje = "Exito";
        } else {
            $mensaje = "Error";
        }

        $acc = 'Verificar-CartaAval';
    }
    if ($acc == 'Status') {
        $st = _antinyeccionSQL($_GET['st']);
        $id = _antinyeccionSQL($_GET['id']);
        $bandera = true;
        if ($st != 9) {
            $proveedor = _antinyeccionSQL($_GET['proveedor']);
            $beneficiario = _antinyeccionSQL($_GET['nombreBeneficiario']);
            $correoUsuarioFAS = _antinyeccionSQL($_GET['correoUsuario']);
            $correoTitular = _antinyeccionSQL($_GET['correoTitular']);
            $titularNombre = _antinyeccionSQL($_GET['nombreTitular']);
            $UsuarioFAS = _antinyeccionSQL($_GET['nombreUsuario']);
            $servicio = _antinyeccionSQL($_GET['servicio']);
            $titularNombreCompleto = _antinyeccionSQL($_GET['nombreTitular']) . ' ' . _antinyeccionSQL($_GET['apellidoTitular']);

            $monto = str_replace(".", "", _antinyeccionSQL($_GET['monto']));
            $monto = str_replace(",", ".", $monto);

            mysql_query("START TRANSACTION");
            $codigoNuevo = mysql_fetch_array(mysql_query("SELECT consecutivo('RRHH','FAS'," . date('Y') . ")"));
            if ($codigoNuevo) {
                $sqlcode = "UPDATE fas_eventos SET status = $st,monto = $monto,proveedor = $proveedor, codigo_evento = '$codigoNuevo[0]', aprobado_por=$cedula, fecha_aprobacion=NOW() WHERE id_evento=$id";
                $sql = mysql_query($sqlcode);

                if (!$sql) {
                    $bandera = false;
                }
            } else {
                $bandera = false;
            }

            if ($bandera) {
                mysql_query("COMMIT");
                $mensaje = 'La Carta Aval fue aprobada con éxito.';

                $mensajedelcorreo = "<img style='' src='http://192.168.0.5/iconos/encamail.jpg' /><br><br>"
                        . "<h4>Estimado, " . $titularNombreCompleto . "</h4>" . "<h4>Sirva la presente  para notificarle que el día de hoy ha sido aprobada "
                        . "su solicitud de ".$servicio." para el beneficiario <i>" . $beneficiario . "</i>, bajo el número: " . $codigoNuevo[0] . ".</h4>"
                        . "<p>Para descargar el documento, Ingrese a la Intranet y acceda al módulo FAS METRO. <br><br><i>".$UsuarioFAS."</i><br><i>Fondo Autoadministrado de Salud - FAS Metro</i>";
                _enviarmail($mensajedelcorreo, $titularNombreCompleto, trim($correoTitular), "Aprobación de ".$servicio." - FAS METRO", $correoUsuarioFAS, $UsuarioFAS);

            } else {
                mysql_query("ROLLBACK");
                $mensaje = 'Error en actualización, por favor intentelo más tarde.';
            }
        } else {
            $sqlcode = "UPDATE fas_eventos SET status = $st WHERE id_evento=$id";
            $sql = mysql_query($sqlcode);
            $mensaje = 'La Carta Aval fue rechazada.';
        }
        $acc = 'Verificar-CartaAval';
    }
    if ($acc == 'Verificar-CartaAval') {
        /*  Query de Verificacion  */
        $sqlSelect = "SELECT "
                . "a.id_evento,"
                . "a.fecha_creacion,"
                . "a.fecha_aprobacion,"
                . "a.codigo_evento,"
                . "a.diagnostico,"
                . "a.procedimiento,"
                . "a.monto,"
                . "b.nombres,"
                . "c.cedula,"
                . "c.ext_telefonica,"
                . "c.cargo,"
                . "c.gerencia,"
                . "c.nombre,"
                . "c.apellido,"
                . "a.cedula_beneficiario,"
                . "b.parentesco,"
                . "g.nombre as Proveedor,"
                . "g.rif,"
                . "g.direccion as P_direccion,"
                . "a.aprobado_por as FAS_cedula,"
                . "f.nombre as FAS_nombre,"
                . "f.apellido as FAS_apellido,"
                . "d.descripcion as Servicio,"
                . "a.servicio as Srv,"
                . "e.descripcion as Especialidad,"
                . "a.status "
                . "FROM fas_eventos a "
                . "INNER JOIN datos_familiares_rrhh b "
                . "on a.cedula_beneficiario=(CASE WHEN b.cedula_familiar = 0 THEN b.cedula_empleado ELSE b.cedula_familiar END) "
                . "INNER JOIN datos_empleado_rrhh c "
                . "on a.cedula_empleado= c.cedula "
                . "INNER JOIN fas_tipos_servicios d "
                . "on a.servicio= d.id_servicio "
                . "INNER JOIN fas_especialidad e "
                . "on a.especialidad= e.id "
                . "LEFT JOIN fas_proveedores g "
                . "on a.proveedor = g.id_proveedor "
                . "LEFT JOIN datos_empleado_rrhh f "
                . "on a.aprobado_por = f.cedula "
                . "WHERE b.cedula_empleado= $cedula ";

        $sqlConsulta = mysql_query($sqlSelect);
        $i = 0;
        $reporte = array();
        while ($result = mysql_fetch_array($sqlConsulta)) {
            $parametro = 'cedula=' . $cedula;
            $parametro .= '&evento=' . $result['id_evento'];
            $parametro = _desordenar($parametro);

            $procedimiento = $result['procedimiento'];
            $diagnostico = $result['diagnostico'];
            $especialidad = $result['Especialidad'];
            $cedula = $result['cedula'];
            $nombre = $result['nombre'] . ' ' . $result['apellido'];
            $cedula_beneficiario = $result['cedula_beneficiario'];
            $nombre_beneficiario = $result['nombres'];
            $parentesco = $result['parentesco'];
            $servicio = $result['Servicio'];
            $servicio_id = $result['Srv'];
            $fecha_cre = explode('-', $result['fecha_creacion']);
            $fecha_creacion = $fecha_cre[2] . '/' . $fecha_cre[1] . '/' . $fecha_cre[0];
            $proveedor_rep = $result['Proveedor'];
            $codigo = $result['codigo_evento'];
            $fecha_ap = explode('-', $result['fecha_aprobacion']);
            $fecha = $fecha_ap[1] . '/' . $fecha_ap[2] . '/' . $fecha_ap[0];
            $fecha_aprobado = $fecha_ap[2] . '/' . $fecha_ap[1] . '/' . $fecha_ap[0];
            $FAS_Empleado = $result['FAS_nombre'] . ' ' . $result['FAS_apellido'];

            $vence = strtotime('+30 day', strtotime($result['fecha_aprobacion']));
            $vence = date('Y-m-d', $vence);
            $venceArray = explode('-', $vence);
            $vence = $venceArray[2] . '/' . $venceArray[1] . '/' . $venceArray[0];

            $reporte = array(
                array("Srs", $proveedor_rep),
                array("titular", $nombre),
                array("cedula_titular", $cedula),
                array("cedula_beneficiario", $cedula_beneficiario),
                array("beneficiario", $nombre_beneficiario),
                array("parentesco", $parentesco),
                array("especialidad", $especialidad),
                array("procedimiento", $procedimiento),
                array("diagnostico", $diagnostico),
                array("tipo_de_servicio", $servicio),
                array("monto", $result['monto']),
                array("presupuesto", ''),
                array("fechas", $fecha_aprobado),
                array("fecha", $fecha),
                array("vence", $vence),
                array("codigo", $codigo)
            );

            switch ($result['status']) {
                case 0 :
                    $icono = 'history';
                    $color = 'gray';
                    $titulo = 'En espera.';
                    break;
                case 1 :
                    $icono = 'check';
                    $color = 'green';
                    $titulo = 'Aprobada.';
                    break;
                case 9 :
                    $icono = 'ban';
                    $color = 'red';
                    $titulo = 'Rechazada.';
                    break;
            }

            $datos[$i] = array(
                'nombre' => $result['nombres'] . ' (' . $result['cedula_beneficiario'] . ')',
                'parentesco' => $result['parentesco'],
                'status' => '<i class="fa fa-' . $icono . '" title="' . $titulo . '" style="color: ' . $color . '"> </i>',
                'fecha' => $result['fecha_creacion'],
                'st' => $result['status'],
                'parametros' => $parametro,
                'reporte' => parametrosReporte($reporte)
            );
            $i++;
        }
    }
    echo json_encode(array('datos' => $datos, 'campos' => $i, 'query' => '', 'mensaje' => $mensaje));


    _adios_mysql();
}
?>