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
    <h2>Ficha del Empleado</h2>
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
    $sqlcode = "SELECT d.direccion_habitacion,d.cargo,c.salario,e.fec_ing FROM datos_empleado_rrhh d, ctrabajo_datos_empleados c,encabezado_listin e WHERE d.cedula=c.cedula_empleado AND e.cedula=d.cedula AND e.cedula= $cedula";
    $sql = mysql_query($sqlcode);
    while ($row = mysql_fetch_array($sql)) {

        $direccion = $row["direccion_habitacion"];
        $cargo = $row["cargo"];
        $salario = $row["salario"];
        $fecha_inicio = $row["fec_ing"];
    }


    _adios_mysql();
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
            <div class="grid-16">
                <div class="widget">
                    <div class="widget-content">
                        <div class="field-group">								
                            <img align="right" style=" border: solid 5px #ddd;width: 100px;margin: 0;  float: right;" src="../../src/images/FOTOS/<?php echo $cedula; ?>.jpg"/>  
                            <br><br><br>   <br><br>  
                            <label>Cedula:</label>
                            <div class="field">
                                <input style="background-color:lightgray" name="cedula" readonly value="<?php echo $cedula; ?>" type="text" name="cedula" id="cedula" size="30" />	
                            </div>
                        </div> <!-- .field-group -->				 

                        <div class="field-group">
                            <label>Nombre y Apellido:</label>
                            <div class="field">
                                <input style="background-color:lightgray" readonly value="<?php echo $nombre; ?>" type="text" name="fname" id="fname" size="30" class="" />			
                                <label for="fname">Nombres</label>
                            </div>
                            <div class="field">
                                <input style="background-color:lightgray" readonly value="<?php echo $apellido; ?>" type="text" name="lname" id="lname" size="30" class="" />			
                                <label for="lname">Apellidos</label>
                            </div>
                        </div> <!-- .field-group -->

                        <div class="field-group">
                            <label>Telefono:</label>
                            <div class="field">
                                <input style="background-color:lightgray" readonly value="<?php echo $telefono; ?>" type="text" name="telefono" id="telefono" size="30"/>	
                            </div>
                        </div> <!-- .field-group -->

                        <div class="field-group">
                            <label>Dirección:</label>
                            <div class="field">
                                <textarea style="background-color:lightgray" readonly value="<?php echo $direccion; ?>" type="text" name="telefono" id="telefono" cols="50" rows="2" class="validate[required]" ><?php echo $direccion; ?></textarea>	
                            </div>
                        </div> <!-- .field-group -->

                        <div class="field-group">		
                            <label>Gerencia a que Pertenece:</label>
                            <div class="field">
                                <textarea style="background-color:lightgray" name="cedula" readonly value="<?php echo $gerencia; ?>" type="text" name="gerencia" id="gerencia" cols="50" rows="2" ><?php echo $gerencia; ?></textarea>	
                            </div>		
                        </div> <!-- .field-group -->

                        <div class="field-group">
                            <label> Cargo:</label>
                            <div class="field">
                                <input style="background-color:lightgray" readonly value="<?php echo $cargo; ?>" type="text" name="usuario_int" id="usuario_int" size="30"/>	
                            </div>
                        </div> <!-- .field-group -->   
                        <div class="field-group">
                            <label> Fecha de Ingreso:</label>
                            <div class="field">
                                <input style="background-color:lightgray" readonly value="<?php echo $fecha_inicio; ?>" type="text" name="fecha_ini" id="fecha_ini" size="30" />	
                            </div>
                        </div> <!-- .field-group -->   

                        <div class="field-group">
                            <label> Salario:</label>
                            <div class="field">
                                <input style="background-color:lightgray" readonly value="<?php echo number_format($salario, 2, ',', '.'); ?>" type="text" name="usuario_int" id="usuario_int" size="30"/>	
                            </div>
                        </div> <!-- .field-group -->  

                        <div class="field-group">
                            <label>Usuario:</label>
                            <div class="field">
                                <input style="background-color:lightgray" readonly value="<?php echo $usuario_int; ?>" type="text" name="usuario_int" id="usuario_int" size="30" />	
                            </div>
                        </div> <!-- .field-group -->  

                        <div class="field-group">
                            <label>Correo Principal:</label>
                            <div class="field">
                                <input style="background-color:lightgray" readonly value="<?php echo $correo_principal; ?>" type="text" name="correo_principal" id="correo_principal" size="30" />	
                            </div>
                        </div> <!-- .field-group -->

                        <div class="field-group">
                            <label>Correo Corporativo:</label>
                            <div class="field">
                                <?php
                                /* if (_correo_existe($usuario_int . "@metrodemaracaibo.gob.ve") == 'SI') {
                                  $poseecorreo = $usuario_int . "@metrodemaracaibo.gob.ve";
                                  } else {
                                  $poseecorreo = "*** No Posee Correo ***";
                                  } */
                                ?>
                                <input style="background-color:lightgray" readonly value="<?php echo $correo_corporativo; //echo $poseecorreo;            ?>" onChange="javascript:this.value = this.value.toUpperCase();" type="text" name="correo_corporativo" id="correo_corporativo" size="30" />	
                            </div>
                        </div> <!-- .field-group -->

                        <div class="actions" style="text-aling:right">
                            <button name="Submit" type="submit" class="btn btn-error">Agregar Incidencia</button>
                            <input type="button" name="Atras" onclick="javascript:window.history.back();" class="btn btn-error" value="Regresar" />
                        </div> <!-- .actions -->
                    </div> <!-- .widget-content -->
                </div> <!-- .widget -->	
            </div><!-- .grid -->	
            <div class="grid-8">
                <div id="gettingStarted" class="box">
                    <h3>Estimado, <?php echo $usuario_datos['nombre'] . " " . $usuario_datos['apellido']; ?></h3>
                    <p>En esta seccion podra visualizar la ficha de los usuarios en el sistema</p>
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