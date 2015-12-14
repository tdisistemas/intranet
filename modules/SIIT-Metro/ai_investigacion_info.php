<?php
if (array_pop(explode('/', $_SERVER['PHP_SELF'])) != 'dashboard.php') {
    header("Location: ../../dashboard.php");
}
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
    notificar("Usted no tiene permisos para esta Seccion/Modulo", "dashboard.php?data=notificar", "notify-error");
    _wm($usuario_datos[9], 'Acceso Denegado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
}
_wm($usuario_datos[9], 'Acceso Autorizado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
if (!$_GET['flag']) {
    ir('dashboard.php?data=averiguaciones-ai');
}
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

    .Tarjeta{
        text-align: center; 
        background-color: #EBEBEB; 
        border-radius: 5px 5px 5px 5px; 
        padding: 5px;
        box-shadow: 2px 2px 5px #999;
    }

    .Tarjeta p{
        font-size: 10px;
        color: #000000;
        margin-bottom: 0em;
        margin-left: 5px;
        margin-right: 5px;
    }

    .Tarjeta .TituloTarjeta{
        text-align: left;
        color: #C14747;

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
    .inactivo{ 
        opacity: .3; 
        cursor: default;
    }

</style>
<div id="contentHeader">
    <h2>Información de Averiguación</h2>
</div> <!-- #contentHeader -->	
<?php
decode_get2($_SERVER["REQUEST_URI"], 2);
$id = _antinyeccionSQL($_GET['id']);
_bienvenido_mysql();

$sqlquery = "SELECT "
        . "a.codigo_ave,"
        . "a.tipo_origen,"
        . "a.causa,"
        . "a.recomendacion,"
        . "a.conclusion,"
        . "a.decision,"
        . "a.sanciones,"
        . "a.otros,"
        . "b.codigo AS cod_den,"
        . "e.codigo AS cod_org,"
        . "b.status AS st_den,"
        . "e.status AS st_org,"
        . "a.fecha_st_1,"
        . "a.fecha_st_2,"
        . "a.fecha_st_3,"
        . "a.fecha_st_9,"
        . "a.fecha,"
        . "b.fecha AS fecha_den,"
        . "e.fecha AS fecha_org,"
        . "b.descripcion AS desc_den,"
        . "e.descripcion AS desc_org,"
        . "b.tipo AS tipo_den,"
        . "e.tipo AS tipo_org,"
        . "d.nombre,"
        . "d.apellido,"
        . "a.status AS st_ave "
        . "FROM ai_averiguaciones a "
        . "LEFT JOIN ai_denuncias b ON a.origen = b.idDenuncia AND a.tipo_origen = 1 "
        . "LEFT JOIN ai_oficios e ON a.origen = e.idOficio AND a.tipo_origen = 2 "
        . "INNER JOIN ai_investigadores c ON a.investigador=c.id_invest "
        . "INNER JOIN datos_empleado_rrhh d ON c.cedula_invest = d.cedula "
        . "WHERE a.idAveriguacion=" . $id;

$sql = mysql_query($sqlquery);
$respuesta = mysql_fetch_array($sql);

$tipo_origen = $respuesta['tipo_origen'];
$cod_den = $respuesta['cod_den'];
$cod_org = $respuesta['cod_org'];
$codigo_ave = $respuesta['codigo_ave'];
$nombre = $respuesta['nombre'] . ' ' . $respuesta['apellido'];
$causa = $respuesta['causa'];
$st_den = $respuesta['st_den'];
$st_org = $respuesta['st_org'];
$st_ave = $respuesta['st_ave'];
$fecha = $respuesta['fecha'];
$fecha_den = $respuesta['fecha_den'];
$fecha_org = $respuesta['fecha_org'];
$desc_den = $respuesta['desc_den'];
$desc_org = $respuesta['desc_org'];
$tipo_org = $respuesta['tipo_org'];
$tipo_den = $respuesta['tipo_den'];
$recomendacion = $respuesta['recomendacion'];
$conclusion = $respuesta['conclusion'];
$decisiones = $respuesta['decision'];
$sanciones = $respuesta['sanciones'];
$otros = $respuesta['otros'];

$parametros = 'id=' . $id;
$parametros = _desordenar($parametros);

$sqlInvol = "SELECT "
        . "a.cedula,"
        . "c.nombre,"
        . "c.apellido,"
        . "c.cargo,"
        . "c.gerencia,"
        . "c.ext_telefonica "
        . "FROM ai_autores a "
        . "INNER JOIN ai_averiguaciones b ON a.idAveriguacion = b.idAveriguacion "
        . "INNER JOIN datos_empleado_rrhh c ON c.cedula = a.cedula "
        . "WHERE a.idAveriguacion = " . $id;

$sqlqueryInv = mysql_query($sqlInvol);
?>
<div class="container">
    <div class="row"> 
        <form class="form uniformForm validateForm" id="from_envio_pe" name="from_envio_pe" method="post" action="dashboard.php?data=asuntoi" >
            <div class="grid-18">
                <div class="">
                    <div class="">
                        <div class="row">
                            <div class="grid-24 bordeado">
                                <div class="widget-header">
                                    <h3>Involucrado(s) </h3>
                                </div>
                                <br>
                                <br>
                                <?php
                                $i = 0;
                                while ($Involucrado = mysql_fetch_array($sqlqueryInv)) {

                                    $cedula = $Involucrado['cedula'];
                                    $nombreInvo = $Involucrado['nombre'] . ' ' . $Involucrado['apellido'];
                                    $cargo = $Involucrado['cargo'];
                                    $gerencia = $Involucrado['gerencia'];
                                    $extension = $Involucrado['ext_telefonica'];
                                    $parametros2 = 'cedula=' . $cedula;
                                    $parametros2 = _desordenar($parametros2);
                                    if ($i != 0) {
                                        ?>
                                        <div class="grid-24" style="text-align: center; margin-left: 1.5%;">
                                            <hr style="border-top: 1px dotted #000; height: 1px; width:75%;">
                                        </div>
                                        <?php
                                    }
                                    ?> 
                                    <div class="grid-24">
                                        <div class="grid-4">
                                            <div class="field-group">
                                                <div class="field">
                                                    <img align="left" style=" border: solid 5px #ddd;max-width: 100px;max-height: 100px" src="../intranet/src/images/FOTOS/<?php echo $cedula; ?>.jpg"/>
                                                </div>
                                            </div> <!-- .field-group -->
                                            <div class="field-group">
                                                <div class="field" style="text-align: center">
                                                    <input type="button" name="Mas" style="width: 80px; font-size: 12px" onclick="javascript:DatosEmpleado('<?= $parametros2 ?>')" class="btn btn-error" value="Más" />
                                                </div>
                                            </div> <!-- .field-group -->
                                        </div>
                                        <div class="grid-8">
                                            <div class="field-group">								
                                                <label style="color:#B22222">Cédula:</label>
                                                <div class="field">
                                                    <span><?php echo $cedula; ?></span>
                                                </div>
                                            </div> <!-- .field-group -->
                                            <div class="field-group">
                                                <label style="color:#B22222">Nombre:</label>
                                                <div class="field">
                                                    <span><?php echo $nombreInvo; ?></span>			
                                                </div>
                                            </div> <!-- .field-group -->
                                            <div class="field-group">
                                                <label style="color:#B22222">Cargo:</label>
                                                <div class="field">
                                                    <span><?php echo $cargo; ?></span>			
                                                </div>
                                            </div> <!-- .field-group -->
                                        </div>
                                        <div class="grid-10">
                                            <div class="field-group">
                                                <label style="color:#B22222">Gerencia:</label>
                                                <div class="field">
                                                    <span><?php echo $gerencia; ?></span>	
                                                </div>		
                                            </div> <!-- .field-group -->
                                            <div class="field-group">
                                                <label style="color:#B22222">Extensión:</label>
                                                <div class="field">
                                                    <?php echo $extension != '0' ? '<span>' . $extension . '</span>' : '<label for="fname">*** No Posee Extensión Registrada! *** </label>' ?>
                                                </div>		
                                            </div> <!-- .field-group -->
                                        </div>
                                    </div>
                                    <?php
                                    $i++;
                                }
                                ?>
                            </div>
                            <div class="grid-24 bordeado" >
                                <div class="widget-header">
                                    <h3><?= $tipo_origen == '1' ? 'Denuncia' : 'Oficio' ?></h3>
                                </div>
                                <br>
                                <div class="grid-8">
                                    <div class="field-group">
                                        <label style="color:#B22222">Código:</label>
                                        <div class="field">
                                            <span><b><?php echo $tipo_origen == '1' ? $cod_den : $cod_org ?></b></span>	
                                        </div>
                                    </div> <!-- .field-group -->
                                    <div class="field-group">
                                        <label style="color:#B22222">Fecha:</label>
                                        <div class="field">
                                            <span><?php echo $tipo_origen == '1' ? $fecha_den : $fecha_org; ?></span>	
                                        </div>
                                    </div> <!-- .field-group -->
                                    <div class="field-group">
                                        <label style="color:#B22222">Tipo:</label>
                                        <div class="field">
                                            <span><?php echo $tipo_origen == '1' ? $tipo_den : $tipo_org; ?></span>	
                                        </div>
                                    </div> <!-- .field-group -->
                                </div>
                                <div class="grid-14">
                                    <div class="field-group">
                                        <label style="color:#B22222">Descripción:</label>
                                        <div class="field">
                                            <span><?php echo $tipo_origen == '1' ? $desc_den : $desc_org; ?></span>	
                                        </div>
                                    </div> <!-- .field-group -->
                                </div><!-- .grid -->
                            </div><!-- .grid -->
                            <div class="grid-24 bordeado">
                                <div class="widget-header">
                                    <h3>Averiguación</h3>
                                </div>
                                <br>
                                <div class="grid-8">
                                    <div class="field-group">
                                        <label style="color:#B22222">Código:</label>
                                        <div class="field">
                                            <span><b><?php echo $codigo_ave; ?></b></span>	
                                        </div>
                                    </div> <!-- .field-group -->
                                    <div class="field-group">
                                        <label style="color:#B22222">Fecha:</label>
                                        <div class="field">
                                            <span><?php echo $fecha; ?></span>	
                                        </div>
                                    </div> <!-- .field-group -->
                                    <div class="field-group">
                                        <label style="color:#B22222">Investigador:</label>
                                        <div class="field">
                                            <span><?php echo $nombre; ?></span>	
                                        </div>
                                    </div> <!-- .field-group -->
                                    <div class="field-group">
                                        <label style="color:#B22222">Estatus:</label>
                                        <div class="field">
                                            <?php
                                            $Archivar = '';
                                            $Retomar = 'none';
                                            $Revision = 'none';
                                            $Remitir = 'none';
                                            $editable = 'none';
                                            $finalizada = 'none';
                                            switch ($st_ave) {
                                                case 0: $st = "Activo";
                                                    $color = "green";
                                                    $texto = 'Abierta';
                                                    $Revision = '';
                                                    $editable = '';
                                                    $fecha_st = 'fecha';
                                                    break;
                                                case 1: $st = "Editar";
                                                    $color = "#2563FF";
                                                    $texto = 'En revisión';
                                                    $Remitir = '';
                                                    $fecha_st = 'fecha_st_1';
                                                    break;
                                                case 2: $st = "Enviar";
                                                    $color = "green";
                                                    $texto = 'Remitida.';
                                                    $fecha_st = 'fecha_st_2';
                                                    Break;
                                                case 3: $st = "Cerrar";
                                                    $color = "green";
                                                    $texto = 'Finalizada';
                                                    $Archivar = 'none';
                                                    $fecha_st = 'fecha_st_3';
                                                    $finalizada = '';
                                                    Break;
                                                case 9: $st = "Archivar";
                                                    $color = "red";
                                                    $texto = 'Archivada';
                                                    $Archivar = 'none';
                                                    $Retomar = '';
                                                    $fecha_st = 'fecha_st_9';
                                                    break;
                                            }
                                            ?>
                                            <span><?php echo iconosIntranet($st, $titulo,false,$color,false)?></span> <span style="color: <?= $color ?>;vertical-align: middle" ><?= $texto ?> <span style="color: black">, desde: </span> <?= $respuesta[$fecha_st] ?></span>	
                                        </div>
                                    </div> <!-- .field-group -->
                                </div>
                                <div class="grid-14">
                                    <div class="field-group">
                                        <label style="color:#B22222">Causa:</label>
                                        <div class="field">
                                            <span><?php echo $causa; ?></span>	
                                        </div>
                                    </div> <!-- .field-group -->
                                </div><!-- .grid -->
                            </div><!-- .grid -->
                            <div class="grid-24 bordeado">
                                <div class="widget-header">
                                    <h3>Conclusiones</h3>
                                </div>
                                <br>
                                <div class="grid-24">
                                    <div class="field-group">
                                        <div class="field" id="Conclu_Mostrado">
                                            <?php echo $conclusion == '' ? '<label for="fname">** No posee Conclusiones registradas. **<label>' : '<span>' . $conclusion . '</span>'; ?>	
                                        </div>
                                        <div class="field" id="Conclu_Editado" style="display: none">
                                            <textarea id="Conclu_Nueva" rows="4" cols="60"><?= $conclusion ?></textarea>	
                                        </div>
                                        <div style="text-align: left">
                                            <button style="display: <?= $editable ?>" onclick="javascript:EditarCampo('Conclu_')" title="Editar" id="Conclu_Editar" type="button" class="btn btn-error btn-edit"><i class="fa fa-edit"></i></button>
                                            <button style="display: none" onclick="javascript:AceptarEdit('Conclu_', 1, '<?= $id ?>')" title="Aceptar" id="Conclu_Aceptar" type="button" class="btn btn-success btn-edit"><i class="fa fa-check"></i></button>
                                            <button style="display: none" onclick="javascript:CancelarEdit('Conclu_')" title="Cancelar" id="Conclu_Cancelar" type="button" class="btn btn-error btn-edit"><i class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .grid -->
                            <div class="grid-24 bordeado">
                                <div class="widget-header">
                                    <h3>Recomendaciones</h3>
                                </div>
                                <br>
                                <div class="grid-24">
                                    <div class="field-group">
                                        <div class="field" id="Recom_Mostrado">
                                            <?php echo $recomendacion == '' ? '<label for="fname">*** No posee Recomandaciones registradas. ***<label>' : '<span>' . $recomendacion . '</span>'; ?>	
                                        </div>
                                        <div class="field" id="Recom_Editado" style="display: none">
                                            <textarea id="Recom_Nueva" rows="4" cols="60"><?= $recomendacion ?></textarea>	
                                        </div>
                                        <div style="text-align: left">
                                            <button style="display: <?= $editable ?>" onclick="javascript:EditarCampo('Recom_')" title="Editar" id="Recom_Editar" type="button" class="btn btn-error btn-edit"><i class="fa fa-edit"></i></button>
                                            <button style="display: none" onclick="javascript:AceptarEdit('Recom_', 2, '<?= $id ?>')" title="Aceptar" id="Recom_Aceptar" type="button" class="btn btn-success btn-edit"><i class="fa fa-check"></i></button>
                                            <button style="display: none" onclick="javascript:CancelarEdit('Recom_')" title="Cancelar" id="Recom_Cancelar" type="button" class="btn btn-error btn-edit"><i class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .grid -->
                            <div class="grid-24 bordeado" style="display: <?= $finalizada ?>">
                                <div class="widget-header">
                                    <h3>Decisiones</h3>
                                </div>
                                <br>
                                <div class="grid-24">
                                    <div class="field-group">
                                        <div class="field" id="Decis_Mostrado">
                                            <?php echo $decisiones == '' ? '<label for="fname">** No posee Desiciones registradas. **<label>' : '<span>' . $decisiones . '</span>'; ?>	
                                        </div>
                                        <div class="field" id="Decis_Editado" style="display: none">
                                            <textarea id="Decis_Nueva" rows="4" cols="60"><?= $decisiones ?></textarea>	
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .grid -->
                            <div class="grid-24 bordeado" style="display: <?= $finalizada ?>">
                                <div class="widget-header">
                                    <h3>Sanciones</h3>
                                </div>
                                <br>
                                <div class="grid-24">
                                    <div class="field-group">
                                        <div class="field" id="Sancio_Mostrado">
                                            <?php echo $sanciones == '' ? '<label for="fname">*** No posee Sanciones registradas. ***<label>' : '<span>' . $sanciones . '</span>'; ?>	
                                        </div>
                                        <div class="field" id="Sancio_Editado" style="display: none">
                                            <textarea id="Sancio_Nueva" rows="4" cols="60"><?= $sanciones ?></textarea>	
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .grid -->
                            <div class="grid-24 bordeado" style="display: <?= $finalizada ?>">
                                <div class="widget-header">
                                    <h3>Otros</h3>
                                </div>
                                <br>
                                <div class="grid-24">
                                    <div class="field-group">
                                        <div class="field" id="Otros_Mostrado">
                                            <?php echo $otros == '' ? '<label for="fname">*** No posee "Otros" registrados. ***<label>' : '<span>' . $otros . '</span>'; ?>	
                                        </div>
                                        <div class="field" id="Otros_Editado" style="display: none">
                                            <textarea id="Otros_Nueva" rows="4" cols="60"><?= $otros ?></textarea>	
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .grid -->
                            <div class="grid-24" style="text-align: center">
                                <div class="field-group">								
                                    <div class="actions inline">
                                        <button onclick="javascript:CambioStatus('<?= $id ?>', '1', '<?= $parametros ?>', 'Enviar a Revisión')" name="Revision" type="button" class="btn btn-error" style="display: <?= $Revision ?>">Enviar a Revisión</button>
                                        <input type="button" name="Atras" onclick="javascript:window.history.back();" class="btn btn-error" value="Regresar" />
                                    </div> <!-- .actions -->
                                </div> <!-- .field-group -->
                            </div>
                        </div><!-- .grid -->
                    </div><!-- .grid -->
                </div><!-- .grid -->	
            </div><!-- .grid -->	
            <div class="grid-6"> 
                <div id="gettingStarted" class="box">
                    <h3>Estimado, <?php echo $usuario_datos['nombre'] . " " . $usuario_datos['apellido']; ?></h3>
                    <p>En esta sección podrá visualizar la información de la averiguación número <b><?= $codigo_ave ?></b></p>
                    <div class="box plain">
                        <a class="btn btn-primary btn-large dashboard_add" onclick="javascript:window.history.back();">Regresar</a>
                    </div>
                </div>
            </div>
        </form>
    </div><!-- .row -->
</div><!-- .container-->

<script type="text/javascript">
    window.onload = function () {
        espejo_gerencia();
    }

    function DatosEmpleado(parametro) {
        window.location = 'dashboard.php?data=usuario-ai-info&flag=1&' + parametro;
    }

    function CambioStatus(campo, st, parametro, mensaje) {
        $.alert({
            type: 'confirm',
            title: 'Alerta',
            text: '<h3>¿Esta seguro que desea <u>' + mensaje + '</u> esta Averiguación ?</h3>',
            callback: function () {
                Cambio(campo, st, parametro);
            }
        });
    }

    function Cambio(campo, st, parametro) {

        $.ajax({
            url: 'modules/SIIT-Metro(Admin)/CambioStatus.php',
            method: 'POST',
            dataType: 'TEXT',
            data: {
                aver: campo,
                acc: st
            },
            success: function (data) {
                $.alert({
                    type: 'alert',
                    title: 'Alerta',
                    text: '<h3>La investigación ha sido <u>' + data + '</u>.</h3>',
                    callback: function () {
                        window.location = "dashboard.php?data=averiguaciones-ai-info&flag=1&" + parametro;
                    }
                });
                setTimeout(function () {
                    window.location = "dashboard.php?data=averiguaciones-ai-info&flag=1&" + parametro;
                }, 3000);
            }
        });
    }

    function AceptarEdit(id, tipo, parametro) {
        var dato = document.getElementById(id + 'Nueva').value;
        $.ajax({
            url: 'modules/SIIT-Metro(Admin)/Anexos.php',
            method: 'POST',
            dataType: 'TEXT',
            data: {
                aver: parametro,
                dato: dato,
                tipo: tipo
            },
            success: function (data) {
                document.getElementById(id + 'Mostrado').innerHTML = '<span>' + data + '</span>';
                CancelarEdit(id);
            }
        });
    }

    function EditarCampo(id) {
        document.getElementById(id + 'Mostrado').style.display = 'none';
        document.getElementById(id + 'Editado').style.display = '';
        document.getElementById(id + 'Editar').style.display = 'none';
        document.getElementById(id + 'Aceptar').style.display = '';
        document.getElementById(id + 'Cancelar').style.display = '';
        document.getElementById(id + 'Nueva').focus();

    }

    function CancelarEdit(id) {
        document.getElementById(id + 'Mostrado').style.display = '';
        document.getElementById(id + 'Editado').style.display = 'none';
        document.getElementById(id + 'Editar').style.display = '';
        document.getElementById(id + 'Aceptar').style.display = 'none';
        document.getElementById(id + 'Cancelar').style.display = 'none';

    }
</script>