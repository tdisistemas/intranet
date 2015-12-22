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

<div id="contentHeader">
    <h2>Registro de Procesos</h2>
    
</div> <!-- #contentHeader -->	

<div class="container">
<?php include('notificador.php'); ?>



    <div class="grid-24">	
        <div class="widget widget-table">
            <div class="widget-header">
                <span class="icon-list"></span>
                <h3 class="icon chart">Registro de Procesos con Punto de Cuenta</h3>		
               
                	
            </div>
            <div class="widget-content">
                <table class="table table-bordered table-striped data-table">
                    <thead>
                        <tr>
                            <th style="width:20%">Punto de Cuenta</th>
                            <th style="width:20%">N° de Proceso</th>
                            <th style="width:25%">N° de Servicio</th>
                            <th style="width:25%">Nombre de la Obra/Actividad
                            <th style="width:5%">Estatus</th>
                            <th style="width:5%">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        mysql_query("set names utf8");
                        
                       
                        
                        $sql = mysql_query("SELECT  gc_control_gestion2.id_cgestion2,gc_control_gestion2.punto_cuenta,gc_control_gestion2.estatus2,gc_control_gestion.n_proceso_completo, gc_control_gestion.obra,gc_control_gestion2.id_cgestion2,gc_control_gestion2.n_proceso, gc_control_gestion2.servicio, gc_control_gestion2.tipo_solicitud FROM gc_control_gestion,gc_control_gestion2 WHERE "
                                . "gc_control_gestion2.n_proceso=gc_control_gestion.n_proceso and validacion_pdc=1");
                        $ano = date('y');
                        $actual = (explode("20", $ano));
                         
                        while ($row = mysql_fetch_array($sql)) {
                            switch ($row["estatus2"]) {
                                            case 1: $st = "pencil-square-o";
                                                $color = "#8B8B8B";
                                                $titulo = "Revisión.";
                                                break;
                                           
                                            case 2: $st = "reply";
                                                $color = "#8B8B8B";
                                                $titulo = "Devuelto.";
                                                break;
                                            case 3: $st = "check";
                                                $color = "#8B8B8B";
                                                $titulo = "Entregado.";
                                                break;
                                            
                                        }
                            ?>
                            <tr class="gradeA">
                                <td><?php echo 'PDC-'.'00'.$row["punto_cuenta"]. '-'.$actual[0] ?></td>
                                <td><?php echo $row["n_proceso_completo"] ?></td>
                                <td><?php echo $row["tipo_solicitud"].'-'.$row["n_proceso"].'-00'.$row["servicio"]. '-'.$actual[0] ?></td>
                                <td><?php echo $row["obra"] ?></td>
                                <td style="text-align:center"><span><i class="fa fa-<?= $st ?>" title="<?= $titulo ?>" style="cursor: pointer; font-size: 15px; color: <?php echo $color ?>" ></i></span></td>
                               
                        

                                <td class="center">
                                     <?php
                                    $parametros = 'id=' . $row[1];
                                    $parametros = _desordenar($parametros);
                                    $parametro = 'np=' . $row[0];
                                    $parametro = _desordenar($parametro);
                                    ?>  
                                    <a href="dashboard.php?data=edicion_reg4&flag=1&<?php echo $parametro.'&'. $parametros; ?>" id="editar" title="Editar" >
                                        <div class="icons-holder" style="float:left;margin-left:15px"><span class="icon-pen-alt-fill"></span></div>
                                    </a>
    <!--<a href="javascript:eliminar('<?php echo $row["Nombre"] ?>','dashboard.php?data=pruebadelete&flag=1&<?php echo $parametros; ?>')" id="eliminar-us" title="Eliminar" >
       <div class="icons-holder" style="float:left;margin-left:15px"><span class="icon-x-alt"></span></div>
    </a>-->
                                </td>
                            </tr>									
                                <?php } ?>
                               

                    </tbody>
                </table>
                
            </div> <!-- .widget-content -->
            
        </div>
        
    </div> <!-- .grid -->
   
                                </td>
                            </tr>



                    </tbody>

                </table>
            </div> <!-- .widget-content -->
        </div>
    </div> <!-- .grid -->
</div> <!-- .container -->

</div> <!-- .container -->

