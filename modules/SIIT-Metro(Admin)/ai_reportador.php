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
    
    .Campo-Tarjeta{
        border: 0.5px solid #B22222; 
        padding: 10px 0px 0px 10px; 
        border-radius: 5px; 
        box-shadow: 5px 5px 5px rgba(0,0,0,0.5);
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
    .centrado{
        text-align: center;
        vertical-align: middle;
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
        <div class="grid-24">
            <div class="grid-18">
                <div class="widget">
                    <div class="widget-header">
                        <span class="icon-layers"></span>
                        <h3>Filtros</h3>
                    </div>
                    <div class="widget-content">
                        <div class="row-fluid">
                            <div class="grid-24 form uniformForm">
                                <div class="grid-8">
                                    <div class="field-group Campo-Tarjeta"> 								
                                        <label style="color:#B22222">Tipos de Reportes:</label>
                                        <div class="field" style="text-align: center">
                                            <select class="form-control" id="reportes" name="reportes" onchange="javascript:TiposdeReportes(this)">
                                                <option selected value="1"> Averiguaciones </option>
                                                <option value="2"> Origenes </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form class="form uniformForm validateForm" id="from_envio_pe" name="from_envio_pe" method="post" >
                                <div class="grid-24 Averiguacion">
                                    <div class="grid-2">
                                    </div>
                                    <div class="grid-6">
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
                                    <div class="grid-6">
                                        <div class="field-group">								
                                            <label style="color:#B22222">Fecha:</label>
                                            <div class="field">
                                                <select id="Fecha" name="Fecha" onchange="SeleccionarFecha(this)">
                                                    <option selected value=""> Ninguno </option>
                                                    <option value="0">Creación</option>
                                                    <option value="1">Revisión</option>
                                                    <option value="2">Remitida</option>
                                                    <option value="3">Finalizada</option>
                                                    <option value="9">Archivada</option>
                                                </select>
                                            </div>
                                        </div>
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
                                    <div class="grid-5" id="zonaDesde" style="display: none">
                                        <div class="field-group">								
                                            <label style="color:#B22222">Desde (>):</label>
                                            <div class="field">
                                                <input id="FechaDesde" class="datepicker" name="FechaDesde" value="" style="min-width: 20%; max-width: 80%;" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-5" id="zonaHasta" style="display: none">
                                        <div class="field-group">								
                                            <label style="color:#B22222">Hasta (<):</label>
                                            <div class="field">
                                                <input id="FechaHasta" class="datepicker" name="FechaHasta" value="" style="min-width: 20%; max-width: 80%;" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid-24 Origen" style="display: none">
                                    <div class="grid-4">
                                    </div>
                                    <div class="grid-8">
                                        <div class="field-group">								
                                            <label style="color:#B22222">Origen:</label>
                                            <div class="field">
                                                <select id="tipoorigen" name="tipoorigen">
                                                    <option selected value="1">Denuncia</option>
                                                    <option value="2">Oficio</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="field-group">								
                                            <label style="color:#B22222">Tipos:</label>
                                            <div class="field">
                                                <select id="tipo" name="tipo">
                                                    <option selected value=""> Todos </option>
                                                    <option value="Verbal">Verbal</option>
                                                    <option value="Escrita">Escrita</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="field-group">								
                                            <label style="color:#B22222">Estatus:</label>
                                            <div class="field">
                                                <select id="origen_st" name="origen_st">
                                                    <option selected value=""> Todos </option>
                                                    <option value="0"> En espera </option>
                                                    <option value="1"> Averiguación Abierta </option>
                                                    <option value="2"> Averiguación Finalizada </option>
                                                    <option value="9"> Descartado </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div> <!-- .row-fluid -->
                                    <div class="grid-5">
                                        <div class="field-group">								
                                            <label style="color:#B22222">Desde (>):</label>
                                            <div class="field">
                                                <input id="OrigenDesde" class="datepicker" name="OrigenDesde" value="" style="min-width: 20%; max-width: 80%;" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-5">
                                        <div class="field-group">								
                                            <label style="color:#B22222">Hasta (<):</label>
                                            <div class="field">
                                                <input id="OrigenHasta" class="datepicker" name="OrigenHasta" value="" style="min-width: 20%; max-width: 80%;" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid-24" style="text-align: center">
                                    <div class="field-group">								
                                        <div class="actions" style="text-aling:left">
                                            <button type="button" class="btn btn-error" onclick="javascript:Reportador();">Reportar</button>
                                            <input type="reset" name="Limpiar" onclick="javascript:LimpiarCampos();" class="btn btn-error" value="Limpiar" />
                                        </div> <!-- .actions -->
                                    </div> <!-- .field-group -->
                                </div>
                            </form>
                        </div> <!-- .row-fluid -->
                    </div> <!-- .widget-content -->
                </div> <!-- .widget -->	
            </div> <!-- .grid -->	
            <div class="grid-6">
                <div id="gettingStarted" class="box">
                    <h3>Estimado, <?php echo $usuario_datos['nombre'] . " " . $usuario_datos['apellido']; ?></h3>
                    <p>En esta sección podrá realizar reportes de las averiguaciones, las denuncias y/o los oficios.</p>
                    <div class="Averiguacion">
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
                    </div>
                    <div class="Origen" style="display: none">
                        <table>
                            <thead>
                                <tr>
                                    <th></th>
                                    <th style="font-weight:bold">Estatus de Denuncias/Oficios</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><i class="fa fa-clock-o"></i></td>
                                    <td>- En Espera.</td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-trash"></i></td>
                                    <td>- Descartado.</td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-check"></i></td>
                                    <td>- Averiguación Abierta.</td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-lock"></i></td>
                                    <td>- Averiguación Finalizada.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div class="box plain">
                        <a class="btn btn-primary btn-large dashboard_add" onclick="javascript:window.history.back();">Regresar</a>
                    </div>
                </div>
            </div>
        </div> <!-- .grid -->	
        <div class="grid-24" id="Grid-Tabla" style="display: none">
            <div class="widget widget-table">
                <div class="widget-header">
                    <span class="icon-list"></span>
                    <h3 class="icon chart" id="Nombre-Reporte"></h3>
                </div>
                <div class="widget-content" id='ZonaTable'>

                </div> <!-- .widget-content -->
            </div>
        </div> <!-- .grid -->
    </div><!-- .row -->
</div><!-- .container-->

<script type="text/javascript">
    window.onload = function () {
        espejo_gerencia();
    }

    function TiposdeReportes(obj) {
        if (obj.value == '1') {
            Mostrar('.Averiguacion');
            Ocultar('.Origen');
        }
        if (obj.value == '2') {
            Mostrar('.Origen');
            Ocultar('.Averiguacion');
        }
    }

    function Ocultar(obj) {
        $(obj).animate({opacity: 0, height: "hide"}, 500);
    }
    function Mostrar(obj) {
        $(obj).animate({opacity: 1, height: "show"}, 500);
    }

    function LimpiarCampos() {

        $("#OrigenHasta").datepicker("option", "minDate", null);
        $("#OrigenDesde").datepicker("option", "maxDate", null);
        $("#FechaDesde").datepicker("option", "maxDate", null);
        $("#FechaHasta").datepicker("option", "minDate", null);
        setTimeout(function () {
            $.uniform.update();
        }, 200);

    }

    function SeleccionarFecha(objeto) {
        var desde = document.getElementById('zonaDesde');
        var hasta = document.getElementById('zonaHasta');
        if (objeto.value != '') {
            Mostrar(desde);
            Mostrar(hasta);
        } else {
            Ocultar(desde);
            Ocultar(hasta);
        }
    }

    function Reportador() {
        var accion, campos, columnas, titulo;
        var reporte = document.getElementById('reportes').value;

        if (reporte == '1') {
            campos = {'origen': document.getElementById('origen').value,
                'investigador': document.getElementById('investigador').value,
                'sitio': document.getElementById('sitio').value,
                'remitido': document.getElementById('remitido').value,
                'estatus': document.getElementById('estatus').value,
                'Fecha': document.getElementById('Fecha').value,
                'FechaDesde': document.getElementById('FechaDesde').value,
                'FechaHasta': document.getElementById('FechaHasta').value};

            columnas = [{"sTitle": "Código", "sWidth": "10%", "sAlign": "center", "mDataProp": "codigo_ave", "sClass": "centrado"},
                {"sTitle": "Origen", "sWidth": "10%", "mDataProp": "origen", "sClass": "centrado"},
                {"sTitle": "Abierta", "sWidth": "10%", "mDataProp": "fecha", "sClass": "centrado"},
                {"sTitle": "Revisión", "sWidth": "10%", "mDataProp": "fecha_st_1", "sClass": "centrado"},
                {"sTitle": "Remitida", "sWidth": "10%", "mDataProp": "fecha_st_2", "sClass": "centrado"},
                {"sTitle": "Finalizada", "sWidth": "10%", "mDataProp": "fecha_st_3", "sClass": "centrado"},
                {"sTitle": "Archivada", "sWidth": "10%", "mDataProp": "fecha_st_9", "sClass": "centrado"},
                {"sTitle": "Estatus", "sWidth": "6%", "mDataProp": "status", "sClass": "centrado"},
                {"sTitle": "Investigador", "sWidth": "24%", "mDataProp": "investigador"}];
            titulo = 'Reporte de Averiguaciones';
            accion = 'Aver';

        } else if (reporte == '2') {
            campos = {'origen': document.getElementById('tipoorigen').value,
                'estatus': document.getElementById('origen_st').value,
                'tipo': document.getElementById('tipo').value,
                'OrigenDesde': document.getElementById('OrigenDesde').value,
                'OrigenHasta': document.getElementById('OrigenHasta').value};

            columnas = [{"sTitle": "Código", "sWidth": "15%", "sAlign": "center", "mDataProp": "codigo", "sClass": "centrado"},
                {"sTitle": "Fecha", "sWidth": "10%", "mDataProp": "fecha", "sClass": "centrado"},
                {"sTitle": "Tipo", "sWidth": "10%", "mDataProp": "tipo", "sClass": "centrado"},
                {"sTitle": "Estatus", "sWidth": "10%", "mDataProp": "status", "sClass": "centrado"},
                {"sTitle": "Descripción", "mDataProp": "descripcion"}];

            accion = 'Org';
            if (document.getElementById('tipoorigen').value == '1') {
                titulo = 'Reporte de Denuncias';
                columnas.push({"sTitle": "Denunciante", "sWidth": "25%", "mDataProp": "denunciante"});
            } else {
                titulo = 'Reporte de Oficios';
            }

        }
        $.ajax({
            url: 'modules/SIIT-Metro(Admin)/Reportador.php',
            dataType: 'JSON',
            method: 'POST',
            beforeSend: function () {
                $('#Grid-Tabla').css({'display': ''});
                $('#ZonaTable').empty();
                $('#ZonaTable').html('<table class="table table-bordered table-striped data-table"></table>');
            },
            data: {
                acc: accion,
                campos: JSON.stringify(campos)
            },
            success: function (data) {
                $('#Nombre-Reporte').empty();
                $('#Nombre-Reporte').html(titulo);

                $(".data-table").dataTable({
                    "aoColumns": columnas,
                    "aaData": data.datos,
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
                $("#FechaHasta").datepicker("option", "minDate", fecha);
            }
        });
        $("#FechaHasta").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "2014:2020",
            onSelect: function (fecha, event) {
                $("#FechaDesde").datepicker("option", "maxDate", fecha);
            }
        });

        $("#OrigenDesde").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "2014:2020",
            onSelect: function (fecha, event) {
                $("#OrigenHasta").datepicker("option", "minDate", fecha)
            }
        });
        $("#OrigenHasta").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "2014:2020",
            onSelect: function (fecha, event) {
                $("#OrigenDesde").datepicker("option", "maxDate", fecha)
            }
        });
    }
    );

</script>