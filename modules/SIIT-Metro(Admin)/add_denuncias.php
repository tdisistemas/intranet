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
    <h2>Denuncias</h2>
</div> <!-- #contentHeader -->	
<?php
if (isset($_POST['Submit'])) {

    $cedula = $_POST["CedulaDenuncianteID"];
    $tipo = $_POST["TipoDenuncia"];
    $descrip = $_POST["DescripDenuncia"];
    $sql = "INSERT INTO ai_denuncias(fecha,denunciante,tipo,descripcion) VALUES(NOW()," . $cedula . ",'" . $tipo . "','" . $descrip . "')";
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
    $codigoNuevo = 'DEN-' . $cod_completo . '-' . substr(date('Y'), -2);
    $sql = "UPDATE ai_denuncias SET codigo='" . $codigoNuevo . "' WHERE idDenuncia=" . $nuevoID;
    $result2 = mysql_query($sql);

    if ($result) {
        notificar('Denuncia registrada con éxito', "dashboard.php?data=denuncias-ai", "notify-success");
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
                        <div class="widget">
                            <div class="widget-header">
                                <span class="icon-layers"></span>
                                <h3>Agregar Denuncia</h3>
                            </div>
                            <div class="widget-content">
                                <div class="row-fluid">
                                    <div class="grid-12">
                                        <div class="field-group">
                                            <label style="color:#B22222">Buscar Denunciante:</label>
                                            <div class="field">
                                                <div class="form-inline">
                                                    <input id="BuscadorDenunciante" type="text" class="form-control"/>
                                                    <input type="button" name="Buscar" onclick="javascript:SeleccionarEmpleado($('#BuscadorDenunciante'));" class="btn btn-error" value="Buscar" />
                                                </div><!-- /input-group -->
                                            </div>
                                        </div>
                                        <div class="field-group" id="campo-tabla" style="display: none; height: 300px; overflow: scroll">
                                            <i class="fa fa-remove pull-right" title="Cerrar Busqueda" onclick="document.getElementById('campo-tabla').style.display = 'none'" style="color: #B22222; cursor: pointer"></i>
                                            <label style="color:#B22222;" id="lvlBusqueda"></label>
                                            <table class="table table-striped">
                                                <tbody id="BusquedaRes" style="display: block; height: 420px; overflow-y: auto; width: 100%"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="grid-10">

                                        <div class="field-group">
                                            <div class="" style="text-align: center">
                                                <img id="retrato" style=" border: solid 5px #ddd;max-width: 100px;max-height: 100px;" src="src/images/FOTOS/No-User.png"/>
                                            </div>
                                            </br>
                                        </div> <!-- .field-group -->

                                        <div class="field-group">								
                                            <label style="color:#B22222">Cédula:</label>
                                            <div class="field">
                                                <span id="CedulaDenunciante"><br></span>
                                                <input name="CedulaDenuncianteID" id="CedulaDenuncianteID" title="ASD" style="display: none" class="validate[required]" />
                                            </div>
                                        </div> <!-- .field-group -->

                                        <div class="field-group">
                                            <label style="color:#B22222">Nombre y Apellido:</label>
                                            <div class="field">
                                                <span id="NombreDenunciante" ><br></span>			
                                            </div>
                                        </div> <!-- .field-group -->

                                        <div class="field-group">								
                                            <label style="color:#B22222">Tipo de Denuncia:</label>
                                            <div class="field">
                                                <select id="TipoDenuncia" name="TipoDenuncia" class="validate[required]">
                                                    <option selected value=""> ** Seleccionar un Tipo ** </option>
                                                    <option value="Verbal">Verbal</option>
                                                    <option value="Escrita">Escrita</option>
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
                                    <div class="grid-24" style="text-align: center">
                                        <div class="field-group">								
                                            <div class="actions" style="text-aling:left">
                                                <button name="Submit" type="submit" class="btn btn-error">Registrar Denuncia</button>
                                                <input type="button" name="Atras" onclick="javascript:window.history.back();" class="btn btn-error" value="Regresar" />
                                            </div> <!-- .actions -->
                                        </div> <!-- .field-group -->
                                    </div>
                                </div> <!-- .row-fluid -->
                            </div> <!-- .widget-content -->
                        </div> <!-- .widget-content -->
                    </div> <!-- .widget -->	
                </div><!-- .grid -->	
                <div class="grid-6">
                    <div id="gettingStarted" class="box">
                        <h3>Estimado, <?php echo $usuario_datos['nombre'] . " " . $usuario_datos['apellido']; ?></h3>
                        <p>En esta sección podrá registrar nuevas Denuncias.</p>
                        <div class="box plain">
                            <a class="btn btn-primary btn-large dashboard_add" onclick="javascript:window.history.back();">Regresar</a>
                        </div>
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

    function DenuncianteSeleccionado() {
        if (document.getElementById("CedulaDenuncianteID").value == '') {
            $.alert({
                type: 'alert'
                , title: 'Alerta'
                , text: '<h3>Debe seleccionar a un denunciante!</h3>',
            });
            return false;
        } else {
            return true;
        }
    }

    function SeleccionarEmpleado(Selected) {
        var campo = Selected.val();
        if (campo) {
            $.ajax({
                url: 'modules/SIIT-Metro(Admin)/DatosPersonales.php',
                dataType: 'JSON',
                method: 'POST',
                beforeSend: function () {
                    document.getElementById("retrato").setAttribute('src', 'src/images/FOTOS/No-User.png');
                    document.getElementById("NombreDenunciante").innerHTML = '<br>';
                    document.getElementById("CedulaDenunciante").innerHTML = '<br>';
                    document.getElementById("CedulaDenuncianteID").value = '';
                },
                data: {
                    Campo: campo
                },
                success: function (data) {
                    document.getElementById("lvlBusqueda").innerHTML = 'Resultados(' + data.campos + ')';
                    var datos = {
                        nombre: '',
                        cedula: '',
                    };
                    var aux = 0;
                    var lista = '';
                    while (aux < data.campos)
                    {
                        datos.nombre = data.datos[aux].nombre + ' ' + data.datos[aux].apellido;
                        datos.cedula = data.datos[aux].cedula;
                        lista += '<tr>\n\
                                <td style="width: 30%">' + datos.cedula + '</td>\n\
                                <td style="width: 60%">' + datos.nombre + '</td>\n\
                                <td class="center" style="width: 10%">\n\
                                <a title="Seleccionar" >\n\
                                <i style="cursor: pointer; " onclick="javascript:SeleccionarDenunciante(\'' + datos.nombre + '\',\'' + datos.cedula + '\')" class="fa fa-share"></i>\n\
                                </a>\n\
                                </td>\n\
                                </tr>';
                        aux++;
                    }
                    document.getElementById("BusquedaRes").innerHTML = lista;
                    document.getElementById("campo-tabla").style.display = 'initial';
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
    function SeleccionarDenunciante(nombre, cedula) {

        document.getElementById("NombreDenunciante").innerHTML = nombre;
        document.getElementById("CedulaDenunciante").innerHTML = cedula;
        document.getElementById("CedulaDenuncianteID").value = cedula;
        document.getElementById("retrato").setAttribute('src', 'src/images/FOTOS/' + cedula + '.jpg');
    }
</script>