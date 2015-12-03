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
</style>

<div id="contentHeader">
    <h2>Ficha del Investigador</h2>
</div> <!-- #contentHeader -->	
<?php
decode_get2($_SERVER["REQUEST_URI"], 2);

$ci = _antinyeccionSQL($_GET['cedula']);
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
$sql.="WHERE usuario_bkp.usuario=" . $ci;



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
            . "d.ext_telefonica, "
            . "d.persona_contacto, "
            . "d.telefono_contacto "
            . "FROM datos_empleado_rrhh d, ctrabajo_datos_empleados c,encabezado_listin e "
            . "WHERE d.cedula=c.cedula_empleado "
            . "AND e.cedula=d.cedula AND e.cedula=" . $cedula;

    $sqlInvest = "SELECT id_invest,status FROM ai_investigadores WHERE cedula_invest=" . $cedula;

    $sqlInvestigador = mysql_query($sqlInvest);
    $rowInvest = mysql_fetch_array($sqlInvestigador);


    $sql = mysql_query($sqlcode);
    while ($row = mysql_fetch_array($sql)) {

        $extencion = $row["ext_telefonica"];
        $direccion = $row["direccion_habitacion"];
        $cargo = $row["cargo"];
        $salario = $row["salario"];
        $fecha_inicio = $row["fec_ing"];
        $fecha_nacimiento = $row["fecha_nac"];
        $nombre_contacto = $row["persona_contacto"];
        $telefono_contacto = $row["telefono_contacto"];
    }
}
?>
<div class="container">
    <div class="row"> 
        <form class="form uniformForm validateForm" id="from_envio_pe" name="from_envio_pe" method="post" action="" >
            <div class="grid-18">
                <div class="widget">
                    <div class="widget-header">
                        <span class="icon-layers"></span>
                        <h3>Información del Investigador</h3>
                    </div>
                    <div class="widget-content">
                        <div class="row">
                            <div class="grid-1">
                            </div>
                            <div class="grid-10">
                                <div class="field-group">
                                    <div class="field">
                                        <img align="left" style=" border: solid 5px #ddd;max-width: 100px;max-height: 100px;" src="../intranet/src/images/FOTOS/<?php echo $cedula; ?>.jpg"/>
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
                                    <label style="color:#B22222">Fecha de Nacimiento:</label>
                                    <div class="field">
                                        <span><?php echo $fecha_nacimiento; ?></span>	
                                    </div>
                                </div> <!-- .field-group --> 

                                <div class="field-group">
                                    <label style="color:#B22222">Teléfono:</label>
                                    <div class="field">
                                        <span><?php echo $telefono; ?></span>
                                    </div>
                                </div> <!-- .field-group -->

                                <div class="field-group">
                                    <label style="color:#B22222">Dirección:</label>
                                    <div class="field">
                                        <span><?php echo $direccion; ?></span>
                                    </div>
                                </div> <!-- .field-group -->

                                <div class="field-group">
                                    <label style="color:#B22222">Correo Personal:</label>
                                    <div class="field">
                                        <span><?php echo $correo_principal; ?></span>	
                                    </div>
                                </div> <!-- .field-group -->

                                <div class="field-group">
                                    <label style="color:#B22222">Persona de Contacto:</label>
                                    <?php
                                    if ($nombre_contacto != ' ' && $nombre_contacto != '') {
                                        ?>
                                        <div class="field Tarjeta">
                                            <p class="TituloTarjeta">Nombre: </p>
                                            <p ><?php echo $nombre_contacto; ?></p>			
                                            <p class="TituloTarjeta">Cedula: </p>
                                            <p ><?php echo $telefono_contacto; ?></p>	
                                        </div> <!-- .field -->
                                        <?php
                                    } else {
                                        ?>
                                        <div class="field">
                                            <label for="fname">*** No Posee Contacto Registrado! *** </label>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div> <!-- .field-group -->

                                <div class="field-group">
                                    <label style="color:#B22222">Carga Familiar:</label>
                                    <?php
                                    $sqlcode = "SELECT "
                                            . "cedula_familiar, "
                                            . "nombres, parentesco "
                                            . "FROM datos_familiares_rrhh "
                                            . "WHERE cedula_empleado =" . $cedula . " "
                                            . "AND cedula_familiar > 0 "
                                            . "ORDER BY cedula_familiar ASC";

                                    $sql = mysql_query($sqlcode);
                                    if ($row = mysql_fetch_array($sql)) {

                                        do {

                                            $parentesco = $row["parentesco"];
                                            $nombres_familiar = $row["nombres"];
                                            $cedula_familiar = $row["cedula_familiar"];
                                            ?>
                                            <div class="field Tarjeta">
                                                <p class="TituloTarjeta">Nombre: </p>
                                                <p ><?php echo $nombres_familiar; ?></p>
                                                <p style="font-weight: bold"><?php echo $parentesco; ?></p>
                                                <?php
                                                if ($cedula_familiar != '1' && $cedula_familiar != '2') {
                                                    ?>
                                                    <p class="TituloTarjeta">Cedula: </p>
                                                    <p ><?php echo $cedula_familiar; ?></p>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <?php
                                        } while ($row = mysql_fetch_array($sql));
                                    } else {
                                        ?>
                                        <div class="field">
                                            <label for="fname">*** No Posee Familiares Registrados! *** </label>
                                        </div>
                                        <?php
                                    }
                                    switch ($rowInvest['status']) {

                                        case 0: $st = "check";
                                            $color = "green";
                                            $texto = 'Activo';
                                            $titulo = 'Desactivar';
                                            break;
                                        case 1: $st = "ban";
                                            $color = "red";
                                            $texto = 'Inactivo.';
                                            $titulo = 'Activar';
                                            break;
                                    }
                                    ?>
                                </div> <!-- .field-group -->
                            </div>
                            <div class="grid-10">
                                <div class="field-group">
                                    <label style="color:#B22222">Estatus:</label>
                                    <div class="field">
                                        <span><i class="fa fa-<?= $st ?>" style="color: <?= $color ?>" ></i></span> <span style="color: <?= $color ?>" ><?= $texto ?></span>
                                    </div>		
                                </div> <!-- .field-group -->
                                <div class="field-group">
                                    <label style="color:#B22222">Gerencia a que Pertenece:</label>
                                    <div class="field">
                                        <span><?php echo $gerencia; ?></span>	
                                    </div>		
                                </div> <!-- .field-group -->

                                <div class="field-group">
                                    <label style="color:#B22222">Extensión:</label>
                                    <div class="field">
                                        <?php echo $extencion != '0' ? '<span>' . $extencion . '</span>' : '<label for="fname">*** No Posee Extención Registrada! *** </label>' ?>	
                                    </div>
                                </div> <!-- .field-group -->   

                                <div class="field-group">
                                    <label style="color:#B22222">Cargo:</label>
                                    <div class="field">
                                        <span><?php echo $cargo; ?></span>	
                                    </div>
                                </div> <!-- .field-group -->   

                                <div class="field-group">
                                    <label style="color:#B22222">Fecha de Ingreso:</label>
                                    <div class="field">
                                        <span><?php echo $fecha_inicio; ?></span>	
                                    </div>
                                </div> <!-- .field-group -->   

                                <div class="field-group">
                                    <label style="color:#B22222">Salario:</label>
                                    <div class="field">
                                        <span><?php echo number_format($salario, 2, ',', '.'); ?></span>	
                                    </div>
                                </div> <!-- .field-group -->  

                                <div class="field-group">
                                    <label style="color:#B22222">Usuario:</label>
                                    <div class="field">
                                        <span><?php echo $usuario_int; ?></span>
                                    </div>
                                </div> <!-- .field-group -->  

                                <div class="field-group">
                                    <label style="color:#B22222">Correo Corporativo:</label>
                                    <div class="field">
                                        <?php
                                        /* if (_correo_existe($usuario_int . "@metrodemaracaibo.gob.ve") == 'SI') {
                                          $poseecorreo = $usuario_int . "@metrodemaracaibo.gob.ve";
                                          } else {
                                          $poseecorreo = "*** No Posee Correo ***";
                                          } */
                                        ?>
                                        <span><?php echo $usuario_int . "@metrodemaracaibo.gob.ve"; //echo $poseecorreo;           ?></span>	
                                    </div>
                                </div> <!-- .field-group -->
                                <div class="field-group">
                                    <label style="color:#B22222">Permisos:</label>
                                    <?php
                                    $sqlcode = "SELECT "
                                            . "motivo_sol, "
                                            . "duracion, "
                                            . "tipo_duracion, "
                                            . "fecha_s "
                                            . "FROM permiso_empleado "
                                            . "WHERE cedula_empleado=" . $cedula . " "
                                            . "AND status=6 "
                                            . "ORDER BY fecha";

                                    $sql = mysql_query($sqlcode);
                                    if ($row = mysql_fetch_array($sql)) {

                                        do {

                                            $motivo = $row["motivo_sol"];
                                            $duracion = $row["fecha_s"] . ' ( ' . $row["duracion"] . ' ' . $row["tipo_duracion"] . " )";
                                            ?>
                                            <div class="field Tarjeta">
                                                <p class="TituloTarjeta">Motivo: </p>
                                                <p ><?php echo $motivo; ?></p>			
                                                <p class="TituloTarjeta">Fecha y Duración: </p>
                                                <p ><?php echo $duracion; ?></p>
                                            </div>
                                            <?php
                                        } while ($row = mysql_fetch_array($sql));
                                    } else {
                                        ?>
                                        <div class="field">
                                            <label for="fname">*** No Posee Permisos Registrados! *** </label>
                                        </div>
                                        <?php
                                    }
                                    _adios_mysql();
                                    ?>
                                </div> <!-- .field-group -->
                            </div><!-- .grid -->
                        </div><!-- .grid -->
                    </div><!-- .grid -->
                </div><!-- .grid -->	
            </div><!-- .grid -->	
            <div class="grid-6">
                <div id="gettingStarted" class="box">
                    <h3>Estimado, <?php echo $usuario_datos['nombre'] . " " . $usuario_datos['apellido']; ?></h3>
                    <p>En esta sección podrá visualizar la ficha de investigador</p>
                    <div class="box plain">
                        <?php
                        $rowInvest['status'] == '1' ? $acc = '0' : $acc = '1';
                        $parametros = 'id=' . $rowInvest['id_invest'] . '&acc=' . $acc;
                        $parametros = _desordenar($parametros);
                        ?>
                        <a class="btn btn-primary btn-large dashboard_add" href="javascript:CambiarStatus_Investigador('<?php echo $nombre . ' ' . $apellido ?>','dashboard.php?data=investigador-ai-eliminar&flag=1&<?php echo $parametros; ?>','<?= $rowInvest['status'] ?>')" id="eliminar-us" ><?= $titulo ?></a>
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
    function CambiarStatus_Investigador(perfil, param, tipo) {
        var tipo_accion;
        if (tipo == 1) {
            tipo_accion = "reactivar";
        } else {
            tipo_accion = "desactivar";
        }
        $.alert({
            type: 'confirm'
            , title: 'Alerta'
            , text: '<h3>¿Desea ' + tipo_accion + ' al investigador: <u>' + perfil + '</u> ?</h3>'
            , callback: function () {
                window.location = param;
            }
        });
    }
</script>