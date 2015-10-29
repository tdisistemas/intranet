<?php
if (array_pop(explode('/', $_SERVER['PHP_SELF'])) != 'dashboard.php') {
  ir("../../dashboard.php");
}
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
  notificar("Usted no tiene permisos para esta Sección/Módulo", "dashboard.php?data=notificar", "notify-error");
  _wm($usuario_datos[9], 'Acceso Denegado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
}
_wm($usuario_datos[9], 'Acceso Autorizado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
?>
<div id="contentHeader">
  <h2>Comunicaciones</h2>
</div> <!-- #contentHeader -->	
<!------------------------------------------------------------------------------------------------------------>
<?php if (@isset($_POST['solicitorango'])) { ?>													<!--------- PROCESO LISTINES --------->
<!------------------------------------------------------------------------------------------------------------>
 


<!----------------------------------------------------------------------------------------------------------->
<?php } else { ?>                                     								  <!----------- VER LISTINES ---------->
<!----------------------------------------------------------------------------------------------------------->	
  <style>
    .field {

      float: left !important;
    }
  </style>		
  <div class="container">
    <div class="row">				
  <?php include('notificador.php'); ?>
      <div class="grid-16">				
        <div class="widget">
          <div class="widget-header">
            <span class="icon-article"></span>
            <h3>Reportes de Comunicaciones Internas</h3>
          </div> <!-- .widget-header -->
          <div class="widget-content">
            <form onsubmit="javascript:return validacion();" class="form validateForm" action="modules/comunicar_admin/pdf.php" method="POST" name="form">
              <div class="grid-8"> 
                <label>Por Fecha:</label>
                <div class="field-group">
                  <div class="field">
                    <label for="date">Desde:</label>	
                    <input type="text" name="desde" id="fecha" size="15" class="fecha"  />
                  </div>
                </div> <!-- .field-group -->
                <div class="field-group">
                  <div class="field"> 
                    <label for="date">Hasta:</label>	
                    <input type="text" name="hasta" id="fecha1" size="15" class="fecha" />
                  </div>
                </div> <!-- .field-group -->
              </div>
   
              <div class="grid-8">
                <label>Otros Filtros:</label>
                <div class="field-group">
                  <div class="field">
                    <label for="date">Por Gerencia:</label>	
                      <select id="gerencia" name="gerencia" style="width:195px">
                      <option value="0"></option>
                      <?php _bienvenido_mysql(); 
                      $sql=mysql_query("SELECT gerencia FROM datos_empleado_rrhh GROUP BY gerencia");while($row=mysql_fetch_array($sql)){ ?>
                      <option value="<?php echo $row["gerencia"]?>"><?php echo $row["gerencia"]?></option>
                      <?php } _adios_mysql();?>
                      </select>
                  </div>
                </div> <!-- .field-group -->
              <div class="field-group">
                  <div class="field">
                    <label for="date">Consecutivo:</label>	
                      <input type="text" name="consecutivo"  size="15"  />
                  </div>
                </div> 
              </div>
               
                <br><br><br><br>
                <div align="center" style="margin-bottom:20px;margin-top:120px;">
                  <input style="margin-right:10px;" class="btn btn-error" type="button" align='center' name="volver" value="Volver" onclick="javascript:window.location.href = 'dashboard.php?data=listines-r'" />
                  <input  id="token" type="hidden" name="token" value="<?php $_SESSION['tokenprepahoa'] = $anticachecret; echo $_SESSION['tokenprepahoa']; ?>" />
                  <input  id="Imprimir" class="btn btn-error"  type="submit" align='center' name="Imprimir" value="Generar y Descargar Excel" />
                  </div>
            </form>	   
          </div>
        </div> <!-- .widget -->
      </div> <!-- .grid -->
      <div class="grid-8">				
        <div class="widget">			
          <div class="widget-header">
          <span class="icon-layers"></span>
            <h3></h3>
          </div>
          <div class="widget-content">
            <h3>Estimado, <?php echo $usuario_datos[1] . ' ' . $usuario_datos[2]  ; ?></h3>
            <p>En esta sección podrá generar reportes de las comunicaciones.</p>
           
           <!-- .pad -->
            </div>  
            <?php
            _adios_mysql();
            ?>
          </div>
        </div>					
      </div> <!-- .grid -->	 
    </div> <!-- .row -->
  </div> <!-- .container -->
<?php } ?>    
<script>

  $(function() {
$("#fecha").datepicker({ maxDate: 0, 
    dateFormat: 'dd/mm/yy ',
changeMonth: true,
changeYear: true,

});
});  

 $(function() {
$("#fecha1").datepicker({ maxDate: 0, 
    dateFormat: 'dd/mm/yy ',
changeMonth: true,
changeYear: true,

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