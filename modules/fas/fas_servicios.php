<?php
if (array_pop(explode('/', $_SERVER['PHP_SELF'])) != 'dashboard.php') {
    ir("../../dashboard.php");
}
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
    notificar("Usted no tiene permisos para esta Sección/Módulo", "dashboard.php?data=notificar", "notify-error");
    _wm($usuario_datos[9], 'Acceso Denegado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
}
_wm($usuario_datos[9], 'Acceso Autorizado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
_bienvenido_mysql();

$nombre = $usuario_datos['nombre'] . " " . $usuario_datos['apellido'];
$cedula = $usuario_datos[3];
$parametros = 'cedula=' . $cedula;
$parametros = _desordenar($parametros);
?>

<style>
    label{
        font-weight: bold;  
        font-size: 15px;
    }

    .widget-header > h3{
        padding-top: 10px; 
        padding-left: 15px
    }
    .bordeado{
        border: 1px solid #A5A5A5; 
        border-style: outset; 
        border-radius: 0px 0px 15px 15px;
    }
    .bordeado > div:not(.widget-header):not(.field-group):not(.field){
        margin-left: 3.5%;
    }

    .SinRegistro{
        text-align: center; 
        font-size: 12px; 
        color: grey;
    }

</style>

<div id="contentHeader">
    <h2>FAS Metro</h2>  
</div>
<div class="container">
    <?php include('notificador.php'); ?>
    <div class="row">
        <div class="grid-24"> 
            <div class="grid-18">
                <form class="form uniformForm validateForm" id="from_envio_pe" name="from_envio_pe" method="post" >
                    <div class="">
                        <div class="">
                            <div class="row"><!-- .grid -->
                                <div class="grid-24 bordeado">
                                    <div class="widget-header">
                                        <h3>FAS-Metro - Servicios</h3>
                                    </div>
                                    <br>
                                    <div class="grid-24 uniform" style="display: initial">
                                        <div class="field-group">
                                            <label style="color:#B22222; margin-bottom: 0px">Servicios:</label>
                                            <?php
                                            $sqlqueryServ = "SELECT * FROM fas_tipos_servicios";
                                            $querySrv = mysql_query($sqlqueryServ);
                                            ?>
                                            <div class="field" style="margin-bottom: 15px">
                                                <select id="servicio" name="Tipo de Servicio." disabled class="Requerido" style="max-width: 300px;">
                                                    <option value="" selected> ** Seleccionar ** </option>
                                                    <?php
                                                    while ($respuesta = mysql_fetch_array($querySrv)) {
                                                        ?>
                                                        <option value="<?php echo $respuesta['id_servicio'] ?>"> <?php echo $respuesta['descripcion'] ?> </option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-24 Carta-Aval" style="display: initial">
                                        <div class="grid-10">
                                            <div class="field-group">								
                                                <label style="color:#B22222">Beneficiario:</label>
                                                <?php
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
                                                        . "AND f.fas= 'A' "
                                                        . "AND f.status <= 1 ";
                                                $queryFAM = mysql_query($sqlSelect);
                                                ?>
                                                <div class="field" style="margin-bottom: 15px">
                                                    <select id="beneficiario" name="Beneficiario." class="Requerido" style="max-width: 300px;">
                                                        <option value=""> ** Seleccionar ** </option>
                                                        <option value="<?php echo $cedula ?>"> <?php echo $nombre . ' (Titular)' ?> </option>
                                                        <?php
                                                        while ($respuesta = mysql_fetch_array($queryFAM)) {
                                                            ?>
                                                            <option value="<?php echo $respuesta['cedula_familiar'] ?>"> <?php echo $respuesta['nombres'] . ' (' . $respuesta['parentesco'] . ')' ?> </option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="field-group">
                                                <label style="color:#B22222; margin-bottom: 0px">Procedimiento:</label>
                                                <div class="field" style="margin-bottom: 15px">
                                                    <textarea id="procedimiento" name="Procedimiento." cols="35" rows="6" class="Requerido" placeholder="Procedimiento."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid-10">
                                            <div class="field-group">								
                                                <label style="color:#B22222">Especialidad:</label>
                                                <?php
                                                $sqlSelect = "SELECT * FROM fas_especialidad ";
                                                $queryESP = mysql_query($sqlSelect);
                                                ?>
                                                <div class="field" style="margin-bottom: 15px">
                                                    <select id="especialidad" name="Especialidad." class="Requerido" style="max-width: 300px;">
                                                        <option value=""> ** Seleccionar ** </option>
                                                        <?php
                                                        while ($respuesta = mysql_fetch_array($queryESP)) {
                                                            ?>
                                                            <option value="<?php echo $respuesta['id'] ?>"> <?php echo $respuesta['descripcion'] ?> </option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="field-group">
                                                <label style="color:#B22222; margin-bottom: 0px">Diagnóstico:</label>
                                                <div class="field" style="margin-bottom: 15px">
                                                    <textarea id="diagnostico" name="Diagnóstico." cols="35" rows="6" class="Requerido" placeholder="Diagnóstico."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid-24" style="margin-top: 0px; display: initial; text-align: center">
                                            <div class="field-group" style="text-align: center; width: 95%">
                                                <button type="button" id="Generar" class="btn btn-error" onclick="javascript:SolicitarCartaAval('<?= $parametros ?>')">Solicitar Carta Aval</button>
                                            </div> <!-- .field-group -->
                                        </div>
                                        <div class="grid-24" style="text-align: left; width: 90%">
                                            <div class="grid-24" style="width: 100%; text-align: center; font-size: 14px;margin-bottom: -15px">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                    <th style="width: 50%; text-align: center; color:#B22222; ">Beneficiario</th>
                                                    <th style="width: 15%; text-align: center; color:#B22222">Parentesco</th>
                                                    <th style="width: 25%; text-align: center; color:#B22222">Fecha</th>
                                                    <th style="width: 5%; text-align: center; color:#B22222">Estatus</th>
                                                    <th style="width: 5%; text-align: center; color:#B22222"></th>
                                                    </thead>
                                                    <tbody id="Tabla-CartaAval">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- .grid -->
                    </div><!-- .grid -->
                </form>
            </div><!-- .grid -->
            <div class="grid-6">
                <div id="gettingStarted" class="box">
                    <h3>Estimado, <?php echo $usuario_datos['nombre'] . " " . $usuario_datos['apellido']; ?></h3>
                    <p>En esta sección podrá realizar la solicitud de la Carta Aval.<b></b></p>
                    <div class="box plain">
                        <a class="btn btn-primary btn-large dashboard_add" onclick="javascript:window.history.back();">Regresar</a>
                    </div>
                </div>
            </div><!-- .grid -->
        </div><!-- .grid -->
    </div>
</div>
<form id="Reportador" action="gen_report/reportes.php" method="post" target="_blank">
    <input id="array" name="array" type="hidden" value="" >
    <input id="jasper" name="jasper" type="hidden" value="fas/FasCartAval.jasper" >
    <input id="nombresalida" name="nombresalida" type="hidden" value="Carta_Aval" >
    <input id="formato" name="formato" type="hidden" value="pdf" >
</form>
<?php
_adios_mysql();
?>
<script>
    $(document).ready(function () {
        VerificarEvento('<?= $parametros ?>', 'CartaAval');
        $('#servicio option[value="2"]').attr('selected', 'selected');
        setTimeout(function () {
            $.uniform.update();
        });
    });

    function TiposdeServicios(obj) {
        if (obj.value == '1') {
            Mostrar('.Carta-Aval');
            //Ocultar('.Excluir');
        }
        if (obj.value == '2') {
            //Mostrar('.Excluir');
            Ocultar('.Carta-Aval');
        }
    }

    function Ocultar(obj) {
        $(obj).animate({opacity: 0, height: "hide"}, 500);
    }
    function Mostrar(obj) {
        $(obj).animate({opacity: 1, height: "show"}, 500);
    }


    function VerificarFas() {
        $('#Reportador').submit();
    }
    function esnumero(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        } else {
            return true;
        }
    }

    function VerificarEvento(parametro, tipo) {
        $.ajax({
            url: 'modules/fas/Servicios.php?flag=1&' + parametro,
            method: 'GET',
            dataType: 'JSON',
            data: {
                acc: 'Verificar-' + tipo
            },
            success: function (data) {
                AsignarResultado(data, 'Tabla-' + tipo);
            }
        });
    }

    function VerPlanilla(reporte) {
        $('#array').val(reporte);
        document.getElementById('Reportador').submit();
    }

    function AsignarResultado(data, zona) {
        var lista = '';
        if (data.campos > 0) {
            var aux = 0;
            while (aux < data.campos)
            {

                lista += '<tr>\n\
                        <td style="text-align: center;vertical-align: middle">' + data.datos[aux].nombre + '</td>\n\
                        <td style="text-align: center;vertical-align: middle">' + data.datos[aux].parentesco + '</td>\n\
                        <td style="text-align: center;vertical-align: middle">' + data.datos[aux].fecha + '</td>\n\
                        <td style="text-align: center;vertical-align: middle">' + data.datos[aux].status + '</td>';
                if (data.datos[aux].st === '1') {
                    lista += '<td style="text-align: center;vertical-align: middle">\n\
                                <a title="Ver Planilla" class="btn btn-error" type="text" onclick="javascript:VerPlanilla(\'' + data.datos[aux].reporte + '\')">\n\
                                    <i style="font-size: 10px" class="fa fa-search-plus"></i>\n\
                                </a>\n\
                              </td>';
                } else {
                    lista += '<td></td>';
                }
                lista += '</tr>';
                aux++;
            }
        } else {
            lista = '<tr><td colspan="5" class="SinRegistro"> *** No posee solicitudes de Carta Aval registradas *** </td></tr>'
        }
        document.getElementById(zona).innerHTML = lista;
        $(".uniformSelect").uniform();

    }

    function SolicitarCartaAval(parametros) {
        var lista = '<b>Campos Necesarios: </b><br><i>';
        var bandera = 0;
        var msj = '';
        var msj2 = '';
        var servicio = $('#servicio').val();
        var beneficiario = $('#beneficiario').val();
        var procedimiento = $('#procedimiento').val();
        var especialidad = $('#especialidad').val();
        var diagnostico = $('#diagnostico').val();

        $('.Requerido').each(function () {
            if ($(this).val() === '') {
                lista += ' - ' + $(this).attr('name') + '<br>';
                bandera = 1;
            }
        });

        if (bandera === 0) {
            $.alert({
                type: 'confirm'
                , title: 'Alerta'
                , text: '<h3>¿Seguro que desea realizar esta acción?</h3>'
                , callback: function () {
                    $.ajax({
                        url: 'modules/fas/Servicios.php?flag=1&' + parametros,
                        method: 'GET',
                        dataType: 'JSON',
                        data: {
                            acc: 'incluir',
                            servicio: servicio,
                            beneficiario: beneficiario,
                            procedimiento: procedimiento,
                            especialidad: especialidad,
                            diagnostico: diagnostico
                        },
                        success: function (data) {
                            if (data.mensaje == 'Exito') {
                                AsignarResultado(data, 'Tabla-CartaAval');
                                msj = 'Solicitud registrada con éxito!';
                                msj2 = 'Debe dirigirse a las oficinas del FAS-Metro a consignar todos los soportes correspondientes.';
                            } else {
                                msj2 = 'Ocurrio un error al tratar de registrar, por favor intente de nuevo. ';
                                msj = '';
                            }
                            $.alert({
                                type: 'alert'
                                , title: 'Alerta'
                                , text: '<h3>' + msj + '</h3><i>' + msj2 + '</i>'
                            });
                        }});
                }
            });

        } else {
            $.alert({
                type: 'alert'
                , title: 'Alerta'
                , text: '<h3>Todos los campos son requeridos!</h3>' + lista + '</i>'
            });
        }
    }
</script>