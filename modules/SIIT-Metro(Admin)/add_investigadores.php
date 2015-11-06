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

    $cedula = $_POST["CedulaInvest"];
    $sql = "INSERT INTO investigadores_ai(cedula_invest, status) VALUES(" . $cedula . ",0)";
    $result = mysql_query($sql);
    if ($result) {
        notificar('Invertigador registrado con exito', "dashboard.php?data=investigadores", "notify-success");
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
                                <div class="grid-11">
                                    <div class="field-group">
                                        <label style="color:#B22222">Lista de Empleados:</label>
                                        <div class="field">
                                            <select id="CedulaInvest" name="CedulaInvest" class="validate[required]" onchange="javascript:SeleccionarEmpleado($('#CedulaInvest'))">
                                                <?php
                                                $sql = mysql_query("SELECT nombre,apellido,cedula FROM datos_empleado_rrhh WHERE gerencia LIKE '%seguridad integral%' ORDER BY nombre");
                                                ?>
                                                <option value="" selected> *** Seleccionar un Empleado ***</option>
                                                <?php
                                                while ($row = mysql_fetch_array($sql)) {
                                                    ?>
                                                    <option value="<?php echo $row["cedula"]; ?>"><?php echo $row["nombre"] . ' ' . $row['apellido']; ?></option>
                                                <?php }
                                                ?>
                                            </select>		
                                        </div>
                                    </div>
                                    <div class="field-group">
                                        <div class="" style="text-align: center">
                                            <img id="retrato" style=" border: solid 5px #ddd;width: 100px;" src="src/images/FOTOS/No-User.jpg"/>
                                        </div>
                                    </div> <!-- .field-group -->	
                                </div>
                                <div class="grid-11">
                                    <div class="field-group">
                                        <label style="color:#B22222">Nombre y Apellido:</label>
                                        <div class="field">
                                            <span id="NombreInvestigador" ><br></span>			
                                        </div>
                                    </div> <!-- .field-group -->

                                    <div class="field-group">								
                                        <label style="color:#B22222">Cedula:</label>
                                        <div class="field">
                                            <span id="CedulaInvestigador"><br></span>	
                                        </div>
                                    </div> <!-- .field-group -->				 

                                    <div class="field-group">
                                        <label style="color:#B22222">Correo:</label>
                                        <div class="field">
                                            <span id="CorreoInvestigador"> <br></span>	
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
                                </div> <!-- .row-fluid -->
                            </div> <!-- .row-fluid -->
                            <div class="actions" style="text-aling:center">
                                <button name="Submit" type="submit" class="btn btn-error">Agrega Investigador</button>
                                <input type="button" name="Atras" onclick="javascript:window.history.back();" class="btn btn-error" value="Regresar" />
                            </div> <!-- .actions -->
                        </div> <!-- .widget-content -->
                    </div> <!-- .widget -->	
                </div><!-- .grid -->	
                <div class="grid-6">
                    <div id="gettingStarted" class="box">
                        <h3>Estimado, <?php echo $usuario_datos['nombre'] . " " . $usuario_datos['apellido']; ?></h3>
                        <p>En esta seccion podra registrar nuevos Investigadores</p>
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
        var cedula = Selected.val();

        $.ajax({
            url: 'modules/SIIT-Metro(Admin)/DatosInvestigador.php',
            dataType: 'JSON',
            method: 'POST',
            beforeSend: function () {
                document.getElementById("retrato").setAttribute('src', 'src/images/FOTOS/No-User.jpg');
            },
            data: {
                cedula: cedula
            },
            success: function (data) {
                document.getElementById("NombreInvestigador").innerHTML = data.nombre + ' ' + data.apellido;
                document.getElementById("CedulaInvestigador").innerHTML = data.cedula;
                document.getElementById("CorreoInvestigador").innerHTML = data.correo;
                document.getElementById("TelefonoInvestigador").innerHTML = data.telefono_habitacion;
                document.getElementById("PersonalInvestigador").innerHTML = data.celular;
                document.getElementById("retrato").setAttribute('src', 'src/images/FOTOS/' + data.cedula + '.jpg');
            },
        })

    }
</script>