<?php
if (array_pop(explode('/', $_SERVER['PHP_SELF'])) != 'dashboard.php') {
    header("Location: ../../dashboard.php");
}
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
    //notificar("Usted no tiene permisos para esta Seccion/Modulo", "dashboard.php?data=notificar", "notify-error");
    _wm($usuario_datos[9], 'Acceso Denegado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
}
_wm($usuario_datos[9], 'Acceso Autorizado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
?>

<?php
include('notificador.php');
decode_get2($_SERVER["REQUEST_URI"], 2);
$id = _antinyeccionSQL($_GET["np"]);
decode_get2($_SERVER["REQUEST_URI"], 2);
$id_2 = _antinyeccionSQL($_GET["np_2"]);
?>
<div id="contentHeader">
    <h2>Registro de Procesos</h2>
</div> <!-- #contentHeader -->	
<div class="container">
    
    <div class="grid-24">	
        <div class="widget widget-table">
            <div class="widget-header">
                <span class="icon-arrow-left"></span>
                <h3 class="icon chart"><a href="dashboard.php?data=controlg" style="color: white;text-decoration: none;">Regresar</a></h3>	

            </div>
            <div class="widget-content">
                <table class="table table-bordered table-striped data-table">
                    <thead>
                        <tr>
                            <th style="width:10%">N° de Servicio</th>
                            <th style="width:10%">Tipo de Solicitud</th>
                            <th style="width:10%">Monto Estimado de Costos</th>
                            <th style="width:10%">Monto Oferta Comercial</th>
                            <th style="width:10%">Monto Análisis Técnico-Económico</th>
                            <th style="width:10%">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        mysql_query("set names utf8");
                        $sql = mysql_query("SELECT id_cgestion2,tipo_solicitud, n_proceso, servicio, montoec, montooc, montoate FROM gc_control_gestion2 WHERE n_proceso='" . $id . "' || n_proceso='" . $id_2 . "'");
                        $ano = date('y');
                        $actual = (explode("20", $ano));
                        while ($row = mysql_fetch_array($sql)) {
                            ?>
                            <tr class="gradeA">
                                <td><?php echo $row["tipo_solicitud"].'-'.$row["n_proceso"].'-00'.$row["servicio"]. '-'.$actual[0] ?></td>
                                <td><?php echo $row["tipo_solicitud"] ?></td>
                                <td><?php echo $row["montoec"] ?></td>
                                <td><?php echo $row["montooc"] ?></td>
                                <td><?php echo $row["montoate"] ?></td>
                              

                                <td class="center">
                                    <?php
                                    $parametros = 'id=' . $row[1];
                                    $parametros = _desordenar($parametros);
                                    $parametro = 'np=' . $row[0];
                                    $parametro = _desordenar($parametro);
                                    ?>  
                                    <a href="dashboard.php?data=edicion_reg2&flag=1&<?php echo $parametro.'&'. $parametros; ?>" id="editar" title="Editar" >
                                        <div class="icons-holder" style="float:left;margin-left:15px"><span class="icon-pen-alt-fill"></span></div>
                                    </a>
                                </td>
                            </tr>

                        <?php } ?>


                    </tbody>

                </table>
            </div> <!-- .widget-content -->
        </div>
    </div> <!-- .grid -->
</div> <!-- .container -->
<script type="text/javascript">
    function eliminar(perfil, param) {
        $.alert({
            type: 'confirm'
            , title: 'Alerta'
            , text: '<h3>¿Desea eliminar el perfil: <u>' + perfil + '</u> ?</h3>'
            , callback: function () {
                window.location = param;
            }
        });
    }
</script>