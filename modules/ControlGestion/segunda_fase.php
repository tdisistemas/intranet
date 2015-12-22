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


<div id="contentHeader">
    <?php
    decode_get2($_SERVER["REQUEST_URI"], 2);
    $id = _antinyeccionSQL($_GET["np"]);
//decode_get2($_SERVER["REQUEST_URI"],1);  
    ?>

    <h2>Estimación de Costos</h2>
</div> <!-- #contentHeader -->	

<?php
if (isset($_POST['enviar'])) {

    $id_cgestion2 = $_POST['id_cgestion2'];
    $tipo_soli = $_POST['tipo_soli'];
    $monto1 = $_POST['monto1'];
    $enviado_presi = $_POST['enviado_presi'];
    $recibido_presi = $_POST['recibido_presi'];



    $sql = mysql_query("SELECT *
                    FROM `gc_control_gestion2`
                    WHERE `n_proceso` = '$id'
                    AND `tipo_solicitud` = '$tipo_soli'
                    ORDER BY `servicio` DESC
                    LIMIT 1 ");

    while ($row = mysql_fetch_array($sql)) {

        $caracteristica = $row['caracteristicas'];
        $conse = $row['conse'];
    }

    $correlativo = (explode('-', $id));
    $ano = date('Y');
    $actual = (explode("20", $ano));
    $conse1 = $conse + 1;
    $servicio_completo = $tipo_soli. '-'. $id. '-00'. $conse1. '-'. $actual[1];

    $status = mysql_query("update gc_control_gestion set estatus_servi=1 where n_proceso='$id' ");
    $sql = "INSERT INTO `gc_control_gestion2` (servicio,`tipo_solicitud`,montoec,`enviado_presidencia`, `recibido_presidencia`, n_proceso, servicio_completo) VALUES"
            . " ('" . $conse1 . "','" . $tipo_soli . "','" . $monto1 . "','" . $enviado_presi . "', '" . $recibido_presi . "', '" . $id . "', '" . $servicio_completo . "')";
    $result = mysql_query($sql);
    if ($result) {
        notificar("Estimación de Costo ingresada con exito", "dashboard.php?data=controlg", "notify-success");
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


                    <h3>Estimación de Costos <?php echo 'GC-' . $id . '-' . substr(date('Y'), -2) ?></h3>

                </div>

                <div class="widget-content">
                    <div class="row">
                        <form class="form validateForm" action="#" method="post"  onsubmit="return validarForm(this)" >

                            <div class="grid-4">
                            </div>
                            <div class="grid-6">
                                <div class="field-group">
                                    <label>Tipo de Solicitud:<br></label>   
                                    <div class="field">
                                        Estimación de Costo<input style="display:none" type="text" name="tipo_soli" id="tipo_soli" size="16" value="EC" />

                                    </div>
                                </div>
                                <div class="field-group">
                                    <label for="datepicker">Fecha de Envio:</br></label>   
                                    <div class="field">
                                        <input id="datepicker" name="enviado_presi" size="14" readonly >
                                    </div>
                                </div>

                            </div>
                            <div class="grid-4">
                            </div>
                            <div class="grid-8">
                                <div class="field-group">
                                    <label for="required">Monto Estimación de Costo:</br></label>   
                                    <div class="field">
                                        <input type="text" name="monto1" id="monto1" size="16" placeholder="Monto Bsf EC." onkeypress="return isNumberKey(event)"/>
                                    </div>
                                </div>
                                <div class="field-group">
                                    <label for="datepicker">Fecha de Recepción:</br></label>   
                                    <div class="field">
                                        <input id="datepicker1" name="recibido_presi" size="14" readonly>
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
                <p>En esta sección podrá ingresar la Estimación de costo del proceso.</p>
                <!-- .pad -->
            </div>  

        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    function validarForm(formulario) {

        if (formulario.monto1.value.length == 0) { //¿Tiene 0 caracteres?
            formulario.monto1.focus();    // Damos el foco al control
            alert('Debe ingresar un Monto'); //Mostramos el mensaje
            return false; //devolvemos el foco
        }


    }

    $(function () {
        $.datepicker.setDefaults($.datepicker.regional["es"]);
        $("#datepicker").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "2000:2015",
            minDate: '0',
            onSelect: function (fecha,event){$('#datepicker1').datepicker("option","minDate",fecha);}
        });
    });
    $(function () {
        $.datepicker.setDefaults($.datepicker.regional["es"]);
        $("#datepicker1").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "2000:2015"
        });
    });

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
    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
    javascript</script>

