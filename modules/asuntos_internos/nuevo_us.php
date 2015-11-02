<?php
alerta('Modulo Deshabilitado por codigo');
ir('dashboard.php');
if (array_pop(explode('/', $_SERVER['PHP_SELF'])) != 'dashboard.php') {
    header("Location: ../../dashboard.php");
}
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
    notificar("Usted no tiene permisos para esta Seccion/Modulo", "dashboard.php?data=notificar", "notify-error");
    _wm($usuario_datos[9], 'Acceso Denegado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
}
_wm($usuario_datos[9], 'Acceso Autorizado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
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
    <h2>Agregar Usuario/Empleado</h2>
</div> <!-- #contentHeader -->	
<?php
if (isset($_POST['Submit'])) {

    $cedula = $_POST["cedula"];
    $nombre = $_POST["fname"];
    $apellido = $_POST["lname"];
    $correo_principal = $_POST["correo_principal"];
    $correo_corporativo = $_POST["correo_corporativo"];
    $telefono = $_POST["telefono"];
    $gerencia = $_POST["gerencia"];
    $usuario_int = $_POST["usuario_int"];
    $password = md5($_POST["password1"] . $cedula);
    $perfil = $_POST["perfil"];

    _bienvenido_mysql();



    $sql = "INSERT INTO autenticacion(cedula, clave, perfil) VALUES('" . $usuario_datos[3] . "','" . $password . "','" . $perfil . "')";
    $result = mysql_query($sql);
    if (!$result) {
        if ($SQL_debug == '1') {

            $resultado = strpos(mysql_error(), 'Duplicate');
            if ($resultado !== FALSE) {
                notificar("Usuario/Empleado Duplicado", "dashboard.php?data=usuarios", "notify-success");
            }
            die('Error en Agregar Registro - 01 - Respuesta del Motor: ' . mysql_error());
            $resultado = strpos(mysql_error(), 'Duplicate');
            if ($resultado !== FALSE) {
                notificar("Usuario/Empleado Duplicado", "dashboard.php?data=usuarios", "notify-success");
            }
        } else {
            die('Error en Agregar Registro');
        }
    }



    $sql = "INSERT INTO usuario_bkp(usuario, nombre, apellido, usuario_int, correo_corporativo, correo_principal, telefono, ubicacion_laboral) VALUES(" . $cedula . ",'" . $nombre . "','" . $apellido . "','" . $usuario_int . "','" . $correo_corporativo . "','" . $correo_principal . "','" . $telefono . "','" . $gerencia . "')";
    $result = mysql_query($sql);
    if ($result) {
        notificar("Usuario/Empleado ingresado con exito", "dashboard.php?data=usuarios", "notify-success");
    } else {
        if ($SQL_debug == '1') {
            die('Error en Agregar Registro - 02 - Respuesta del Motor: ' . mysql_error());
        } else {
            die('Error en Agregar Registro');
        }
    }
} else {
    ?>



    <div class="container">
        <div class="row">
            <form class="form uniformForm validateForm" id="from_envio_pe" name="from_envio_pe" method="post" action="#" >
                <div class="grid-16">
                    <div class="widget">
                        <div class="widget-content">
                            <div class="field-group">								
                                <label>Cedula:</label>
                                <div class="field">
                                    <input readonly onkeypress="return event.charCode >= 48 && event.charCode <= 57" type="text" name="cedula" id="cedula" size="25" class="validate[required],maxSize[9]" />	
                                </div>
                            </div> <!-- .field-group -->				 

                            <div class="field-group">
                                <label>Nombre y Apellido:</label>
                                <div class="field">
                                    <input readonly onChange="javascript:this.value = this.value.toUpperCase();" onkeypress="return event.charCode >= 65 && event.charCode <= 90 || event.charCode >= 97 && event.charCode <= 122" type="text" name="fname" id="fname" size="25" class="" />			
                                    <label for="fname">Primer Nombre</label>
                                </div>
                                <div class="field">
                                    <input readonly onChange="javascript:this.value = this.value.toUpperCase();" onkeypress="return event.charCode >= 65 && event.charCode <= 90 || event.charCode >= 97 && event.charCode <= 122" type="text" name="lname" id="lname" size="25" class="" />			
                                    <label for="lname">Primer Apellido</label>
                                </div>
                            </div> <!-- .field-group -->

                            <div class="field-group">
                                <label>Usuario:</label>
                                <div class="field">
                                    <input  onChange="javascript:this.value = this.value.toUpperCase();" onkeypress="return event.charCode >= 65 && event.charCode <= 90 || event.charCode >= 97 && event.charCode <= 122 || event.charCode == 46" type="text" name="usuario_int" id="usuario_int" size="32" class="validate[required]" />	
                                    <label for="lname">Recuerde que debe de ser NOMBRE.APELLIDO</label>
                                </div>
                            </div> <!-- .field-group -->

                            <div class="field-group">
                                <label>Contraseña:</label>
                                <div class="field">
                                    <input type="password" name="password1" id="password1" size="35" class="validate[required,minSize[8]]" value="" />	
                                </div>
                            </div> <!-- .field-group -->

                            <div class="field-group">
                                <label>Contraseña Nuevamente:</label>
                                <div class="field">
                                    <input type="password" name="password2" id="password2" size="35" class="validate[required,equals[password1]]" value="" />	
                                </div>
                            </div> <!-- .field-group -->             

                            <div class="field-group">
                                <label>Correo Principal:</label>
                                <div class="field">
                                    <input onChange="javascript:this.value = this.value.toLowerrCase();" type="text" name="correo_principal" id="correo_principal" size="45" class="validate[custom[email]" />	
                                </div>
                            </div> <!-- .field-group -->

                            <div class="field-group">
                                <label>Correo Corporativo:</label>
                                <div class="field">
                                    <input readonly onChange="javascript:this.value = this.value.toUpperCase();" type="text" name="correo_corporativo" id="correo_corporativo" size="45" class="validate[custom[email]" />	
                                </div>
                            </div> <!-- .field-group -->

                            <div class="field-group">
                                <label>Telefono:</label>
                                <div class="field">
                                    <input type="text" name="telefono" id="telefono" size="32" class="validate[required]" />	
                                </div>
                            </div> <!-- .field-group -->

                            <div class="field-group">		
                                <label>Gerencia a que Pertenece:</label>
                                <div class="field">
                                    <select name="gerencia" id="gerencia" onchange="espejo_gerencia()">
                                        echo "<option value='  -   -  '>  -   -  </option>";
                                        <?php
                                        _bienvenido_mysql();
                                        $consulta = mysql_query("SELECT ubicacion_laboral FROM usuario_bkp GROUP BY ubicacion_laboral ORDER BY ubicacion_laboral");
                                        while ($registro = mysql_fetch_row($consulta)) {
                                            echo "<option value='" . $registro[0] . "'>" . $registro[0] . ")</option>";
                                        }
                                        echo "</select>";
                                        _adios_mysql();
                                        ?>
                                    </select>			
                                </div>		
                            </div> <!-- .field-group -->

                            <div class="field-group">		
                                <label>Perfil de Usuario:</label>
                                <div class="field">
                                    <select name="perfil" id="perfil">
                                        <?php
                                        _bienvenido_mysql();
                                        $consulta = mysql_query("SELECT id, perfil FROM perfiles");
                                        echo "<option value='0'></option>";
                                        while ($registro = mysql_fetch_row($consulta)) {
                                            echo "<option value='" . $registro[0] . "'>" . $registro[1] . "</option>";
                                        }
                                        echo "</select>";
                                        _adios_mysql();
                                        ?>
                                    </select>
                                    <label>Definicion de Accesos</label>
                                </div>		
                            </div> <!-- .field-group -->
                            <div class="actions" style="text-aling:right">
                                <button name="Submit" type="submit" class="btn btn-error">Agrega Usuario/Empleado</button>
                                <input type="button" name="Atras" onclick="javascript:window.history.back();" class="btn btn-error" value="Regresar" />
                            </div> <!-- .actions -->
                        </div> <!-- .widget-content -->
                    </div> <!-- .widget -->	
                </div><!-- .grid -->	
                <div class="grid-8">
                    <div id="gettingStarted" class="box">
                        <h3>Estimado, <?php echo $usuario_datos[1] . ' ' . $usuario_datos[2]; ?></h3>
                        <p>En esta seccion podra Agregar los usuarios/empleados para el sistema</p>
                    </div>
                </div>
        </div> <!-- .grid -->	
    </form>
    </div><!-- .row -->
    </div> <!-- .container -->
<?php } ?>

<script type="text/javascript">
    window.onload = function () {
        espejo_gerencia();
    }
</script>