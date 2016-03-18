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
 $nombreImg1 = "../../src/images/cabecera.png";
 $nombreImg2 = "../../src/images/piepagina.png";

    
?>

<div id="contentHeader">
    <h2>Registro de Procesos</h2>
</div> <!-- #contentHeader -->	


 <div class="container">
   
    <?php include('notificador.php'); ?>
     
     <div class="grid-24">	
  	<div class="widget widget-plain">
					
					<div class="widget-content">
				
<?php
      _bienvenido_mysql();
			
      $sql_cg= mysql_query("SELECT id_cgestion FROM gc_control_gestion WHERE 1");
      $a = mysql_num_rows($sql_cg);
      
      $sql_tp=  mysql_query("SELECT tipo_solicitud FROM gc_control_gestion2 WHERE tipo_solicitud = 'EC'");
      $b = mysql_num_rows($sql_tp);
      
       $sql_tp=  mysql_query("SELECT tipo_solicitud FROM gc_control_gestion2 WHERE tipo_solicitud = 'ATE'");
       $c= mysql_num_rows($sql_tp);
       
       $sql_tp=  mysql_query("SELECT tipo_solicitud FROM gc_control_gestion2 WHERE tipo_solicitud = 'AP'");
       $d= mysql_num_rows($sql_tp);
       
      
			_adios_mysql();

?>
						
						<div class="dashboard_report first activeState">
							<div class="pad">
								<span class="value"><?php echo $a; ?></span>Total de Procesos Registrados
							</div> <!-- .pad -->
						</div>
						
						<div class="dashboard_report defaultState">
							<div class="pad">
								<span class="value"><?php echo $b; ?></span> Total de Estimación de Costo
							</div> <!-- .pad -->
						</div>
						
						<div class="dashboard_report defaultState">
							<div class="pad">
								<span class="value"><?php echo $c; ?></span> Total de Análisis Técnico Económico
							</div> <!-- .pad -->
						</div>
						
						<div class="dashboard_report defaultState last">
							<div class="pad">
								<span class="value"><?php echo $d; ?></span> Total de Ajuste de Precios
							</div> <!-- .pad -->
						</div>
                                                
						
					</div> <!-- .widget-content -->
					
				</div> <!-- .widget -->	
	</div> <!-- .grid -->
                                                

    <div class="grid-24">				
        <div class="widget">
            <div class="widget-header">
                <span class="icon-article"></span>
                <h3>Consulta de los Procesos</h3>
            </div> <!-- .widget-header -->
            <div class="widget-content">
                <form onsubmit="javascript:return validacion();" class="form validateForm" action="" method="post">
                    <div class="grid-6"> 
                        <label>Por Fecha:</label>
                        <div class="field-group">
                            <div class="field">
                                <label for="date">Desde</label>	
                                <input type="text" name="desde" id="desde" size="15" class="fecha"  />
                            </div>
                        </div>
                        <div class="field-group">
                            <div class="field">
                                <label for="date">Hasta:</label>	
                                <input type="text" name="hasta" id="hasta" size="15" class="fecha" />
                            </div>
                        </div>
                    </div>
                    <div class="grid-6">
                        <div class="field-group">
                            <div class="field">
                                <label for="date">Procesos</label>	
                                <select id="tabla" name="tabla" onChange="Block(this)" style="width:155px">
                                    <option value="1" >Procesos Registrados</option>
                                    <option value="2"  >Solicitud</option>
                                </select>
                            </div>
                        </div>

                        <div class="field-group">
                            <div class="field">
                                <label for="">Responsable</label>	

                                <select id="responsable" name="responsable"    style="width:110px;">
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
                    </div>

                    <div class="grid-6">
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
                        <div class="field-group">
                            <div class="field">
                                <label for="date">Estatus</label>	
                                <select id="estatus" name="estatus" style="width:155px">
                                    <option value="" selected>Todos</option>
                                    <option value="1" >En Elaboración</option>
                                    <option value="2">Entregado</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="grid-6">
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
                    </div> 
            </div> 
            <div class="grid-24" style="text-align:center">
                <button type="submit" name="enviar" class="btn btn-primary">Enviar</button>

            </div>
</form>	   

        </div> <!-- .widget -->
    </div> <!-- .grid -->
    
   
    <?php
    if (isset($_POST['tabla']) && $_POST['tabla'] == "1") {
        ?>
        <div class="grid-24">	
            <div class="widget widget-table">
                <div class="widget-header">
                    <span class="icon-list"></span>
                    <h3 class="icon chart">Registro de Procesos</h3>		
                 </div>
                <div class="widget-content">
                    <table class="table table-bordered table-striped data-table">
                        <thead>
                            <tr>
                                <th style="width:10%">N° de Proceso</th>
                                <th style="width:10%">Fecha de Ingreso</th>
                                <th style="width:30%">Gerencia Requiriente</th>
                                <th style="width:20%">Responsable</th>
                                <th style="width:15%">Nombre de la Obra/Actividad</th>
                                <th style="width:5%">Estatus</th>
                                <th style="width:5%">Tipo de Solicitud</th>
                                

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                           
                            $sql_query = "SELECT  gc_control_gestion.id_cgestion,gc_control_gestion.n_proceso_completo,gc_control_gestion.fecha_ingreso,
                              gc_control_gestion.gerencia_req,gc_control_gestion.responsable,gc_control_gestion.obra, 
                              gc_control_gestion.estatus, gc_control_gestion2.tipo_solicitud,gc_control_gestion2.n_proceso, gc_control_gestion2.servicio_completo, gc_control_gestion2.montoec, 
                              gc_control_gestion2.montooc, gc_control_gestion2.montoate FROM gc_control_gestion,
                              gc_control_gestion2 WHERE gc_control_gestion2.n_proceso=gc_control_gestion.n_proceso and 1";
                            
                               
                            if (isset($_POST['desde']) && $_POST['desde'] != '') {
                                $sql_query.= " AND fecha_ingreso>='" . $_POST['desde'] . "'";
                               
                            }
                            if (isset($_POST['hasta']) && $_POST['hasta'] != '') {
                                $sql_query.= " AND fecha_ingreso<='" . $_POST['hasta'] . "'";
                               
                            }
                            if (isset($_POST['gerencia']) && $_POST['gerencia'] != '') {
                                $sql_query.= " AND gerencia_req='" . $_POST['gerencia'] . "'";
                                
                            }
                            if (isset($_POST['responsable']) && $_POST['responsable'] != '') {
                                $sql_query.= " AND responsable='" . $_POST['responsable'] . "'";
                               
                            }
                            if (isset($_POST['estatus']) && $_POST['estatus'] != '') {
                                $sql_query.= " AND estatus='" . $_POST['estatus'] . "'";
                                
                            }
                            if (isset($_POST['tipo_solicitud']) && $_POST['tipo_solicitud'] != '') {
                                $sql_query.= " AND tipo_solicitud='" . $_POST['tipo_solicitud'] . "'";
                               
                            }
                            
                            
                            $sql = mysql_query($sql_query);
                            $ano = date('y');
                            $actual = (explode("20", $ano));

                            while ($row = mysql_fetch_array($sql)) {
                                $final = $row["tipo_solicitud"] [2] == '' ? '' : $row["tipo_solicitud"] [2] . '.';

                                switch ($row["estatus"]) {
                                    case 1: $st = "pencil-square-o";
                                        $color = "#8B8B8B";
                                        $titulo = "En Elaboración.";
                                        break;
                                    case 2: $st = "check";
                                        $color = "#8B8B8B";
                                        $titulo = "Entregado.";
                                        break;
                                } 
                            $arreglo = array(
                               array ('Cantidad',$a), 
                               array ('Query',$sql_query), 
                                array('img1',$nombreImg1), 
                                array('img2',$nombreImg2));
                                ?>

                                <tr class="gradeA">
                                    <td><?php echo $row["n_proceso_completo"] ?></td>
                                    <td><?php echo $row["fecha_ingreso"] ?></td>
                                    <td><?php echo $row["gerencia_req"] ?></td>
                                    <td><?php echo $row["responsable"] ?></td>
                                    <td><?php echo $row["obra"] ?></td>
                                    <td style="text-align:center"><span><i class="fa fa-<?= $st ?>" title="<?= $titulo ?>" style="cursor: pointer; font-size: 15px; color: <?php echo $color ?>" ></i></span></td>
                                    <td><?php echo $row["tipo_solicitud"] [0] . '.' . $row["tipo_solicitud"] [1] . '.' . $final ?></td>

                                </tr>									
    <?php } ?>

                        </tbody>
                        
                    </table>
                    <div id="Grid-Importar box plain"> 
                        <form id="Reportador" action="gen_report/reportes.php" method="post" target ="_blank">
                            <input id="array" name="array" type="hidden" value="<?php echo parametrosReporte($arreglo)?>" >
                            <input id="jasper" name="jasper" type="hidden" value="/ControlGestionAdmin/reportecg.jasper" >
                            <input id="nombresalida" name="nombresalida" type="hidden" value="Procesos Incluidos27" >
                            <input type="hidden" name="formato" id="formato" value="" >
                        </form>
                           <button type="text" onclick="javascript: ActionReportador('pdf')" title="Exportar a PDF" class="btn btn-error" href="#"><i style="color: white; font-weight: 500; font-size: 25px" class="fa fa-file-pdf-o"></i></button>
                           <button type="text" onclick="javascript: ActionReportador('xlsx')" title="Exportar a EXCEL" class="btn btn-error" href="#"><i style="color: white; font-weight: 500; font-size: 25px" class="fa fa-file-excel-o"></i></button>   
                    </div>
           
            </div>

                </div> <!-- .widget-content -->

            </div>

        </div> <!-- .grid -->
    <?php
}
?>
    <?php
    if (isset($_POST['tabla']) && $_POST['tabla'] == "2") {
        if (isset($_POST['tipo_solicitud']) && $_POST['tipo_solicitud']=='EC'){
            
            $tipo = '';
        }else {
            
            $tipo = 'display:none';
        }
        
        ?>
        <div class="grid-24">	
            <div class="widget widget-table">
                <div class="widget-header">
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
                                <th style="width:10%">Fecha de Recepción</th>
                                <th style="width:10%;<?php echo $tipo?>">Recibido por</th>
                                
                            </tr>
                        </thead>
                        <tbody>
    <?php
    $sql_query = "SELECT  gc_control_gestion.id_cgestion,gc_control_gestion.n_proceso_completo,gc_control_gestion.fecha_ingreso,
                              gc_control_gestion.gerencia_req,gc_control_gestion.responsable,gc_control_gestion.obra, 
                              gc_control_gestion.estatus, gc_control_gestion2.tipo_solicitud,gc_control_gestion2.n_proceso, gc_control_gestion2.servicio_completo, gc_control_gestion2.montoec, 
                              gc_control_gestion2.montooc, gc_control_gestion2.montoate,gc_control_gestion2.recibido_presidencia , gc_control_gestion2.recibido_por FROM gc_control_gestion,
                              gc_control_gestion2 WHERE gc_control_gestion2.n_proceso=gc_control_gestion.n_proceso and 1";
    if (isset($_POST['desde']) && $_POST['desde'] != '') {
        $sql_query.= " AND enviado_presidencia>='" . $_POST['desde'] . "'";
    }
    if (isset($_POST['hasta']) && $_POST['hasta'] != '') {
        $sql_query.= " AND enviado_presidencia<='" . $_POST['hasta'] . "'";
    }
    if (isset($_POST['tipo_solicitud']) && $_POST['tipo_solicitud'] != '') {
        $sql_query.= " AND tipo_solicitud='" . $_POST['tipo_solicitud'] . "'";
    }

  

    $ano = date('y');
    $actual = (explode("20", $ano)); 
    $sql = mysql_query($sql_query);
    while ($row = mysql_fetch_array($sql)) {
        $final = $row["tipo_solicitud"] [2] == '' ? '' : $row["tipo_solicitud"] [2] . '.';
        ?>
                                <tr class="gradeA">
                                    <td><?php echo $row["servicio_completo"]?></td>
                                    <td><?php echo $row["tipo_solicitud"] [0] . '.' . $row["tipo_solicitud"] [1] . '.' . $final ?></td>
                                    <td><?php echo $row["montoec"] ?></td>
                                    <td><?php echo $row["montooc"] ?></td>
                                    <td><?php echo $row["montoate"] ?></td> 
                                    <td><?php echo $row["recibido_presidencia"] ?></td> 
                                    <td style="<?php echo $tipo?>"><?php echo $row["recibido_por"] ?></td> 
                                </tr>
                         

    <?php } $arreglo = array(
        array ('Query',$sql_query), 
        array('img1',$nombreImg1), 
        array('img2',$nombreImg2)); ?>
             
             
             

                        </tbody>

                    </table>
                    <div id="Grid-Importar box plain"> 
                        <form id="Reportador" action="/intranet/gen_report/reportes.php" method="post" target ="_blank">
                            <input id="array" name="array" type="hidden" value="<?php echo parametrosReporte($arreglo)?>" >
                            <input id="jasper" name="jasper" type="hidden" value="/ControlGestionAdmin/servicio.jasper" >
                            <input id="nombresalida" name="nombresalida" type="hidden" value="Servicio5" >	
                            <input type="hidden" name="formato" id="formato" value="" >
                        </form>
                           <button type="text" onclick="javascript: ActionReportador('pdf')" title="Exportar a PDF" class="btn btn-error" href="#"><i style="color: white; font-weight: 500; font-size: 25px" class="fa fa-file-pdf-o"></i></button>
                           <button type="text" onclick="javascript: ActionReportador('xlsx')" title="Exportar a EXCEL" class="btn btn-error" href="#"><i style="color: white; font-weight: 500; font-size: 25px" class="fa fa-file-excel-o"></i></button>   
                    </div>
                </div> <!-- .widget-content -->
            </div>
        </div> <!-- .grid -->
       
    <?php
}
?>
        

    </div> <!-- .grid -->

    <script type="text/javascript">
     function ActionReportador(formato) {
        document.getElementById('formato').value = formato;
        document.getElementById('Reportador').submit();
    }    
    
    function Block(esto)
        {
            if (esto.value == 2)
            {
                document.getElementById('responsable').disabled = true;
                document.getElementById('gerencia').disabled = true;
                document.getElementById('estatus').disabled = true;
            } else
            {
                document.getElementById('responsable').disabled = false;
                document.getElementById('gerencia').disabled = false;
                document.getElementById('estatus').disabled = false;
            }
        }


        $(function () {
            $.datepicker.setDefaults($.datepicker.regional["es"]);
            $("#desde").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "2015:2020",
                onSelect: function (fecha, event) {
                    $('#hasta').datepicker("option", "minDate", fecha);
                }
            });
        });
        $(function () {
            $.datepicker.setDefaults($.datepicker.regional["es"]);
            $("#hasta").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "2015:2020"
            });
        });
    </script>