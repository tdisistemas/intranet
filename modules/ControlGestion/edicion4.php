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

    <h2>Edición de Puntos de Cuenta</h2>
</div> <!-- #contentHeader -->	

<?php
       
    decode_get2($_SERVER["REQUEST_URI"], 2);
    $id = _antinyeccionSQL($_GET["np"]);
       _bienvenido_mysql();
   $segunda_fase = mysql_query("SELECT  fecha_aprobado, envio_pdc, recibido_pdc, instruccion, entregado,fecha_egreso, estatus2, observaciones  FROM `gc_control_gestion2`
                    WHERE  `id_cgestion2` = '$id' ");
 
   $editar_ec=  mysql_fetch_array($segunda_fase);


if (isset($_POST['enviar'])) {
    
    $id_2 = $_POST["id_cgestion2"];
    $fecha_aprobado = $_POST["fecha_aprobado"];
    $enviado_pdc = $_POST["enviado_pdc"];
    $recibido_pdc = $_POST["recibido_pdc"];
    $instruccion = $_POST["instruccion"];
    $observaciones = $_POST["observaciones"];
    $entregado = $_POST["entregado"];
    $fecha_egreso = $_POST["fecha_egreso"];
    $estatus2 = $_POST["estatus2"];
   
    $parametro = 'np=' . $id_2;
    $parametro = _desordenar($parametro);
       
 
 $sql="UPDATE gc_control_gestion2 SET  ". "fecha_aprobado='".$fecha_aprobado."', ". "envio_pdc='".$enviado_pdc."', ". "recibido_pdc='".$recibido_pdc."', ". "instruccion='".$instruccion."', ". "observaciones='".$observaciones."', ". "entregado='".$entregado."', ". "entregado='".$entregado."', ". "fecha_egreso='".$fecha_egreso."', ". "estatus2='".$estatus2."'  WHERE id_cgestion2=".$id;
  $result = mysql_query($sql) or die('Error al Modificar Registro ' . mysql_error());
  
  if($result){
    notificar("Punto de Cuenta modificado con exito" ,"dashboard.php?data=puntoc", "notify-success");
  }
  else { 
    die(mysql_error());
  }			
}
?>
<div class="container">
    <div class="row">
        <div class="grid-16">
            <div class="widget">
                <div class="widget-header"  > <span class="icon-folder-fill"></span>
                    <h3>Edición del punto de cuenta</h3>
                </div>

                <div class="widget-content">
                    <div class="row">
                        <form class="form validateForm" action="#" method="post"  onsubmit="return validarForm(this)" >
                            
                            <div class="grid-2">
                            </div>
                            <div class="grid-8">
                              <div class="field-group">
                                    <label>Fecha de Aprobación:<br></label>   
                                    <div class="field">
                                    <input type="date" name="fecha_aprobado" id="datepicker" size="14"  placeholder="Fecha de Aprobación" value="<?php echo $editar_ec['fecha_aprobado'];?>"/>
                                    </div>
                                </div>
                                
                             
                                <div class="field-group">
                                    <label for="date">Instrucción del Presidente:</br></label>   
                                    <select  name="instruccion" id="instru" value="<?php echo $editar_ec['instruccion'];?>">
                                       <option value="">Seleccione</option>
                                    <option value="APROBADO">Aprobado</option>
                                    <option value="RECHAZADO">Rechazado</option>
                                    </select>
                                <input id="instruccionauxi" style="display:none" value="<?php echo $editar_ec['instruccion'];?>" />
                                </div>
                               
                              <div class="field-group"></br>
                                    <label for="required">Estatus:</br></label>   
                                    <div class="field">
                                   <select  name="estatus2" id="estatus2" value="<?php echo $editar_ec['estatus2'];?>">
                                       <option value="">Seleccione</option>
                                    <option value="REVISIÓN">Revisión</option>
                                    <option value="EN TRAMITE">En Tramite</option>
                                    <option value="DEVUELTO">Devuelto</option>
                                    <option value="ENTREGADO">Entregado</option>
                                    </select>
                                    </div>
                                    <input id="estatus2auxi" style="display:none" value="<?php echo $editar_ec['estatus2'];?>" />
                                </div>
                                
                            </div>
                            <div class="grid-6">
                                
                                 <div class="field-group">
                                    <label>Fecha de Envio:<br></label>   
                                    <div class="field">
                                    <input type="date" name="enviado_pdc" id="datepicker1" size="14"  placeholder="Enviado a Presidencia" value="<?php echo $editar_ec['envio_pdc'];?>"/>
                                    </div>
                                </div>
                                
                                 <div class="field-group">
                                    <label for="required">Fecha de Egreso:</br></label>   
                                   <div class="field">
                                    <input type="date" name="fecha_egreso" id="datepicker3" size="14"  placeholder="Fecha de Egreso" value="<?php echo $editar_ec['fecha_egreso'];?>"/>
                                    </div>
                                </div>
                                 
                                
                            </div>
                            
                            <div class="grid-6">
                                <div class="field-group">
                                    
                                   <label>Fecha de Recepción:<br></label>   
                                    <div class="field">
                                    <input type="date" name="recibido_pdc" id="datepicker2" size="14"  placeholder="Recibido de Presidencia" value="<?php echo $editar_ec['recibido_pdc'];?>"/>
                                    </div>
                                    </div>
                               
                       
                                 <div class="field-group">
                                    <label for="required">Entregado a:</br></label>   
                                    <div class="field">
                                   <input type="text" name="entregado" id="responsable_req" size="14" placeholder="Entregado a"onChange="conMayusculas(this)" value="<?php echo $editar_ec['entregado'];?>"/>
                                    </div>
                                </div>
                                
                                
                            </div>
                          <div class="grid-24" align="center" >
                                <div class="field-group">
                                    <label for="required">Observaciones:</br></label>   
                                    <div class="field">
                                        <textarea type="text" name="observaciones" id="observaciones" cols="50" rows="5"  placeholder="Ingrese las observaciones" onChange="conMayusculas(this)"><?php echo $editar_ec['observaciones'];?></textarea>
                                    </div>
                                </div>
                            </div> 
                            </div>
                          
                                
                                <div class="grid-24" align="center">
                                    <table >
                                        
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
        </div>
 <div class="grid-8">				
        <div class="widget">			
          <div class="widget-header">
          <span class="icon-layers"></span>
            <h3></h3>
          </div>
          <div class="widget-content">
            <h3>Estimado, <?php echo $usuario_datos[1] . ' ' . $usuario_datos[2]  ; ?></h3>
            <p>En esta sección podrán editar los puntos de cuenta que fueron generados al momento de crear los servicios.</p>
            <!-- .pad -->
            </div>  
           
          </div>
        </div>    
</div>
   
</div>
</div>
<script type="text/javascript">
    window.onload =function (){
       selectcombo("instruccionauxi", "instru");
       selectcombo("estatus2auxi", "estatus2");
       
   }
   function selectcombo (origen, destino){
       $("#"+destino+"").val($("#"+origen+"").val());

    }
    function validarForm(formulario) {

  if(formulario.tipo_soli.value.length==0) { //¿Tiene 0 caracteres?
    formulario.tipo_soli.focus();    // Damos el foco al control
    alert('Debe seleccionar el Tipo de solicitud'); //Mostramos el mensaje
    return false; //devolvemos el foco
  }
   if(formulario.monto.value.length==0) { //¿Tiene 0 caracteres?
    formulario.monto.focus();    // Damos el foco al control
    alert('Debe ingresar un Monto'); //Mostramos el mensaje
    return false; //devolvemos el foco
  }
  
   }
  $(function () {
$.datepicker.setDefaults($.datepicker.regional["es"]);
$("#datepicker").datepicker({
dateFormat: 'yy-mm-dd',
changeMonth: true,
changeYear: true,
yearRange: "1950:2014",
minDate: '0',
onSelect: function (fecha,event){$('#datepicker1').datepicker("option","minDate",fecha);}
});
});
$(function () {
$.datepicker.setDefaults($.datepicker.regional["es"]);
$("#datepicker1").datepicker({
dateFormat: 'yy-mm-dd',
changeMonth: true,
changeYear: true,
yearRange: "1950:2014",

});
});
$(function () {
$.datepicker.setDefaults($.datepicker.regional["es"]);
$("#datepicker2").datepicker({
dateFormat: 'yy-mm-dd',
changeMonth: true,
changeYear: true,
yearRange: "1950:2014",
minDate: '0',
onSelect: function (fecha,event){$('#datepicker3').datepicker("option","minDate",fecha);}
});
});
$(function () {
$.datepicker.setDefaults($.datepicker.regional["es"]);
$("#datepicker3").datepicker({
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


