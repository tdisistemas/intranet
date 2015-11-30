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
    ir('dashboard.php?data=usuarios_ai');
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
        font-size: 12px; 
        padding: 5px;
        box-shadow: 2px 2px 5px #999;
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
    <h2>Historial del Empleado</h2>
</div> <!-- #contentHeader -->	
<?php
decode_get2($_SERVER["REQUEST_URI"], 2);

$id = _antinyeccionSQL($_GET['id']);
_bienvenido_mysql();

$sql = "SELECT ";
$sql.="usuario_bkp.id_usuario, ";
$sql.="usuario_bkp.nombre, ";
$sql.="usuario_bkp.apellido, ";
$sql.="usuario_bkp.usuario, ";
$sql.="autenticacion.clave, ";
$sql.="usuario_bkp.correo_corporativo, ";
$sql.="usuario_bkp.correo_principal, ";
$sql.="usuario_bkp.telefono, ";
$sql.="usuario_bkp.habilitado, ";
$sql.="usuario_bkp.usuario_int, ";
$sql.="'disponible', ";
$sql.="autenticacion.perfil, ";
$sql.="perfiles.perfil AS perfil_nom, ";
$sql.="perfiles.role AS role, ";
$sql.="usuario_bkp.ubicacion_laboral ";
$sql.="FROM ";
$sql.="usuario_bkp ";
$sql.="LEFT JOIN autenticacion ON autenticacion.cedula = usuario_bkp.usuario ";
$sql.="LEFT JOIN perfiles ON autenticacion.perfil = perfiles.id ";
$sql.="WHERE usuario_bkp.id_usuario=$id;";



$perfil_qry = mysql_query($sql);

if ($perfil_qry) {
    $reg = mysql_fetch_array($perfil_qry);
    $num_rows = mysql_num_rows($perfil_qry);
    if ($num_rows == 1) {

        $id_empleado = $reg[0];
        $cedula = $reg[3];
        $nombre = $reg[1];
        $apellido = $reg[2];
        $correo_principal = $reg[6];
        $correo_corporativo = $reg[5];
        $telefono = $reg[7];
        $gerencia = $reg[10];
        $usuario_int = $reg[9];
        $perfil = $reg[12];
        $idperfil = $reg[11];
        $id_gerencia = $reg[10];
        $gerencia = $reg[14];
    } else {
        // SI NO ENCUENTRA REGISTROS SENCILLAMENTE ALGO PASO DEMACIADO RARO!
    }
    $sqlcode = "SELECT "
            . "d.direccion_habitacion,"
            . "d.cargo,"
            . "c.salario,"
            . "e.fec_ing, "
            . "d.fecha_nac, "
            . "d.persona_contacto, "
            . "d.telefono_contacto "
            . "FROM datos_empleado_rrhh d, ctrabajo_datos_empleados c,encabezado_listin e "
            . "WHERE d.cedula=c.cedula_empleado "
            . "AND e.cedula=d.cedula AND e.cedula=" . $cedula;

    $sql = mysql_query($sqlcode);
    while ($row = mysql_fetch_array($sql)) {

        $direccion = $row["direccion_habitacion"];
        $cargo = $row["cargo"];
        $salario = $row["salario"];
        $fecha_inicio = $row["fec_ing"];
        $fecha_nacimiento = $row["fecha_nac"];
        $nombre_contacto = $row["persona_contacto"];
        $telefono_contacto = $row["telefono_contacto"];
    }
} else {
    if ($SQL_debug == '1') {
        die('Error en Visualizar para Modificar Registro - Respuesta del Motor: ' . mysql_error());
    } else {
        die('Error en Modificar Registro');
    }
}
?>
<div class="container">
    <div class="row"> 
        <form class="form uniformForm validateForm" id="from_envio_pe" name="from_envio_pe" method="post" action="dashboard.php?data=asuntoi" >
            <div class="grid-18">
                <div class="widget">
                    <div class="widget-header">
                        <span class="icon-layers"></span>
                        <h3>Historial del Empleado</h3>
                    </div>
                    <div class="widget-content">
                        <div class="row">
                            <div class="grid-1">
                            </div>
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
                                </div>
                                <div class="field-group">
                                    <label style="color:#B22222">Nombre y Apellido:</label>
                                    <div class="field">
                                        <span><?php echo $nombre . ' ' . $apellido; ?></span>			
                                    </div>
                                </div>
                                <div class="field-group">
                                    <label style="color:#B22222">Extensión:</label>
                                    <div class="field">
                                        <span><?php echo $extension; ?></span>	
                                    </div>		
                                </div> 
                            </div>
                            <div class="grid-10">
                                <div class="field-group">
                                    <label style="color:#B22222">Cargo:</label>
                                    <div class="field">
                                        <span><?php echo $cargo; ?></span>			
                                    </div>
                                </div> 
                                <div class="field-group">
                                    <label style="color:#B22222">Gerencia:</label>
                                    <div class="field">
                                        <span><?php echo $gerencia; ?></span>	
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
                    <p>En esta sección podrá visualizar el historial de incidencias del empleado <i><?= $nombre . ' ' . $apellido ?></i></p>
                    <div class="box plain">
                        <?php
                        $parametros = 'id=' . $id_empleado;
                        $parametros = _desordenar($parametros);
                        ?>  
                        <a href="dashboard.php?data=citar" class="btn btn-primary btn-large dashboard_add">Citar</a>
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
</script>
