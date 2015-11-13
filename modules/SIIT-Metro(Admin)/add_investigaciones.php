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
    ir('dashboard.php?data=denuncia-ai-info');
}
_bienvenido_mysql();
if (isset($_POST['Submit'])) {
    $cedula = $_POST['CedulaID'];
    $Causa = $_POST['Causa'];
    $ubicacion_laboral = $_POST['ubicacion_laboral'];
    $investigador = $_POST['investigador'];
    $idDenuncia = $_POST['idDenuncia'];
    $remitidoS = $_POST['remitido'];

    $sql = "INSERT INTO ai_averiguaciones(denuncia,fecha,involucrado,causa,sitio_suceso,investigador,remitido) VALUES(" . $idDenuncia . ",NOW()," . $cedula . ",'" . $Causa . "','" . $ubicacion_laboral . "'," . $investigador . ",".$remitidoS.")";
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
    $codigoNuevo = 'AIM-' . $cod_completo . '-' . substr(date('Y'), -2);
    $sqlUp = "UPDATE ai_averiguaciones SET codigo_ave ='" . $codigoNuevo . "' WHERE idAveriguacion=" . $nuevoID;
    $result2 = mysql_query($sqlUp);

    $sqlUpDen = "UPDATE ai_denuncias SET status = 1 WHERE idDenuncia=" . $idDenuncia;
    $result3 = mysql_query($sqlUpDen);

    if ($result) {
        notificar('Averiguación creada con exito!', "dashboard.php?data=admin_ai", "notify-success");
    } else {
        if ($SQL_debug == '1') {
            die('Error en Agregar Registro - 02 - Respuesta del Motor: ' . mysql_error());
        } else {
            die('Error en Agregar Registro');
        }
    }
} else {
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
        <h2>Apertura de Averiguación</h2>
    </div> <!-- #contentHeader -->	
    <?php
    decode_get2($_SERVER["REQUEST_URI"], 2);
    $id = _antinyeccionSQL($_GET['id']);

    $sqlquery = "SELECT "
            . "d.codigo,"
            . "d.descripcion "
            . "FROM ai_denuncias d "
            . "INNER JOIN datos_empleado_rrhh e "
            . "WHERE d.denunciante = e.cedula "
            . "AND d.idDenuncia=" . $id;

    $sql = mysql_query($sqlquery);
    $respuesta = mysql_fetch_array($sql);

    $ubicacionQuery = "SELECT "
            . "ubicacion_laboral "
            . "FROM datos_empleado_rrhh "
            . "WHERE 1 "
            . "GROUP BY ubicacion_laboral";

    $UL = mysql_query($ubicacionQuery);

    $investigadoresQuery = "SELECT "
            . "i.id_invest,"
            . "d.nombre,"
            . "d.apellido "
            . "FROM ai_investigadores i "
            . "INNER JOIN datos_empleado_rrhh d "
            . "WHERE i.cedula_invest = d.cedula "
            . "AND i.status = 0";

    $Invest = mysql_query($investigadoresQuery);

    $remitidosQuery = "SELECT "
            . "id_inst,"
            . "Nombre,"
            . "Iniciales "
            . "FROM cuerpos_seguridad "
            . "WHERE 1";

    $Remit = mysql_query($remitidosQuery);
    
    $codigo = $respuesta['codigo'];
    $descripcion = $respuesta['descripcion'];
    ?>
    <div class="container">
        <div class="row"> 
            <form class="form uniformForm validateForm" id="from_envio_pe" name="from_envio_pe" method="post" action="" onsubmit="return Seleccionado()">
                <div class="grid-18">
                    <div class="widget">
                        <div class="widget-header">
                            <span class="icon-layers"></span>
                            <h3>Denuncia # <?php echo $codigo; ?></h3>
                        </div>
                        <div class="widget-content">
                            <div class="row">

                                <div class="grid-10">

                                    <div class="field-group">
                                        <div class="" style="text-align: center">
                                            <img id="retrato" style=" border: solid 5px #ddd;width: 100px;" src="src/images/FOTOS/No-User.jpg"/>
                                        </div>
                                        </br>
                                    </div> <!-- .field-group -->
                                    <div class="field-group">
                                        <label style="color:#B22222">Nombre y Apellido:</label>
                                        <div class="field">
                                            <span id="Nombre" ><br></span>			
                                        </div>
                                    </div> <!-- .field-group -->

                                    <div class="field-group">								
                                        <label style="color:#B22222">Cedula:</label>
                                        <div class="field">
                                            <span id="Cedula"><br></span>
                                            <input name="CedulaID" id="CedulaID" title="ASD" style="display: none" class="validate[required]" />
                                        </div>
                                    </div> <!-- .field-group -->

                                    <div class="field-group">
                                        <label style="color:#B22222">Codigo de la Denuncia:</label>
                                        <div class="field">
                                            <span><b><?php echo $codigo; ?></b></span>	
                                            <input name="idDenuncia" id="idDenuncia" value="<?php echo $id; ?>" style="display: none"/>	
                                        </div>
                                    </div> <!-- .field-group -->

                                    <div class="field-group">								
                                        <label style="color:#B22222">Descripción de la Denuncia:</label>
                                        <div class="field">
                                            <span> "<i><?= $descripcion ?></i>"</span>
                                        </div>
                                    </div> <!-- .field-group -->

                                    <div class="field-group">								
                                        <label style="color:#B22222">Causa:</label>
                                        <div class="field">
                                            <textarea id="Causa" name="Causa" cols="8" rows="8" style="width: 300px" class="validate[required]"></textarea>
                                        </div>
                                    </div> <!-- .field-group -->

                                </div> <!-- .row-fluid -->
                                <div class="grid-12">
                                    <div class="field-group">
                                        <label style="color:#B22222">Buscar Autor(es):</label>
                                        <div class="field">
                                            <div class="form-inline">
                                                <input id="Buscador" type="text" class="form-control"/>
                                                <input type="button" name="Buscar" onclick="javascript:SeleccionarEmpleado($('#Buscador'));" class="btn btn-error" value="Buscar" />
                                            </div><!-- /input-group -->
                                        </div>
                                    </div>
                                    <div class="field-group" id="campo-tabla" style="display: none; height: 300px; overflow: scroll">
                                        <label style="color:#B22222;" id="lvlBusqueda"></label>
                                        <table class="table table-striped">
                                            <tbody id="BusquedaRes" style="display: block; height: 350px; overflow-y: auto; width: 100%"></tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="grid-1">
                                </div>
                                <div class="grid-20">
                                    <div class="grid-10">

                                        <div class="field-group">
                                            <label style="color:#B22222">Sitio del Suceso:</label>
                                            <div class="field">
                                                <select id="ubicacion_laboral" name="ubicacion_laboral" class="validate[required]">
                                                    <option selected value=""> *** Seleccionar *** </option>
                                                    <?php
                                                    while ($respuesta = mysql_fetch_array($UL)) {
                                                        $cadena = explode('-', $respuesta['ubicacion_laboral']);
                                                        if ($cadena[0] != '') {
                                                            ?>
                                                            <option value="<?= $cadena[0] ?>"> <?= $cadena[0] ?> </option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div> <!-- .field-group -->
                                        <div class="field-group">
                                            <label style="color:#B22222">Investigador a cargo:</label>
                                            <div class="field">
                                                <select id="investigador" name="investigador" class="validate[required]">
                                                    <option selected value=""> *** Seleccionar *** </option>
                                                    <?php
                                                    while ($respuesta = mysql_fetch_array($Invest)) {
                                                        ?>
                                                        <option value="<?= $respuesta['id_invest'] ?>"> <?= $respuesta['nombre'] . ' ' . $respuesta['apellido'] ?> </option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div> <!-- .field-group -->
                                        <div class="field-group">
                                            <label style="color:#B22222">Remitido a:</label>
                                            <div class="field">
                                                <select id="remitido" name="remitido" class="">
                                                    <option selected value="0"> No remitido. </option>
                                                    <?php
                                                    while ($remitido = mysql_fetch_array($Remit)) {
                                                        ?>
                                                        <option value="<?= $remitido['id_inst'] ?>"> <?= $remitido['Iniciales'] ?> </option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div> <!-- .field-group -->
                                    </div><!-- .grid -->
                                </div><!-- .grid -->
                                <div class="grid-24" style="text-align: center">
                                    <div class="field-group">								
                                        <div class="actions">
                                            <button name="Submit" type="submit" class="btn btn-error">Registrar Investigación</button>
                                            <input type="button" name="Atras" onclick="javascript:window.history.back();" class="btn btn-error" value="Cancelar" />
                                        </div> <!-- .actions -->
                                    </div> <!-- .field-group -->
                                </div>
                            </div><!-- .grid -->
                        </div><!-- .grid -->
                    </div><!-- .grid -->	
                </div><!-- .grid -->	
                <div class="grid-6">
                    <div id="gettingStarted" class="box">
                        <h3>Estimado, <?php echo $usuario_datos['nombre'] . " " . $usuario_datos['apellido']; ?></h3>
                        <p>En esta seccion podra iniciar Investigaciones nuevas.</p>
                    </div>
                </div>
            </form>
        </div><!-- .row -->
    </div><!-- .container-->
    <?php
}
_adios_mysql();
?>
<script type="text/javascript">
    window.onload = function () {
        espejo_gerencia();
    }


    function Seleccionado() {
        if (document.getElementById("CedulaID").value == '') {
            $.alert({
                type: 'alert'
                , title: 'Alerta'
                , text: '<h3>Debe seleccionar a un involucrado!</h3>',
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
                    document.getElementById("retrato").setAttribute('src', 'src/images/FOTOS/No-User.jpg');
                    document.getElementById("Nombre").innerHTML = '<br>';
                    document.getElementById("Cedula").innerHTML = '<br>';
                    document.getElementById("CedulaID").value = '';
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
                                <td class="center" style="width: 10%">\n\
                                <a title="Seleccionar" >\n\
                                <i style="cursor: pointer; " onclick="javascript:Seleccionar(\'' + datos.nombre + '\',\'' + datos.cedula + '\')" class="fa fa-reply"></i>\n\
                                </a>\n\
                                </td>\n\
                                <td style="width: 30%">' + datos.cedula + '</td>\n\
                                <td style="width: 60%">' + datos.nombre + '</td>\n\
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
    function Seleccionar(nombre, cedula) {

        document.getElementById("Nombre").innerHTML = nombre;
        document.getElementById("Cedula").innerHTML = cedula;
        document.getElementById("CedulaID").value = cedula;
        document.getElementById("retrato").setAttribute('src', 'src/images/FOTOS/' + cedula + '.jpg');
    }

</script>