<?php
if (array_pop(explode('/', $_SERVER['PHP_SELF'])) != 'dashboard.php') {
    header("Location: ../../dashboard.php");
}
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
    notificar("Usted no tiene permisos para esta Sección/Módulo", "dashboard.php?data=notificar", "notify-error");
    _wm($usuario_datos[9], 'Acceso Denegado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
}
_wm($usuario_datos[9], 'Acceso Autorizado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');

?>
<div id="contentHeader">
    <h2>Fas Metro</h2>
</div> <!-- #contentHeader -->	

<div class="container">
    <div class="row">
        <div class="grid-16">				
            <div class="widget">			
                <div class="widget-header">
                    <span class="icon-layers"></span>
                    <h3>Empleados Metro</h3>
                </div>
                <div class="widget-content">
                    <p>
                    </p>
                    <?php ?>
                </div>	
                <div align="center" style="margin-bottom:20px;">
                    <?php
                    $_SESSION['fas'] = $anticachecret;
                    ?>
                    Cédula del Empleado:<br><br>
                    <input autofocus="" type="text" name="cedula" onkeypress="return esnumero(event)" id="da" value="" size="20"/>
                    <br><br>  
                    <input class="btn btn-error" id="boton" type="button" align='center' name="Imprimir" value="Previsualizar Planilla" onclick="asignarVariables()" />

                    <br><br><br>
                </div>		
            </div>
        </div>					
    </div> <!-- .grid -->
    <div class="grid-8">
        <div id="gettingStarted" class="box">
            <h3>Estimado, <?php echo $usuario_datos[1] . ' ' . $usuario_datos[2]; ?></h3>
            <p>En esta Sección podrá visualizar las planillas (FAS METRO) de los trabajadores.</p>					
        </div>
    </div>
</div> <!-- .row -->
<form id="Reportador" action="gen_report/reportes.php" method="post" target="_blank">
    <input id="array" name="array" type="hidden" value="" >
    <input id="jasper" name="jasper" type="hidden" value="fas/insc_fas.jasper" >
    <input id="nombresalida" name="nombresalida" type="hidden" value="FAS" >
    <input id="formato" name="formato" type="hidden" value="pdf" >
</form>
</div> <!-- .container -->
<script>
    function esnumero(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        } else {
            return true;
        }
    }
    function asignarVariables() {
        var cedula = $('#da').val();
        if (cedula != '0' && cedula != '') {
            $.ajax({
                url: 'modules/fas_admin/Variable.php',
                method: 'GET',
                dataType: 'JSON',
                beforeSend: function () {
                    $('#boton').attr('disabled', true);
                },
                data: {
                    empleado: cedula
                },
                success: function (data) {
                    if (data.estatus == 'OK') {
                        $('#array').val(data.respuesta);
                        $('#Reportador').submit();
                    } else {
                        $.alert({
                            type: 'alert',
                            title: 'Alerta',
                            text: '<h3>El Empleado con CI: ' + cedula + ' no esta registrado en el FAS!</h3>'
                        });
                        $('#da').val('');
                    }
                    $('#boton').removeAttr('disabled');
                }
            });
        }
    }
</script>













