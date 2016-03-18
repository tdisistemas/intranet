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

                        decode_get2($_SERVER["REQUEST_URI"], 2);
                        $id_np = _antinyeccionSQL($_GET["np"]);
                        decode_get2($_SERVER["REQUEST_URI"], 2);
                        $id_servi = _antinyeccionSQL($_GET["servi"]);
?>

<div id="contentHeader">
    <h2>Servicios del Proceso</h2>
</div> <!-- #contentHeader -->	
<div class="container">
    <?php include('notificador.php'); ?>
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
                        $sql = mysql_query("SELECT id_cgestion2,n_proceso, servicio, tipo_solicitud, montoec, montooc, montoate FROM gc_control_gestion2 WHERE n_proceso='" . $id_np . "' || servicio='" . $id_servi . "'");
                        $ano = date('y');
                        $actual = (explode("20", $ano));
                        
                        while ($row = mysql_fetch_array($sql)) {
                            $final= $row["tipo_solicitud"] [2] =='' ? '' : $row["tipo_solicitud"] [2].'.'; ?>
                            <tr class="gradeA">
                                <td><?php echo $row["tipo_solicitud"].'-'.$row["n_proceso"].'-00'.$row["servicio"]. '-'.$actual[0] ?></td>
                                <td><?php echo $row["tipo_solicitud"] [0]. '.'. $row["tipo_solicitud"] [1].'.'.$final?></td>
                                <td><?php echo number_format($row['montoec'], 2, ',', '.');?> Bsf</td>
                                <td><?php echo number_format($row['montooc'], 2, ',', '.');?> Bsf</td>
                                <td><?php echo number_format($row['montoate'], 2, ',', '.');?> Bsf</td>
                              

                                <td class="center">
                                    <?php
                                    $parametros = 'id=' . $row['id_cgestion2'];
                                    $parametros .= '&np=' . $row['n_proceso'];
                                    $parametros = _desordenar($parametros);
                                  
                                   
                                    ?>  
                                    <?php 
                                    if ($row['tipo_solicitud'] == 'EC'){
                                        
                                    ?>
                                    <a href="dashboard.php?data=edicion_reg2&flag=1&<?php echo $parametros?>" id="editar" title="Editar" >
                                        <div class="icons-holder" style="float:left;margin-left:15px"><span class="icon-pen-alt-fill"></span></div>
                                    </a>
                                    <?php }?>
                                     
                                     <?php 
                                    if ($row['tipo_solicitud'] == 'ATE'){
                                      
                                    ?>
                                    <a href="dashboard.php?data=edicion_reg3&flag=1&<?php echo $parametros?>" id="editar" title="Editar" >
                                        <div class="icons-holder" style="float:left;margin-left:15px"><span class="icon-pen-alt-fill"></span></div>
                                    </a>
                                    <?php }?>
                                    
                                    <?php 
                                    if ($row['tipo_solicitud'] == 'AP'){
                                      
                                    ?>
                                    <a href="dashboard.php?data=edicion_reg5&flag=1&<?php echo $parametros?>" id="editar" title="Editar" >
                                        <div class="icons-holder" style="float:left;margin-left:15px"><span class="icon-pen-alt-fill"></span></div>
                                    </a>
                                    <?php }?>
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
