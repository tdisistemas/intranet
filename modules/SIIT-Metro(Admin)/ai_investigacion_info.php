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

    bordeado{
        border: 1px solid #A5A5A5; 
        border-style: outset; 
        border-radius: 0px 0px 15px 15px;
    }

    .encabezado {
        background: #FF8484;
        background:-moz-linear-gradient(top, #FF8484 0%, #FF8484 100%); /* FF3.6+ */
        background:-webkit-gradient(linear, left top, left bottom, color-stop(0%,#FF8484), color-stop(100%,#FF8484)); /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(top, #FF8484 0%,#FF8484 100%); /* Chrome10+,Safari5.1+ */
        background:-o-linear-gradient(top, #FF8484 0%,#FF8484 100%); /* Opera11.10+ */
        background:-ms-linear-gradient(top, #FF8484 0%,#FF8484 100%); /* IE10+ */
        background:linear-gradient(top, #FF8484 0%,#FF8484 100%); /* W3C */
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#FAFAFA', endColorstr='#E9E9E9');
        -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr='#FAFAFA', endColorstr='#E9E9E9')";

        height: 40px;
        line-height: 40px;

        border-bottom: 1px solid #D5D5D5;

        position: relative;

        -webkit-border-top-left-radius: 4px;
        -webkit-border-top-right-radius: 4px;
        -moz-border-radius-topleft: 4px;
        -moz-border-radius-topright: 4px;
        border-top-left-radius: 4px;
        border-top-right-radius: 4px;

        -webkit-background-clip: padding-box;
    }
    .encabezado-in {
	background: #E9E9E9;
	background:-moz-linear-gradient(top, #FAFAFA 0%, #E9E9E9 100%); /* FF3.6+ */
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0%,#FAFAFA), color-stop(100%,#E9E9E9)); /* Chrome,Safari4+ */
	background:-webkit-linear-gradient(top, #FAFAFA 0%,#E9E9E9 100%); /* Chrome10+,Safari5.1+ */
	background:-o-linear-gradient(top, #FAFAFA 0%,#E9E9E9 100%); /* Opera11.10+ */
	background:-ms-linear-gradient(top, #FAFAFA 0%,#E9E9E9 100%); /* IE10+ */
	background:linear-gradient(top, #FAFAFA 0%,#E9E9E9 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#FAFAFA', endColorstr='#E9E9E9');
	-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr='#FAFAFA', endColorstr='#E9E9E9')";
	
	height: 40px;
	line-height: 40px;
	
	border-bottom: 1px solid #D5D5D5;
	
	position: relative;
	
	-webkit-border-top-left-radius: 4px;
	-webkit-border-top-right-radius: 4px;
	-moz-border-radius-topleft: 4px;
	-moz-border-radius-topright: 4px;
	border-top-left-radius: 4px;
	border-top-right-radius: 4px;
	
	-webkit-background-clip: padding-box;
	margin-bottom: 15px;
    }
    .encabezado h3{

        font-size: 14px;
        font-weight: 800;
        color: #FFF;
        line-height: 18px;
        display: inline-block;
        margin-right: 3em;

        position: relative;
        top: 2px;
        left: 10px;

        text-shadow: 1px 1px 2px rgba(255,255,255,.5);
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
        . "b.codigo,"
        . "b.status AS st_den,"
        . "a.fecha,"
        . "b.fecha AS fecha_den,"
        . "b.descripcion,"
        . "d.nombre,"
        . "d.apellido,"
        . "e.gerencia,"
        . "e.nombre AS Invo_nombre,"
        . "a.involucrado,"
        . "e.apellido AS Invo_apellido,"
        . "a.status AS st_ave "
        . "FROM ai_averiguaciones a "
        . "INNER JOIN ai_denuncias b ON a.denuncia = b.idDenuncia "
        . "INNER JOIN ai_investigadores c ON a.investigador=c.id_invest "
        . "INNER JOIN datos_empleado_rrhh d ON c.cedula_invest = d.cedula "
        . "INNER JOIN datos_empleado_rrhh e ON a.involucrado = e.cedula "
        . "WHERE a.idAveriguacion=" . $id;

$sql = mysql_query($sqlquery);
$respuesta = mysql_fetch_array($sql);

$codigo = $respuesta['codigo'];
$codigo_ave = $respuesta['codigo_ave'];
$nombre = $respuesta['nombre'] . ' ' . $respuesta['apellido'];
$nombreInvo = $respuesta['Invo_nombre'] . ' ' . $respuesta['Invo_apellido'];
$fecha = $respuesta['fecha'];
$causa = $respuesta['causa'];
$st_den = $respuesta['st_den'];
$st_ave = $respuesta['st_ave'];
$cedula = $respuesta['involucrado'];
$gerencia = $respuesta['gerencia'];
$fecha = $respuesta['fecha'];
$fecha_den = $respuesta['fecha_den'];
$descripcion = $respuesta['descripcion'];
?>
<div class="container">
    <div class="row"> 
        <form class="form uniformForm validateForm" id="from_envio_pe" name="from_envio_pe" method="post" action="dashboard.php?data=asuntoi" >
            <div class="grid-18">
                <div class="widget">
                    <div class="widget-header">
                        <span class="icon-layers"></span>
                        <h3>Averiguación # <?php echo $codigo_ave; ?></h3>
                    </div>
                    <div class="widget-content">
                        <div class="row">
                            <div class="grid-24 bordeado" style="">
                                <div class="encabezado">
                                    <h3 style="padding-top: 10px; padding-left: 15px">Involucrado </h3>
                                </div>
                                <br>
                                <div class="grid-5">
                                    <div class="field-group">
                                        <div class="field">
                                            <img align="left" style=" border: solid 5px #ddd;width: 100px;" src="../../src/images/FOTOS/<?php echo $cedula; ?>.jpg"/>
                                        </div>
                                    </div> <!-- .field-group -->
                                </div>
                                <div class="grid-11">
                                    <div class="field-group">
                                        <label style="color:#B22222">Nombre:</label>
                                        <div class="field">
                                            <span><?php echo $nombreInvo; ?></span>			
                                        </div>
                                    </div> <!-- .field-group -->
                                    <div class="field-group">
                                        <label style="color:#B22222">Gerencia:</label>
                                        <div class="field">
                                            <span><?php echo $gerencia; ?></span>	
                                        </div>		
                                    </div> <!-- .field-group -->
                                </div>
                                <div class="grid-8">
                                    <div class="field-group">								
                                        <label style="color:#B22222">Cedula:</label>
                                        <div class="field">
                                            <span><?php echo $cedula; ?></span>
                                        </div>
                                    </div> <!-- .field-group -->
                                </div>


                            </div>
                            <div class="grid-24 bordeado">
                                <div class="widget-header">
                                    <h3 style="padding-top: 10px; padding-left: 15px">Denuncia</h3>
                                </div>
                                <br>
                                <div class="grid-8">
                                    <div class="field-group">
                                        <label style="color:#B22222">Codigo:</label>
                                        <div class="field">
                                            <span><b><?php echo $codigo; ?></b></span>	
                                        </div>
                                    </div> <!-- .field-group -->
                                </div>
                                <div class="grid-8">
                                    <div class="field-group">
                                        <label style="color:#B22222">Fecha:</label>
                                        <div class="field">
                                            <span><?php echo $fecha_den; ?></span>	
                                        </div>
                                    </div> <!-- .field-group -->
                                </div>
                                <div class="grid-8">
                                    <div class="field-group">
                                        <label style="color:#B22222">Descripción:</label>
                                        <div class="field">
                                            <span><?php echo $descripcion; ?></span>	
                                        </div>
                                    </div> <!-- .field-group -->
                                </div><!-- .grid -->
                            </div><!-- .grid -->
                            <div class="grid-24" style="text-align: center">
                                <div class="field-group">								
                                    <div class="actions">
                                        <?php
                                        $parametros = 'id=' . $id;
                                        $parametros = _desordenar($parametros);
                                        ?> 

                                        <button onclick="javascript:NuevaAveriguacion('<?php echo $parametros; ?>')" name="Iniciar" type="button" class="btn btn-error">Iniciar Averiguación</button>
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
                    <p>En esta seccion podra visualizar la información de la averiguación numero <b><?= $codigo_ave ?></b></p>
                </div>
            </div>
        </form>
    </div><!-- .row -->
</div><!-- .container-->

<script type="text/javascript">
    window.onload = function () {
        espejo_gerencia();
    }

    function NuevaAveriguacion(data) {
        window.location = "dashboard.php?data=add_investigacion&flag=1&" + data;
    }
</script>