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
    <h2>Oficios</h2>
</div> <!-- #contentHeader -->	
<?php
if (isset($_POST['Submit'])) {

    $tipo = $_POST["TipoOficio"];
    $descrip = $_POST["DescripOficio"];
    $victima = $_POST["victima"];
    $sql = "INSERT INTO ai_oficios(fecha,tipo,descripcion,victima) VALUES(NOW(),'$tipo','$descrip',$victima)";

    $bandera = true;
    mysql_query('START TRANSACTION');

    $result = mysql_query($sql);
    $nuevoID = mysql_insert_id();
    if ($result && $nuevoID) {

        $cod_completo = str_pad($nuevoID, 6, "0", STR_PAD_LEFT);
        $codigoNuevo = 'AIM-OFC-' . $cod_completo . '-' . substr(date('Y'), -2);
        $sql = "UPDATE ai_oficios SET codigo='" . $codigoNuevo . "' WHERE idOficio=" . $nuevoID;
        $result2 = mysql_query($sql);

        if (mysql_num_rows($result2) > 0) {
            $bandera = true;
        } else {
            $bandera = true;
        }
    } else {
        $bandera = false;
    }


    if ($bandera) {
        mysql_query('COMMIT');
    } else {
        mysql_query('ROLLBACK');
    }


    if ($bandera) {
        notificar('Oficio registrado con éxito', "dashboard.php?data=oficios-ai", "notify-success");
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
            <form class="form uniformForm validateForm" id="from_envio_pe" name="from_envio_pe" method="post" action="" onsubmit="return VictimaSeleccionado()">
                <div class="grid-18">
                    <div class="widget">
                        <div class="widget">
                            <div class="widget-header">
                                <span class="icon-layers"></span>
                                <h3>Agregar Oficio</h3>
                            </div>
                            <div class="widget-content">
                                <div class="row-fluid">
                                    <div class="grid-24">
                                        <div class="field-group">
                                            <label style="color:#B22222">Buscar Denunciante / Victima :</label>
                                            <div class="field">
                                                <div class="form-inline">
                                                    <input id="BuscadorDenunciante" type="text" class="form-control"/>
                                                    <input type="button" name="Buscar" onclick="javascript:SeleccionarEmpleado($('#BuscadorDenunciante'));" class="btn btn-error" value="Buscar" />
                                                </div><!-- /input-group -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-10" id="campo-tabla" style="display: none">
                                        <div class="field-group">
                                            <i class="fa fa-remove pull-right" title="Cerrar Busqueda" onclick="document.getElementById('campo-tabla').style.display = 'none'" style="color: #B22222; cursor: pointer"></i>
                                            <label style="color:#B22222;" id="lvlBusqueda"></label>
                                            <table class="table table-striped">
                                                <tbody id="BusquedaRes" style="display: block; height: 450px; overflow-y: auto; width: 100%"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="grid-14"  style="margin-bottom: 0px">
                                        <div class="grid-24" style="margin-bottom: 0px">
                                            <label style="color:#B22222"><b>Victima:</b></label><br>
                                            <div class="grid-24" style="margin-bottom: 5px">
                                                <div class="field-group">
                                                    <div class="field" style="margin-bottom: 5px">
                                                        <input class="VictimaCheack" id="empresa" type="checkbox" name="victima" value="200088419" /> Empresa (Metro de Maracaibo).<br>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="grid-24" >
                                                <div class="field-group">
                                                    <div class="field" style="margin-bottom: 5px">
                                                        <input class="VictimaCheack" type="checkbox" name="victima" value="" id="persona" /> Persona:<br>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="grid-24" id="PersonaVic" style="display: none; margin-bottom: 0px">
                                                <div class="grid-8">
                                                    <div class="field-group">
                                                        <div class="" style="text-align: center">
                                                            <img id="retratoVictima" style=" border: solid 5px #ddd;width: 80px;height: 100px;" src="../src/images/FOTOS/No-User.png"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="grid-16">
                                                    <div class="field-group">
                                                        <div class="field">
                                                            <label style="color:#B22222">Cédula:</label>
                                                            <span id="CedulaVictima" style="position: absolute"></span>
                                                            <input name="CedulaVictimaID" id="CedulaVictimaID" style="display: none"/>
                                                        </div>
                                                        <div class="field">
                                                            <label style="color:#B22222">Nombre:</label>
                                                            <span id="NombreVictima" class="Nombres" style=""></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-12">
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
                        </div> <!-- .widget-content -->
                    </div> <!-- .widget -->	
                </div><!-- .grid -->	
                <div class="grid-6">
                    <div id="gettingStarted" class="box">
                        <h3>Estimado, <?php echo $usuario_datos['nombre'] . " " . $usuario_datos['apellido']; ?></h3>
                        <p>En esta sección podrá registrar nuevos Oficios.</p>
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

    $(document).ready(function () {
        $('.VictimaCheack').click(function () {

            $(".VictimaCheack").attr('checked', false);
            $(this).attr('checked', true);
            if ($('#empresa').attr('checked')) {
                $('#PersonaVic').animate({opacity: 0, height: "hide"}, 500);
            } else {
                $('#PersonaVic').animate({opacity: 1, height: "show"}, 500);
            }

            setTimeout(function () {
                $.uniform.update();
            }, 100);
        });

        $("#empresa").trigger('click');
        $("#empresa").attr('checked', true);
        setTimeout(function () {
            $.uniform.update();
        }, 100);
    });

    function SeleccionarEmpleado(Selected) {
        var campo = Selected.val();
        if (campo) {
            $.ajax({
                url: 'modules/SIIT-Metro(Admin)/DatosPersonales.php',
                dataType: 'JSON',
                method: 'POST',
                beforeSend: function () {
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
                                <td rowspan="2" style="width: 20%"><img style=" border: solid 5px #ddd;width: 60px;max-height: 80px;" src="src/images/FOTOS/' + datos.cedula + '.jpg"/></td>\n\
                                    <td style="width: 70%; vertical-align: middle">' + datos.nombre + '</td>\n\
                                <tr>\n\
                                    <td class="center" style="width: 70%;vertical-align: middle; text-align: center">\n\
                                        <button style="font-size: 11px;padding: 4px 12px" title="Victima" class="btn btn-error" type="button" onclick="javascript:Seleccionar(\'' + datos.nombre + '\',\'' + datos.cedula + '\',\'Victima\')">\n\                                             <i style="cursor: pointer;  display: " class="fa fa-user"></i>\n\
                                        Victima</button>\n\
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
    function Seleccionar(nombre, cedula, tipo) {

        if (tipo === 'Victima') {
            $('#persona').val(cedula);
        }

        document.getElementById("Nombre" + tipo).innerHTML = nombre;
        document.getElementById("Cedula" + tipo).innerHTML = cedula;
        document.getElementById("Cedula" + tipo + "ID").value = cedula;
        document.getElementById("retrato" + tipo).setAttribute('src', 'src/images/FOTOS/' + cedula + '.jpg');
    }


    function VictimaSeleccionado() {
        var mensaje = '';
        if ($('#CedulaVictimaID').val() === '' && $('#persona').attr('checked')) {
            mensaje = "Debe seleccionar una Victima!";
            $.alert({
                type: 'alert'
                , title: 'Alerta'
                , text: '<h3>' + mensaje + '</h3>',
            });
            return false;
        } else {
            return true;
        }
    }
</script>