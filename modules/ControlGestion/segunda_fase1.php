<?php
//alerta('Modulo Deshabilitado por codigo');
//ir('dashboard.php');
if (array_pop(explode('/', $_SERVER['PHP_SELF'])) != 'dashboard.php') {
    header("Location: ../../dashboard.php");
}
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
    //notificar("Usted no tiene permisos para esta Seccion/Modulo", "dashboard.php?data=notificar", "notify-error");
    _wm($usuario_datos[9], 'Acceso Denegado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
}
_wm($usuario_datos[9], 'Acceso Autorizado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
?>
<style>

    .titulo {

        margin-top: 10px;
        font-weight: bold;
        font-size: 13px;
        color: #b22222;
    }
    .input {
        font-style: oblique;
    }
</style>

<div id="contentHeader">
    <?php
    decode_get2($_SERVER["REQUEST_URI"], 2);
    $id = _antinyeccionSQL($_GET["np"]);
//decode_get2($_SERVER["REQUEST_URI"],1);  
    ?>

    <h2>Análisis Técnico- Económico</h2>
</div> <!-- #contentHeader -->	

<?php
$montoec = mysql_query("SELECT montoec FROM `gc_control_gestion2`
                    WHERE `n_proceso` = '$id'");
$monto = mysql_fetch_array($montoec);

if (isset($_POST['enviar'])) {

    $id_cgestion2 = $_POST['id_cgestion2'];
    $tipo_soli = $_POST['tipo_soli'];
    $monto1 = $_POST['monto1'];
    $enviado_presi = $_POST['enviado_presi'];
    $monto2 = $_POST['monto2'];
    $monto3 = $_POST['monto3'];
    $desviacion = $_POST['desviacion'];
    $valipdc = isset($_POST['pdc']) ? $_POST['pdc'] : '0';
    $validarpdc = $valipdc;
    $sql = mysql_query("SELECT * FROM `gc_control_gestion2`
                    WHERE `n_proceso` = '$id'
                    AND `tipo_solicitud` = '$tipo_soli'
                    ORDER BY `servicio` DESC
                    LIMIT 1 ");

    while ($row = mysql_fetch_array($sql)) {


        $conse = $row['servicio'];
    }
    $conse1 = $conse + 1;

    $correlativo = (explode('-', $id));
    $ano = date('Y');
    $actual = (explode("20", $ano));
    $servicio_completo = $tipo_soli . '-' . $id . '-00' . $conse1 . '-' . $actual[1];


    $status = mysql_query("update gc_control_gestion set estatus_servi=3 where n_proceso='$id' ");

    if ($validarpdc > 0) {
        $codigo = mysql_fetch_array(mysql_query("SELECT consecutivo('PRES', 'PDC', '" . date('Y') . "')"));
    }

    $montosp = $monto1;
    $montosc = str_replace('.', '', $montosp);
    $monto1_final = str_replace(',', '.', $montosc);
    
     $montosp2 = $monto2;
    $montosc2 = str_replace('.', '', $montosp2);
    $monto_final2 = str_replace(',', '.', $montosc2);
    
     $montosp3 = $monto3;
    $montosc3 = str_replace('.', '', $montosp3);
    $monto_final3 = str_replace(',', '.', $montosc3);

    $sql = "INSERT INTO `gc_control_gestion2` (servicio,`tipo_solicitud`,`montoec`,`enviado_presidencia`,`montooc`, `deviacion`, `montoate`, punto_cuenta, n_proceso, validacion_pdc, servicio_completo) VALUES"
            . " ('" . $conse1 . "','" . $tipo_soli . "','" . $monto1_final . "','" . $enviado_presi . "','" . $monto_final2 . "', '" . $desviacion . "','" . $monto_final3 . "','" . $codigo[0] . "', '" . $id . "', '" . $validarpdc . "','" . $servicio_completo . "')";
    $result = mysql_query($sql);

    if ($result) {
        notificar("Análisis Técnico- Económico ingresado con exito", "dashboard.php?data=controlg", "notify-success");
    } else {
        if ($SQL_debug == '1') {
            die('Error en Agregar Registro - 02 - Respuesta del Motor: ' . mysql_error());
        } else {
            die('Error en Agregar Registro');
        }
    }
}
?>


<!-- #contentHeader -->
<div class="container">
    <div class="row">
        <div class="grid-16">
            <div class="widget">
                <div class="widget-header"  > <span class="icon-folder-fill"></span>
                    <h3>Análisis Técnico- Económico <?php echo 'GC-' . $id . '-' . substr(date('Y'), -2) ?></h3>
                </div>

                <div class="widget-content">
                    <div class="row">
                        <form class="form validateForm" action="#" method="post" id="f1" name="f1" onsubmit="return montoAlto()" >


                            <div class="grid-24" style="margin-bottom: -25px;">
                                <div class="field-group">
                                    <div class="titulo">Tipo de Solicitud:</div>  
                                    <div class="field">

                                        <p class="input"> Análisis Técnico- Económico</p><input style="display:none" name="tipo_soli" id="tipo_soli" value="ATE" onkeypress="return enterDecimal(event)"/>

                                    </div>
                                </div>
                            </div>

                            <div class="grid-8">
                                <div class="field-group">
                                    <div class="titulo">Monto Estimación de Costo:</div>    
                                    <div class="field">
                                        <input type="text" name="monto1" id="monto1" size="16"  onkeyup="Sumar()" style="text-align: right" class="requerido" value="<?php echo number_format($monto['montoec'], 2, ',', '.');?>" readonly><span style="font-size: 13px; font-weight: bold;"> Bs.f</span>
                                        <input type="checkbox" name="validarec" class="validarmontos" id="1" size="16"/>
                                    </div>
                                </div> 
                                <div class="field-group">
                                    <div class="titulo">Monto Oferta Comercial:</div>     
                                    <div class="field">
                                        <input type="text" name="monto2" id="monto2" size="16" onkeyup="Sumar()"  onkeypress="return enterDecimal(event)" style="text-align: right" class="requerido" ><span style="font-size: 13px; font-weight: bold;"> Bs.f</span>
                                        <input type="checkbox" class="validarmontos" name="validaroc" id="2" size="16" />
                                    </div>
                                </div>

                            </div>
                            <div class="grid-8">

                                <div class="field-group">
                                    <div class="titulo">Monto ATE:</div>    
                                    <div class="field">
                                        <input type="text" name="monto3" id="monto3" size="16" readonly  style="text-align: right" class="requerido" ><span style="font-size: 13px; font-weight: bold;"> Bs.f</span>

                                    </div>
                                </div>
                                <div class="field-group">
                                    <div class="titulo">Desviación:</div>     
                                    <div class="field">

                                        <input type="text" name="desviacion" id="desviacion" size="16" style="width:40px" readonly style="text-align: right" class="requerido"/><span style="font-size: 13px; font-weight: bold;"> %</span>
                                    </div>
                                </div>

                            </div> 

                            <div class="grid-8">

                                <div class="field-group">
                                    <div class="titulo">Fecha de Envio:</div>  
                                    <div class="field">
                                        <input id="datepicker" name="enviado_presi" size="14" readonly class="requerido">
                                    </div>
                                </div>
                                <div class="field-group">
                                    <div class="titulo">Generar Punto de Cuenta:</div>   
                                    <div class="field">
                                        <input type="checkbox" name="pdc" id="pdc" class="validarpdc" size="16" value="1" checked />

                                    </div>
                                </div>
                            </div>

                            <div class="grid-24" align="center">
                                <table >

                                    <tr>
                                        <td align="center"><button type="submit" name="enviar" class="btn btn-primary">Enviar</button></td>
                                        <td align="center"><button type="button" name="Atras" onclick="javascript:window.history.back();" class="btn btn-error"/>Regresar</button></td>
                                    </tr>
                                </table>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="grid-8">				
        <div class="widget">			
            <div class="widget-header">
                <span class="icon-layers"></span>
                <h3></h3>
            </div>
            <div class="widget-content">
                <h3>Estimado, <?php echo $usuario_datos[1] . ' ' . $usuario_datos[2]; ?></h3>
                <p>En esta sección podrá ingresar el Análisis Técnico- Económico del proceso.</p>
                <!-- .pad -->
            </div>  

        </div>
    </div>
</div>
</div>
<script type="text/javascript">

    
    $(document).ready(function () {

        $(".validarmontos").click(function () {
            $(".validarmontos").removeAttr('checked');
            $(this).attr('checked', true);

            $("#monto3").val($('#' + 'monto' + $(this).attr('id')).val());
        });


    });

    $(document).ready(function () {

        $(".validarpdc").click(function () {
            $(".validarpdc").removeAttr('checked');
            $(this).attr('checked', true);

        });


    });

    function montoAlto() {


        var bandera = 0;
        $('.requerido').each(function () {
            if ($(this).val() == '') {

                bandera++;

            }

        });
        if (bandera > 0) {
            alert('Debe llenar todos los campos');
            return false;
        } else {
            var desv = document.getElementById('desviacion');

            if (desv.value > 15 || desv.value < -15) {
                alert("La desviación no se encuentra en el rango acorde")
                desv.focus();
                return false;
            } else
            {
                return true;
            }
        }



    }
    
    
    function Sumar() {

        document.f1.desviacion.value = '';
        var a = document.f1.monto1.value;
        var b = document.f1.monto2.value;
        var asc = a.replace('.', '');
        var asp = asc.replace(',', '.');
        var bsc = b.replace('.', '');
        var bsp = bsc.replace(',', '.');

        if (a.length > 4 && b.length > 4) {


            var c = ((parseInt(asp) - parseInt(bsp)) / parseInt(bsp) * 100);

            var d = Math.round(c);

            document.f1.desviacion.value = d;

        }
    }


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

    $(function () {
        $.datepicker.setDefaults($.datepicker.regional["es"]);
        $("#datepicker").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "2000:2015",
            minDate: '0'
        });
    });

    function conMayusculas(field) {
        field.value = field.value.toUpperCase()
    }
    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    function valido(e) {
        tecla = (document.all) ? e.keyCode : e.which;
        tecla = String.fromCharCode(tecla)
        return /^[0-9\%]+$/.test(tecla);
    }
</script>
