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


$arreglo = parametrosReporte(array(
    array('cedulaE', $cedula)
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
                                        <h3>FAS-Metro - Servicios</h3>
                                    </div>
                                    <br>
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
                                                    <textarea id="procedimiento" name="Procedimiento." cols="35" rows="6" class="Requerido" onkeypress="return conMayusculas(this)" placeholder="Procedimiento."></textarea>
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
                                                    <textarea id="diagnostico" name="Diagnóstico." cols="35" rows="6" class="Requerido" onkeypress="return conMayusculas(this)" placeholder="Diagnóstico."></textarea>
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
                                                    <th style="width: 10%; text-align: center; color:#B22222"></th>
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
                    <p>En esta sección podrá realizar la verificación de la Carta Aval.<b></b></p>
                    <div class="box plain">
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
        $('#servicio option[value="2"]').attr('selected', 'selected');
        setTimeout(function () {
            $.uniform.update();
        });
    });
</script>