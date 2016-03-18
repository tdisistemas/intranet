|<?php
if (array_pop(explode('/', $_SERVER['PHP_SELF'])) != 'dashboard.php') {
    ir("../../dashboard.php");
}
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
    notificar("Usted no tiene permisos para esta Sección/Módulo", "dashboard.php?data=notificar", "notify-error");
    _wm($usuario_datos[9], 'Acceso Denegado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
}
_wm($usuario_datos[9], 'Acceso Autorizado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
_bienvenido_mysql();

$parametros = 'cedula=' . $usuario_datos[3];
$parametros = _desordenar($parametros);


$arreglo = parametrosReporte(array(
    array('cedulaE', $usuario_datos[3])
        ));
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
                                        <h3>Inclusión / Exclusión FAS</h3>
                                    </div>
                                    <br>
                                    <div class="grid-24" style="display: initial">
                                        <div class="field-group">	
                                            <label style="color:#B22222">Movimiento:</label>
                                            <div class="field-group">	
                                                <select id="movimiento" name="Movimiento." class="Requerido" onchange="javascript:TiposdeMovimientos(this)">
                                                    <option value="1" selected> Incluir </option>
                                                    <option value="2"> Excluir </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-24 Incluir" style="display: initial">
                                        <div class="grid-6">
                                            <div class="field-group">								
                                                <label style="color:#B22222">Nombres:</label>
                                                <div class="field">
                                                    <input id="p_nombre" name="Primer Nombre." class="Requerido" style="max-width: 200px;" placeholder="Primer Nombre"/>
                                                    <input id="s_nombre" name="Segundo Nombre." class="" style="max-width: 200px;" placeholder="Segundo Nombre"/>
                                                </div>
                                            </div>
                                            <div class="field-group">
                                                <label style="color:#B22222">Apellidos:</label>
                                                <div class="field">
                                                    <input id="p_apellido" name="Primer Apellido." class="Requerido" style="max-width: 200px;" placeholder="Primer Apellido"/>
                                                    <input id="s_apellido" name="Segundo Apellido." class="Requerido" style="max-width: 200px;" placeholder="Segundo Apellido"/>
                                                </div>
                                            </div> <!-- .field-group -->	
                                        </div>
                                        <div class="grid-6">
                                            <div class="field-group">
                                                <label style="color:#B22222; margin-bottom: 0px">Cédula:</label>
                                                <div class="field" style="margin-bottom: 15px">
                                                    <input id="cedula_persona" name="Cédula." class="Requerido" style="max-width: 200px;" onkeypress="return esnumero(event)" placeholder="C.I. de la persona a incluir."/>
                                                </div>
                                            </div> <!-- .field-group -->
                                            <div class="field-group">
                                                <label style="color:#B22222; margin-bottom: 0px">Sexo:</label>
                                                <div class="field" style="margin-bottom: 15px">
                                                    <select id="sexo" name="Sexo." class="Requerido" style="max-width: 300px;">
                                                        <option value=""> ** Seleccionar ** </option>
                                                        <option value="Femenino"> Femenino </option>
                                                        <option value="Masculino"> Masculino </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="field-group">								
                                                <label style="color:#B22222; margin-bottom: 0px">Fecha de Nacimiento:</label>
                                                <div class="field" style="margin-bottom: 15px">
                                                    <input id="fecha_nacimiento" name="Fecha de Nacimiento." class="datepicker Requerido" style="min-width: 20%; max-width: 250px" readonly>
                                                </div>
                                            </div> <!-- .field-group -->
                                        </div>
                                        <div class="grid-6">
                                            <div class="field-group">
                                                <label style="color:#B22222; margin-bottom: 0px">Parentesco:</label>
                                                <div class="field" style="margin-bottom: 15px">
                                                    <select id="parentesco" name="Parentesco." class="Requerido" style="max-width: 300px;">
                                                        <option value=""> ** Seleccionar ** </option>
                                                        <option value="Progenitor(a)"> Progenitor(a) </option>
                                                        <option value="Conyugue"> Conyugue </option>
                                                        <option value="Hijo(a)"> Hijo(a) </option>
                                                        <option value="Otro(a)"> Otro(a) </option>
                                                    </select>
                                                </div>
                                            </div> <!-- .field-group -->
                                            <div class="field-group">
                                                <label style="color:#B22222; margin-bottom: 0px">Motivo:</label>
                                                <?php
                                                $sqlquery = "SELECT id_motivo, descripcion FROM fas_IE_motivos";
                                                $query = mysql_query($sqlquery . " WHERE tipo = 'I'");
                                                ?>
                                                <div class="field" style="margin-bottom: 15px">
                                                    <select id="motivo_int" name="Motivo." class="Requerido" style="max-width: 300px;">
                                                        <option value=""> ** Seleccionar ** </option>
                                                        <?php
                                                        while ($respuesta = mysql_fetch_array($query)) {
                                                            ?>
                                                            <option value="<?php echo $respuesta['id_motivo'] ?>"> <?php echo $respuesta['descripcion'] ?> </option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid-24" style="margin-top: 0px; display: initial; text-align: center">
                                            <div class="field-group" style="text-align: center; width: 95%">
                                                <button type="button" id="Generar" class="btn btn-error" onclick="javascript:IncluirFamiliar('<?= $parametros ?>')">Registrar Familiar</button>
                                            </div> <!-- .field-group -->
                                        </div>
                                        <div class="grid-24" style="text-align: left; width: 90%">
                                            <div class="grid-24" style="width: 100%; text-align: center; font-size: 14px;margin-bottom: -15px">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                    <th style="width: 15%; text-align: center; color:#B22222; ">Cédula</th>
                                                    <th style="width: 35%; text-align: center; color:#B22222">Nombres y Apellidos</th>
                                                    <th style="width: 15%; text-align: center; color:#B22222">Parentesco</th>
                                                    <th style="width: 35%; text-align: center; color:#B22222">Motivo</th>
                                                    <th colspan="8" style="width: 15%;text-align: center;vertical-align: middle"></th>
                                                    </thead>
                                                    <tbody id="Tabla-Inclusiones">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="grid-24" style="margin-top: 0px; display: initial; text-align: center">
                                            <div class="field-group" style="text-align: center; width: 95%">
                                                <button type="button" id="Generar" class="btn btn-error" onclick="javascript:RegistrarInclusion('<?php echo $parametros ?>')">Registrar Inclusión</button>
                                            </div> <!-- .field-group -->
                                        </div>
                                    </div>
                                    <div class="grid-24 Excluir" style="display: none">
                                        <div class="grid-24" style="text-align: left; width: 90%">
                                            <div class="grid-24" style="width: 100%; text-align: center; font-size: 14px;margin-bottom: -15px">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                    <th style="width: 15%; text-align: center; color:#B22222; ">Cédula</th>
                                                    <th style="width: 35%; text-align: center; color:#B22222">Nombres y Apellidos</th>
                                                    <th style="width: 15%; text-align: center; color:#B22222">Parentesco</th>
                                                    <th style="width: 35%; text-align: center; color:#B22222">Motivo</th>
                                                    <th colspan="8" style="width: 15%;text-align: center;vertical-align: middle"></th>
                                                    </thead>
                                                    <tbody id="Tabla-Exclusiones">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="grid-24" style="margin-top: 0px; display: initial; text-align: center">
                                            <div class="field-group" style="text-align: center; width: 95%">
                                                <button type="button" id="Generar" class="btn btn-error" onclick="javascript:ExcluirFamiliar('<?php echo $parametros ?>')">Excluir</button>
                                            </div> <!-- .field-group -->
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
                    <p>En esta sección podrá hacer la Inclusión y/o Exclusión de carga familiar en el FAS-Metro.<b></b></p>
                    <div class="box plain">
                        <a class="btn btn-primary btn-large dashboard_add"  href="dashboard.php?data=Historial_FAS&'<?= $parametros ?>'">Historial</a>
                        <a class="btn btn-primary btn-large dashboard_add" onclick="javascript:window.history.back();">Regresar</a>
                    </div>
                </div>
            </div><!-- .grid -->
        </div><!-- .grid -->
    </div>
</div>
<form id="Reportador" action="gen_report/reportes.php" method="post" target="_blank">
    <input id="array" name="array" type="hidden" value="<?= $arreglo ?>" >
    <input id="jasper" name="jasper" type="hidden" value="fas/fas_inclu_exclu.jasper" >
    <input id="nombresalida" name="nombresalida" type="hidden" value="FAS" >
    <input id="formato" name="formato" type="hidden" value="pdf" >
</form>
<?php
_adios_mysql();
?>
<script>
    $(document).ready(function () {
        VerificarMovimiento('<?= $parametros ?>', 'Exclusiones');
        VerificarMovimiento('<?= $parametros ?>', 'Inclusiones');
    });
    function VerificarFas() {
        $('#Reportador').submit();
    }
    $.datepicker.setDefaults($.datepicker.regional["es"]);
    $(".datepicker").datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        maxDate: '0'
    });

    function TiposdeMovimientos(obj) {
        if (obj.value == '1') {
            Mostrar('.Incluir');
            Ocultar('.Excluir');
        }
        if (obj.value == '2') {
            Mostrar('.Excluir');
            Ocultar('.Incluir');
        }
    }

    function Ocultar(obj) {
        $(obj).animate({opacity: 0, height: "hide"}, 500);
    }
    function Mostrar(obj) {
        $(obj).animate({opacity: 1, height: "show"}, 500);
    }

    function Incluir(Indice) {
        $('.Familiares_excluir_' + Indice).removeAttr('checked');
        $('.Familiares_incluir_' + Indice).attr('checked', true);
    }
    function Excluir(Indice) {
        $('.Familiares_incluir_' + Indice).removeAttr('checked');
        $('.Familiares_excluir_' + Indice).attr('checked', true);
    }

    function esnumero(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        } else {
            return true;
        }
    }

    function conMayusculas(field) {
        field.value = field.value.toUpperCase()
    }


    function validarLetras(e) { // 1
        tecla = (document.all) ? e.keyCode : e.which;
        if (tecla == 8)
            return true; // backspace
        if (tecla == 32)
            return true; // espacio
        if (e.ctrlKey && tecla == 86) {
            return true;
        } //Ctrl v
        if (e.ctrlKey && tecla == 67) {
            return true;
        } //Ctrl c
        if (e.ctrlKey && tecla == 88) {
            return true;
        } //Ctrl x

        patron = /[a-zA-Z]/; //patron

        te = String.fromCharCode(tecla);
        return patron.test(te); // prueba de patron
    }


    function VerificarMovimiento(parametro, tipo) {
        $.ajax({
            url: 'modules/fas/Movimientos.php?flag=1&' + parametro,
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

    function AsignarResultado(data, zona) {
        var lista = '';

        if (zona == 'Tabla-Exclusiones') {
            if (data.campos > 0) {
                var aux = 0;
                var i;
                while (aux < data.campos)
                {

                    lista += '<tr>\n\
                            <td style="text-align: center;vertical-align: middle">' + data.datos[aux].cedula_familiar + '</td>\n\
                            <td class="escondido" style="text-align: center;vertical-align: middle">' + data.datos[aux].nombre_familiar + '</td>\n\
                            <td style="text-align: center;vertical-align: middle">' + data.datos[aux].parentesco + '</td>\n\
                            <td style="text-align: center;vertical-align: middle">\n\
<?php $query_exc = mysql_query($sqlquery . " WHERE tipo = 'E'"); ?>\n\
                                        <select id="Motivo_exclu_' + (aux + 1) + '" class"Requerido" style="max-width: 300px;">\n\
                                            <option value=""> ** Seleccionar ** </option>\n\
<?php while ($excl = mysql_fetch_array($query_exc)) { ?>\n\
                                                                                <option value="<?php echo $excl['id_motivo'] ?>"> <?php echo $excl['descripcion'] ?> </option>\n\
<?php } ?>\n\
                                        </select>\n\
                            <td style="text-align: center;vertical-align: middle">';
                    if (data.datos[aux].status == 0) {
                        lista += '<input type="checkbox" class="exclu_" id="exclu_' + (aux + 1) + '" value="' + data.datos[aux].cedula_familiar + '" />\n\
                            </td>\n\
                    </tr>'
                    } else {
                        lista += '<i class="fa fa-history" title="En espera."> </i>\n\
                        </td>\n\
                    </tr>'
                    }
                    aux++;
                }
            } else {
                lista = '<tr><td colspan="5" class="SinRegistro">  *** No posee familiares registrados en FAS-Metro *** </td></tr>'
            }
        } else {

            if (data.campos > 0) {
                var aux = 0;
                var i;
                while (aux < data.campos)
                {

                    lista += '<tr>\n\
                <td style="text-align: center;vertical-align: middle">' + data.datos[aux].cedula_familiar + '</td>\n\
                        <td class="escondido" style="text-align: center;vertical-align: middle">' + data.datos[aux].nombre + '</td>\n\
                        <td style="text-align: center;vertical-align: middle">' + data.datos[aux].parentesco + '</td>\n\
                        <td style="text-align: center;vertical-align: middle">' + data.datos[aux].motivo + '</td>\n\
                        <td style="text-align: center;vertical-align: middle">';
                    if (data.datos[aux].status == 0) {
                        lista += '<input type="checkbox" class="inclu_" id="inclu_' + (aux + 1) + '" value="' + data.datos[aux].cedula_familiar + '" />\n\
                        </td>\n\
                </tr>';
                    } else {
                        lista += '<i class="fa fa-history" title="En espera."> </i>\n\
                        </td>\n\
                </tr>';
                    }
                    aux++;
                }
            } else {
                lista = '<tr><td colspan="5" class="SinRegistro"> *** No posee personas registradas para realizar la Inclusión *** </td></tr>'
            }

        }
        document.getElementById(zona).innerHTML = lista;
        $(".uniformSelect").uniform();

    }

    function RegistrarInclusion(parametrosGenerales) {
        var bandera = 0;
        var parametros = [];
        $('.inclu_:checked').each(function () {
            var variables = {
                cedula: $(this).val()
            };
            parametros.push(variables);
            bandera++;
        });
        var Data = JSON.stringify(parametros);
        if (bandera > 0) {
            $.alert({
                type: 'confirm'
                , title: 'Alerta'
                , text: '<h3>¿Seguro que desea realizar esta acción?</h3><h5><i></i></h5><br>'
                , callback: function () {
                    $.ajax({
                        url: 'modules/fas/Movimientos.php?flag=1&' + parametrosGenerales,
                        method: 'GET',
                        dataType: 'JSON',
                        data: {
                            acc: 'incluir-registro',
                            data: Data
                        },
                        success: function (data) {
                            $.alert({
                                type: 'alert'
                                , title: 'Información'
                                , text: '<h5><i>' + data.mensaje + '.</i></h5><br>'
                            });
                            AsignarResultado(data, 'Tabla-Inclusiones');
                        }
                    });
                }
            });

        } else {
            $.alert({
                type: 'alert'
                , title: 'Alerta'
                , text: '<h3>Acción Invalida!.</h3><h5><i>Es necesario seleccionar por lo menos a una carga familiar para realizar esta operación.</i></h5><br>'
            });
        }
    }
    function ExcluirFamiliar(parametrosGenerales) {
        var bandera = 0;
        var contador = 0;
        var parametros = [];
        $('.exclu_:checked').each(function () {
            contador++;
            if ($('#Motivo_' + $(this).attr('id') + '').val() !== '') {
                var variables = {
                    cedula: $(this).val(),
                    motivo: $('#Motivo_' + $(this).attr('id') + '').val()
                };
                parametros.push(variables);
            } else {
                bandera = 1;
            }
        });
        var Data = JSON.stringify(parametros);
        if (bandera === 0 && contador > 0) {
            $.alert({
                type: 'confirm'
                , title: 'Alerta'
                , text: '<h3>¿Seguro que desea realizar esta acción?</h3><h5><i>Todas las personas seleccionadas quedaran excluidas de los beneficios ofrecidos por FAS-Metro.</i></h5><br>'
                , callback: function () {
                    $.ajax({
                        url: 'modules/fas/Movimientos.php?flag=1&' + parametrosGenerales,
                        method: 'GET',
                        dataType: 'JSON',
                        data: {
                            acc: 'excluir',
                            data: Data
                        },
                        success: function (data) {
                            $.alert({
                                type: 'alert'
                                , title: 'Información'
                                , text: '<h5><i>' + data.mensaje + '.</i></h5><br>'
                            });
                            AsignarResultado(data, 'Tabla-Exclusiones');
                        }
                    });
                }
            });

        } else {
            if (contador <= 0) {
                $.alert({
                    type: 'alert'
                    , title: 'Alerta'
                    , text: '<h3>Acción Invalida!.</h3><h5><i>Es necesario seleccionar por lo menos a una carga familiar para realizar esta operación.</i></h5><br>'
                });
            } else {
                $.alert({
                    type: 'alert'
                    , title: 'Alerta'
                    , text: '<h3>Todos los campos son requeridos!</h3><h5><i>Para realizar la exclusión, es necesario especificar el motivo.</i></h5><br>'
                });
            }
        }
    }
    function IncluirFamiliar(parametros, nombre) {
        var lista = '<b>Campos Necesarios: </b><br><i>';
        var bandera = 0;
        var msj = '';
        var msj2 = '';
        var motivo = $('#motivo_int').val();
        var primer_N = $('#p_nombre').val();
        var segundo_N = $('#s_nombre').val();
        var primer_A = $('#p_apellido').val();
        var segundo_A = $('#s_apellido').val();
        var cedula_persona = $('#cedula_persona').val();
        var sexo = $('#sexo').val();
        var fecha_nacimiento = $('#fecha_nacimiento').val();
        var parentesco = $('#parentesco').val();

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
                        url: 'modules/fas/Movimientos.php?flag=1&' + parametros,
                        method: 'GET',
                        dataType: 'JSON',
                        data: {
                            acc: 'incluir',
                            nombre1: primer_N,
                            nombre2: segundo_N,
                            apellido1: primer_A,
                            apellido2: segundo_A,
                            cedula_persona: cedula_persona,
                            fecha_nacimiento: fecha_nacimiento,
                            parentesco: parentesco,
                            sexo: sexo,
                            motivo: motivo
                        },
                        success: function (data) {
                            if (data.mensaje == 'Exito') {
                                AsignarResultado(data, 'Tabla-Inclusiones');
                                msj = 'Persona registrada con éxito en el sistema!';
                                msj2 = 'Para realizar la Solicitud de Inclusión del FAS-Metro, seleccione a la o las personas que desea Incluir de la Lista de Personas Registradas.';
                            } else {
                                msj2 = 'Ocurrio un error al tratar de registrar, por favor intente de nuevo. ';
                                msj = '';
                            }
                            $.alert({
                                type: 'alert'
                                , title: 'Alerta'
                                , text: '<h3>' + msj + '</h3><i>' + msj2 + '</i>'
                            });
                        }
                    });
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







