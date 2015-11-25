<?php
if (array_pop(explode('/', $_SERVER['PHP_SELF'])) != 'dashboard.php') {
    header("Location: ../../dashboard.php");
}
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
    notificar("Usted no tiene permisos para esta Seccion/Modulo", "dashboard.php?data=notificar", "notify-error");
    _wm($usuario_datos[9], 'Acceso Denegado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
}
_wm($usuario_datos[9], 'Acceso Autorizado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
_bienvenido_mysql();
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
    <h2>Agregar Nuevo Oficio</h2>
</div> <!-- #contentHeader -->	
<?php
if (isset($_POST['Submit'])) {

    $tipo = $_POST["TipoOficio"];
    $descrip = $_POST["DescripOficio"];
    $sql = "INSERT INTO ai_oficios(fecha,tipo,descripcion) VALUES(NOW(),'" . $tipo . "','" . $descrip . "')";
    $result = mysql_query($sql);
    $nuevoID = mysql_insert_id();
    switch (strlen($nuevoID)) {
        case 1:
            $cod_completo = '00000' . $nuevoID;
            break;
        case 2:
            $cod_completo = '0000' . $nuevoID;
            break;
        case 3:
            $cod_completo = '000' . $nuevoID;
            break;
        case 4:
            $cod_completo = '00' . $nuevoID;
            break;
        case 5:
            $cod_completo = '0' . $nuevoID;
            break;
        case 6:
            $cod_completo = $nuevoID;
            break;
    }
    $codigoNuevo = 'OFC-' . $cod_completo . '-' . substr(date('Y'), -2);
    $sql = "UPDATE ai_oficios SET codigo='" . $codigoNuevo . "' WHERE idOficio=" . $nuevoID;
    $result2 = mysql_query($sql);

    if ($result) {
        notificar('Oficio registrado con exito', "dashboard.php?data=oficios-ai", "notify-success");
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
            <form class="form uniformForm validateForm" id="from_envio_pe" name="from_envio_pe" method="post" action="" onsubmit="return DenuncianteSeleccionado()">
                <div class="grid-18">
                    <div class="widget">
                        <div class="widget-content">
                            <div class="row-fluid">
                                <div class="grid-10">
                                    <div class="field-group">								
                                        <label style="color:#B22222">Tipo de Oficio:</label>
                                        <div class="field">
                                            <select id="TipoDenuncia" name="TipoOficio" class="validate[required]">
                                                <option selected value=""> ** Seleccionar un Tipo ** </option>
                                                <option value="Verbal">Verbal</option>
                                                <option value="Escrito">Escrita</option>
                                            </select>
                                        </div>
                                    </div> <!-- .field-group -->
                                    <div class="field-group">								
                                        <label style="color:#B22222">Descripción:</label>
                                        <div class="field">
                                            <textarea id="DescripDenuncia" name="DescripOficio" cols="8" rows="8" style="width: 300px" class="validate[required]"></textarea>
                                        </div>
                                    </div> <!-- .field-group -->
                                </div> <!-- .row-fluid -->
                                <div class="grid-24" style="text-align: center">
                                    <div class="field-group">								
                                        <div class="actions" style="text-aling:left">
                                            <button name="Submit" type="submit" class="btn btn-error">Registrar Oficio</button>
                                            <input type="button" name="Atras" onclick="javascript:window.history.back();" class="btn btn-error" value="Regresar" />
                                        </div> <!-- .actions -->
                                    </div> <!-- .field-group -->
                                </div>
                            </div> <!-- .row-fluid -->
                        </div> <!-- .widget-content -->
                    </div> <!-- .widget -->	
                </div><!-- .grid -->	
                <div class="grid-6">
                    <div id="gettingStarted" class="box">
                        <h3>Estimado, <?php echo $usuario_datos['nombre'] . " " . $usuario_datos['apellido']; ?></h3>
                        <p>En esta sección podrá registrar nuevos Oficios.</p>
                    </div>
                </div>
        </div> <!-- .grid -->	
    </form>
    </div><!-- .row -->
    </div> <!-- .container -->
    <?php
}
_adios_mysql();
?>

<script type="text/javascript">
    window.onload = function () {
        espejo_gerencia();
    }
</script>