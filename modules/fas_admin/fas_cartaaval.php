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
    ir('dashboard.php?data=admin_ai');
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
    .MargenInferior, .MargenInferior > div:not(:first-child){
        margin-bottom: 0px !important;
    }
</style>
<div id="contentHeader">
    <h2>FAS Metro - Carta Aval</h2>  
</div> <!-- #contentHeader -->	
<?php
decode_get2($_SERVER["REQUEST_URI"], 2);
$id = _antinyeccionSQL($_GET['id']);
$cedulaUsuario = $usuario_datos[3];
$correoUsuario = $usuario_datos[5];
$NombreUsuarioMain = $usuario_datos['nombre'] . " " . $usuario_datos['apellido'];

_bienvenido_mysql();

$sqlSelect = "SELECT "
        . "a.id_evento,"
        . "a.fecha_creacion,"
        . "a.fecha_aprobacion,"
        . "a.codigo_evento,"
        . "a.diagnostico,"
        . "a.procedimiento,"
        . "a.monto,"
        . "b.nombres,"
        . "c.cedula,"
        . "c.ext_telefonica,"
        . "c.cargo,"
        . "c.gerencia,"
        . "c.nombre,"
        . "c.apellido,"
        . "a.cedula_beneficiario,"
        . "b.parentesco,"
        . "g.nombre as Proveedor,"
        . "g.rif,"
        . "g.direccion as P_direccion,"
        . "a.aprobado_por as FAS_cedula,"
        . "f.nombre as FAS_nombre,"
        . "f.apellido as FAS_apellido,"
        . "h.usuario_int,"
        . "d.descripcion as Servicio,"
        . "a.servicio as Srv,"
        . "e.descripcion as Especialidad,"
        . "a.status "
        . "FROM fas_eventos a "
        . "INNER JOIN datos_familiares_rrhh b "
        . "on a.cedula_beneficiario=(CASE WHEN b.cedula_familiar = 0 THEN b.cedula_empleado ELSE b.cedula_familiar END) "
        . "INNER JOIN datos_empleado_rrhh c "
        . "on a.cedula_empleado= c.cedula "
        . "INNER JOIN fas_tipos_servicios d "
        . "on a.servicio= d.id_servicio "
        . "INNER JOIN fas_especialidad e "
        . "on a.especialidad= e.id "
        . "LEFT JOIN fas_proveedores g "
        . "on a.proveedor = g.id_proveedor "
        . "LEFT JOIN datos_empleado_rrhh f "
        . "on a.aprobado_por = f.cedula "
        . "INNER JOIN autenticacion h "
        . "on a.cedula_empleado= h.cedula "
        . "WHERE a.id_evento = $id ";

$sqlConsulta = mysql_query($sqlSelect);

$result = mysql_fetch_array($sqlConsulta);
$procedimiento = $result['procedimiento'];
$diagnostico = $result['diagnostico'];
$especialidad = $result['Especialidad'];
$usuario = $result['usuario_int'];
$cedula = $result['cedula'];
$nombre = $result['nombre'] . ' ' . $result['apellido'];
$nombreTitular = $result['nombre'];
$apellidoTitular = $result['apellido'];
$cedula_beneficiario = $result['cedula_beneficiario'];
$nombre_beneficiario = $result['nombres'];
$parentesco = $result['parentesco'];
$servicio = $result['Servicio'];
$servicio_id = $result['Srv'];
$fecha_cre = explode('-', $result['fecha_creacion']);
$fecha_creacion = $fecha_cre[2] . '/' . $fecha_cre[1] . '/' . $fecha_cre[0];
$extension = $result['ext_telefonica'];
$gerencia = $result['gerencia'];
$cargo = $result['cargo'];
$status = $result['status'];
$proveedor_rep = $result['Proveedor'];
$proveedor = $result['Proveedor'] . ' (' . $result['rif'] . '). ';
$codigo = $result['codigo_evento'];
$FAS_Cedula = $result['FAS_cedula'];
$fecha_ap = explode('-', $result['fecha_aprobacion']);
$fecha = $fecha_ap[1] . '/' . $fecha_ap[2] . '/' . $fecha_ap[0];
$fecha_aprobado = $fecha_ap[2] . '/' . $fecha_ap[1] . '/' . $fecha_ap[0];
$FAS_Empleado = $result['FAS_nombre'] . ' ' . $result['FAS_apellido'];

$vence = strtotime('+30 day', strtotime($result['fecha_aprobacion']));
$vence = date('Y-m-d', $vence);
$venceArray = explode('-', $vence);
$vence = $venceArray[2] . '/' . $venceArray[1] . '/' . $venceArray[0];

$proveedor_detalle = $result['Proveedor'] . ' (' . $result['rif'] . '), ' . $result['P_direccion'];



$monto = number_format($result['monto'], 2, ',', '.');
?>
<div class="container">
    <div class="row"> 
        <form class="form uniformForm validateForm" id="from_envio_pe" name="from_envio_pe" method="post" action="dashboard.php?data=asuntoi" >
            <div class="grid-18">
                <div class="row">
                    <div class="grid-24 bordeado">
                        <div class="widget-header">
                            <h3>Titular</h3>
                        </div>
                        <br>
                        <br>
                        <div class="grid-24">
                            <div class="grid-4">
                                <div class="field-group">
                                    <div class="field">
                                        <img align="left" style=" border: solid 5px #ddd;max-width: 100px;max-height: 100px" src="../src/images/FOTOS/<?php echo $cedula; ?>.jpg"/>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-8">
                                <div class="field-group">								
                                    <label style="color:#B22222">Cédula:</label>
                                    <div class="field">
                                        <span><?php echo $cedula ?></span>
                                    </div>
                                </div> <!-- .field-group -->
                                <div class="field-group">
                                    <label style="color:#B22222">Nombre:</label>
                                    <div class="field">
                                        <span><?php echo $nombre; ?></span>			
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
                    </div>
                    <div class="grid-24 bordeado">
                        <div class="widget-header">
                            <h3>Beneficiario</h3>
                        </div>
                        <br>
                        <br>
                        <div class="grid-24">
                            <div class="grid-4">

                            </div>
                            <div class="grid-8">
                                <div class="field-group">								
                                    <label style="color:#B22222">Cédula:</label>
                                    <div class="field">
                                        <span><?php echo $cedula_beneficiario; ?></span>
                                    </div>
                                </div> <!-- .field-group -->
                                <div class="field-group">
                                    <label style="color:#B22222">Nombre:</label>
                                    <div class="field">
                                        <span><?php echo $nombre_beneficiario; ?></span>			
                                    </div>
                                </div>
                            </div>
                            <div class="grid-10">
                                <div class="field-group">
                                    <label style="color:#B22222">Parentesco:</label>
                                    <div class="field">
                                        <span><?php echo $parentesco; ?></span>	
                                    </div>		
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="grid-24 bordeado">
                        <div class="widget-header">
                            <h3><?php echo 'Carta Aval' ?></h3>
                        </div>
                        <br>
                        <div class="grid-24 MargenInferior">
                            <div class="grid-3">

                            </div>
                            <div class="grid-6">
                                <div class="field-group">
                                    <label style="color:#B22222">Código:</label>
                                    <div class="field">
                                        <span><b><?php echo $codigo != '' ? $codigo : '<i style="color: gray" class="fa fa-clock-o"></i>'; ?></b></span>	
                                    </div>
                                </div>
                            </div>
                            <div class="grid-6">
                                <div class="field-group">
                                    <label style="color:#B22222">Fecha de Solicitud:</label>
                                    <div class="field">
                                        <span><?php echo $fecha_creacion; ?></span>	
                                    </div>
                                </div>
                            </div>
                            <div class="grid-6">
                                <div class="field-group">
                                    <label style="color:#B22222">Estatus:</label>
                                    <div class="field">
                                        <?php
                                        $Aprobar = '';
                                        $Descartar = '';
                                        $Verificar = 'none';
                                        switch ($status) {
                                            case 0: $st = "Espera";
                                                $color = "gray";
                                                $texto = 'En Espera.';
                                                break;
                                            case 1: $st = "Activo";
                                                $color = "green";
                                                $texto = 'Aprobada.';
                                                $Aprobar = 'none';
                                                $Descartar = 'none';
                                                $Verificar = '';
                                                break;
                                            case 9: $st = "Inactivo";
                                                $color = "red";
                                                $texto = 'Descartada.';
                                                $Aprobar = 'none';
                                                $Descartar = 'none';
                                                break;
                                        }
                                        ?>
                                        <span><?php echo iconosIntranet($st, $titulo, false, $color, false) ?></span> <span style="color: <?= $color ?>;vertical-align: middle" ><?= $texto ?> </span>	
                                    </div>
                                </div> <!-- .field-group -->
                            </div><!-- .grid -->
                        </div><!-- .grid -->
                        <div class="grid-24" style="text-align: center; margin-left: 0%;">
                            <hr style="border-top: 1px dotted #000; height: 1px; width:75%;">
                        </div>
                        <div class="grid-2">
                        </div>
                        <div class="grid-20 MargenInferior">
                            <div class="grid-24 MargenInferior">
                                <div class="grid-11 MargenInferior">
                                    <div class="field-group MargenInferior" style="min-height: 70px">
                                        <label style="color:#B22222">Proveedor:</label>
                                        <div class="field">
                                            <?php
                                            if ($status == 0 || $status == 9) {
                                                ?>
                                                <input id="proveedor" style="width: 100%"/>	
                                                <input id="proveedor-id" style="width: 100%; display: none"/>	
                                                <?php
                                            } else {
                                                ?>
                                                <p> <?php echo $proveedor ?></p>	
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div><!-- .grid -->
                                <?php
                                if ($status == 0 || $status == 9) {
                                    ?>
                                    <div class="grid-11 MargenInferior">
                                        <div class="field-group MargenInferior">
                                            <label style="color:#B22222">Detalles:</label>
                                            <div class="field">
                                                <p id="proveedor-detalles"><label style="text-align: center">*** Seleccionar un proveedor ***</label></p>	
                                            </div>
                                        </div>
                                    </div><!-- .grid -->
                                    <?php
                                }
                                ?>
                            </div><!-- .grid -->
                            <div class="grid-24 MargenInferior">
                                <div class="grid-11 MargenInferior">
                                    <div class="field-group">
                                        <label style="color:#B22222">Especialidad:</label>
                                        <div class="field">
                                            <span><?php echo $especialidad; ?></span>	
                                        </div>
                                    </div>
                                </div>
                                <div class="grid-11 MargenInferior">
                                    <div class="field-group">
                                        <label style="color:#B22222">Monto:</label>
                                        <div class="field">
                                            <?php
                                            if ($status == 0 || $status == 9) {
                                                ?>
                                                <input id="Monto-CA" style="max-width: 100px; text-align: right" onkeypress="return enterDecimal(event)" value="0,00"/> <span style="font-weight: bold"> Bs.f</span>
                                                <?php
                                            } else {
                                                ?>
                                                <span> <?php echo $monto ?></span> <span style="font-weight: bold"> Bs.f</span>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-24">
                                <div class="grid-11">
                                    <div class="field-group">
                                        <label style="color:#B22222">Procedimiento:</label>
                                        <div class="field" id="Proc_Mostrado">
                                            <span><?php echo $procedimiento; ?></span>	
                                        </div>
                                        <div class="field" id="Proc_Editado" style="display: none">
                                            <textarea id="Proc_Nueva" rows="4" cols="35"><?= $procedimiento ?></textarea>	
                                        </div>
                                        <div style="text-align: left">
                                            <?php
                                            if ($status == 0 || $status == 9) {
                                                ?>
                                                <button onclick="javascript:EditarCampo('Proc_')" title="Editar" id="Proc_Editar" type="button" class="btn btn-error btn-edit"><i class="fa fa-edit"></i></button>
                                                <button style="display: none" onclick="javascript:AceptarEdit('Proc_', 2, '<?= $id ?>')" title="Aceptar" id="Proc_Aceptar" type="button" class="btn btn-success btn-edit"><i class="fa fa-check"></i></button>
                                                <button style="display: none" onclick="javascript:CancelarEdit('Proc_')" title="Cancelar" id="Proc_Cancelar" type="button" class="btn btn-error btn-edit"><i class="fa fa-times"></i></button>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid-11">
                                    <div class="field-group">
                                        <label style="color:#B22222">Diagnostico:</label>
                                        <div class="field"  id="Diag_Mostrado">
                                            <span><?php echo $diagnostico; ?></span>	
                                        </div>
                                        <div class="field" id="Diag_Editado" style="display: none">
                                            <textarea id="Diag_Nueva" rows="4" cols="35"><?= $diagnostico ?></textarea>	
                                        </div>
                                        <div style="text-align: left">
                                            <?php
                                            if ($status == 0 || $status == 9) {
                                                ?>
                                                <button onclick="javascript:EditarCampo('Diag_')" title="Editar" id="Diag_Editar" type="button" class="btn btn-error btn-edit"><i class="fa fa-edit"></i></button>
                                                <button style="display: none" onclick="javascript:AceptarEdit('Diag_', 1, '<?= $id ?>')" title="Aceptar" id="Diag_Aceptar" type="button" class="btn btn-success btn-edit"><i class="fa fa-check"></i></button>
                                                <button style="display: none" onclick="javascript:CancelarEdit('Diag_')" title="Cancelar" id="Diag_Cancelar" type="button" class="btn btn-error btn-edit"><i class="fa fa-times"></i></button>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        if ($status == 1) {
                            ?>
                            <div class="grid-24" style="text-align: center; margin-left: 0%;">
                                <hr style="border-top: 1px dotted #000; height: 1px; width:75%;">
                            </div>
                            <div class="grid-2">
                            </div>
                            <div class="grid-20">
                                <div class="grid-24 MargenInferior">
                                    <div class="grid-11 ">
                                        <div class="field-group MargenInferior">
                                            <label style="color:#B22222">Aprobado Por:</label>
                                            <div class="field">
                                                <label style="">Cédula:</label>
                                                <span><?php echo $FAS_Cedula; ?></span>			
                                            </div>
                                            <div class="field">
                                                <label style="">Nombre:</label>
                                                <span><?php echo $FAS_Empleado; ?></span>			
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-11 ">
                                        <div class="field-group MargenInferior">
                                            <label style="color:#B22222">Fecha de Aprobación:</label>
                                            <div class="field">
                                                <span><?php echo $fecha_aprobado; ?></span>			
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div><!-- .grid -->
                    <div class="grid-24" style="text-align: center">
                        <div class="field-group">								
                            <div class="actions">
                                <?php
                                $parametros = 'id=' . $id;
                                $parametros .= '&cedula=' . $cedulaUsuario;
                                $parametros .= '&nombreUsuario=' . $NombreUsuarioMain;
                                $parametros .= '&correoUsuario=' . $correoUsuario;
                                $parametros .= '&nombreBeneficiario=' . $nombre_beneficiario;
                                $parametros .= '&correoTitular=' . $usuario . '@metrodemaracaibo.gob.ve';
                                $parametros .= '&nombreTitular=' . $nombreTitular;
                                $parametros .= '&apellidoTitular=' . $apellidoTitular;
                                $parametros .= '&servicio=' . $servicio;
                                $parametros = _desordenar($parametros);

                                $reporte = array(
                                    array("Srs", $proveedor_rep),
                                    array("titular", $nombre),
                                    array("cedula_titular", $cedula),
                                    array("cedula_beneficiario", $cedula_beneficiario),
                                    array("beneficiario", $nombre_beneficiario),
                                    array("parentesco", $parentesco),
                                    array("especialidad", $especialidad),
                                    array("procedimiento", $procedimiento),
                                    array("diagnostico", $diagnostico),
                                    array("tipo_de_servicio", $servicio),
                                    array("monto", $result['monto']),
                                    array("presupuesto", ''),
                                    array("fechas", $fecha_aprobado),
                                    array("fecha", $fecha),
                                    array("vence", $vence),
                                    array("codigo", $codigo)
                                );
                                ?>  
                                <button name="Verificar" type="button" class="btn btn-error" onclick="javascript: VerificarCartaAval()" style="display: <?= $Verificar ?>">Verificar</button>
                                <button onclick="javascript:CambioStatus('1', '<?= $parametros ?>', 'Aprobar')" name="Aprobar" type="button" class="btn btn-error" style="display: <?= $Aprobar ?>">Aprobar</button>
                                <button onclick="javascript:CambioStatus('9', '<?= $parametros ?>', 'Descartar')" name="Descartar" type="button" class="btn btn-error" style="display: <?= $Descartar ?>">Descartar</button>
                                <input type="button" name="Atras" onclick="javascript:window.history.back();" class="btn btn-error" value="Regresar" />
                            </div> <!-- .actions -->
                        </div> <!-- .field-group -->
                    </div>
                </div><!-- .grid -->	
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
        </form>
        <form id="Reportador" action="gen_report/reportes.php" method="post" target="_blank">
            <input id="array" name="array" type="hidden" value="<?php echo parametrosReporte($reporte) ?>" >
            <input id="jasper" name="jasper" type="hidden" value="fas/FasCartAval.jasper" >
            <input id="nombresalida" name="nombresalida" type="hidden" value="Carta_Aval" >
            <input id="formato" name="formato" type="hidden" value="pdf" >
        </form>
    </div><!-- .row -->
</div><!-- .container-->

<script type="text/javascript">

    function VerificarCartaAval() {
        document.getElementById('Reportador').submit();
    }

    $(document).ready(function () {
        var options = {
            url: function (phrase) {

                return "modules/fas_admin/Autocompletar.php";
            },
            getValue: function (element) {
                return element.nombre + " (" + element.rif + ")";
            },
            list: {
                match: {
                    enabled: true
                },
                onSelectItemEvent: function () {

                },
                onChooseEvent: function () {
                    $("#proveedor-detalles").html($("#proveedor").getSelectedItemData().nombre + ', ' + $("#proveedor").getSelectedItemData().direccion).trigger("change");
                    $("#proveedor-id").val($("#proveedor").getSelectedItemData().proveedor).trigger("change");
                },
                onHideListEvent: function () {

                }
            },
            ajaxSettings: {
                dataType: "json",
                method: "GET",
                data: {
                    dataType: "json"
                }
            },
            preparePostData: function (data) {
                data.buscar = $("#proveedor").val();
                data.acc = 'Proveedores';

                return data;
            },
            requestDelay: 400
        };

        $("#proveedor").easyAutocomplete(options);

    });

    function CambioStatus(st, parametro, mensaje) {
        var monto = $('#Monto-CA').val();
        var proveedor = $('#proveedor-id').val();

        if ((monto != '0,00' && monto != '0' && monto != '0,0' && monto != '' && monto != '00' && proveedor != '') || st == '9') {
            $.alert({
                type: 'confirm',
                title: 'Alerta',
                text: '<h3>¿Esta seguro que desea <u>' + mensaje + '</u> esta Carta Aval?</h3>',
                callback: function () {
                    Cambio(st, parametro, monto, proveedor);
                }
            });
        } else {
            $.alert({
                type: 'alert',
                title: 'Alerta',
                text: '<h3>Todos los campos son requeridos.</h3>'
            });
        }
    }

    function Cambio(st, parametro, monto, proveedor) {

        $.ajax({
            url: 'modules/fas/Servicios.php?flag=1&' + parametro,
            method: 'POST',
            dataType: 'JSON',
            data: {
                acc: 'Status',
                monto: monto,
                proveedor: proveedor,
                st: st
            },
            success: function (data) {
                $.alert({
                    type: 'alert',
                    title: 'Alerta',
                    text: '<h3><u>' + data.mensaje + '</u>.</h3>',
                    callback: function () {
                        window.location = "dashboard.php?data=Fas-CartaAval-info&flag=1&" + parametro;
                    }
                });
                setTimeout(function () {
                    window.location = "dashboard.php?data=Fas-CartaAval-info&flag=1&" + parametro;
                }, 3000);
            }
        });
    }

    function AceptarEdit(id, tipo, parametro) {
        var campo = document.getElementById(id + 'Nueva').value;
        $.ajax({
            url: 'modules/fas/Servicios.php',
            method: 'POST',
            dataType: 'JSON',
            data: {
                acc: 'Editables',
                evento: parametro,
                campo: campo,
                tipo: tipo
            },
            success: function (data) {
                document.getElementById(id + 'Mostrado').innerHTML = '<span>' + data.datos + '</span>';
                document.getElementById(id + 'Nueva').value = data.datos;
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
</script>