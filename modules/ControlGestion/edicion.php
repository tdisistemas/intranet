<?php
if (array_pop(explode('/', $_SERVER['PHP_SELF'])) != 'dashboard.php') {
    header("Location: ../../dashboard.php");
}
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
  //notificar("Usted no tiene permisos para esta Sección/Módulo", "dashboard.php?data=notificar", "notify-error");
    _wm($usuario_datos[9], 'Acceso Denegado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
}
_wm($usuario_datos[9], 'Acceso Autorizado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
?>

<div id="contentHeader">

    <?php //decode_get2($_SERVER["REQUEST_URI"],1);  ?>

    <h2>Edición de la Primera Fase</h2>
</div> <!-- #contentHeader -->	

<?php
        
    decode_get2($_SERVER["REQUEST_URI"], 2);
    $id = _antinyeccionSQL($_GET["id"]);
    _bienvenido_mysql();
    
    $result = mysql_query("SELECT * FROM gc_control_gestion WHERE id_cgestion = " . $id);
    $reg = mysql_fetch_array($result);
    $parametros = 'id=' . $id;
    $parametros = _desordenar($parametros);
    $num_rows = mysql_num_rows($result);

    if ($num_rows == 1) {
        $id_2 = $reg["id_cgestion"];
        $clase = $reg[1];
        $fecha_ing = $reg[3];
        $gerencia = $reg[4];
        $responsable = $reg[5];
        $obra = $reg[6];
        $estatus = $reg[7];
        $documentose = $reg[8];
        $documentos=  explode(',', $documentose);
      
    } else {
        notificar("No Existen Registros", "dashboard.php?data=controlg", "notify-error");
    }
if (isset($_POST['enviar'])) {
    
    $id = $_POST["id_cgestion2"];
    $clase = $_POST["clase"];
    $estatus = $_POST["estatus"];
    $alcance=  isset($_POST['alcance']) ? $_POST['alcance']:'0';
    $memoriad= isset($_POST['memoriad']) ? $_POST['memoriad']:'0';
    $computos= isset($_POST['computos']) ? $_POST['computos']:'0';
    $especificaciones= isset($_POST['especificaciones']) ? $_POST['especificaciones']:'0';
    $planos= isset($_POST['planos']) ? $_POST['planos']:'0';
    $anexos= isset($_POST['anexos']) ? $_POST['anexos']:'0';
    
    
    $documento_anterior=$_POST["documento_anterior"];
    $anteriores=  explode(',', $documento_anterior);
    
    if($anteriores[0]==1){
        $alcance=1;
    }
    if($anteriores[1]==1){
        $memoriad=1;
    }
    if($anteriores[2]==1){
        $computos=1;
    }
    if($anteriores[3]==1){
        $especificaciones=1;
    }
    if($anteriores[4]==1){
        $planos=1;
    }
    if($anteriores[5]==1){
        $anexos=1;
    }
    
    
    $documentose= $alcance. "," .$memoriad. "," .$computos. "," .$especificaciones. "," .$planos. "," .$anexos; 
 
    
    $parametro = 'np=' . $id_2;
    $parametro = _desordenar($parametro);
       
 
 $sql="UPDATE gc_control_gestion SET  ". "clase='".$clase."',". "estatus='".$estatus."', ". "documentos_entre='".$documentose."' WHERE id_cgestion=".$id_2;
  
  $result = mysql_query($sql) or die('Error al Modificar Registro ' . mysql_error());
  
  if($result){
    notificar("Primera fase modificada con exito" ,"dashboard.php?data=controlg", "notify-success");
  }
  else { 
    die(mysql_error());
  }			
}
?>

<!-- #contentHeader -->
<div class="container">
  <div class="row">
    <div class="grid-16">
      <div class="widget">
        <div class="widget-header"> <span class="icon-folder-fill"></span>
          <h3>Primera Fase</h3>
        </div>
        
<div class="widget-content">
							
<form class="form validateForm" action="#" method="post"  onsubmit="return validarForm(this)" >

                            <div class="grid-2">
                              </div>
                              <div class="grid-10">
                              <div class="field-group">
                                <label>Clase:<br></label>   
                              <div class="field">
                                  <select  name="clase" id="clase" >
                                      <option value="">Seleccione..</option>
                                      <option value="ClaseI">Clase I</option>
                                        <option value="ClaseII">Clase II</option>
                                        <option value="ClaseIII">Clase III</option>
                                        <option value="ClaseIV">Clase IV</option>
                                        <option value="ClaseV">Clase V</option>
                                    </select>
                                  <input id="auxiliar" style="display:none" value="<?=$clase?>" />
                                </div>
                                
                                <div class="field-group">
                                    <label for="date">Gerencia Requiriente:</br></label>   
                                    <div class="field">
                                   <input type="text" name="gerencia" id="gerencia" size="22" value="<?php echo $gerencia;?>" disabled/>
                                    </div>
                                </div>
                                <div class="field-group">
                                    <label for="required">Nombre de la Obra/Actividad:</br></label>   
                                    <div class="field">
                                   <input type="text" name="nombre_obra" id="nombre_obra" size="24" value="<?php echo $obra;?>" disabled/>	
                                    </div>
                                </div>
                                
                                <div class="field-group">
                                    <label for="required">Estatus del Tramite:</br></label>   
                                    <div class="field">
                                   <select  name="estatus" id="estatus" value="<?php echo $estatus;?>">
                                       <option value="">Seleccione</option>
                                    <option value="EN ELABORACIÓN">En Elaboración</option>
                                    <option value="ENTREGADO">Entregado</option>
                                    </select>
                                        <input id="estatusauxi" style="display:none" value="<?=$estatus?>" />
                                    </div>
                                </div>
                            </div>
                         
                              </div>
                                <div class="grid-2">
                                </div>
                                <div class="grid-10">
                                 <div class="field-group">
                                    <label for="datepicker">Fecha de Ingreso:<br></label>   
                                    <div class="field">
                                    <input type="date" name="fecha_ing" id="datepicker" size="14"   value="<?php echo $fecha_ing;?>" disabled/>
                                    </div>
                                </div>
                                <div class="field-group">
                                    <label for="required">Responsable del Requerimiento:</br></label>   
                                    <div class="field">
                                   <input type="text" name="responsable_req" id="responsable_req" size="22" value="<?php echo $responsable;?>" disabled/>
                                    </div>
                                </div>
                             
                                <div class="field-group">
                                    <label for="required">Documentos Entregados:</br></label>   
                                    <div class="field">
                                        <input type="checkbox"name="alcance" id="alcance" value="1" size="14" <?php echo $documentos[0]=="1" ? "checked disabled" : '';?>/>&nbsp;&nbsp;Alcance del Proyecto</br>
                                   <input type="checkbox" name="memoriad" id="memoriad" value="1" size="14" <?php echo $documentos[1]=="1" ? "checked disabled" : '';?> />&nbsp;&nbsp;Memoría Descriptiva</br>
                                   <input type="checkbox" name="computos" id="computos" value="1" size="14" <?php echo $documentos[2]=="1" ? "checked disabled" : '';?>/>&nbsp;&nbsp;Computos Metricos</br>
                                   <input type="checkbox" name="especificaciones" id="especificaciones" value="1" size="14" <?php echo $documentos[3]=="1" ? "checked disabled" : '';?>/>&nbsp;&nbsp;Especificaciones Tecnicas</br>
                                   <input type="checkbox" name="planos" id="planos" value="1" size="14" <?php echo $documentos[4]=="1" ? "checked disabled" : '';?>/>&nbsp;&nbsp;Planos</br>
                                   <input type="checkbox" name="anexos" id="anexos" value="1" size="14" <?php echo $documentos[5]=="1" ? "checked disabled" : '';?>/>&nbsp;&nbsp;Anexos</br>
                                   <input type="text" name="documento_anterior" id="documento_anterior" value="<?php echo $documentose ?>" style="display:none"/>
                                    
                                    </div>
                                </div>
                                 </div>
                                  
                         
                            
                         
                            

<div class="grid-24" align="center">
<table >
  <tr>
    <td>
<div id="cargador" style="display:none;font-size:14px"> <img src="src/images/loaders/indicator-big.gif" width="10" height="10" /> Cargando </div> 
<div id="cargador_2" style="display:none;font-size:14px"> <img src="src/images/loaders/indicator-big.gif" width="10" height="10" /> Cargando </div>

</td>
  </tr>
  <tr>
      <td align="center"><button type="submit" name="enviar" class="btn btn-primary">Enviar</button></td>
      <td align="center"><button type="button" name="Atras" onclick="javascript:window.history.back();" class="btn btn-error"/>Regresar</button></td>
  </tr>
</table>
</div>


</form>
    
</div>
</div>
</div>
      <div class="grid-8">				
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
            <?php
            _adios_mysql();
            ?>
</div>
    
        </div>
</div>

</div>


<script type="text/javascript">
   window.onload =function (){
       selectcombo("auxiliar", "clase");
       selectcombo("estatusauxi", "estatus");
       
   }
   function selectcombo (origen, destino){
       $("#"+destino+"").val($("#"+origen+"").val());

    }
   
    function validarForm(formulario) {

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
  if(formulario.responsable_req.value.length==0) { //¿Tiene 0 caracteres?
    formulario.responsable_req.focus();    // Damos el foco al control
    alert('Debe ingresar el responsable del requerimiento'); //Mostramos el mensaje
    return false; //devolvemos el foco
  }
  if(formulario.nombre_obra.value.length==0) { //¿Tiene 0 caracteres?
    formulario.nombre_obra.focus();    // Damos el foco al control
    alert('Debe ingresar el nombre de la Obra/Actividad'); //Mostramos el mensaje
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
javascript
</script>






