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
  <h2>Consulta de Procesos</h2>
</div> <!-- #contentHeader -->	
<!------------------------------------------------------------------------------------------------------------>
                                								  <!----------- VER LISTINES ---------->
<!----------------------------------------------------------------------------------------------------------->	
  <style>
    .field {

      float: left !important;
    }
  </style>		
  <div class="container">
    <div class="row">				
  <?php include('notificador.php'); ?>
      <div class="grid-12">				
        <div class="widget">
          <div class="widget-header">
            <span class="icon-article"></span>
            <h3>Consulta de los Procesos</h3>
          </div> <!-- .widget-header -->
          <div class="widget-content">
            <form onsubmit="javascript:return validacion();" class="form validateForm" action="modules/ControlGestionAdmin/pdf.php" method="POST" name="form">
              <div class="grid-8"> 
                <label>Por Fecha:</label>
                <div class="field-group">
                  <div class="field">
                    <label for="date">Desde</label>	
                    <input type="text" name="desde" id="datepicker" size="15" class="fecha"  />
                  </div>
                   <div class="field">
                    <label for="date">Hasta:</label>	
                    <input type="text" name="hasta" id="datepicker1" size="15" class="fecha" />
                  </div>
                </div> <!-- .field-group -->
                <div class="field-group">
                 
                </div> <!-- .field-group -->
              </div>
            
              <div class="grid-8">
                <label>Otros Filtros:</label>
                <div class="field-group">
                  <div class="field">
                    <label for="date">Por Gerencia:</label>	
                      <select id="gerencia" name="gerencia" style="width:155px">
                      <option value="0"></option>
                      <?php _bienvenido_mysql(); 
                      $sql=mysql_query("SELECT gerencia FROM reporte_planvacacional_retardado GROUP BY gerencia");while($row=mysql_fetch_array($sql)){ ?>
                      <option value="<?php echo $row["gerencia"]?>"><?php echo $row["gerencia"]?></option>
                      <?php } _adios_mysql();?>
                      </select>
                  </div>
                 <div class="field-group"> 
                  <div class="field">
                    <label for="sexo">Por Sexo:</label>	
                      <select id="sexo" name="sexo" style="width:155px">
                      <option value="0"></option>
                      <?php _bienvenido_mysql(); 
                      $sql=mysql_query("SELECT sexo FROM reporte_planvacacional_retardado GROUP BY sexo");while($row=mysql_fetch_array($sql)){ ?>
                      <option value="<?php echo $row["sexo"]?>"><?php echo $row["sexo"]?></option>
                      <?php } _adios_mysql();?>
                      </select>
                  </div>
                 </div>  
                </div> <!-- .field-group -->
              </div>
                <br><br><br><br>
                <div align="center" style="margin-bottom:20px;margin-top:120px;">
                  <input style="margin-left:10px;" class="btn btn-error" type="button" align='center' name="volver" value="Volver" onclick="javascript:window.location.href = 'dashboard.php?data=listines-r'" />
                  <input  id="token" type="hidden" name="token" value="<?php $_SESSION['tokenplanvac'] = $anticachecret; echo $_SESSION['tokenplanvac']; ?>" />
                  <input  id="Imprimir" class="btn btn-error"  type="submit" align='center' name="Imprimir" value="Generar y Descargar Excel" />
                  <input style="margin-left:10px;" class="btn btn-error" type="button" align='center' name="Recargar" value="Recargar" onclick="javascript:location.reload();" />
                </div>
            </form>	   
          </div>
        </div> <!-- .widget -->
      </div> <!-- .grid -->
      <div class="grid-12">				
        <div class="widget">			
          <div class="widget-header">
          <span class="icon-layers"></span>
            <h3>Breve Resumen</h3>
          </div>
          <center>
            <div class="widget-content">
            <h5 align="left">Estimado, <?php echo $usuario_datos[1] . ' ' . $usuario_datos[2]  ; ?></h5>
            <p align="justify">En esta sección podrá generar reportes y ver breves resúmenes de los participantes inscritos en el Plan Vacacional 2015.</p>
                                          
            </div>
           
          </div>
        </div>
          </div>
        </div>					
      </div> <!-- .grid -->	
    </div> <!-- .row -->
  </div> <!-- .container -->
 
<script>
 $(function () {
        $.datepicker.setDefaults($.datepicker.regional["es"]);
        $("#datepicker").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "2015:2020"
        });
    });
</script>
<script>
function validacion() {
  var f1 = document.getElementById('desde').value;
  var f2 = document.getElementById('hasta').value;
  if ((f1=='')||(f2=='') ) {
    // Si no se cumple la condicion...
    alert('Recuerde seleccionar el rango de fechas "Desde" y "Hasta" para generar un reporte');
    return false;
  }
  else{
    return true;
  }
}
</script>