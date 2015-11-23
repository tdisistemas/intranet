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
    <h2>Registro de Procesos</h2>
</div> <!-- #contentHeader -->	

<div class="container">
<?php include('notificador.php'); ?>



    <div class="grid-24">	
        <div class="widget widget-table">
            <div class="widget-header">
                <span class="icon-list"></span>
                <h3 class="icon chart">Registro de Procesos</h3>		
                <span class="icon-folder-fill"></span>
                <h3 class="icon chart"><a href="dashboard.php?data=insertar_cl1" style="color: white;text-decoration: none;">Agregar Procesos</a></h3>		
            </div>
            <div class="widget-content">
                <table class="table table-bordered table-striped data-table">
                    <thead>
                        <tr>
                            <th style="width:10%">N° de Proceso</th>
                            <th style="width:10%">Fecha de Ingreso</th>
                            <th style="width:20%">Gerencia Requiriente</th>
                            <th style="width:20%">Responsable</th>
                            <th style="width:10%">Nombre de la Obra/Actividad</th>
                            <th style="width:15%">Estatus del Tramite</th>
                            <th style="width:15%">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        mysql_query("set names utf8");
                        $sql = mysql_query("SELECT * FROM gc_control_gestion");
                        $ano = date('y');
                        $actual = (explode("20", $ano));
                        while ($row = mysql_fetch_array($sql)) {
                            ?>
                            <tr class="gradeA">
                                <td><?php echo 'GC-' . $row[2] . '-' . $actual[0] ?></td>
                                <td><?php echo $row[3] ?></td>
                                <td><?php echo $row[4] ?></td>
                                <td><?php echo $row[5] ?></td>
                                <td><?php echo $row[6] ?></td>
                                <td><?php echo $row[7] ?></td>

                                <td class="center">
                                    <?php
                                    $parametros = 'id=' . $row[0];
                                    $parametros = _desordenar($parametros);
                                    $parametro = 'np=' . $row[2];
                                    $parametro = _desordenar($parametro);
                                    ?>  
                                    <!--<a href="dashboard.php?data=edicion_reg&flag=1&<?php echo $parametros; ?>" id="editar" title="Editar" >
                                        <div class="icons-holder" style="float:left;margin-left:15px"><span class="icon-pen-alt-fill"></span></div>
                                    </a>-->
                                    <?php
                                    switch ($row[13]){
                                        case 0: ?><a href="dashboard.php?data=seg_fase&flag=1&<?php echo $parametro; ?>" id="seg_fase" title="Insertar EC" >
                                            <div class="icons-holder" style="float:left;margin-left:15px"><span class="icon-folder-stroke"></span></div>
                                                </a>
                                                
                                                <?php
                                                break;
                                        case 1: ?><a href="dashboard.php?data=seg_fase1&flag=1&<?php echo $parametro; ?>" id="seg_fase1" title="Insertar ATE">
                                            <div class="icons-holder" style="float:left;margin-left:15px"><span class="icon-folder-stroke"></span></div>
                                                </a>
                                                   
                                                <?php
                                                break;
                                        
                                        }
                                        
                                        if ($row[13]>=2){
                                            ?>
                                            <a href="dashboard.php?data=seg_fase2&flag=1&<?php echo $parametro; ?>" id="seg_fase2" title="Insertar AP">
                                            <div class="icons-holder" style="float:left;margin-left:15px"><span class="icon-folder-stroke"></span></div>
                                                </a>
                                        <?php
                                        }
                                        
                                        if ($row[13]>0){
                                            ?>
                                            <a href="dashboard.php?data=consultar&flag=1&<?php echo $parametro; ?>" id="consultar" title="Consultar">
                                                    <div class="icons-holder" style="float:left;margin-left:15px"><span class="icon-magnifying-glass"></span></div>
                                                    </a>
                                        <?php
                                        }
                                        
                                        ?>
                              
                                         <a href="dashboard.php?data=edicion_reg&flag=1&<?php echo $parametros; ?>" id="editar" title="Editar" >
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

