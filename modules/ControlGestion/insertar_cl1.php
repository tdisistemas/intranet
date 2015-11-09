<?php 
if (array_pop(explode('/', $_SERVER['PHP_SELF']))!='dashboard.php') {ir("../../dashboard.php");}
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
	notificar("Usted no tiene permisos para esta Sección/Módulo", "dashboard.php?data=notificar", "notify-error");
	_wm($usuario_datos[9],'Acceso Denegado en: '.ucwords(array_pop(explode('/', __dir__))),'S/I');
} 
_wm($usuario_datos[9],'Acceso Autorizado en: '.ucwords(array_pop(explode('/', __dir__))),'S/I');
?>

<div id="contentHeader">
  <h2>Registro de Proyectos</h2>
</div>
<!-- #contentHeader -->
<div class="container">
  <div class="row">
    <div class="grid-24">
      <div class="widget">
        <div class="widget-header"> <span class="icon-folder-fill"></span>
          <h3>Primera Fase</h3>
        </div>
        
<div class="widget-content">
							
<form class="form validateForm" action="dashboard.php?data=insertar-proy" method="post"  onsubmit="return validate()" enctype="multipart/form-data" >


<div class="grid-8">		
<label for="datepicker">Fecha de Ingreso:</br></label>
<input type="date" name="fecha_ing" id="datepicker" size="14" class="validate[required]" placeholder="Fecha de Ingreso"/>
</div>

<div class="grid-8">
<label for="required">Nombre de la Obra/Actividad:</br></label>
<input type="text" name="nombre_obra" id="nombre_obra" size="14" class="validate[required]" placeholder="Nombre de la Obra/Actividad"/>	
</div>

<div class="grid-8">
    <label for="date">Gerencia Requiriente:</br></label>
               <select id="gerencia" name="gerencia" style="width:110px">
                <option value="0"></option>
                     <?php _bienvenido_mysql();
                     $sql=mysql_query("SELECT gerencia FROM datos_empleado_rrhh GROUP BY gerencia");while($row=mysql_fetch_array($sql)){ ?>
                <option value="<?php echo $row["gerencia"]?>"><?php echo $row["gerencia"]?></option>
                     <?php } _adios_mysql();?>
                </select>	
</div>


<div class="grid-8">
<label for="required">Responsable del Requerimiento:</br></label>
<input type="text" name="responsable_req" id="responsable_req" size="14" class="validate[required]" placeholder="Responsable del Requerimiento"/>	
</div>


<div class="grid-8">
<label for="required">Nombre de la Empresa y/o Contructor:</br></label>
<input type="text" name="nombre_empre" id="nombre_empre" size="14" class="validate[required]" placeholder="Nombre de la Empresa y/o Constructor"/>	
</div>


<div class="grid-8 ">
<label>Estatus del Tramite:<br></label>   
<select  name="estatus" id="estatus">
<option>Seleccione</option>
<option value="R">Revisión</option>
</select>
</div>
		
	          	
 

<div class="grid-24" align="center">
<table >
  <tr>
    <td align="center">
<div id="cargador" style="display:none;font-size:14px"> <img src="src/images/loaders/indicator-big.gif" width="10" height="10" /> Cargando </div> 
<div id="cargador_2" style="display:none;font-size:14px"> <img src="src/images/loaders/indicator-big.gif" width="10" height="10" /> Cargando </div>

</td>
  </tr>
  <tr>
      <td align="center"><button type="submit" name="enviar" class="btn btn-primary">Enviar</button></td>
      <td><button type="submit" name="Atras" onclick="javascript:window.history.back();" class="btn btn-error" value="Regresar" >Regresar</button></td>
  </tr>
</table>
</div>


</form>
</div>
</div>
</div>
</div>
</div>
</div>

<script type="text/javascript">
javascript</script>








