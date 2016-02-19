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
?>

<style>
    label{
        font-weight: bold;  
        font-size: 15px;
    }
</style>

<div id="contentHeader">
    <h2>FAS Metro</h2>  
</div>
<div class="container">
    <?php include('notificador.php'); ?>
    <div class="grid-24" style="text-align: center">
        <?php
        $_SESSION['fas'] = $anticachecret;
        $estatus = _dameestatus($usuario_datos[3]);
        if ($estatus != 1) {
            ?>
            <form id="FAS-FORM" action="modules/fas/pdf.php?token=<?php echo $anticachecret; ?>" method="POST">
                <div class="widget widget-table">
                    <div class="widget-header" style="text-align: left"> <i class="icon-book"></i>
                        <h3 class="icon chart">FAS Metro - Proceso de Inscripción <?=date('Y')?></h3>
                    </div>
                    <div class="widget-content">
                        <table  class="table table-bordered table-striped ">
                            <thead>
                                <tr>
                                    <th style="width:10%; text-align: center; vertical-align: middle">Cédula </th>
                                    <th style="width:25%; text-align: center; vertical-align: middle">Nombres</th>  
                                    <th style="width:10%; text-align: center; vertical-align: middle">Fecha de Nacimiento</th>
                                    <th style="width:10%; text-align: center; vertical-align: middle">Parentesco</th>
                                    <th style="width:25%; text-align: center; vertical-align: middle">¿Padece Alguna Enfermedad?</th>
                                    <th style="width:10%; text-align: center; vertical-align: middle">Vida y Accidente (%)</th>
                                    <th style="width:10%; text-align: center; vertical-align: middle">Cobertura H.C.M. (FAS)</th>
                                </tr>
                            </thead>
                            <?php
                            $aux = 0;
                            $sql = mysql_query("SELECT * FROM `datos_familiares_rrhh`  WHERE cedula_empleado=$usuario_datos[3]   and parentesco!='titular' ");
                            while ($row_cont = mysql_fetch_array($sql)) {
                                $cedula = $row_cont['cedula_familiar'];
                                $edad = calculaedad($row_cont["fecha_nac"]);
                                ?>
                                <tr class="gradeA">
                                    <td style="text-align: center; vertical-align: middle"><?php
                                        if ($cedula == 0) {
                                            echo $row_cont["cedula_empleado"];
                                        } else {
                                            echo $row_cont["cedula_familiar"];
                                        }
                                        ?></td>
                                    <td style="text-align: center; vertical-align: middle"><?php echo $row_cont["nombres"] ?></td>

                                    <td style="text-align: center; vertical-align: middle"><?php echo $row_cont["fecha_nac"] ?></td>
                                    <td style="text-align: center; vertical-align: middle"><?php echo $row_cont["parentesco"]; ?></td>
                                    <td style="text-align:center;vertical-align: middle;">
                                        <input type="text"  name="familiares[]" value="<?= $cedula ?>" style="display: none">
                                        <input type="checkbox" name="" class="Enfermedad_Si_<?= $aux ?>" value="SI" onclick="Enfermedad_Si('<?= $aux ?>')" style="display: inline-block"> Si
                                        <input type="checkbox" name="familiares[]" class="Enfermedad_No_<?= $aux ?>" value="NO" onclick="Enfermedad_No('<?= $aux ?>')" checked> No <br>
                                        <input type="text" class="Especificar" name="familiares[]" title="Especificar" value="" style="width:50%"  id="Enfermedad_<?= $aux ?>" disabled>
                                    </td>
                                    <td style="text-align:center;vertical-align: middle;">
                                        <div id="lineas">
                                            <input type="text" name="familiares[]" class="importe_linea Poliza" onkeypress="return esnumero(event)" value="0" style="width:50%" >
                                        </div>
                                    </td>
                                    <td style="text-align:center;vertical-align: middle;">
                                        <?php
                                        if ($row_cont['parentesco'] != 'Otro(a)') {
                                            ?>
                                            <input type="checkbox" name="familiares[]"  id="" class="Familiares_incluir_<?= $aux ?>" onchange="javascript: Incluir('<?= $aux ?>')" value="1"> Si <br>
                                            <?php
                                        }
                                        ?>
                                        <input type="checkbox" name="familiares[]"  id="" class="Familiares_excluir_<?= $aux ?>" onchange="javascript: Excluir('<?= $aux ?>')" checked value="0"> No
                                    </td>

                                    <?php
                                    $aux++;
                                }
                                ?>
                            </tr>
                        </table>
                    </div>
                </div>
                <div align="center">
                    <div class="field">  
                        <label for="required">¿Incluye Maternidad? (Conyuge o titular)</label></br>
                        <input type="radio" name="maternidad" id="si" value="Si" size="15"  />Si   
                        <input type="radio" name="maternidad" id="no" value="No" size="15" checked />No 
                    </div>
                    <div class="field">   
                        <label for="required">¿Fuma Habitualmente?</label></br>
                        <input type="radio"  name="fuma" id="si" value="Si" size="15"  />Si   
                        <input type="radio" name="fuma" id="no" value="No" size="15"  checked />No 
                    </div>
                    <div class="field">  
                        <label for="required">¿Posee algún familiar dentro de la Empresa?</label></br>
                        <input type="radio" onchange="verifica_ced()" name="familiar" id="si" value="Si" size="15"  />Si   
                        <input type="radio" onchange="nada_ced()" name="familiar" id="no" value="No" size="15"  checked />No 
                        <div id="cedula_f"></div>
                    </div>
                    <div class="field">    
                        <label for="required">¿Posee algún seguro privado?</label></br>
                        <input type="radio" onchange="verifica()" name="poliza" id="si" value="Si" size="15"  />Si   
                        <input type="radio" onchange="nada()" name="poliza" id="no" value="No" size="15"  checked />No 
                        <div id="poliza"></div>
                    </div>
                    <div class="field">  
                        <label for="required">¿Ha sido intervenido alguna vez?</label></br>
                        <input type="radio" name="intervencion" onchange="verifica_int()" id="si" value="Si" size="15"  />Si   
                        <input type="radio" name="intervencion" onchange="nada_int()" id="no" value="No" size="15"  checked />No 
                        <div id="int"></div>
                    </div>
                    <br><br>
                </div>
                <div align="center">

                    <input style="" class="btn btn-error" type="text" onclick="javascript: calcular_total()" value="Realizar Inscripción" />
                <?php } else { ?>
                    <p style="font-size:15px;"><b>Nota:</b> <i>Este usuario ya ha realizado la inscripción para el año <?=date('Y')?>.</i></p>
                    <input style="" class="btn btn-error" type="text" onclick="javascript:VerificarFas()" value="Visualizar Planilla" /> 
                    <?php
                }
                _adios_mysql();
                ?>
            </div>
        </form>
    </div>
    <?php
    $arreglo = parametrosReporte(array(
        array('cedulaE', $usuario_datos[3])
    ));
    ?>
    <form id="Reportador" action="gen_report/reportes.php" method="post" target="_blank">
        <input id="array" name="array" type="hidden" value="<?= $arreglo ?>" >
        <input id="jasper" name="jasper" type="hidden" value="fas/insc_fas.jasper" >
        <input id="nombresalida" name="nombresalida" type="hidden" value="FAS" >
        <input id="formato" name="formato" type="hidden" value="pdf" >
    </form>
</div>
<script>
    function VerificarFas() {
        $('#Reportador').submit();
    }
    $('.Poliza').change(function () {
        if ($(this).val() === '') {
            $(this).val('0');
        }

    });
    function Enfermedad_Si(Indice) {
        $('#Enfermedad_' + Indice).removeAttr('disabled');
        $('#Enfermedad_' + Indice).attr('required', true);
        $('#Enfermedad_' + Indice).focus();
        $('.Enfermedad_Si_' + Indice).attr('checked', true);
        $('.Enfermedad_No_' + Indice).removeAttr('checked');
    }
    function Enfermedad_No(Indice) {
        $('#Enfermedad_' + Indice).attr('disabled', true);
        $('#Enfermedad_' + Indice).removeAttr('required');
        $('.Enfermedad_No_' + Indice).attr('checked', true);
        $('.Enfermedad_Si_' + Indice).removeAttr('checked');
    }
    function Incluir(Indice) {
        $('.Familiares_excluir_' + Indice).removeAttr('checked');
        $('.Familiares_incluir_' + Indice).attr('checked', true);
    }
    function Excluir(Indice) {
        $('.Familiares_incluir_' + Indice).removeAttr('checked');
        $('.Familiares_excluir_' + Indice).attr('checked', true);
    }
    function calcular_total() {
        var importe_total = 0;
        var requerido = 0;
        $(".importe_linea").each(
                function (index, value) {
                    importe_total = importe_total + eval($(this).val());
                }
        );
        $(".Especificar").each(function () {
            if ($(this).attr('required') && $(this).val() == '') {
                $.alert({
                    type: 'alert',
                    title: 'Alerta',
                    text: '<h3>Todos los campos son requeridos!</h3><p> Debe especificar enfermedad.</p>'
                });
                requerido = 1;
                return false;
            }

        });
        if (requerido > 0) {
            return false;
        }
        if (importe_total > 100) {
            $.alert({
                type: 'alert',
                title: 'Alerta',
                text: '<p>El % de Vida y Accidente no puede ser mayor al 100%.</p>'
            });
            return false;
        }
        if (importe_total < 100) {
            $.alert({
                type: 'alert',
                title: 'Alerta',
                text: '<p>El % de Vida y Accidente no puede ser menor al 100%.</p>'
            });
            return false;
        }
        $.alert({
            type: 'confirm',
            title: 'Confirmar',
            text: '<h3>¿Estas de acuerdo con la información suministrada?</h3><p>De ser correcto procederemos a guardar los datos y no podrán ser modificados!</p>',
            callback: function () {
                $('#FAS-FORM').submit();
            }
        });

    }
    function esnumero(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        } else {
            return true;
        }
    }
    function verifica() {


        var si = document.getElementById("si").value;
        if (si == 'Si') {
            $("div#poliza").load("modules/fas/verifica.php?=" + si);
        }

    }
    function nada() {


        var no = document.getElementById("no").value;
        if (no == 'No') {
            $("div#poliza").load("modules/fas/nada.php");
        }
    }

    function verifica_ced() {


        var si = document.getElementById("si").value;
        if (si == 'Si') {
            $("div#cedula_f").load("modules/fas/cedula_empleado_fam.php?=" + si);
        }

    }
    function nada_ced() {


        var no = document.getElementById("no").value;
        if (no == 'No') {
            $("div#cedula_f").load("modules/fas/nada.php");
        }
    }

    function verifica_int() {


        var si = document.getElementById("si").value;
        if (si == 'Si') {
            $("div#int").load("modules/fas/intervencion.php?=" + si);
        }

    }
    function nada_int() {


        var no = document.getElementById("no").value;
        if (no == 'No') {
            $("div#int").load("modules/fas/nada.php");
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



</script>







