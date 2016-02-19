<?php
if (array_pop(explode('/', $_SERVER['PHP_SELF'])) != 'dashboard.php') {
    header("Location: ../../dashboard.php");
}
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
    notificar("Usted no tiene permisos para esta Seccion/Modulo", "dashboard.php?data=notificar", "notify-error");
    _wm($usuario_datos[9], 'Acceso Denegado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
}
_wm($usuario_datos[9], 'Acceso Autorizado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');

decode_get2($_SERVER["REQUEST_URI"], 2);
_bienvenido_mysql();
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
    <h2>Citas</h2>
</div> <!-- #contentHeader -->	
<?php
$correo = _antinyeccionSQL($_GET['correo']);
$cedula = _antinyeccionSQL($_GET['cedula']);
$nombre = _antinyeccionSQL($_GET['nombre']);
$origen = _antinyeccionSQL($_GET['Origen']);


if (isset($_POST['Submit'])) {

    $fecha = $_POST['FechaCita'];
    $hora = $_POST['HoraCita'];
    $motivo = $_POST['MotivoCita'];
    $cedula = $_POST['CedulaCita'];
    $nombre = $_POST['NombreCita'];
    $correo = $_POST['CorreoCita'];
    $investigador = $usuario_datos[3];

    $nombres = $usuario_datos['nombre'] . " " . $usuario_datos['apellido'];
    $mensajedelcorreo = "<img src='http://192.168.0.5/iconos/encamail.jpg' /><br><br>"
            . "<h3>Estimado, " . $nombre . "</h3>" . "<br /><h4> La presente es para informarle que es requerida su presencia "
            . "en las oficinas de Asuntos Internos, el día " . $fecha[8] . $fecha[9] . "/" . $fecha[5] . $fecha[6] . " a la(s) " . $hora . ", por motivo: " . $motivo . ".</h4>"
            . "<br /><br /><p>Agradeciendo su presencia y puntual asistencia, <br> <b>Gerencia de Seguridad Integral</b>";
    _enviarmail($mensajedelcorreo, $nombre . ' ' . $apellido, trim($correo), 'Cita');

    $sql = "INSERT INTO ai_citas(fecha,hora,motivo,empleado,fecha_creada,investigador) VALUES('" . $fecha . "','" . $hora . "','" . $motivo . "'," . $cedula . ",NOW()," . $investigador . ")";
    $result = mysql_query($sql);
    if ($result) {
        notificar("Cita registrada con éxito", "javascript:window.history.go(-2)", "notify-success");
    } else {
        if ($SQL_debug == '1') {
            die('Error en Agregar Registro - 02 - Respuesta del Motor: ' . mysql_error());
        } else {
            die('Error en Agregar Registro');
        }
    }
} else {
    ?>
    <div class="container">
        <div class="row">
            <form class="form uniformForm validateForm" id="from_envio_pe" name="from_envio_pe" method="post" action="" onsubmit="">
                <div class="grid-18">
                    <div class="widget">
                        <div class="widget">
                            <div class="widget-header">
                                <span class="icon-layers"></span>
                                <h3>Agregar Cita</h3>
                            </div>
                            <div class="widget-content">
                                <div class="row-fluid">
                                    <div class="grid-24">
                                        <div class="field-group">
                                            <div class="field">
                                                <img align="left" style=" border: solid 5px #ddd;max-width: 100px; max-height: 100px" src="../src/images/FOTOS/<?php echo $cedula; ?>.jpg"/>
                                            </div>
                                        </div> <!-- .field-group -->
                                    </div>
                                    <div class="grid-24">
                                        <div class="field-group">								
                                            <label style="color:#B22222">Cédula:</label>
                                            <div class="field">
                                                <span><?php echo $cedula; ?></span>
                                                <input id="CedulaCita" name="CedulaCita" value="<?= $cedula ?>" style="display: none" />
                                                <input id="NombreCita" name="NombreCita" value="<?= $nombre ?>" style="display: none" />
                                                <input id="CorreoCita" name="CorreoCita" value="<?= $correo ?>" style="display: none" />
                                            </div>
                                        </div> <!-- .field-group -->
                                    </div>
                                    <div class="grid-24" >
                                        <div class="field-group">
                                            <label style="color:#B22222">Nombre y Apellido:</label>
                                            <div class="field">
                                                <span><?php echo $nombre; ?></span>			
                                            </div>
                                        </div> <!-- .field-group -->	
                                    </div>
                                    <div class="grid-24">
                                        <div class="field-group">								
                                            <label style="color:#B22222">Fecha:</label>
                                            <div class="field">
                                                <input id="FechaCita" class="datepicker" name="FechaCita" size="14" value="" style="min-width: 20%; max-width: 80%" readonly>
                                            </div>
                                        </div> <!-- .field-group -->
                                    </div> <!-- .row-fluid -->
                                    <div class="grid-24">
                                        <div class="field-group">								
                                            <label style="color:#B22222">Hora:</label>
                                            <div class="field">
                                                <input id="HoraCita" class="timepicker validate[required]" name="HoraCita" size="14" value="" style="min-width: 20%; max-width: 80%" readonly>
                                            </div>
                                        </div> <!-- .field-group -->
                                    </div> <!-- .row-fluid -->
                                    <div class="grid-24">
                                        <div class="field-group">								
                                            <label style="color:#B22222">Motivo:</label>
                                            <div class="field">
                                                <textarea id="MotivoCita" name="MotivoCita" cols="8" rows="8" style="min-width: 40%; max-width: 80%" class="validate[required]"></textarea>
                                            </div>
                                        </div> <!-- .field-group -->
                                    </div> <!-- .row-fluid -->
                                    <div class="grid-24" style="text-align: center">
                                        <div class="field-group">								
                                            <div class="actions" style="text-aling:left">
                                                <button name="Submit" type="submit" class="btn btn-error">Registrar Cita</button>
                                                <input type="button" name="Atras" onclick="javascript:window.history.back();" class="btn btn-error" value="Regresar" />
                                            </div> <!-- .actions -->
                                        </div> <!-- .field-group -->
                                    </div>
                                </div> <!-- .row-fluid -->
                            </div> <!-- .widget-content -->
                        </div> <!-- .widget -->	
                    </div> <!-- .widget -->	
                </div><!-- .grid -->	
                <div class="grid-6">
                    <div id="gettingStarted" class="box">
                        <h3>Estimado, <?php echo $usuario_datos['nombre'] . " " . $usuario_datos['apellido']; ?></h3>
                        <p>En esta sección podrá registrar una Cita.</p>
                        <div class="box plain">
                            <a class="btn btn-primary btn-large dashboard_add" onclick="javascript:window.history.back();">Regresar</a>
                        </div>
                    </div>
                </div>
            </form>
        </div> <!-- .grid -->	
    </div><!-- .row -->
    <?php
}

_adios_mysql();
?>

<script type="text/javascript">
    window.onload = function () {
        espejo_gerencia();
    }
    $(function () {

        $.datepicker.setDefaults($.datepicker.regional["es"]);
        $(".datepicker").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "2014:2020",
            minDate: '0'
        });
        $('.datepicker').datepicker('setDate', '0');

        $(".timepicker").timepicker({
            timeFormat: 'hh:mm',
            showPeriod: true,
            showCloseButton: true,
            rows: 2,
            hours: {
                starts: 8,
                ends: 16
            }
        });

        activame('<?= $origen ?>');
        $('#' + '<?= $origen ?>').addClass('opened');
        $('#' + '<?= $origen ?> ul').css({'display': 'block'});
    });
</script>