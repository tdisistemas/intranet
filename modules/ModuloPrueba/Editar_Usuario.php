<?php
if (array_pop(explode('/', $_SERVER['PHP_SELF'])) != 'dashboard.php') {
    header("Location: ../../dashboard.php");
}
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
    notificar("Usted no tiene permisos para esta Sección/Módulo", "dashboard.php?data=notificar", "notify-error");
    _wm($usuario_datos[9], 'Acceso Denegado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
}
_wm($usuario_datos[9], 'Acceso Autorizado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
?>

<div id="contentHeader">

    <?php //decode_get2($_SERVER["REQUEST_URI"],1);  ?>

    <h2>Modificar Usuario <?= $_GET["Nombre"]; ?></h2>
</div> <!-- #contentHeader -->	

<?php
if (isset($_POST['Submit'])) {

    $id = $_POST["idUser"];
    $nombre = $_POST["NombreUser"];
    $cedula = $_POST["CedulaUser"];
    $correo = $_POST["CorreoUser"];

    _bienvenido_mysql();

    $result = mysql_query("UPDATE Prueba_User SET Nombre='" . $nombre . "', Cedula='" . $cedula . "', Correo='" . $correo . "' WHERE idUser = " . $id) or die(mysql_error());

    if ($result) {
        notificar("Usuario editado con éxito", "dashboard.php?data=prueba", "notify-success");
    } else {
        die(mysql_error());
        echo $noticia;
    }
} else {
    decode_get2($_SERVER["REQUEST_URI"], 2);
    $id = _antinyeccionSQL($_GET["id"]);
    _bienvenido_mysql();
    $result = mysql_query("SELECT * FROM Prueba_User WHERE idUser = " . $id);
    $reg = mysql_fetch_array($result);

    $num_rows = mysql_num_rows($result);

    if ($num_rows == 1) {
        $nombre = $reg[1];
        $cedula = $reg[2];
        $correo = $reg[3];
    } else {
        notificar("No Existen Registros", "dashboard.php?data=prueba", "notify-error");
    }
}
?>

<div class="container">
    <div class="grid-24">
        <div class="widget">
            <div class="widget-content">

                <form class="form uniformForm validateForm" name="from_envio_mi" method="post" action="#" >

                    <div class="field-group">
                        <label for="NombreUser">Nombre y Apellido:</label>
                        <div class="field">
                            <input type="text" onChange="javascript:this.value = this.value.toUpperCase();" name="NombreUser" id="NombreUser" size="32" class="validate[required]" value="<?php echo $nombre; ?>" autofocus />	
                        </div>
                    </div> <!-- .field-group -->

                    <div class="field-group">
                        <label for="CedulaUser">Cedula:</label>
                        <div class="field">
                            <input type="text" name="CedulaUser" id="CedulaUser" size="32" class="validate[required],maxSize[9]" value="<?php echo $cedula; ?>" />
                        </div>
                    </div> <!-- .field-group -->

                    <div class="field-group">
                        <label for="CorreoUser">Correo:</label>
                        <div class="field">
                            <input id="CorreoUser" class="validate[required,custom[email]]" name="CorreoUser" size="32" class="" onChange="javascript:this.value = this.value.toUpperCase();" value="<?php echo $correo; ?>">
                        </div>
                    </div> <!-- .field-group -->

                    <input type="hidden" name="idUser" value="<?php echo $id; ?>" />

                    <div class="actions" style="text-aling:right">
                        <button name="Submit" type="submit" class="btn btn-error">Modificar Registro</button>
                        <input type="button" name="Atras" onclick="javascript:window.history.back();" class="btn btn-error" value="Regresar" />
                    </div> <!-- .actions -->
                </form>


            </div> <!-- .widget-content -->

        </div> <!-- .widget -->	
    </div>
</div> <!-- .container -->

