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
    <h2>Agregar Nueva Denuncia</h2>
</div> <!-- #contentHeader -->	
<?php
if (isset($_POST['Submit'])) {

    $cedula = $_POST["CedulaDenuncianteID"];
    $tipo = $_POST["TipoDenuncia"];
    $descrip = $_POST["DescripDenuncia"];
    $sql = "INSERT INTO denuncias_ai(fecha,denunciante,tipo,descripcion) VALUES(NOW()," . $cedula . "," . $tipo . ",'" . $descrip . "')";
    $result = mysql_query($sql);
    if ($result) {
        notificar('Denuncia registrado con exito', "dashboard.php?data=denuncias-ai", "notify-success");
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
            <form class="form uniformForm validateForm" id="from_envio_pe" name="from_envio_pe" method="post" action="" >
                <div class="grid-18">
                    <div class="widget">
                        <div class="widget-content">
                            <div class="row-fluid">
                                <div class="grid-10">
                                    <div class="field-group">
                                        <label style="color:#B22222">Buscar Denunciante:</label>
                                        <div class="field">
                                            <div class="form-inline">
                                                <input id="BuscadorDenunciante" type="text" class="form-control"/>
                                                <input type="button" name="Buscar" onclick="javascript:SeleccionarEmpleado($('#BuscadorDenunciante'));" class="btn btn-error" value="Buscar" />
                                            </div><!-- /input-group -->
                                        </div>
                                    </div>
                                    <div class="field-group">
                                        <div class="" style="text-align: center">
                                            <img id="retrato" style=" border: solid 5px #ddd;width: 100px;" src="src/images/FOTOS/No-User.jpg"/>
                                        </div>
                                    </div> <!-- .field-group -->
                                    <div class="field-group" style="text-align: center">
                                        <label style="color:#B22222">Nombre y Apellido:</label>
                                        <div class="field">
                                            <span id="NombreDenunciante" ><br></span>			
                                        </div>
                                    </div> <!-- .field-group -->

                                    <div class="field-group" style="text-align: center">								
                                        <label style="color:#B22222">Cedula:</label>
                                        <div class="field">
                                            <span id="CedulaDenunciante"><br></span>	
                                        </div>
                                        <input name="CedulaDenuncianteID" id="CedulaDenuncianteID" style="display: non" />
                                    </div> <!-- .field-group -->
                                </div>
                                <div class="grid-8">
                                    <div class="field-group">								
                                        <label style="color:#B22222">Tipo de Denuncia:</label>
                                        <div class="field">
                                            <select id="TipoDenuncia" name="TipoDenuncia" class="validate[required]">
                                                <option selected value="0"> ** Seleccionar un Tipo**</option>
                                                <option value="1">Tipo 1</option>
                                                <option value="2">Tipo 2</option>
                                            </select>
                                        </div>
                                    </div> <!-- .field-group -->
                                    <div class="field-group">								
                                        <label style="color:#B22222">Descripción:</label>
                                        <div class="field">
                                            <textarea id="DescripDenuncia" name="DescripDenuncia" cols="8" rows="8" style="width: 300px" class="validate[required]"></textarea>
                                        </div>
                                    </div> <!-- .field-group -->
                                </div> <!-- .row-fluid -->
                                <div class="grid-18">
                                    <div class="field-group">								
                                        <div class="actions" style="text-aling:left">
                                            <button name="Submit" type="submit" class="btn btn-error">Registrar Denuncia</button>
                                            <input type="button" name="Atras" onclick="javascript:window.history.back();" class="btn btn-error" value="Regresar" />
                                        </div> <!-- .actions -->
                                    </div> <!-- .field-group -->
                                </div> <!-- .row-fluid -->
                            </div> <!-- .row-fluid -->
                        </div> <!-- .widget-content -->
                    </div> <!-- .widget -->	
                </div><!-- .grid -->	
                <div class="grid-6">
                    <div id="gettingStarted" class="box">
                        <h3>Estimado, <?php echo $usuario_datos['nombre'] . " " . $usuario_datos['apellido']; ?></h3>
                        <p>En esta seccion podra registrar nuevas Denuncias</p>
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

    function SeleccionarEmpleado(Selected) {
        var campo = Selected.val();
        if (campo) {
            $.ajax({
                url: 'modules/SIIT-Metro/DatosDenunciante.php',
                dataType: 'JSON',
                method: 'POST',
                beforeSend: function () {
                    document.getElementById("retrato").setAttribute('src', 'src/images/FOTOS/No-User.jpg');
                    document.getElementById("NombreDenunciante").innerHTML = '<br>';
                    document.getElementById("CedulaDenunciante").innerHTML = '<br>';
                    document.getElementById("CedulaDenuncianteID").value = '';
                },
                data: {
                    Campo: campo
                },
                success: function (data) {
                    if (data.campos == 1) {
                        document.getElementById("NombreDenunciante").innerHTML = data.datos[0].nombre + ' ' + data.datos[0].apellido;
                        document.getElementById("CedulaDenunciante").innerHTML = data.datos[0].cedula;
                        document.getElementById("CedulaDenuncianteID").value = data.datos[0].cedula;
                        document.getElementById("retrato").setAttribute('src', 'src/images/FOTOS/' + data.datos[0].cedula + '.jpg');
                    } else {
                        alert('Hay varios resultados!' + data.campos);
                    }
                },
            });
        } else {
            $.alert({
                type: 'alert'
                , title: 'Alerta'
                , text: '<h3>Debe agregar un elemento a la busqueda!</h3>',
            });
        }

    }
</script>