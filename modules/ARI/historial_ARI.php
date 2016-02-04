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
    case 1: case 2: $periodotitle = 'Primer Periodo';
        $periodo = 1;
        break;
    case 3: case 4: case 5: $periodotitle = 'Segundo Periodo';
        $periodo = 2;
        break;
    case 6: case 7: case 8: $periodotitle = 'Tercer Periodo';
        $periodo = 3;
        break;
    case 9: case 10: case 11: $periodotitle = 'Cuarto Periodo';
        $periodo = 4;
        break;
    case 12: $periodotitle = 'Quinto Periodo';
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

$mensual = number_format($result['salario'], 2, ',', '.');
$anual = number_format(($result['salario'] * 12), 2, ',', '.');
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
                                    <h3>Historial de Declaraciones AR-I del empleado <?= $nombre ?></h3>
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
                                </div>
                                <div class="grid-24" style="text-align: left; width: 90%">
                                    <div class="grid-24" style="width: 100%; text-align: center; font-size: 14px;margin-bottom: -15px">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                            <th style="width: 15%; text-align: center; color:#B22222">Confirmado</th>
                                            <th style="width: 10%; text-align: center; color:#B22222">Año</th>
                                            <th style="width: 10%; text-align: center; color:#B22222">Periodo</th>
                                            <th style="width: 10%; text-align: center; color:#B22222"> % </th>
                                            <th style="; text-align: center; color:#B22222">Código</th>
                                            <th colspan="8" style="width: 10%;text-align: center;vertical-align: middle"></th>
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
            <p>En esta sección podrá ver el historial de declaraciones de AR-I <b></b></p>
            <div class="box plain">
                <a class="btn btn-primary btn-large dashboard_add" onclick="javascript:window.history.back();">Regresar</a>
            </div>
        </div>
    </div>

</div><!-- .row -->

<script type="text/javascript">


    function VerDeclaracion(reporte) {
        $('#array').val(reporte);
        document.getElementById('Reportador').submit();
    }

    function AsignarResultado(data) {
        var lista = '';
        var botones = '';
        if (data.campos > 0) {
            var aux = 0;
            var i;
            while (aux < data.campos)
            {
                lista += '<tr>\n\
                                <td class="escondido" style="text-align: center;vertical-align: middle">' + data.datos[aux].confirmado + '</td>\n\
                                <td style="text-align: center;vertical-align: middle">' + data.datos[aux].año + '</td>\n\
                                <td style="text-align: center;vertical-align: middle">' + data.datos[aux].periodo + '</td>\n\
                                <td style="text-align: center;vertical-align: middle">' + data.datos[aux].retencion + '</td>\n\
                                <td style="text-align: center;vertical-align: middle">' + data.datos[aux].codigo + '</td>\n\
                                <td style="text-align: center;vertical-align: middle">\n\
                                <a title="Ver Planilla" class="btn btn-error" type="text" onclick="javascript:VerDeclaracion(\'' + data.datos[aux].reporte + '\')">\n\
                                    <i style="font-size: 10px" class="fa fa-search-plus"></i>\n\
                                </a>\n\
                                </td>\n\
                                </tr>';
                aux++;
            }
        } else {
            lista = '<tr><td colspan="8" class="SinRegistro">*** No posee Declaraciones registradas. ***</td></tr>'
        }
        document.getElementById('Tabla-Sanciones').innerHTML = lista;
    }

    function VerificarDeclaraciones(parametro) {
        $.ajax({
            url: 'modules/ARI/Declaraciones.php?flag=1&' + parametro,
            method: 'GET',
            dataType: 'JSON',
            data: {
                acc: 'historial'
            },
            success: function (data) {
                AsignarResultado(data);
            }
        });
    }

    $(document).ready(function () {
        VerificarDeclaraciones('<?= $parametros ?>');
        $("#IngresoAnual").focus();
    });

</script>