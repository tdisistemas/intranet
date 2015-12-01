<?php
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

    .Tarjeta{
        text-align: center; 
        background-color: #EBEBEB; 
        border-radius: 5px 5px 5px 5px; 
        font-size: 12px; 
        padding: 5px;
        box-shadow: 2px 2px 5px #999;
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
    <h2>Registro de Averiguaciones</h2>
</div> <!-- #contentHeader -->	
<div class="container">
    <?php
    include('notificador.php');
    decode_get2($_SERVER["REQUEST_URI"], 2);
    _bienvenido_mysql();
    ?>
    <div class="grid-24">	
        <div class="widget widget-plain">

            <div class="widget-content">

                <?php
                
                $sqlcode = "SELECT "
                        . "a.idAveriguacion,"
                        . "a.fecha,"
                        . "a.tipo_origen,"
                        . "e.nombre,"
                        . "e.apellido,"
                        . "a.status AS st_ave,"
                        . "b.codigo AS cod_den,"
                        . "c.codigo AS cod_org,"
                        . "a.codigo_ave "
                        . "FROM ai_averiguaciones a "
                        . "LEFT JOIN ai_denuncias b ON a.origen = b.idDenuncia AND a.tipo_origen = 1 "
                        . "LEFT JOIN ai_oficios c ON a.origen = c.idOficio AND a.tipo_origen = 2 "
                        . "INNER JOIN ai_investigadores d ON a.investigador = d.id_invest "
                        . "INNER JOIN datos_empleado_rrhh e ON d.cedula_invest = cedula "
                        //. "WHERE a.investigador = (SELECT id_invest FROM ai_investigadores WHERE cedula_invest = ".$usuario_datos[3].")";
                        . "WHERE a.investigador = (SELECT id_invest FROM ai_investigadores WHERE cedula_invest = 9714161)";

                $sql = mysql_query($sqlcode);
                $a = mysql_num_rows($sql);
                ?>
            </div> <!-- .widget-content -->

        </div> <!-- .widget -->	
    </div> <!-- .grid -->
    <div class="row"> 
        <form class="form uniformForm validateForm" id="from_envio_pe" name="from_envio_pe" method="post" action="dashboard.php?data=asuntoi" >
            <div class="grid-18">
                <div style="" class="grid-9 dashboard_report first activeState">
                    <div class="pad" align="center">
                        <span class="value"><?php echo $a; ?></span> Total de Averiguaciones
                    </div> <!-- .pad -->
                </div>
                <div class="widget widget-table">
                    <div class="widget-header">
                        <span class="icon-list"></span>
                        <h3 class="icon chart">Registro de Averiguaciones</h3>
                    </div>
                    <div class="widget-content">
                        <table class="table table-bordered table-striped data-table">
                            <thead>
                                <tr>
                                    <th style="width:15%">Código</th>
                                    <th style="width:15%">Origen</th>
                                    <th style="width:15%">Fecha</th>
                                    <th style="width:5%">Estatus</th>
                                    <th style="width:40%">Investigador</th>
                                    <th style="width:10%">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = mysql_fetch_array($sql)) {
                                    switch ($row['st_ave']) {
                                        case 0: $st = "check";
                                            $color = "#8B8B8B";
                                            $titulo = "En progreso.";
                                            break;
                                        case 1: $st = "edit";
                                            $color = "#1100CD";
                                            $titulo = "En revisión.";
                                            break;
                                        case 2: $st = "sign-out";
                                            $color = "green";
                                            $titulo = "Remitida.";
                                            Break;
                                        case 3: $st = "lock";
                                            $color = "green";
                                            $titulo = "Finalizada.";
                                            Break;
                                        case 9: $st = "lock";
                                            $color = "red";
                                            $titulo = "Archivada.";
                                            break;
                                    }
                                    ?>
                                <tr class="gradeA">
                                        <td><?php echo $row['codigo_ave'] ?></td>
                                        <td><?php echo $row['tipo_origen'] == '1' ? $row['cod_den'] : $row['cod_org'] ?></td>
                                        <td><?php echo $row['fecha'] ?></td>
                                        <td style="text-align: center"><span><i class="fa fa-<?= $st ?>" title="<?=$titulo?>" style="cursor: pointer; font-size: 15px; color: <?php echo '#8B8B8B'//$color ?>" ></i></span></td>
                                        <td><?php echo $row['nombre'] . ' ' . $row['apellido'] ?></td>

                                        <td class="center">
                                            <?php
                                            $parametros = 'id=' . $row["idAveriguacion"];
                                            $parametros = _desordenar($parametros);
                                            ?>  
                                            <a href="dashboard.php?data=averiguaciones-ai-info&flag=1&<?php echo $parametros; ?>" id="editar" title="Información" >
                                                <i class="fa fa-info-circle" style="color: black; font-size: 15px"></i>
                                            </a><!--
                                            <a href="javascript:eliminar('<?php echo $row['nombre'] . " " . $row['apellido'] ?>','dashboard.php?data=investigador-ai-eliminar&flag=1&<?php echo $parametros; ?>')" id="eliminar-us" title="Eliminar" >
                                                <div class="icons-holder" style="float:left;margin-left:15px"><span class="icon-x-alt"></span></div>
                                            </a>-->
                                        </td>
                                    </tr>									
                                    <?php
                                }
                                ?> 
                            </tbody>
                        </table>
                    </div> <!-- .widget-content -->
                </div>
            </div> <!-- .grid -->	
            <div class="grid-6">
                <div id="gettingStarted" class="box">
                    <h3>Estimado, <?php echo $usuario_datos['nombre'] . " " . $usuario_datos['apellido']; ?></h3>
                    <p>En esta sección podrá acceder al panel de control del módulo Asuntos Internos, así como visualizar la lista de las averiguaciones registradas a su cargo.</p>
                    <div class="box plain">
                        <!--<a href="dashboard.php?data=investigadores" class="btn btn-primary btn-large dashboard_add">Investigadores</a>
                        <a href="dashboard.php?data=denuncias-ai" class="btn btn-primary btn-large dashboard_add">Denuncias</a>
                        <a href="dashboard.php?data=oficios-ai" class="btn btn-primary btn-large dashboard_add">Oficios</a>-->
                        <a class="btn btn-primary btn-large dashboard_add" onclick="javascript:window.history.back();">Regresar</a>
                    </div>
                </div>
            </div>
        </form>
    </div><!-- .row -->
</div><!-- .container-->

<script type="text/javascript">
    window.onload = function () {
        espejo_gerencia();
    }
</script>