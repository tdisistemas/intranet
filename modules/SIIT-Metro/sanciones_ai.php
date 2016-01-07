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

    .Editar-Visible{
        display: initial;
    }
    .centrado{
        width: 20px; 
        text-align: center; 
        vertical-align: middle;
    }
    .centrado > a > i{
        color: black;
        cursor: pointer;
    }
    .SinRegistro{
        text-align: center; 
        font-size: 12px; 
        color: grey;
    }
    #Editado{
        text-align: left;  
        //margin-left: 34%;
    }
    #Botones{
        text-align: center;
        margin-top: -35px !important;
    }
    #SeccionSanciones > div:not(:first-child){
        margin-top: 30px;
    }
    #Tabla-Sanciones{
        height: 50px;
        overflow: scroll;
    }
    #Mostrados > table{
        width: 100%; 
        display:block;
    }
    #Mostrados > table > thead{
        display: block; 
        width: 100%;
    }
    #Mostrados > table > tbody{
        width: 100%;
        display: block;
        overflow-y: auto; 
        overflow-x: hidden;
        height: 450px; 
        overflow: auto;
    }
    
    @media (max-width: 1175px){
        #Editado > div{
            margin-left: 0px;   
            margin-right: 0px;
            width: 100%;
        }
    }
    @media (max-width: 1020px){
        #Editado{
            margin-left: 0;
        }
        #Botones{
            text-align: left;
        }
        #SeccionSanciones > div:not(:first-child){
            margin-top: -20px;
        }
    }

</style>
<div id="contentHeader">
    <h2>Historial de Sanciones</h2>
</div> <!-- #contentHeader -->	
<?php
decode_get2($_SERVER["REQUEST_URI"], 2);

$cedula = _antinyeccionSQL($_GET['cedula']);
$nombre = _antinyeccionSQL($_GET['nombre']);
$origen = _antinyeccionSQL($_GET['Origen']);
_bienvenido_mysql();

$sqlquery = "SELECT "
        . "a.idSancion,"
        . "a.fecha_sancion,"
        . "a.descripcion "
        . "FROM ai_sanciones a "
        . "WHERE a.empleado = " . $cedula . " "
        . "AND status=0 "
        . "ORDER BY fecha_sancion DESC";

$sql = mysql_query($sqlquery);
$parametros = 'cedula=' . $cedula;
$parametros = _desordenar($parametros);
?>
<div class="container">
    <div class="row"> 
        <form class="form uniformForm validateForm" id="from_envio_pe" name="from_envio_pe" method="post" action="dashboard.php?data=asuntoi" >
            <div class="grid-18">
                <div class="">
                    <div class="">
                        <div class="row"><!-- .grid -->
                            <div class="grid-24 bordeado">
                                <div class="widget-header">
                                    <h3>Sanciones Administrativas</h3>
                                </div>
                                <br>
                                <div class="grid-24" id="SeccionSanciones">
                                    <div class="grid-6"> 
                                        <img align="left" style=" border: solid 5px #ddd;max-width: 100px; max-height: 100px" src="../intranet/src/images/FOTOS/No-User.png"/>
                                    </div>
                                    <div class="grid-5">
                                        <div class="field-group">								
                                            <label style="color:#B22222">Cédula:</label>
                                            <div class="field">
                                                <span><?php echo $cedula; ?></span>
                                            </div>
                                        </div> <!-- .field-group -->
                                    </div>
                                    <div class="grid-12">
                                        <div class="field-group">
                                            <label style="color:#B22222">Nombre y Apellido:</label>
                                            <div class="field">
                                                <span><?php echo $nombre; ?></span>			
                                            </div>
                                        </div> <!-- .field-group -->	
                                    </div>
                                </div>
                                <div class="grid-24" style="text-align: center; width: 90%">
                                    <div class="grid-24" style="width: 100%; text-align: center; font-size: 14px;margin-bottom: -15px">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                            <th style="width: 80px; text-align: center; color:#B22222">Fecha</th>
                                            <th style="color:#B22222">Descripción</th>
                                            <th style="width: 20px;"></th>
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="grid-24" id="Mostrado" style="width: 100%; text-align: center; font-size: 14px; overflow-y: auto; max-height: 450px;">
                                        <table class="table table-striped table-bordered">
                                            <tbody id="Tabla-Sanciones">

                                            </tbody>
                                        </table>	
                                    </div>
                                    <div id="Editado" class="grid-24" style="display: none;">
                                        <div class="grid-4">
                                            <label for="fecha" style="color:#B22222; font-size: 12px; font-weight: bold">Fecha</label><br>
                                            <input id="fecha" class="datepicker" name="fecha" value="" style="max-width: 90px" readonly/>
                                        </div>
                                        <div class="grid-20">
                                            <label for="descripcion" style="color:#B22222; font-size: 12px; font-weight: bold">Descripción</label><br>
                                            <textarea id="descripcion" class="" rows="2" style="width: 90%"></textarea>
                                        </div>
                                    </div>
                                    <div class="grid-24" id="Botones">
                                        <button style="display: " onclick="javascript:EditarCampo()" title="Nuevo" id="Editar" type="button" class="btn btn-error btn-edit"><i class="fa fa-plus"></i></button>
                                        <button style="display: none" onclick="javascript:AceptarEdit('<?= $parametros ?>')" title="Aceptar" id="Aceptar" type="button" class="btn btn-success btn-edit"><i class="fa fa-check"></i></button>
                                        <button style="display: none" onclick="javascript:CancelarEdit()" title="Cancelar" id="Cancelar" type="button" class="btn btn-error btn-edit"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- .grid -->
                </div><!-- .grid -->
            </div><!-- .grid -->	
    </div><!-- .grid -->	
    <div class="grid-6"> 
        <div id="gettingStarted" class="box">
            <h3>Estimado, <?php echo $usuario_datos['nombre'] . " " . $usuario_datos['apellido']; ?></h3>
            <p>En esta sección podrá visualizar el historial de sanciones del empleado <b></b></p>
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

    function AsignarResultado(data) {

        var lista = '';
        if (data.campos > 0) {
            var aux = 0;
            while (aux < data.campos)
            {
                lista += '<tr>\n\
                                <td style="width: 80px;text-align: center;">' + data.datos[aux].fecha + '</td>\n\
                                <td >' + data.datos[aux].descripcion + '</td>\n\
                                <td class="centrado">\n\
                                <a title="Eliminar" >\n\
                                <i onclick="javascript:Eliminar(\'' + data.datos[aux].sancion + '\')" class="fa fa-trash"></i>\n\
                                </a>\n\
                                </td>\n\
                                </tr>';
                aux++;
            }
        } else {
            lista = '<tr><td  class="SinRegistro">*** No posee Sanciones registradas. ***</td></tr>'
        }
        document.getElementById('Tabla-Sanciones').innerHTML = lista;
    }

    function VerificarSanciones(parametro) {
        $.ajax({
            url: 'modules/SIIT-Metro/Sanciones.php?flag=1&' + parametro,
            method: 'POST',
            dataType: 'JSON',
            data: {
                acc: 'verificar'
            },
            success: function (data) {
                AsignarResultado(data);
            }
        });
    }

    function Eliminar(parametro) {

        $.alert({
            type: 'confirm'
            , title: 'Alerta'
            , text: '<h3>Desea eliminar Sanción?</h3>'
            , callback: function () {
                $.ajax({
                    url: 'modules/SIIT-Metro/Sanciones.php?flag=1&' + parametro,
                    method: 'POST',
                    dataType: 'JSON',
                    data: {
                        acc: 'eliminar'
                    },
                    success: function (data) {
                        AsignarResultado(data);
                    }
                });
            }
        });
    }

    function AceptarEdit(parametro) {
        var descrp = document.getElementById('descripcion').value;
        var fecha = document.getElementById('fecha').value;
        if (descrp != '' && fecha != '') {
            $.ajax({
                url: 'modules/SIIT-Metro/Sanciones.php?flag=1&' + parametro,
                method: 'POST',
                dataType: 'JSON',
                data: {
                    acc: 'sanciones',
                    fecha: fecha,
                    descripcion: descrp
                },
                success: function (data) {
                    AsignarResultado(data);
                    CancelarEdit();
                }
            });
        } else {
            $.alert({
                type: 'alert'
                , title: 'Alerta'
                , text: '<h3>Todos los campos son requeridos!</h3>'
                , callback: function () {
                }
            });
        }
    }

    function EditarCampo() {
        document.getElementById('Editado').style.display = '';
        document.getElementById('Editar').style.display = 'none';
        document.getElementById('Aceptar').style.display = '';
        document.getElementById('Cancelar').style.display = '';

    }

    function CancelarEdit() {
        document.getElementById('fecha').value = '';
        document.getElementById('descripcion').value = '';
        document.getElementById('Editado').style.display = 'none';
        document.getElementById('Editar').style.display = '';
        document.getElementById('Aceptar').style.display = 'none';
        document.getElementById('Cancelar').style.display = 'none';

    }

    $(document).ready(function () {
        activame('<?= $origen ?>');
        VerificarSanciones('<?= $parametros ?>');
        $('#' + '<?= $origen ?>').addClass('opened');
        $('#' + '<?= $origen ?> ul').css({'display': 'block'});
        $(".datepicker").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "2014:2020"
        });
    });
</script>