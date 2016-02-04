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
    .bsf{
        font-size: 12px;
        font-weight: bold;
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
                                    <div class="grid-8 DatosDeclaraciones" style="margin-top: 0px; display: initial">
                                        <div class="field-group">
                                            <label style="color:#B22222">Ingreso estimado:</label>
                                            <div class="field" style="margin-bottom: 2px">
                                                <label>Mensual:</label>    
                                                <input name="IngresoMensual" id="IngresoMensual" title="Ingreso Mensual" readonly style="max-width: 250px; text-align: right" class="" value="<?= $mensual ?>"/><span class="bsf"> Bs.f</span>
                                                <label style="color: #B22222; font-style: italic"> * Ingreso mensual según Nómina, utilizado como referencia. </label>
                                            </div>
                                            <br>
                                            <div class="field" style="margin-bottom: 2px">
                                                <label >Ingreso Anual Estimado:</label>
                                                <input name="IngresoAnual" id="IngresoAnual" title="Ingreso Anual Estimado" style="max-width: 250px; text-align: right" class="" onkeypress="return enterDecimal(event)" value="<?= $anual ?>"/><span class="bsf"> Bs.f</span>
                                                <label style="color: #B22222; font-style: italic"> * En caso de ser requerido, puede incluir ingresos adicionales (vacaciones, aguinaldos, etc). Totalice el monto anual.</label>
                                            </div>
                                            <div class="field" style="margin-bottom: 2px">
                                                <label >Ingreso Anual Estimado:</label>
                                                <input name="IngresoAnual" id="IngresoAnual" title="Ingreso Anual Estimado" style="max-width: 250px; text-align: right" class="" onkeypress="return enterDecimal(event)" value="0,00"/><span class="bsf"> Bs.f</span>
                                                <label style="color: #B22222; font-style: italic"> * En caso de ser requerido, puede incluir ingresos adicionales (vacaciones, aguinaldos, etc). Totalice el monto anual.</label>
                                            </div>
                                            <div class="field" style="margin-bottom: 2px">
                                                <label >Ingreso Anual Estimado:</label>
                                                <input name="IngresoAnual" id="IngresoAnual" title="Ingreso Anual Estimado" style="max-width: 250px; text-align: right" class="" onkeypress="return enterDecimal(event)" value="0,00"/><span class="bsf"> Bs.f</span>
                                                <label style="color: #B22222; font-style: italic"> * En caso de ser requerido, puede incluir ingresos adicionales (vacaciones, aguinaldos, etc). Totalice el monto anual.</label>
                                            </div>
                                            <div class="field" style="margin-bottom: 2px">
                                                <label >Ingreso Anual Estimado:</label>
                                                <input name="IngresoAnual" id="IngresoAnual" title="Ingreso Anual Estimado" style="max-width: 250px; text-align: right" class="" onkeypress="return enterDecimal(event)" value="0,00"/><span class="bsf"> Bs.f</span>
                                                <label style="color: #B22222; font-style: italic"> * En caso de ser requerido, puede incluir ingresos adicionales (vacaciones, aguinaldos, etc). Totalice el monto anual.</label>
                                            </div>
                                        </div> <!-- .field-group -->
                                        <div class="field-group">								
                                            <label style="color:#B22222">Carga Familiar:</label>
                                            <div class="field" style="margin-bottom: 2px">
                                                <input name="CargaFamiliar" id="CargaFamiliar" title="Carga Familiar" path="note" type="number" min="0" max="10" style="width: 50px;" value="<?= $sqlCargaCount ?>"/>
                                                <span style="color: #888; opacity: 0.8; font-size: 12px; font-weight: bold"> Cantidad </span>    
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-8 DatosDeclaraciones Desgravamenes Variable" style="margin-top: 0px; display: initial">
                                        <div class="field-group">
                                            <input type="checkbox" id="Unico" class="Desg" value="1"/>
                                            <span style="color:#B22222; font-weight: bold">Desgravamen Único:</span>
                                            <br><br>
                                            <div class="field" style="margin-bottom: 2px">
                                                <label>Desgravamen Único:</label>    
                                                <input name="DesgravameUnico" id="DesgravameUnico" readonly title="Desgravamen Único" readonly style="max-width: 250px; text-align: right" class="" value="774"/><span class="bsf"> U.T.</span>
                                                <label style="color: #B22222; font-style: italic"> * Monto fijo del Desgravamen (Art. 62 - Ley). </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-8 DatosDeclaraciones Desgravamenes Unico" style="margin-top: 0px; display: initial">
                                        <div class="field-group">
                                            <input type="checkbox" id="Variable" class="Desg" value="2"/>
                                            <span style="color:#B22222; font-weight: bold">Desgravamen Variable:</span>
                                            <br><br>
                                            <div class="field" style="margin-bottom: 2px">
                                                <label >Institutos Docentes:</label>
                                                <input name="Institutos" id="Institutos" title="Institutos Docentes" style="max-width: 250px; text-align: right" class="" onkeypress="return enterDecimal(event)" value="0.00"/><span class="bsf"> Bs.f</span>
                                                <label style="color: #B22222; font-style: italic"> * Por la educación del contribuyente y descendientes no mayores a 25 años.</label>
                                            </div>
                                            <div class="field" style="margin-bottom: 2px">
                                                <label >Primas:</label>
                                                <input name="Primas" id="Primas" title="Primas" style="max-width: 250px; text-align: right" class="" onkeypress="return enterDecimal(event)" value="0.00"/><span class="bsf"> Bs.f</span>
                                                <label style="color: #B22222; font-style: italic"> * Primas de Seguro, Hospitalización, Cirugia y Maternidad.</label>
                                            </div>
                                            <div class="field" style="margin-bottom: 2px">
                                                <label >Servicios Médicos:</label>
                                                <input name="ServiciosMedicos" id="ServiciosMedicos" title="Servicios Medicos" style="max-width: 250px; text-align: right" class="" onkeypress="return enterDecimal(event)" value="0.00"/><span class="bsf"> Bs.f</span>
                                                <label style="color: #B22222; font-style: italic"> * Servicios Médicos odontológicos y de Hospitalización (incluye carga familiar).</label>
                                            </div>
                                            <div class="field" style="margin-bottom: 2px">
                                                <label >Intereses:</label>
                                                <input name="Intereses" id="Intereses" title="Intereses" style="max-width: 250px; text-align: right" class="" onkeypress="return enterDecimal(event)" value="0.00"/><span class="bsf"> Bs.f</span>
                                                <label style="color: #B22222; font-style: italic"> * Intereses por la adquisición de la vivienda principal o de lo pagado por alquiler de la vivienda que le sirve de asiento permanente.</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-24" style="margin-top: 0px; display: initial; text-align: center">
                                        <div class="field-group" style="text-align: center; width: 95%">
                                            <input name="Periodo" id="Periodo" value="<?= $periodo ?>" style="display: none"/>
                                            <button type="button" id="Generar" class="btn btn-error" onclick="javascript:AceptarEdit('<?= $parametros ?>')">Generar</button>
                                        </div> <!-- .field-group -->
                                    </div>
                                </div>
                                <div class="grid-24" style="text-align: left; width: 90%">
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
                                            <th colspan="8" style="width: 15%;text-align: center;vertical-align: middle"></th>
                                            </thead>
                                            <tbody id="Tabla-Sanciones">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="grid-24 DatosDeclaraciones" style="display: inicial">
                                    <label style="color: #B22222; font-style: italic; text-align: left; width: 70%"> <b>IMPORTANTE:</b><br> Esta declaración solo considera el Desgravámen Único (Art. 62), si desea declarar otros desgravámenes realice la declaración con la planilla física.</label>
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
                <a class="btn btn-primary btn-large dashboard_add"  href="dashboard.php?data=Historial_AR-I&'<?= $parametros ?>'">Historial</a>
                <a class="btn btn-primary btn-large dashboard_add" onclick="javascript:window.history.back();">Regresar</a>
            </div>
        </div>
    </div>

</div><!-- .row -->

<script type="text/javascript">
    var desgravamen;
//-----------------------------------------------------------------
//   Máscara de Decimales para montos Gracias Banco del Tesoro
//-----------------------------------------------------------------
    var amountformat = true;
    function enterDecimal(elEvento) {
        var event = elEvento || window.event;

        var elem = event.currentTarget || event.srcElement;
        var kcode = event.which || event.keyCode;
        var val;
        var newVal = "";
        if (amountformat)
            elem.value = replaceAll(elem.value, ",");
        switch (kcode) {
            case 66:
            case 98:
            {
                if (amountformat)
                    formatValor(elem, true);
                return false;
            }
            case 72:
            case 104:
            {
                if (amountformat)
                    formatValor(elem, true);
                return false;
            }
            case 77:
            case 109:
            {
                if (amountformat)
                    formatValor(elem, true);
                return false;
            }
            case 84:
            case 116:
            {
                if (amountformat)
                    formatValor(elem, true);
                return false;
            }
            default:
            {
                if (amountformat) {
                    if ((kcode < 48 || kcode > 57) && kcode != 13) {

                        if (kcode == 37 || kcode == 39) {
                            //event.returnValue = true;
                            //formatValor(elem,true);
                            return true;
                        } else if (kcode == 8) {
                            //event.returnValue = true;
                            //formatValor(elem,true);
                            if (elem.value == "0" || elem.value == "00" || elem.value == "0,00" || elem.value == "0,0" || elem.value == "") {
                                elem.value = "0,00";
                            }
                            return true;
                        } else {
                            //event.returnValue = false;
                            formatValor(elem, true);
                            return false;
                        }
                        //break;
                    } else if (kcode != 13) {
                        formatValor(elem, false);
                        //break;
                        return true;
                    } else {
                        formatValor(elem, true);
                        if (elem.value == "0" || elem.value == "00" || elem.value == "0,00" || elem.value == "0,0" || elem.value == "") {
                            elem.value = "0,00";
                        }

                        //break;
                        return true;
                    }
                } else {
                    if ((kcode < 48 || kcode > 57) && kcode != 13) {
                        //event.returnValue = false;
                        return false;
                    } else if (kcode == 46 && elem.value.indexOf(',') !== -1) {
                        //event.returnValue = false;
                        return false;
                    }
                }
            }
        }

    }


    function replaceAll(value, charte) {

        var result = value;
        var posi = value.indexOf(charte);
        if (posi > -1) {
            while (posi > -1) {
                result = value.substring(0, posi);
                result = result + value.substring(posi + 1);
                posi = result.indexOf(charte);
                value = result;
            }
        }

        return(result);

    }


    function formatValor(campo, preformat) {

        var vr = campo.value;
        //vr = vr.replace( ".", "" );
        vr = replaceAll(vr, ".");
        vr = replaceAll(vr, ",");
        campo.value = "";
        var sign = "";
        if (vr.indexOf('-') != -1) {
            vr = replaceAll(vr, "-");
            sign = "-";
        }
        var tam = (preformat) ? vr.length : vr.length + 1;

        campo.maxLength = 15;
        if (tam <= 2) {
            campo.value = "0," + vr;
        }
        if ((tam > 2) && (tam <= 5)) {
            campo.maxLength = 16;
            campo.value = vr.substr(0, tam - 2) + ',' + vr.substr(tam - 2, tam);
        }
        if ((tam >= 6) && (tam <= 8)) {
            campo.maxLength = 17;
            campo.value = vr.substr(0, tam - 5) + '.' + vr.substr(tam - 5, 3) + ',' + vr.substr(tam - 2, tam);
        }
        if ((tam >= 9) && (tam <= 11)) {
            campo.maxLength = 18;
            campo.value = vr.substr(0, tam - 8) + '.' + vr.substr(tam - 8, 3) + '.' + vr.substr(tam - 5, 3) + ',' + vr.substr(tam - 2, tam);
        }
        if ((tam >= 12) && (tam <= 14)) {
            campo.maxLength = 19;
            campo.value = vr.substr(0, tam - 11) + '.' + vr.substr(tam - 11, 3) + '.' + vr.substr(tam - 8, 3) + '.' + vr.substr(tam - 5, 3) + ',' + vr.substr(tam - 2, tam);
        }
        if ((tam >= 15) && (tam <= 17)) {
            campo.maxLength = 20;
            campo.value = vr.substr(0, tam - 14) + '.' + vr.substr(tam - 14, 3) + '.' + vr.substr(tam - 11, 3) + '.' + vr.substr(tam - 8, 3) + '.' + vr.substr(tam - 5, 3) + ',' + vr.substr(tam - 2, tam);
        }
        var pos = campo.value.indexOf(',');
        if (pos != -1) {
            vr = campo.value.substr(0, pos);
            if (vr == "00" || (vr.length == 2 && vr.substr(0, 1) == "0"))
                campo.value = campo.value.substr(1, tam);
        }
        campo.value = sign + campo.value;
    }
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
                        $('#IngresoAnual').val(data.datos[aux].estimado);
                        $('#IngresoAnual').focus();
                    } else {
                        botones = 'display: none';
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
                                <a style="' + botones + '" title="Confirmar Declaración" class="btn btn-error" type="text" onclick="javascript:Confirmar(\'' + data.datos[aux].declaracion + '\')">\n\
                                <i style="font-size: 10px" class="fa fa-check"></i>\n\
                                </a>\n\                                \n\
                                <a title="Ver Planilla" class="btn btn-error" type="text" onclick="javascript:VerDeclaracion(\'' + data.datos[aux].reporte + '\')">\n\
                                    <i style="font-size: 10px" class="fa fa-search-plus"></i>\n\
                                </a>\n\
                                </td>\n\
                                </tr>';
                aux++;
            }
        } else {
            lista = '<tr><td colspan="8" class="SinRegistro">*** No posee Declaraciones registradas para este periodo. ***</td></tr>'
        }
        document.getElementById('Tabla-Sanciones').innerHTML = lista;
    }

    function VerificarDeclaraciones(parametro) {
        $.ajax({
            url: 'modules/ARI/Declaraciones.php?flag=1&' + parametro,
            method: 'GET',
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
        var unico = $('#DesgravameUnico').val();
        var institutos = $('#Institutos').val();
        var primas = $('#Primas').val();
        var serviciosM = $('#ServiciosMedicos').val();
        var intereses = $('#Intereses').val();

        $.ajax({
            url: 'modules/ARI/Declaraciones.php?flag=1&' + parametro,
            method: 'GET',
            dataType: 'JSON',
            data: {
                acc: 'modificar',
                carga: carga,
                unico: unico,
                desgravamen: desgravamen,
                institutos: institutos,
                primas: primas,
                serviciosM: serviciosM,
                intereses: intereses,
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
            , text: '<h3>Desea confirmar esta Declaración?</h3><h5><i>Solo se podrá confirmar una declaración AR-I por Periodo (trimestre)</i></h5><br>'
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
        var carga = $('#CargaFamiliar').val();
        var ingreso = $('#IngresoAnual').val();
        var periodo = $('#Periodo').val();
        var unico = $('#DesgravameUnico').val();
        var institutos = $('#Institutos').val();
        var primas = $('#Primas').val();
        var serviciosM = $('#ServiciosMedicos').val();
        var intereses = $('#Intereses').val();

        if (carga != '' && ingreso != '') {
            $.ajax({
                url: 'modules/ARI/Declaraciones.php?flag=1&' + parametro,
                method: 'GET',
                dataType: 'JSON',
                beforeSend: function () {
                    $('#Generar').attr('disabled', true);
                },
                data: {
                    acc: 'declaraciones',
                    carga: carga,
                    periodo: periodo,
                    desgravamen: desgravamen,
                    unico: unico,
                    institutos: institutos,
                    primas: primas,
                    serviciosM: serviciosM,
                    intereses: intereses,
                    ingreso: ingreso
                },
                success: function (data) {
                    AsignarResultado(data);
                    $('#Generar').removeAttr('disabled');
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
        $("#IngresoAnual").focus();
        $(".Desg").click(function () {
            $(".Desg").attr('checked', false);
            $(this).attr('checked', true);

            desgravamen = $(this).val();

            $('.Desgravamenes > div > div > input').removeAttr('disabled');
            $('.' + $(this).attr('id') + ' > div > div > input').attr('disabled', true);

            setTimeout(function () {
                $.uniform.update();
            }, 100);
        });
        $("#Unico").trigger('click');
        $("#Unico").attr('checked', true);
        setTimeout(function () {
            $.uniform.update();
        }, 100);
    });

</script>