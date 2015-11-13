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

<div id="contentHeader">
    <h2>Lista de Averiguaciones</h2>
</div> <!-- #contentHeader -->	

<div class="container">
    <?php include('notificador.php'); ?>



    <div class="grid-24">	
        <div class="widget widget-plain">

            <div class="widget-content">

                <?php
                _bienvenido_mysql();
                mysql_query("set names utf8");

                $sqlcode = "SELECT "
                        . "a.idAveriguacion,"
                        . "a.codigo_ave,"
                        . "b.codigo,"
                        . "a.fecha,"
                        . "d.nombre,"
                        . "d.apellido,"
                        . "a.status "
                        . "FROM ai_averiguaciones a "
                        . "INNER JOIN ai_denuncias b ON a.denuncia = b.idDenuncia "
                        . "INNER JOIN ai_investigadores c ON a.investigador=c.id_invest "
                        . "INNER JOIN datos_empleado_rrhh d ON c.cedula_invest = d.cedula";
                
                $sql = mysql_query($sqlcode);
                $a = mysql_num_rows($sql);
                ?>

                <div style="margin-left: 400px;" class="dashboard_report first activeState">
                    <div class="pad" align="center">
                        <span class="value"><?php echo $a; ?></span> Total de Averiguaciones
                    </div> <!-- .pad -->
                </div>



            </div> <!-- .widget-content -->

        </div> <!-- .widget -->	
    </div> <!-- .grid -->

    <div class="grid-18">	
        <div class="widget widget-table">
            <div class="widget-header">
                <span class="icon-list"></span>
                <h3 class="icon chart">Registro de Averiguaciones</h3>
            </div>
            <div class="widget-content">
                <table class="table table-bordered table-striped data-table">
                    <thead>
                        <tr>
                            <th style="width:15%">Codigo</th>
                            <th style="width:15%">Denuncia</th>
                            <th style="width:20%">Fecha</th>
                            <th style="width:40%">Investigador</th>
                            <th style="width:10%">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysql_fetch_array($sql)) {
                            ?>
                            <tr class="gradeA">
                                <td><?php echo $row['codigo_ave'] ?></td>
                                <td><?php echo $row['codigo'] ?></td>
                                <td><?php echo $row['fecha'] ?></td>
                                <td><?php echo $row['nombre'].' '.$row['apellido'] ?></td>

                                <td class="center">
                                    <?php
                                    $parametros = 'id=' . $row["id_invest"];
                                    $parametros = _desordenar($parametros);
                                    ?>  
                                    <!--<a href="dashboard.php?data=investigador-ai-info&flag=1&<?php echo $parametros; ?>" id="editar" title="Información" >
                                        <div class="icons-holder" style="float:left;margin-left:15px"><span class="icon-user"></span></div>
                                    </a>
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
            <p>En esta seccion podra visualizar la lista de las Averiguaciones registradas.</p>
        </div>
    </div>

</div> <!-- .container -->
<?php
_adios_mysql();
?>
<script type="text/javascript">
    function eliminar(perfil, param) {
        $.alert({
            type: 'confirm'
            , title: 'Alerta'
            , text: '<h3>¿Desea eliminar el investigador: <u>' + perfil + '</u> ?</h3>'
            , callback: function () {
                window.location = param;
            }
        });
    }
</script>