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
        . "a.causa,"
        . "a.recomendacion,"
        . "a.conclusion,"
        . "b.codigo,"
        . "b.status AS st_den,"
        . "a.fecha,"
        . "b.fecha AS fecha_den,"
        . "b.descripcion,"
        . "b.tipo,"
        . "d.nombre,"
        . "d.apellido,"
        . "a.status AS st_ave "
        . "FROM ai_averiguaciones a "
        . "INNER JOIN ai_denuncias b ON a.denuncia = b.idDenuncia "
        . "INNER JOIN ai_investigadores c ON a.investigador=c.id_invest "
        . "INNER JOIN datos_empleado_rrhh d ON c.cedula_invest = d.cedula "
        . "WHERE a.idAveriguacion=" . $id;

$sql = mysql_query($sqlquery);
$respuesta = mysql_fetch_array($sql);

$codigo = $respuesta['codigo'];
$codigo_ave = $respuesta['codigo_ave'];
$nombre = $respuesta['nombre'] . ' ' . $respuesta['apellido'];
$causa = $respuesta['causa'];
$st_den = $respuesta['st_den'];
$st_ave = $respuesta['st_ave'];
$fecha = $respuesta['fecha'];
$fecha_den = $respuesta['fecha_den'];
$descripcion = $respuesta['descripcion'];
$tipo = $respuesta['tipo'];
$recomendacion = $respuesta['recomendacion'];
$conclusion = $respuesta['conclusion'];

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
                                                    <img align="left" style=" border: solid 5px #ddd;width: 100px;" src="../../src/images/FOTOS/<?php echo $cedula; ?>.jpg"/>
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
                                                    <span><?php echo $extension; ?></span>	
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
                                    <h3>Denuncia</h3>
                                </div>
                                <br>
                                <div class="grid-8">
                                    <div class="field-group">
                                        <label style="color:#B22222">Código:</label>
                                        <div class="field">
                                            <span><b><?php echo $codigo; ?></b></span>	
                                        </div>
                                    </div> <!-- .field-group -->
                                    <div class="field-group">
                                        <label style="color:#B22222">Fecha:</label>
                                        <div class="field">
                                            <span><?php echo $fecha_den; ?></span>	
                                        </div>
                                    </div> <!-- .field-group -->
                                    <div class="field-group">
                                        <label style="color:#B22222">Tipo:</label>
                                        <div class="field">
                                            <span><?php echo $tipo; ?></span>	
                                        </div>
                                    </div> <!-- .field-group -->
                                </div>
                                <div class="grid-14">
                                    <div class="field-group">
                                        <label style="color:#B22222">Descripción:</label>
                                        <div class="field">
                                            <span><?php echo $descripcion; ?></span>	
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
                                            <button style="display: " onclick="javascript:EditarCampo('Conclu_')" title="Editar" id="Conclu_Editar" type="button" class="btn btn-error btn-edit"><i class="fa fa-edit"></i></button>
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
                                            <button style="display: " onclick="javascript:EditarCampo('Recom_')" title="Editar" id="Recom_Editar" type="button" class="btn btn-error btn-edit"><i class="fa fa-edit"></i></button>
                                            <button style="display: none" onclick="javascript:AceptarEdit('Recom_', 2, '<?= $id ?>')" title="Aceptar" id="Recom_Aceptar" type="button" class="btn btn-success btn-edit"><i class="fa fa-check"></i></button>
                                            <button style="display: none" onclick="javascript:CancelarEdit('Recom_')" title="Cancelar" id="Recom_Cancelar" type="button" class="btn btn-error btn-edit"><i class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .grid -->
                            <div class="grid-24" style="text-align: center">
                                <div class="field-group">								
                                    <div class="actions">
                                        <button onclick="javascript:Revision('<?php echo $parametros; ?>')" name="Iniciar" type="button" class="btn btn-error">Enviar a Revisión</button>
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
                    <p>En esta sección podrá visualizar la información de la averiguación numero <b><?= $codigo_ave ?></b></p>
                </div>
            </div>
        </form>
    </div><!-- .row -->
</div><!-- .container-->

<script type="text/javascript">
    window.onload = function () {
        espejo_gerencia();
    }

    function AceptarEdit(id, tipo, parametro) {
        var dato = document.getElementById(id + 'Nueva').value;
        $.ajax({
            url: 'modules/SIIT-Metro(Admin)/Conclusiones_Recomendaciones.php',
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