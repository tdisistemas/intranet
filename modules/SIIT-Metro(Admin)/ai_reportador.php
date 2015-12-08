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
    <h2>Reportes Asuntos Internos</h2>
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
                $sqlcodeInvest = "SELECT "
                        . "a.id_invest,"
                        . "b.nombre,"
                        . "b.apellido "
                        . "FROM ai_investigadores a "
                        . "INNER JOIN datos_empleado_rrhh b ON a.cedula_invest = b.cedula "
                        . "WHERE a.status = 0";

                $sqlInvest = mysql_query($sqlcodeInvest);

                $sqlcodeSitios = "SELECT "
                        . "ubicacion_laboral "
                        . "FROM datos_empleado_rrhh "
                        . "WHERE 1 "
                        . "GROUP BY ubicacion_laboral";

                $sqlSitios = mysql_query($sqlcodeSitios);

                $sqlCodeRemitidos = "SELECT "
                        . "id_inst,"
                        . "Nombre,"
                        . "Iniciales "
                        . "FROM cuerpos_seguridad "
                        . "WHERE 1";

                $sqlRemitidos = mysql_query($sqlCodeRemitidos);
                ?>
            </div> <!-- .widget-content -->

        </div> <!-- .widget -->	
    </div> <!-- .grid -->
    <div class="row"> 
        <form class="form uniformForm validateForm" id="from_envio_pe" name="from_envio_pe" method="post" >
            <div class="grid-24">
                <div class="grid-18">
                    <div class="widget">
                        <div class="widget-header">
                            <span class="icon-layers"></span>
                            <h3>Filtros</h3>
                        </div>
                        <div class="widget-content">
                            <div class="row-fluid">
                                <div class="grid-8">
                                    <div class="field-group">								
                                        <label style="color:#B22222">Origen:</label>
                                        <div class="field">
                                            <select id="origen" name="origen">
                                                <option selected value=""> Todos </option>
                                                <option value="1">Denuncia</option>
                                                <option value="2">Oficio</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="field-group">								
                                        <label style="color:#B22222">Remitido:</label>
                                        <div class="field">
                                            <select id="remitido" name="remitido">
                                                <option selected value=""> No Remitido </option>
                                                <?php
                                                while ($rowRemitido = mysql_fetch_array($sqlRemitidos)) {
                                                    ?>
                                                    <option value="<?= $rowRemitido['id_inst'] ?>"> <?= $rowRemitido['Iniciales'] ?> </option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="field-group">								
                                        <label style="color:#B22222">Investigador:</label>
                                        <div class="field">
                                            <select id="investigador" name="investigador">
                                                <option selected value=""> Todos </option>
                                                <?php
                                                while ($rowInvest = mysql_fetch_array($sqlInvest)) {
                                                    ?>
                                                    <option value="<?= $rowInvest['id_invest'] ?>"> <?= $rowInvest['nombre'] . ' ' . $rowInvest['apellido'] ?> </option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div> <!-- .row-fluid -->
                                <div class="grid-8">
                                    <div class="field-group">								
                                        <label style="color:#B22222">Sitio:</label>
                                        <div class="field">
                                            <select id="sitio" name="sitio">
                                                <option selected value=""> Todos </option>
                                                <?php
                                                while ($rowSitios = mysql_fetch_array($sqlSitios)) {
                                                    if ($rowSitios['ubicacion_laboral'] != '') {
                                                        $cadena = explode('-', $rowSitios['ubicacion_laboral']);
                                                        ?>
                                                        <option value="<?= $cadena[0] ?>"> <?= $rowSitios['ubicacion_laboral'] ?> </option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="field-group">								
                                        <label style="color:#B22222">Estatus:</label>
                                        <div class="field">
                                            <select id="estatus" name="estatus">
                                                <option selected value=""> Todos </option>
                                                <option value="0"> En Progreso </option>
                                                <option value="1"> En Revisión </option>
                                                <option value="2"> Remitida </option>
                                                <option value="3"> Finalizada </option>
                                                <option value="9"> Archivada </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid-8">
                                    <div class="field-group">								
                                        <label style="color:#B22222">Fecha:</label>
                                        <div class="field">
                                            <select id="Fecha" name="Fecha" onchange="SeleccionarFecha(this)">
                                                <option selected value=""> Ninguno </option>
                                                <option value="0">Creación</option>
                                                <option value="1">Revisión</option>
                                                <option value="2">Remitida</option>
                                                <option value="3">Finalizada</option>
                                                <option value="4">Archivada</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="field-group" id="zonaDesde" style="display: none">								
                                        <label style="color:#B22222">Desde (>):</label>
                                        <div class="field">
                                            <input id="FechaDesde" class="datepicker" name="FechaDesde" value="" style="min-width: 20%; max-width: 80%;" readonly>
                                        </div>
                                    </div>
                                    <div class="field-group" id="zonaHasta" style="display: none">								
                                        <label style="color:#B22222">Hasta (<):</label>
                                        <div class="field">
                                            <input id="FechaHasta" class="datepicker" name="FechaHasta" value="" style="min-width: 20%; max-width: 80%;" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid-24" style="text-align: center">
                                    <div class="field-group">								
                                        <div class="actions" style="text-aling:left">
                                            <button type="button" class="btn btn-error" onclick="javascript:Reportador();">Reportar</button>
                                            <input type="button" name="Atras" onclick="javascript:window.history.back();" class="btn btn-error" value="Regresar" />
                                        </div> <!-- .actions -->
                                    </div> <!-- .field-group -->
                                </div>
                            </div> <!-- .row-fluid -->
                        </div> <!-- .widget-content -->
                    </div> <!-- .widget -->	
                </div> <!-- .grid -->	
                <div class="grid-6">
                    <div id="gettingStarted" class="box">
                        <h3>Estimado, <?php echo $usuario_datos['nombre'] . " " . $usuario_datos['apellido']; ?></h3>
                        <p>En esta sección podrá realizar reportes de las averiguaciones.</p>
                        <table>
                            <thead>
                                <tr>
                                    <th></th>
                                    <th style="font-weight:bold">Estatus de Averiguación</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><i class="fa fa-check"></i></td>
                                    <td>- Abierta.</td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-edit"></i></td>
                                    <td>- En Revisión.</td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-sign-out"></i></td>
                                    <td>- Remitida.</td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-lock"></i></td>
                                    <td>- Finalizada.</td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-lock" style="color: red"></i></td>
                                    <td>- Archivada.</td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <div class="box plain">
                            <a class="btn btn-primary btn-large dashboard_add" onclick="javascript:window.history.back();">Regresar</a>
                        </div>
                    </div>
                </div>
            </div> <!-- .grid -->	
            <div class="grid-24">
                <div class="widget widget-table">
                    <div class="widget-header">
                        <span class="icon-list"></span>
                        <h3 class="icon chart">Reporte de Averiguaciones</h3>
                    </div>
                    <div class="widget-content">
                        <table class="table table-bordered table-striped data-table">
                            <thead>
                                <tr>
                                    <th style="width:10%">Código</th>
                                    <th style="width:10%">Origen</th>
                                    <th style="width:10%">Abierta</th>
                                    <th style="width:10%">Revisión</th>
                                    <th style="width:10%">Remitida</th>
                                    <th style="width:10%">Finalizada</th>
                                    <th style="width:10%">Archivada</th>
                                    <th style="width:5%">Estatus</th>
                                    <th style="width:25%">Investigador</th>
                                </tr>
                            </thead>
                            <tbody id='CuerpoReporte'>
                            </tbody>
                        </table>
                    </div> <!-- .widget-content -->
                </div>
            </div> <!-- .grid -->
        </form>
    </div><!-- .row -->
</div><!-- .container-->

<script type="text/javascript">
    window.onload = function () {
        espejo_gerencia();
    }
    function SeleccionarFecha(objeto) {
        var desde = document.getElementById('zonaDesde');
        var hasta = document.getElementById('zonaHasta');
        if (objeto.value != '') {
            desde.style.display = '';
            hasta.style.display = '';
        } else {
            desde.style.display = 'none';
            hasta.style.display = 'none';
        }
    }

    function Reportador() {
        var org = document.getElementById('origen').value;
        var invest = document.getElementById('investigador').value;
        var sit = document.getElementById('sitio').value;
        var remit = document.getElementById('remitido').value;
        var st = document.getElementById('estatus').value;
        var fecha = document.getElementById('Fecha').value;
        var desde = document.getElementById('FechaDesde').value;
        var hasta = document.getElementById('FechaHasta').value;

        $.ajax({
            url: 'modules/SIIT-Metro(Admin)/Reportador.php',
            dataType: 'JSON',
            method: 'POST',
            beforeSend: function () {
                $('.data-table').dataTable().fnClearTable();
            },
            data: {
                acc: 'Aver',
                origen: org,
                investigador: invest,
                sitio: sit,
                remitido: remit,
                estatus: st,
                Fecha: fecha,
                FechaDesde: desde,
                FechaHasta: hasta
            },
            success: function (data) {
                var datos = {
                    investigador: '',
                    codigo_ave: '',
                    origen: '',
                    fecha: '',
                    fecha_st_1: '',
                    fecha_st_2: '',
                    fecha_st_3: '',
                    fecha_st_9: '',
                    status: {
                        st: '',
                        titulo: '',
                        color: ''
                    }
                };
                var aux = 0;
                var lista = '';
                while (aux < data.campos)
                {
                    datos.investigador = data.datos[aux].investigador;
                    datos.codigo_ave = data.datos[aux].codigo_ave;
                    datos.origen = data.datos[aux].origen;
                    datos.fecha = data.datos[aux].fecha;
                    datos.fecha_st_1 = data.datos[aux].fecha_st_1;
                    datos.fecha_st_2 = data.datos[aux].fecha_st_2;
                    datos.fecha_st_3 = data.datos[aux].fecha_st_3;
                    datos.fecha_st_9 = data.datos[aux].fecha_st_9;
                    datos.status.st = data.datos[aux].status[0];
                    datos.status.titulo = data.datos[aux].status[2];
                    datos.status.color = data.datos[aux].status[1];
                    lista += '<tr class="gradeA"> \n\
                                    <td>' + datos.codigo_ave + '</td>\n\
                                    <td>' + datos.origen + '</td>\n\
                                    <td style="text-align: center">' + datos.fecha + '</td>\n\
                                    <td style="text-align: center">' + datos.fecha_st_1 + '</td>\n\
                                    <td style="text-align: center">' + datos.fecha_st_2 + '</td>\n\
                                    <td style="text-align: center">' + datos.fecha_st_3 + '</td>\n\
                                    <td style="text-align: center">' + datos.fecha_st_9 + '</td>\n\
                                    <td style="text-align: center"><span><i class="fa fa-' + datos.status.st + '" title="' + datos.status.titulo + '" style="cursor: pointer; font-size: 15px; color: ' + datos.status.color + '" ></i></span></td>\n\
                                    <td>' + datos.investigador + '</td>\n\
                            </tr>';
                    aux++;
                }
                document.getElementById("CuerpoReporte").innerHTML = lista;
                $(".data-table").dataTable({
                    "bDestroy": true,
                    "bJQueryUI": true,
                    "sPaginationType": "full_numbers"
                });
            },
        });
    }

    $(function () {
        $.datepicker.setDefaults($.datepicker.regional["es"]);
        $("#FechaDesde").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "2014:2020",
            onSelect: function (fecha, event) {
                $("#FechaHasta").datepicker("option", "minDate", fecha)
            }
        });
        $("#FechaHasta").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "2014:2020"
        });
    });

</script>