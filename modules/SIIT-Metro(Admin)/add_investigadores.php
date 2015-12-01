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
    <h2>Agregar Investigador</h2>
</div> <!-- #contentHeader -->	
<?php
if (isset($_POST['Submit'])) {

    $cedula = $_POST["CedulaInvestigadorID"];
    $sql = "INSERT INTO ai_investigadores(cedula_invest, status) VALUES(" . $cedula . ",0)";
    $result = mysql_query($sql);
    if ($result) {
        notificar('Invertigador registrado con éxito', "dashboard.php?data=investigadores", "notify-success");
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
            <form class="form uniformForm validateForm" id="from_envio_pe" name="from_envio_pe" method="post" action="" onsubmit="return Seleccionado()">
                <div class="grid-18">
                    <div class="widget">
                        <div class="widget-content">
                            <div class="row-fluid">
                                <div class="grid-12">
                                    <div class="field-group">
                                        <label style="color:#B22222">Buscar Investigador:</label>
                                        <div class="field">
                                            <div class="form-inline">
                                                <input id="Buscadorinvestigador" type="text" class="form-control"/>
                                                <input type="button" name="Buscar" onclick="javascript:SeleccionarInvestigador($('#Buscadorinvestigador'));" class="btn btn-error" value="Buscar" />
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
                                <div class="grid-12">
                                    <div class="field-group">
                                        <div class="" style="text-align: center">
                                            <img id="retrato" style=" border: solid 5px #ddd;width: 100px;" src="src/images/FOTOS/No-User.jpg"/>
                                        </div>
                                        </br>
                                    </div> <!-- .field-group -->
                                    <div class="field-group">
                                        <label style="color:#B22222">Nombre y Apellido:</label>
                                        <div class="field">
                                            <span id="NombreInvestigador" ><br></span>			
                                        </div>
                                    </div> <!-- .field-group -->

                                    <div class="field-group">								
                                        <label style="color:#B22222">Cédula:</label>
                                        <div class="field">
                                            <span id="CedulaInvestigador"><br></span>	
                                            <input id="CedulaInvestigadorID" name="CedulaInvestigadorID" style="display: none" value=""/>	
                                        </div>
                                    </div> <!-- .field-group -->				 

                                    <div class="field-group">
                                        <label style="color:#B22222">Correo:</label>
                                        <div class="field">
                                            <span id="CorreoInvestigador"> <br></span>	
                                        </div>
                                    </div> <!-- .field-group -->
                                    
                                    <div class="field-group">
                                        <label style="color:#B22222">Correo Institucional:</label>
                                        <div class="field">
                                            <span id="CorreoInst"> <br></span>	
                                        </div>
                                    </div> <!-- .field-group -->

                                    <div class="field-group">
                                        <label style="color:#B22222">Teléfono:</label>
                                        <div class="field">
                                            <span id="TelefonoInvestigador"> <br></span>	
                                        </div>
                                    </div> <!-- .field-group -->

                                    <div class="field-group">
                                        <label style="color:#B22222">Teléfono Personal:</label>
                                        <div class="field">
                                            <span id="PersonalInvestigador"> <br></span>	
                                        </div>
                                    </div> <!-- .field-group -->
                                    <div class="actions" style="text-aling:center">
                                        <button name="Submit" type="submit" class="btn btn-error">Agrega Investigador</button>
                                        <input type="button" name="Atras" onclick="javascript:window.history.back();" class="btn btn-error" value="Regresar" />
                                    </div> <!-- .actions -->
                                </div> <!-- .row-fluid -->
                            </div> <!-- .row-fluid -->
                        </div> <!-- .widget-content -->
                    </div> <!-- .widget -->	
                </div><!-- .grid -->	
                <div class="grid-6">
                    <div id="gettingStarted" class="box">
                        <h3>Estimado, <?php echo $usuario_datos['nombre'] . " " . $usuario_datos['apellido']; ?></h3>
                        <p>En esta sección podrá registrar nuevos Investigadores</p>
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

    function Seleccionado() {
        if (document.getElementById("CedulaInvestigadorID").value == '') {
            $.alert({
                type: 'alert'
                , title: 'Alerta'
                , text: '<h3>Debe seleccionar a un investigador!</h3>',
            });
            return false;
        } else {
            return true;
        }
    }

    function SeleccionarInvestigador(Selected) {
        var campo = Selected.val();
        if (campo) {
            $.ajax({
                url: 'modules/SIIT-Metro(Admin)/DatosInvestigador.php',
                dataType: 'JSON',
                method: 'POST',
                beforeSend: function () {
                    document.getElementById("retrato").setAttribute('src', 'src/images/FOTOS/No-User.jpg');
                    document.getElementById("NombreInvestigador").innerHTML = '<br>';
                    document.getElementById("CedulaInvestigador").innerHTML = '<br>';
                    document.getElementById("CorreoInvestigador").innerHTML = '<br>';
                    document.getElementById("CorreoInst").innerHTML = '<br>';
                    document.getElementById("TelefonoInvestigador").innerHTML = '<br>';
                    document.getElementById("PersonalInvestigador").innerHTML = '<br>';
                    document.getElementById("CedulaInvestigadorID").value = '';
                },
                data: {
                    acc: 'Buscar',
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
                        datos.correo = data.datos[aux].correo;
                        datos.usuario = data.datos[aux].usuario;
                        datos.telefono = data.datos[aux].telefono_habitacion;
                        datos.celular = data.datos[aux].celular;
                        lista += '<tr>\n\
                                <td style="width: 30%">' + datos.cedula + '</td>\n\
                                <td style="width: 60%">' + datos.nombre + '</td>\n\
                                <td class="center" style="width: 10%">\n\
                                <a title="Seleccionar" >\n\
                                <i style="cursor: pointer; " onclick="javascript:InvestigadorSeleccionado(\'' + datos.nombre + '\',\'' + datos.cedula + '\',\'' + datos.correo + '\',\'' + datos.usuario + '\',\'' + datos.telefono + '\',\'' + datos.celular + '\')" class="fa fa-share"></i>\n\
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
    function InvestigadorSeleccionado(nombre, cedula, correo, usuario, telefono, celular) {
        $.ajax({
            url: 'modules/SIIT-Metro(Admin)/DatosInvestigador.php',
            dataType: 'JSON',
            method: 'POST',
            data: {
                acc: 'Verificar',
                Campo: cedula
            },
            success: function (data) {
                if (data == '1') {
                    document.getElementById("NombreInvestigador").innerHTML = nombre;
                    document.getElementById("CedulaInvestigador").innerHTML = cedula;
                    document.getElementById("CorreoInvestigador").innerHTML = correo;
                    document.getElementById("CorreoInst").innerHTML = usuario + '@metrodemaracaibo.gob.ve'
                    document.getElementById("TelefonoInvestigador").innerHTML = telefono;
                    document.getElementById("PersonalInvestigador").innerHTML = celular;
                    document.getElementById("CedulaInvestigadorID").value = cedula;
                    document.getElementById("retrato").setAttribute('src', 'src/images/FOTOS/' + cedula + '.jpg');
                } else {
                    $.alert({
                        type: 'alert'
                        , title: 'Alerta'
                        , text: '<h3>El investigador <u>'+nombre+'</u> ya esta registrado!</h3>',
                    });
                }
            },
        });
    }
</script>