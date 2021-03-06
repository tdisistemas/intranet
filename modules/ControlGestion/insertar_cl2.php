<?php 
if (array_pop(explode('/', $_SERVER['PHP_SELF']))!='dashboard.php') {ir("../../dashboard.php");}
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
	//notificar("Usted no tiene permisos para esta Sección/Módulo", "dashboard.php?data=notificar", "notify-error");
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
    <div class="grid-17">
      <div class="widget">
        <div class="widget-header"> <span class="icon-folder-fill"></span>
          <h3>Primera Fase</h3>
        </div>
        
<div class="widget-content">
							
<form class="form validateForm" action="dashboard.php?data=insertar-proy1" method="post"  onsubmit="return validarForm(this)">


    
                            <div class="grid-2">
                            </div>
                            <div class="grid-8">
                              <div class="field-group">
                                <label>Clase:<br></label>   
                              <div class="field">
                                <select  name="clase" id="clase">
                                    <option value="">Seleccione</option>
                                <option value="ClaseII">Clase II</option>
                                <option value="ClaseIV">Clase IV</option>
                                </select>
                                </div>
                              </div>
                                <div class="field-group">
                                    <label for="date">Nombre de la Empresa y/o Contructor:</br></label>   
                                    <div class="field">
                                   <input type="text" name="nombre_empre" id="nombre_empre" size="14"  placeholder="Nombre de la Empresa y/o Constructor" onChange="conMayusculas(this)"/>	
                                    </div>
                                </div>
                               <div class="field-group">
                                    <label for="required">Estatus del Tramite:</br></label>   
                                    <div class="field">
                                   <select  name="estatus" id="estatus">
                                       <option value="">Seleccione</option>
                                    <option value="REVISIÓN">Revisión</option>
                                    </select>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="grid-6">
                                 <div class="field-group">
                                    <label>Fecha de Ingreso:<br></label>   
                                    <div class="field">
                                    <input type="date" name="fecha_ing" id="datepicker" size="14"  placeholder="Fecha de Ingreso"/>
                                    </div>
                                </div>
                                
                                 <div class="field-group">
                                    <label for="required">Nombre de la Obra/Actividad:</br></label>   
                                    <div class="field">
                                   <input type="text" name="nombre_obra" id="nombre_obra" size="14" placeholder="Nombre de la Obra/Actividad" onChange="conMayusculas(this)"/>	
                                    </div>
                                </div>
                               
                                
                            </div>
                            
                            <div class="grid-6">
                                <div class="field-group">
                                    <label for="date">Gerencia Requiriente:</br></label>   
                                    <div class="field">
                                   <select id="gerencia" name="gerencia" style="width:110px">
                                    <option value=""></option>
                                          <?php _bienvenido_mysql();
                                         $sql=mysql_query("SELECT gerencia FROM datos_empleado_rrhh GROUP BY gerencia");while($row=mysql_fetch_array($sql)){ ?>
                                    <option value="<?php echo $row["gerencia"]?>"><?php echo $row["gerencia"]?></option>
                                      <?php } _adios_mysql();?>
                                    </select>	
                                    </div>
                                </div>
                       
                                 <div class="field-group">
                                    <label for="required">Responsable del Requerimiento:</br></label>   
                                    <div class="field">
                                   <input type="text" name="responsable_req" id="responsable_req" size="14" placeholder="Responsable del Requerimiento"onChange="conMayusculas(this)"/>
                                    </div>
                                </div>
                                
                                
                            </div>
                            <div class="grid-2">
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
    <div class="grid-7">				
        <div class="widget">			
          <div class="widget-header">
          <span class="icon-layers"></span>
            <h3></h3>
          </div>
          <div class="widget-content">
            <h3>Estimado, <?php echo $usuario_datos[1] . ' ' . $usuario_datos[2]  ; ?></h3>
            <p>En esta sección podrá ingresar los datos de la primera fase del proceso</p>
            <!-- .pad -->
            </div>  
           
          </div>
        </div>
</div>
</div>

<script type="text/javascript">
    function validarForm(formulario) {

  if(formulario.clase.value.length==0) { //¿Tiene 0 caracteres?
    formulario.clase.focus();    // Damos el foco al control
    alert('Debe seleccionar el tipo de clase'); //Mostramos el mensaje
    return false; //devolvemos el foco
  }
    if(formulario.datepicker.value.length==0) { //¿Tiene 0 caracteres?
    formulario.datepicker.focus();    // Damos el foco al control
    alert('Debe ingresar la fecha de ingreso'); //Mostramos el mensaje
    return false; //devolvemos el foco
  }
   if(formulario.gerencia.value.length==0) { //¿Tiene 0 caracteres?
    formulario.gerencia.focus();    // Damos el foco al control
    alert('Debe seleccionar la Gerencia Requiriente'); //Mostramos el mensaje
    return false; //devolvemos el foco
  }
  if(formulario.nombre_empre.value.length==0) { //¿Tiene 0 caracteres?
    formulario.nombre_empre.focus();    // Damos el foco al control
    alert('Debe ingresar el nombre de la Empresa'); //Mostramos el mensaje
    return false; //devolvemos el foco
  }
  if(formulario.nombre_obra.value.length==0) { //¿Tiene 0 caracteres?
    formulario.nombre_obra.focus();    // Damos el foco al control
    alert('Debe ingresar el nombre de la Obra/Actividad'); //Mostramos el mensaje
    return false; //devolvemos el foco
  }
  if(formulario.responsable_req.value.length==0) { //¿Tiene 0 caracteres?
    formulario.responsable_req.focus();    // Damos el foco al control
    alert('Debe ingresar el responsable del requerimiento'); //Mostramos el mensaje
    return false; //devolvemos el foco
  }
  
  if(formulario.estatus.value.length==0) { //¿Tiene 0 caracteres?
    formulario.gerencia.focus();    // Damos el foco al control
    alert('Debe seleccionar el estatus'); //Mostramos el mensaje
    return false; //devolvemos el foco
  }
    }
  $(function () {
$.datepicker.setDefaults($.datepicker.regional["es"]);
$("#datepicker").datepicker({
dateFormat: 'yy-mm-dd',
changeMonth: true,
changeYear: true,
yearRange: "1950:2014"
});
});
function conMayusculas(field) {
field.value = field.value.toUpperCase()
}
javascript</script>









