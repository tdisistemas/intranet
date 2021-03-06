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
    ir('dashboard.php?data=denuncias-ai');
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
</style>
<div id="contentHeader">
    <h2>Información de Denuncias</h2>
</div> <!-- #contentHeader -->	
<?php
decode_get2($_SERVER["REQUEST_URI"], 2);
$id = _antinyeccionSQL($_GET['id']);
_bienvenido_mysql();

$sqlquery = "SELECT "
        . "d.codigo,"
        . "d.fecha,"
        . "d.denunciante,"
        . "d.descripcion,"
        . "d.status,"
        . "e.nombre,"
        . "e.apellido,"
        . "e.cedula,"
        . "e.cargo,"
        . "e.telefono_habitacion,"
        . "e.correo_electronico,"
        . "e.gerencia,"
        . "d.tipo "
        . "FROM ai_denuncias d "
        . "INNER JOIN datos_empleado_rrhh e "
        . "WHERE d.denunciante = e.cedula "
        . "AND d.idDenuncia=" . $id;

$sql = mysql_query($sqlquery);
$respuesta = mysql_fetch_array($sql);

$codigo = $respuesta['codigo'];
$nombre = $respuesta['nombre'] . ' ' . $respuesta['apellido'];
$cedula = $respuesta['cedula'];
$telefono = $respuesta['telefono_habitacion'];
$correo_principal = $respuesta['correo_electronico'];
$gerencia = $respuesta['gerencia'];
$cargo = $respuesta['cargo'];
$fecha = $respuesta['fecha'];
$descripcion = $respuesta['descripcion'];
$tipo = $respuesta['tipo'];
$status = $respuesta['status'];
?>
<div class="container">
    <div class="row"> 
        <form class="form uniformForm validateForm" id="from_envio_pe" name="from_envio_pe" method="post" action="dashboard.php?data=asuntoi" >
            <div class="grid-18">
                <div class="widget">
                    <div class="widget-header">
                        <span class="icon-layers"></span>
                        <h3>Denuncia # <?php echo $codigo; ?></h3>
                    </div>
                    <div class="widget-content">
                        <div class="row">
                            <div class="grid-1">
                            </div>
                            <div class="grid-10">
                                <div class="field-group">
                                    <div class="field">
                                        <img align="left" style=" border: solid 5px #ddd;max-width: 100px;max-height: 100px;" src="../src/images/FOTOS/<?php echo $cedula; ?>.jpg"/>
                                    </div>
                                </div> <!-- .field-group -->	

                                <div class="field-group">								
                                    <label style="color:#B22222">Cédula:</label>
                                    <div class="field">
                                        <span><?php echo $cedula; ?></span>
                                    </div>
                                </div> <!-- .field-group -->	

                                <div class="field-group">
                                    <label style="color:#B22222">Nombre y Apellido:</label>
                                    <div class="field">
                                        <span><?php echo $nombre . ' ' . $apellido; ?></span>			
                                    </div>
                                </div> <!-- .field-group -->

                                <div class="field-group">
                                    <label style="color:#B22222">Teléfono:</label>
                                    <div class="field">
                                        <span><?php echo $telefono; ?></span>
                                    </div>
                                </div> <!-- .field-group -->

                                <div class="field-group">
                                    <label style="color:#B22222">Correo Personal:</label>
                                    <div class="field">
                                        <span><?php echo $correo_principal; ?></span>	
                                    </div>
                                </div> <!-- .field-group -->

                                <div class="field-group">
                                    <label style="color:#B22222">Gerencia a que Pertenece:</label>
                                    <div class="field">
                                        <span><?php echo $gerencia; ?></span>	
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
                                    <label style="color:#B22222">Código:</label>
                                    <div class="field">
                                        <span><b><?php echo $codigo; ?></b></span>	
                                    </div>
                                </div> <!-- .field-group -->
                                <div class="field-group">
                                    <label style="color:#B22222">Fecha:</label>
                                    <div class="field">
                                        <span><?php echo $fecha; ?></span>	
                                    </div>
                                </div> <!-- .field-group -->
                                <div class="field-group">
                                    <label style="color:#B22222">Descripción:</label>
                                    <div class="field">
                                        <span><?php echo $descripcion; ?></span>	
                                    </div>
                                </div> <!-- .field-group -->
                                <div class="field-group">
                                    <label style="color:#B22222">Tipo:</label>
                                    <div class="field">
                                        <span><?php echo $tipo; ?></span>	
                                    </div>
                                </div> <!-- .field-group -->
                                <div class="field-group">
                                    <label style="color:#B22222">Estatus:</label>
                                    <div class="field">
                                        <?php
                                        $Info = 'none';
                                        $Descartar = 'none';
                                        $Nueva = 'none';
                                        switch ($status) {
                                            case 0: $st = "Espera";
                                                $color = "#8B8B8B";
                                                $Nueva = '';
                                                $texto = 'En espera.';
                                                $Descartar = '';
                                                break;
                                            case 1: $st = "Activo";
                                                $color = "green";
                                                $texto = "Averiguación Abierta.";
                                                $Info = '';
                                                break;
                                            case 2: $st = "Cerrar";
                                                $color = "green";
                                                $texto = 'Averiguación finalizada.';
                                                $Info = '';
                                                break;
                                            case 9: $st = "Eliminar";
                                                $color = "red";
                                                $texto = 'Descartada.';
                                                break;
                                        }
                                        ?>
                                        <span><?php echo iconosIntranet($st, $titulo,false,$color,false)?></span> <span style="color: <?= $color ?>;vertical-align: middle" ><?= $texto ?></span>	
                                    </div>
                                </div> <!-- .field-group -->

                            </div><!-- .grid -->
                            <div class="grid-24" style="text-align: center">
                                <div class="field-group">								
                                    <div class="actions">
                                        <?php
                                        $parametros = 'id=' . $id . '&ot=1';
                                        $parametros = _desordenar($parametros);
                                        ?> 
                                        <button onclick="javascript:NuevaAveriguacion('<?php echo $parametros; ?>')" name="Iniciar" type="button" class="btn btn-error" style="display: <?php echo $Nueva ?>">Iniciar Averiguación</button>
                                        <button onclick="javascript:DescartarDenuncia('<?= $codigo ?>', '<?php echo $parametros; ?>')" name="Descartar" type="button" class="btn btn-error" style="display: <?php echo $Descartar ?>">Descartar</button>
                                        <button onclick="javascript:InformacionAveriguacion('<?php echo $parametros; ?>')" name="Informacion" type="button" class="btn btn-error" style="display: <?php echo $Info ?>">Información de Averiguación</button>
                                        <button onclick="javascript:window.history.back();" type="button" name="Atras" class="btn btn-error" >Regresar</button>
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
                    <p>En esta sección podrá visualizar la información de la Denuncia número <b><?= $codigo ?></b></p>
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

    function DescartarDenuncia(codigo, data) {
        $.alert({
            type: 'confirm'
            , title: 'Alerta'
            , text: '<h3>¿Desea descartar la denuncia: <u>' + codigo + '</u>?</h3>'
            , callback: function () {
                window.location = "dashboard.php?data=denuncia-ai-eliminar&flag=1&" + data;
            }
        });

    }

    function NuevaAveriguacion(data) {
        window.location = "dashboard.php?data=add_investigacion&flag=1&" + data;
    }

    function InformacionAveriguacion(data) {
        window.location = "dashboard.php?data=investigacion-ai-info&flag=1&" + data;
    }
</script>