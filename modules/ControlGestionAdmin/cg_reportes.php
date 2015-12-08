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
        <div class="widget">
          <div class="widget-header">
            <span class="icon-article"></span>
            <h3>Consulta de los Procesos</h3>
          </div> <!-- .widget-header -->
          <div class="widget-content">
            <form onsubmit="javascript:return validacion();" class="form validateForm" action="dashboard.php?data=control_gestion_reporte" method="POST" name="form">
              <div class="grid-8"> 
                <label>Por Fecha:</label>
                <div class="field-group">
                  <div class="field">
                    <label for="date">Desde</label>	
                    <input type="text" name="desde" id="desde" size="15" class="fecha"  />
                  </div>
                   <div class="field">
                    <label for="date">Hasta:</label>	
                    <input type="text" name="hasta" id="hasta" size="15" class="fecha" />
                  </div>
                </div> <!-- .field-group -->
                <div class="field-group">
                 
                </div> <!-- .field-group -->
              </div>
            
              <div class="grid-8">
                <label>Otros Filtros:</label>
                <div class="field-group">
                  <div class="field">
                    <label for="date">Procesos</label>	
                      <select id="tabla" name="tabla" style="width:155px">
                          <option value="1" selected>Procesos Registrados</option>
                          <option value="2">Solicitud</option>
                      </select>
                  </div>
                    <div class="field-group">
                    <div class="field">
                    <label for="">Responsable</label>	
                       
                                        <select id="responsable" name="responsable"  style="width:110px">
                                            <option value="">Todas</option>
                                            <?php
                                            _bienvenido_mysql();
                                            $sql = mysql_query("SELECT responsable FROM gc_control_gestion GROUP BY responsable");
                                            while ($row = mysql_fetch_array($sql)) {
                                                ?>
                                                <option value="<?php echo $row["responsable"] ?>"><?php echo $row["responsable"] ?></option>
                                            <?php } _adios_mysql(); ?>
                                        </select>
                  </div>
                    </div>
                    <div class="field-group">
                    <div class="field">
                    <label for="">Gerencia</label>	
                       
                                        <select id="gerencia" name="gerencia"  style="width:110px">
                                            <option value="">Todas</option>
                                            <?php
                                            _bienvenido_mysql();
                                            $sql = mysql_query("SELECT gerencia_req FROM gc_control_gestion GROUP BY gerencia_req");
                                            while ($row = mysql_fetch_array($sql)) {
                                                ?>
                                                <option value="<?php echo $row["gerencia_req"] ?>"><?php echo $row["gerencia_req"] ?></option>
                                            <?php } _adios_mysql(); ?>
                                        </select>
                  </div>
                    </div>
                    <div class="field">
                    <label for="date">Estatus</label>	
                      <select id="estatus" name="estatus" style="width:155px">
                          <option value="" selected>Todos</option>
                          <option value="1" >En Elaboración</option>
                          <option value="2">Entregado</option>
                      </select>
                  </div>
                 <div class="field-group"> 
                  <div class="field">
                    <label for="">Por Tipo de Solicitud:</label>	
                      <select id="tipo_solicitud" name="tipo_solicitud" style="width:155px">
                          <option value="" selected>Todos</option>
                      <option value="EC">EC</option>
                      <option value="ATE">ATE</option>
                      <option value="AP">AP</option>
                      
                      </select>
                  </div>
                 </div>  
                </div> <!-- .field-group -->
              </div>
                <br><br><br><br>
                <div align="center" style="margin-bottom:20px;margin-top:120px;">
                  
                  
                  <td align="center"><button type="submit" name="enviar" class="btn btn-primary">Enviar</button></td>
                  
                </div>
            </form>	   
          </div>
        </div> <!-- .widget -->
      </div> <!-- .grid -->
      <?php
            if(isset($_POST['tabla']) && $_POST['tabla']=="1"){
      ?>
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
                            <th style="width:25%">Gerencia Requiriente</th>
                            <th style="width:20%">Responsable</th>
                            <th style="width:10%">Nombre de la Obra/Actividad</th>
                            <th style="width:5%">Estatus</th>
                            <th style="width:10%">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql_query = "SELECT * FROM gc_control_gestion WHERE  1";
                        if (isset($_POST['desde']) && $_POST['desde'] != ''){
                            $sql_query.= " AND fecha_ingreso>='". $_POST['desde']."'";
                        }
                        if (isset($_POST['hasta']) && $_POST['hasta'] != ''){
                            $sql_query.= " AND fecha_ingreso<='". $_POST['hasta']."'";
                        }
                         if (isset($_POST['gerencia']) && $_POST['gerencia'] != ''){
                            $sql_query.= " AND gerencia_req='". $_POST['gerencia']."'";
                        }
                        if (isset($_POST['responsable']) && $_POST['responsable'] != ''){
                            $sql_query.= " AND responsable='". $_POST['responsable']."'";
                        }
                        if (isset($_POST['estatus']) && $_POST['estatus'] != ''){
                            $sql_query.= " AND estatus='". $_POST['estatus']."'";
                        }
                        alertadev($sql_query);
                        $sql = mysql_query($sql_query);
                        $ano = date('y');
                        $actual = (explode("20", $ano));
                        while ($row = mysql_fetch_array($sql)) {
                        switch ($row[8]) {
                                            case 1: $st = "pencil-square-o";
                                                $color = "#8B8B8B";
                                                $titulo = "En Elaboración.";
                                                break;
                                            case 2: $st = "check";
                                                $color = "#8B8B8B";
                                                $titulo = "Entregado.";
                                                break;
                                            
                                        }
                            ?>
                        
                            <tr class="gradeA">
                                <td><?php echo 'GC-' . $row[2] . '-' . $actual[0] ?></td>
                                <td><?php echo $row[3] ?></td>
                                <td><?php echo $row[4] ?></td>
                                <td><?php echo $row[5] ?></td>
                                <td><?php echo $row[6] ?></td>
                                <td style="text-align:center"><span><i class="fa fa-<?= $st ?>" title="<?= $titulo ?>" style="cursor: pointer; font-size: 15px; color: <?php echo $color ?>" ></i></span></td>

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
                                    switch ($row[14]){
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
                                        
                                        if ($row[14]>=2){
                                            ?>
                                            <a href="dashboard.php?data=seg_fase2&flag=1&<?php echo $parametro; ?>" id="seg_fase2" title="Insertar AP">
                                            <div class="icons-holder" style="float:left;margin-left:15px"><span class="icon-folder-stroke"></span></div>
                                                </a>
                                        <?php
                                        }
                                        
                                        if ($row[14]>0){
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
    <?php
            }
    ?>
      <?php
            if(isset($_POST['tabla']) && $_POST['tabla']=="2"){
      ?>
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
                      
                        $sql_query ="SELECT id_cgestion2,n_proceso, servicio, tipo_solicitud, montoec, montooc, montoate, enviado_presidencia FROM gc_control_gestion2 WHERE 1";
                        if (isset($_POST['desde']) && $_POST['desde'] != ''){
                            $sql_query.= " AND enviado_presidencia>='". $_POST['desde']."'";
                        }
                        if (isset($_POST['hasta']) && $_POST['hasta'] != ''){
                            $sql_query.= " AND enviado_presidencia<='". $_POST['hasta']."'";
                        }
                        if (isset($_POST['tipo_solicitud']) && $_POST['tipo_solicitud'] != ''){
                            $sql_query.= " AND tipo_solicitud='". $_POST['tipo_solicitud']."'";
                        }
                        alertadev($sql_query);
                        
                        $ano = date('y');
                        $actual = (explode("20", $ano));
                        $sql = mysql_query($sql_query); 
                        while ($row = mysql_fetch_array($sql)) {
                            $final= $row["tipo_solicitud"] [2] =='' ? '' : $row["tipo_solicitud"] [2].'.'; ?>
                            <tr class="gradeA">
                                <td><?php echo $row["tipo_solicitud"].'-'.$row["n_proceso"].'-00'.$row["servicio"]. '-'.$actual[0] ?></td>
                                <td><?php echo $row["tipo_solicitud"] [0]. '.'. $row["tipo_solicitud"] [1].'.'.$final?></td>
                                <td><?php echo $row["montoec"] ?></td>
                                <td><?php echo $row["montooc"] ?></td>
                                <td><?php echo $row["montoate"] ?></td>
                              

                                <td class="center">
                                    <?php
                                    $parametros = 'id=' . $row[0];
                                    $parametros = _desordenar($parametros);
                                    $parametro = 'np=' . $row[1];
                                    $parametro = _desordenar($parametro);
                                  
                                   
                                    ?>  
                                    <a href="dashboard.php?data=edicion_reg2&flag=1&<?php echo $parametros. '&'. $parametro?>" id="editar" title="Editar" >
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
    <?php
            }
    ?>
</div> <!-- .container -->

</div> <!-- .container -->

<script>
$(function () {
        $.datepicker.setDefaults($.datepicker.regional["es"]);
        $("#desde").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "2000:2015",
           
            onSelect: function (fecha,event){$('#hasta').datepicker("option","minDate",fecha);}
        });
    });
    $(function () {
        $.datepicker.setDefaults($.datepicker.regional["es"]);
        $("#hasta").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "2000:215"
        });
    });
</script>