<?php
//alerta('Modulo Deshabilitado por codigo');
//ir('dashboard.php');
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
    <h2>Agregar Usuario/Prueba</h2>
</div> <!-- #contentHeader -->	
<?php
if (isset($_POST['Submit'])) {

    $cedula = $_POST["CedulaUser"];
    $nombre = $_POST["NombreUser"];
    $password = md5($_POST["ClaveUser"] . $cedula);
    $correo_principal = $_POST["CorreoUser"];

    _bienvenido_mysql();





    $sql = "INSERT INTO Prueba_User(Nombre, Cedula, Correo, Clave) VALUES('" . $nombre . "','" . $cedula . "','" . $correo_principal . "','" . $password . "')";
    $result = mysql_query($sql);
    if ($result) {
        notificar("Usuario ingresado con exito", "dashboard.php?data=prueba", "notify-success");
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
                                <label>Nombre y Apellido:</label>
                                <div class="field">
                                    <input onChange="javascript:this.value = this.value.toUpperCase();" type="text" name="NombreUser" id="NombreUser" size="32" class="validate[required]" />			
                                </div>
                            </div> <!-- .field-group -->
                            
                            <div class="field-group">								
                                <label>Cedula:</label>
                                <div class="field">
                                    <input type="text" name="CedulaUser" id="CedulaUser" size="32" class="validate[required],maxSize[9]" />	
                                </div>
                            </div> <!-- .field-group -->				 
                            
                            <div class="field-group">
                                <label>Correo:</label>
                                <div class="field">
                                    <input onChange="javascript:this.value = this.value.toUpperCase();" type="text" name="CorreoUser" id="CorreoUser" size="32" class="validate[required,custom[email]]" />	
                                </div>
                            </div> <!-- .field-group -->

                            <div class="field-group">
                                <label>Contraseña:</label>
                                <div class="field">
                                    <input type="password" name="ClaveUser" id="ClaveUser" size="32" class="validate[required,minSize[8]]" value="" />	
                                </div>
                            </div> <!-- .field-group -->

                            <div class="actions" style="text-aling:right">
                                <button name="Submit" type="submit" class="btn btn-error">Agrega Usuario</button>
                                <input type="button" name="Atras" onclick="javascript:window.history.back();" class="btn btn-error" value="Regresar" />
                            </div> <!-- .actions -->
                        </div> <!-- .widget-content -->
                    </div> <!-- .widget -->	
                </div><!-- .grid -->	
                <div class="grid-8">
                    <div id="gettingStarted" class="box">
                        <h3>Estimado, <?php echo $usuario_datos[1] . ' ' . $usuario_datos[2]; ?></h3>
                        <p>En esta seccion podra Agregar los Usuarios/Prueba para el sistema</p>
                    </div>
                </div>
        </div> <!-- .grid -->	
    </form>
    </div><!-- .row -->
    </div> <!-- .container -->
<?php } ?>

<script type="text/javascript">
    window.onload = function() {
        espejo_gerencia();
    }
</script>