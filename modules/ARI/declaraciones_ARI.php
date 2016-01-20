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

<style>

    .bordeado{
        border: 1px solid #A5A5A5; 
        border-style: outset; 
        border-radius: 0px 0px 15px 15px;
    }
    .bordeado > div:not(.widget-header):not(.field-group):not(.field){
        margin-left: 3.5%;
    }

    .widget-header > h3{
        padding-top: 10px; 
        padding-left: 15px
    }

    .btn-edit{
        border-width: 0px; 
        padding-right: 6px; 
        padding-left: 6px;
        text-align: center;
        width: 30px;
    }

    .Editar-Visible{
        display: initial;
    }
    .centrado{
        width: 20px; 
        text-align: center; 
        vertical-align: middle;
    }
    .centrado > a > i{
        color: black;
        cursor: pointer;
    }
    .SinRegistro{
        text-align: center; 
        font-size: 12px; 
        color: grey;
    }
    #Editado{
        text-align: left;  
        //margin-left: 34%;
    }
    #Botones{
        text-align: center;
        margin-top: -35px !important;
    }
    #SeccionDeclaraciones > div:not(:first-child){
        margin-top: 30px;
    }
    #SeccionDeclaraciones > div{
        min-height: 100px;
    }
    #Tabla-Sanciones{
        height: 50px;
        overflow: scroll;
    }
    #Mostrados > table{
        width: 100%; 
        display:block;
    }
    #Mostrados > table > thead{
        display: block; 
        width: 100%;
    }
    #Mostrados > table > tbody{
        width: 100%;
        display: block;
        overflow-y: auto; 
        overflow-x: hidden;
        height: 450px; 
        overflow: auto;
    }

    @media (max-width: 1175px){
        #Editado > div{
            margin-left: 0px;   
            margin-right: 0px;
            width: 100%;
        }
    }
    @media (max-width: 1020px){
        #Editado{
            margin-left: 0;
        }
        #Botones{
            text-align: left;
        }
        #SeccionDeclaraciones > div:not(:first-child){
            margin-top: -20px;
        }
        #SeccionDeclaraciones > div{
            min-height: 0px;
        }
    }

</style>
<div id="contentHeader">
    <h2>Declaración AR-I</h2>
</div> <!-- #contentHeader -->	
<?php
_bienvenido_mysql();
$cedula = $usuario_datos[3];
$nombre = $usuario_datos['nombre'] . " " . $usuario_datos['apellido'];

$periodo = '';
$mes = date('m');
$año = date('Y');
switch ($mes) {
    case 1: case 2: $periodotitle = 'Primer Trimestre';
        $periodo = 1;
        break;
    case 3: case 4: case 5: $periodotitle = 'Segundo Trimestre';
        $periodo = 2;
        break;
    case 6: case 7: case 8: $periodotitle = 'Tercer Trimestre';
        $periodo = 3;
        break;
    case 9: case 10: case 11: $periodotitle = 'Cuarto Trimestre';
        $periodo = 4;
        break;
    case 12: $periodotitle = 'Quinto Trimestre';
        $periodo = 5;
        break;
}
$sqlUT = "SELECT "
        . "unidad_tributaria "
        . "FROM variables_fiscales "
        . "WHERE año = $año "
        . "AND periodo = $periodo";

$sqlUnidadT = mysql_query($sqlUT);
$resultUT = mysql_fetch_array($sqlUnidadT);
$UT = $resultUT['unidad_tributaria'];

$sqlquery = "SELECT "
        . "salario "
        . "FROM ctrabajo_datos_empleados "
        . "WHERE cedula_empleado =" . $cedula;

$sqlsalario = mysql_query($sqlquery);
$result = mysql_fetch_array($sqlsalario);
$salario = $result['salario'];

$sqlrif = "SELECT "
        . "rif "
        . "FROM datos_empleado_rrhh "
        . "WHERE cedula =" . $cedula;

$queryrif = mysql_query($sqlrif);
$resultRif = mysql_fetch_array($queryrif);
$Rif = $resultRif['rif'];

$parametros = 'cedula=' . $cedula;
$parametros .= '&periodo=' . $periodo;
$parametros .= '&año=' . $año;
$parametros .= '&UT=' . $UT;
$parametros .= '&Rif=' . $Rif;
$parametros .= '&Nombre=' . $usuario_datos['apellido'] . " " . $usuario_datos['nombre'];
$parametros = _desordenar($parametros);

$sqlcode = "SELECT "
        . "cedula_familiar, "
        . "nombres, parentesco "
        . "FROM datos_familiares_rrhh "
        . "WHERE cedula_empleado =" . $cedula . " "
        . "AND parentesco like '%Hijo(a)%' "
        . "ORDER BY cedula_familiar ASC";

$sqlcarga = mysql_query($sqlcode);
$sqlCargaCount = mysql_num_rows($sqlcarga);
?>
<div class="container">
    <div class="row"> 
        <form class="form uniformForm validateForm" id="from_envio_pe" name="from_envio_pe" method="post" action="dashboard.php?data=asuntoi" >
            <div class="grid-18">
                <div class="">
                    <div class="">
                        <div class="row"><!-- .grid -->
                            <div class="grid-24 bordeado">
                                <div class="widget-header">
                                    <h3>Declaración AR-I para el  <?= $periodotitle; ?> del año <?= $año ?></h3>
                                </div>
                                <br>
                                <div class="grid-24" id="SeccionDeclaraciones" style="display: initial">
                                    <div class="grid-6"> 
                                        <img align="left" style=" border: solid 5px #ddd;max-width: 100px; max-height: 100px" src="../src/images/FOTOS/<?= $cedula ?>.jpg" onerror="src='../intranet/src/images/FOTOS/No-User.png'"/>
                                    </div>
                                    <div class="grid-5">
                                        <div class="field-group">								
                                            <label style="color:#B22222">Cédula:</label>
                                            <div class="field">
                                                <span><?php echo $cedula; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-12">
                                        <div class="field-group">
                                            <label style="color:#B22222">Nombre y Apellido:</label>
                                            <div class="field">
                                                <span><?php echo $nombre; ?></span>
                                                <input name="Nombre" id="Nombre" style="max-width: 250px; display: none" value="<?php echo $nombre; ?>"/>
                                            </div>
                                        </div> <!-- .field-group -->	
                                    </div>
                                    <div class="grid-8 DatosDeclaraciones" style="display: inicial"></div>
                                    <div class="grid-8 DatosDeclaraciones" style="margin-top: 0px; display: initial">
                                        <div class="field-group">
                                            <label style="color:#B22222">Ingreso estimado:</label>
                                            <div class="field" style="margin-bottom: 2px">
                                                <label>Mensual:</label>    
                                                <input name="IngresoMensual" id="IngresoMensual" title="Ingreso Mensual" readonly style="max-width: 250px" class="" value="<?= $salario ?>"/>
                                            </div>
                                            <br>
                                            <div class="field">
                                                <label>Estimación Anual:</label>
                                                <input name="IngresoAnual" id="IngresoAnual" title="Ingreso Anual Estimado" style="max-width: 250px" class="" onkeypress="return soloNumeros(event)" value="<?= $salario * 12 ?>"/>
                                            </div>
                                        </div> <!-- .field-group -->
                                        <div class="field-group">								
                                            <label style="color:#B22222">Carga Familiar(Cantidad):</label>
                                            <div class="field">
                                                <input name="CargaFamiliar" id="CargaFamiliar" title="Carga Familiar" path="note" type="number" min="0" max="10" style="width: 50px" value="<?= $sqlCargaCount ?>"/>
                                                <span style="color: #888; opacity: 0.8; font-size: 12px; font-weight: bold"> Solo Hijo(s) </span>    
                                            </div>
                                        </div>
                                        <div class="field-group" style="text-align: center; width: 70%">
                                            <input name="Periodo" id="Periodo" value="<?= $periodo ?>" style="display: none"/>
                                            <button type="button" id="Generar" class="btn btn-error" onclick="javascript:AceptarEdit('<?= $parametros ?>')">Generar</button>
                                        </div> <!-- .field-group -->
                                    </div>
                                </div>
                                <div class="grid-24" style="text-align: center; width: 90%">
                                    <div class="grid-24" style="width: 100%; text-align: center; font-size: 14px;margin-bottom: -15px">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                            <th style="width: 10%; text-align: center; color:#B22222; ">Generado</th>
                                            <th style="width: 10%; text-align: center; color:#B22222">Confirmado</th>
                                            <th style="width: 5%; text-align: center; color:#B22222">Carga</th>
                                            <th style="width: 15%; text-align: center; color:#B22222">Ingreso</th>
                                            <th style="width: 5%; text-align: center; color:#B22222">Estatus</th>
                                            <th style="width: 10%; text-align: center; color:#B22222"> % </th>
                                            <th style="width: 30%; text-align: center; color:#B22222">Código</th>
                                            <th style="width: 15%;text-align: center;vertical-align: middle"></th>
                                            </thead>
                                            <tbody id="Tabla-Sanciones">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- .grid -->
                </div><!-- .grid -->
            </div><!-- .grid -->
        </form>
    </div><!-- .grid -->
    <form id="Reportador" action="gen_report/reportes.php" method="post" target="_blank">
        <input id="array" name="array" type="hidden" value="" >
        <input id="jasper" name="jasper" type="hidden" value="AR-I/Seniat.jasper" >
        <input id="nombresalida" name="nombresalida" type="hidden" value="Declaracion_AR-I" >
        <input id="formato" name="formato" type="hidden" value="pdf" >
    </form>
    <div class="grid-6"> 
        <div id="gettingStarted" class="box">
            <h3>Estimado, <?php echo $usuario_datos['nombre'] . " " . $usuario_datos['apellido']; ?></h3>
            <p>En esta sección podrá hacer la declaracion de AR-I <b></b></p>
            <div class="box plain">
                <a class="btn btn-primary btn-large dashboard_add" onclick="javascript:window.history.back();">Regresar</a>
            </div>
        </div>
    </div>

</div><!-- .row -->

<script type="text/javascript">
    function soloNumeros(e) {
        var key = window.Event ? e.which : e.keyCode;
        return ((key >= 48 && key <= 57) || key == 8 || key == 0);
    }

    function VerDeclaracion(reporte) {
        $('#array').val(reporte);
        document.getElementById('Reportador').submit();
    }

    function AsignarResultado(data) {
        var lista = '';
        var botones = '';
        var periodo = 'display: none';
        if (data.campos > 0) {
            var aux = 0;
            var i;
            while (aux < data.campos)
            {
                if (data.confirmado > 0) {
                    if (data.confirmado == 1) {
                        $('#Generar').html('Actualizar');
                        $('#Generar').attr("onclick", "javascript:Modificar('" + data.datos[aux].declaracion + "')");
                        $('#CargaFamiliar').val(data.datos[aux].carga);
                        $('#IngresoAnual').val(data.datos[aux].monto);
                    } else {
                        botones = 'display: none';
                        periodo = '';
                        $('.DatosDeclaraciones').css({'display': 'none'});
                        $('.periodo').css({'display': 'none'});
                        $('.codigo').css({'display': ''});
                    }


                }
                lista += '<tr>\n\
                                <td style="text-align: center;vertical-align: middle">' + data.datos[aux].generado + '</td>\n\
                                <td class="escondido" style="text-align: center;vertical-align: middle">' + data.datos[aux].confirmado + '</td>\n\
                                <td style="text-align: center;vertical-align: middle">' + data.datos[aux].carga + '</td>\n\
                                <td style="text-align: center;vertical-align: middle">' + data.datos[aux].estimado + '</td>\n\
                                <td style="text-align: center;vertical-align: middle">' + data.datos[aux].status + '</td>\n\
                                <td style="text-align: center;vertical-align: middle">' + data.datos[aux].retencion + '</td>\n\
                                <td style="text-align: center;vertical-align: middle">' + data.datos[aux].codigo + '</td>\n\
                                <td style="text-align: center;vertical-align: middle">\n\
                                <a style="' + botones + '" title="Confirmar" class="btn btn-error" type="text" onclick="javascript:Confirmar(\'' + data.datos[aux].declaracion + '\')">\n\
                                <i style="font-size: 10px" class="fa fa-check"></i>\n\
                                </a>\n\                                \n\
                                <a title="Ver" class="btn btn-error" type="text" onclick="javascript:VerDeclaracion(\'' + data.reporte + '\')">\n\
                                    <i style="font-size: 10px" class="fa fa-search-plus"></i>\n\
                                </a>\n\
                                </td>\n\
                                </tr>';
                aux++;
            }
        } else {
            lista = '<tr><td  class="SinRegistro">*** No posee Declaraciones registradas para este periodo. ***</td></tr>'
        }
        document.getElementById('Tabla-Sanciones').innerHTML = lista;
    }

    function VerificarDeclaraciones(parametro) {
        $.ajax({
            url: 'modules/ARI/Declaraciones.php?flag=1&' + parametro,
            method: 'POST',
            dataType: 'JSON',
            data: {
                acc: 'verificar'
            },
            success: function (data) {
                AsignarResultado(data);
            }
        });
    }

    function Modificar(parametro) {
        var carga = $('#CargaFamiliar').val();
        var ingreso = $('#IngresoAnual').val();
        $.ajax({
            url: 'modules/ARI/Declaraciones.php?flag=1&' + parametro,
            method: 'POST',
            dataType: 'JSON',
            data: {
                acc: 'modificar',
                carga: carga,
                ingreso: ingreso
            },
            success: function (data) {
                AsignarResultado(data);
            }
        });
    }

    function Confirmar(parametro) {

        $.alert({
            type: 'confirm'
            , title: 'Alerta'
            , text: '<h3>Desea confirmar esta Declaración?</h3><h5><i>Solo se podra confirmar una declaración AR-I por Trimestre</i></h5><br>'
            , callback: function () {
                $.ajax({
                    url: 'modules/ARI/Declaraciones.php?flag=1&' + parametro,
                    method: 'POST',
                    dataType: 'JSON',
                    data: {
                        acc: 'confirmar'
                    },
                    success: function (data) {
                        AsignarResultado(data);
                    }
                });
            }
        });
    }

    function AceptarEdit(parametro) {
        var carga = document.getElementById('CargaFamiliar').value;
        var ingreso = document.getElementById('IngresoAnual').value;
        var periodo = document.getElementById('Periodo').value;
        if (carga != '' && ingreso != '') {
            $.ajax({
                url: 'modules/ARI/Declaraciones.php?flag=1&' + parametro,
                method: 'POST',
                dataType: 'JSON',
                data: {
                    acc: 'declaraciones',
                    carga: carga,
                    periodo: periodo,
                    ingreso: ingreso
                },
                success: function (data) {
                    AsignarResultado(data);
                }
            });
        } else {
            $.alert({
                type: 'alert'
                , title: 'Alerta'
                , text: '<h3>Todos los campos son requeridos!</h3>'
                , callback: function () {
                }
            });
        }
    }

    $(document).ready(function () {
        VerificarDeclaraciones('<?= $parametros ?>');
    });

</script>