<?php
if (array_pop(explode('/', $_SERVER['PHP_SELF'])) != 'dashboard.php') {
    header("Location: ../../dashboard.php");
}
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
    notificar("Usted no tiene permisos para esta Seccion/Modulo", "dashboard.php?data=notificar", "notify-error");
    _wm($usuario_datos[9], 'Acceso Denegado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
}
_wm($usuario_datos[9], 'Acceso Autorizado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
?>

<script type="text/javascript">
    function espejo_gerencia() {
        var myarr, ubi, a, b, c;
        ubi = document.getElementById('gerencia').value;
        myarr = ubi.split(" - ");
        a = myarr[2];
        b = myarr[0];
        c = myarr[1];
        document.getElementById('visor_gerencia').innerHTML = '<b>Codigo: </b> ' + a + '<br /><b>Gerencia: </b>' + b + '<br /><b>Ubicacion: </b>' + c;
    }
</script>

<style>
    .field{
        width: 100%;
    }

    .Tarjeta{
        text-align: center; 
        background-color: #EBEBEB; 
        border-radius: 5px 5px 5px 5px; 
        font-size: 12px; 
        padding: 5px;
        box-shadow: 2px 2px 5px #999;
    }

    div.selector {
        width:85%;
    }

    div.selector span {
        width:78%;
    }
    select {
        width:100%;
    }
</style>

<div id="contentHeader">
    <h2>FAS Metro - Admin</h2>
</div> <!-- #contentHeader -->	
<div class="container">
    <?php
    include('notificador.php');
    decode_get2($_SERVER["REQUEST_URI"], 2);
    _bienvenido_mysql();
    ?>
    <div class="grid-24">	
        <div class="widget widget-plain">

            <div class="widget-content">

                <?php
                $sqlSelect = "SELECT "
                        . "a.id_evento,"
                        . "a.fecha_creacion,"
                        . "b.nombres,"
                        . "c.nombre,"
                        . "c.apellido,"
                        . "a.cedula_beneficiario,"
                        . "b.parentesco,"
                        . "d.descripcion as Servicio,"
                        . "a.status "
                        . "FROM fas_eventos a "
                        . "INNER JOIN datos_familiares_rrhh b "
                        . "on a.cedula_beneficiario=(CASE WHEN b.cedula_familiar = 0 THEN b.cedula_empleado ELSE b.cedula_familiar END) "
                        . "INNER JOIN datos_empleado_rrhh c "
                        . "on a.cedula_empleado= c.cedula "
                        . "INNER JOIN fas_tipos_servicios d "
                        . "on a.servicio= d.id_servicio "
                        . "WHERE a.status=0 ";

                $sqlContadores = "SELECT SUM(CASE WHEN servicio = 2 THEN 1 ELSE 0 END) AS carta_a,SUM(CASE WHEN servicio = 1 THEN 1 ELSE 0 END) AS emergencia FROM fas_eventos WHERE status=0";
                $sqlCount = mysql_query($sqlContadores);
                $contadores = mysql_fetch_array($sqlCount);


                $sqlConsulta = mysql_query($sqlSelect);
                $a = mysql_num_rows($sqlConsulta);
                ?>
            </div> <!-- .widget-content -->

        </div> <!-- .widget -->	
    </div> <!-- .grid -->
    <div class="row"> 
        <form class="form uniformForm validateForm" id="from_envio_pe" name="from_envio_pe" method="post" action="dashboard.php?data=asuntoi" >
            <div class="grid-18">
                <div style="" class="grid-7 dashboard_report first activeState">
                    <div class="pad" align="center">
                        <span class="value"><?php echo $a; ?></span> Total de Servicios Pendientes
                    </div> <!-- .pad -->
                </div>
                <div style="" class="grid-7 dashboard_report defaultState">
                    <div class="pad" align="center">
                        <span class="value"><?php echo $contadores['carta_a'] == '' ? 0 : $contadores['carta_a']; ?></span> Total de Cartas Avales Pendientes
                    </div> <!-- .pad -->
                </div>
                <div style="display: none" class="grid-7 dashboard_report defaultState">
                    <div class="pad" align="center">
                        <span class="value"><?php echo $contadores['emergencia'] == '' ? 0 : $contadores['emergencia']; ?></span> Total de Emergencias Pendientes
                    </div> <!-- .pad -->
                </div>
                <div class="widget widget-table">
                    <div class="widget-header">
                        <span class="icon-list"></span>
                        <h3 class="icon chart">Servicios</h3>
                    </div>
                    <div class="widget-content">
                        <table class="table table-bordered table-striped data-table">
                            <thead>
                                <tr>
                                    <th style="width:25%">Titular</th>
                                    <th style="width:30%">Beneficiario</th>
                                    <th style="width:15%">Servicio</th>
                                    <th style="width:10%">Fecha</th>
                                    <th style="width:10%">Estatus</th>
                                    <th style="width:10%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = mysql_fetch_array($sqlConsulta)) {
                                    $fecha = explode('-', $row['fecha_creacion']);
                                    $fecha_creacion = $fecha[2] . '/' . $fecha[1] . '/' . $fecha[0];
                                    $color = false;
                                    switch ($row['status']) {
                                        case 0: $st = "Espera";
                                            $titulo = 'En Espera.';
                                            break;
                                        case 1: $st = "Activo";
                                            $titulo = 'Aprobada.';
                                            break;
                                        case 9: $st = "Inactivo";
                                            $titulo = 'Descartada.';
                                            break;
                                    }
                                    ?>
                                    <tr class="gradeA">
                                        <td style="vertical-align: middle"><?php echo $row['nombre'] . ' ' . $row['apellido'] ?></td>
                                        <td><?php echo $row['nombres'] ?></td>
                                        <td><?php echo $row['Servicio'] ?></td>
                                        <td><?php echo $fecha_creacion ?></td>
                                        <td style="text-align: center"><span><?php echo iconosIntranet($st, $titulo, false, $color, false) ?></span></td>
                                        <td class="center">
                                            <?php
                                            $parametros = 'id=' . $row["id_evento"];
                                            $parametros = _desordenar($parametros);
                                            ?>  
                                            <a href="dashboard.php?data=Fas-CartaAval-info&flag=1&<?php echo $parametros; ?>" id="editar" title="Información" >
                                                <?php echo iconosIntranet('Informacion', 'Información', true, 'black', false) ?>
                                            </a>
                                        </td>
                                    </tr>									
                                    <?php
                                }
                                ?> 
                            </tbody>
                        </table>
                    </div> <!-- .widget-content -->
                </div>
            </div> <!-- .grid -->	
            <div class="grid-6">
                <div id="gettingStarted" class="box">
                    <h3>Estimado, <?php echo $usuario_datos['nombre'] . " " . $usuario_datos['apellido']; ?></h3>
                    <p>En esta sección podrá acceder al panel de control del módulo Fas - Metro, así como visualizar la lista de las eventos registrados pendientes a revisión.</p>

                    <br>
                    <div class="box plain">
                        <a class="btn btn-primary btn-large dashboard_add" onclick="javascript:window.history.back();">Regresar</a>
                    </div>
                </div>
            </div>
        </form>
    </div><!-- .row -->
</div><!-- .container-->

<script type="text/javascript">
    window.onload = function () {
        espejo_gerencia();
    }
</script>