<?php
//alerta('Modulo Deshabilitado por codigo');
//ir('dashboard.php');
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

    <?php 
    decode_get2($_SERVER["REQUEST_URI"], 2);
    $id = _antinyeccionSQL($_GET["np"]);
//decode_get2($_SERVER["REQUEST_URI"],1);  ?>
    
    <h2>Segunda Fase del Proyecto</h2>
</div> <!-- #contentHeader -->	

<?php
 $montoec = mysql_query("SELECT montoec FROM `gc_control_gestion2`
                    WHERE `n_proceso` = '$id'");
 $monto=  mysql_fetch_array($montoec);

 
                    
if (isset($_POST['enviar'])) {

    $id_cgestion2 = $_POST['id_cgestion2'];
    $tipo_soli = $_POST['tipo_soli'];
    $monto1 = $_POST['monto1'];
    $monto2 = $_POST['monto2'];
    $monto3 = $_POST['monto3'];
    $deviacion = $_POST['deviacion'];
    $valipdc=  isset($_POST['pdc']) ? $_POST['pdc']:'0';
    $validarpdc= $valipdc;
     $sql = mysql_query("SELECT * FROM `gc_control_gestion2`
                    WHERE `n_proceso` = '$id'
                    AND `tipo_solicitud` = '$tipo_soli'
                    ORDER BY `servicio` DESC
                    LIMIT 1 ");

    while ($row = mysql_fetch_array($sql)) {

        
        $conse = $row['servicio'];
       
    }
    $conse1 = $conse + 1; 
    
    $correlativo=(explode('-',$id));
    $ano = date('Y');
    $actual = (explode("20", $ano));
   

    
    $status = mysql_query("update gc_control_gestion set estatus_servi=3 where n_proceso='$id' ");
    
    if ($validarpdc>0){
        
         $sql = mysql_query("SELECT caracteristicas, conse 
            FROM `gc_controlconse`
            WHERE `caracteristicas` = 'PDC'");

    while ($row = mysql_fetch_array($sql)) {
    
    $caracteristica = $row['caracteristicas'];
    $conse2  = $row['conse'];

}

$ano = date('Y');
$actual=(explode("20",$ano));
$conse3=$conse2+1;
$consecutivo=mysql_query("update gc_controlconse set conse='".$conse3."' where caracteristicas='PDC' ");
$punto_cuenta = $caracteristica . '-00'.$conse2.'-' . $actual[1] ;
    }
    
    $sql = "INSERT INTO `gc_control_gestion2` (servicio,`tipo_solicitud`,`montoec`,`montooc`, `deviacion`, `montoate`, punto_cuenta, n_proceso, validacion_pdc) VALUES"
            . " ('" . $conse1 . "','" . $tipo_soli . "','" . $monto1 . "','" . $monto2 . "', '" . $deviacion . "','" . $monto3 . "','" . $conse3 . "', '" . $id . "', '" . $validarpdc . "')";
    $result = mysql_query($sql);
    
    if ($result) {
        notificar("Análisis Técnico- Económico ingresado con exito", "dashboard.php?data=controlg", "notify-success");
    } else {
        if ($SQL_debug == '1') {
            die('Error en Agregar Registro - 02 - Respuesta del Motor: ' . mysql_error());
        } else {
            die('Error en Agregar Registro');
        }
    }
}
?>


<!-- #contentHeader -->
<div class="container">
    <div class="row">
        <div class="grid-16">
            <div class="widget">
                <div class="widget-header"  > <span class="icon-folder-fill"></span>
                    <h3>Segunda Fase del Proyecto</h3>
                </div>

                <div class="widget-content">
                    <div class="row">
                        <form class="form validateForm" action="#" method="post"  onsubmit="return validarForm(this)" >
                            
                            
                            <div class="grid-8">
                                <div class="field-group">
                                    <label>Tipo de Solicitud:<br></label>   
                                    <div class="field">
                                    <select name="tipo_soli" id="tipo_soli" style="width:160px" >
                                        
                                        <option value="ATE" selected>Análisis Técnico- Económico</option>
                                    
                                </select>
                                    </div>
                                </div>
                                 <div class="field-group">
                                    <label for="required">Monto ATE:</br></label>   
                                    <div class="field">
                                   <input type="text" name="monto3" id="monto3" size="16" placeholder="Monto Bsf ATE." onkeypress="return isNumberKey(event)"/>
                                    </div>
                                </div>
                              
                                 
                               <div class="field-group">
                                    <label for="required">Generar Punto de Cuenta:</br></label>   
                                    <div class="field">
                                        <input type="checkbox" name="pdc" id="pdc" size="16" value="1" checked />
                                       
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="grid-8">
                                <div class="field-group">
                                    <label for="required">Monto Estimación de Costo:</br></label>   
                                    <div class="field">
                                        <input type="text" name="monto1" id="monto1" size="16" value="<?php echo $monto['montoec'];?>" readonly/>
                                    </div>
                                </div>
                                  <div class="field-group">
                                    <label for="required">Desviación:</br></label>   
                                    <div class="field">
                                   <input type="text" name="deviacion" id="deviacion" size="16" placeholder="% de Deviación."  onkeypress="return valido(event)"/>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="grid-8">
                            <div class="field-group">
                                    <label for="required">Monto Oferta Comercial:</br></label>   
                                    <div class="field">
                                   <input type="text" name="monto2" id="monto2" size="16" placeholder="Monto Bsf OC." onkeypress="return isNumberKey(event)"/>
                                    </div>
                                </div>
                            <div class="field-group">
                                    <label for="datepicker">Enviado a Presidencia:</br></label>   
                                    <div class="field">
                                        <input id="datepicker" name="enviado_presi" size="14" readonly>
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
    </div>
    <div class="grid-8">				
        <div class="widget">			
          <div class="widget-header">
          <span class="icon-layers"></span>
            <h3></h3>
          </div>
          <div class="widget-content">
            <h3>Estimado, <?php echo $usuario_datos[1] . ' ' . $usuario_datos[2]  ; ?></h3>
            <p>En esta sección podrá ingresar los datos de la segunda fase del proceso</p>
            <!-- .pad -->
            </div>  
           
          </div>
        </div>
</div>
</div>
<script type="text/javascript">
    function validarForm(formulario) {

  if(formulario.monto1.value.length==0) { //¿Tiene 0 caracteres?
    formulario.monto1.focus();    // Damos el foco al control
    alert('Debe ingresar la Estimación de Costo'); //Mostramos el mensaje
    return false; //devolvemos el foco
  }
   if(formulario.monto2.value.length==0) { //¿Tiene 0 caracteres?
    formulario.monto2.focus();    // Damos el foco al control
    alert('Debe ingresar la Oferta Comercial'); //Mostramos el mensaje
    return false; //devolvemos el foco
  }
  if(formulario.monto3.value.length==0) { //¿Tiene 0 caracteres?
    formulario.monto3.focus();    // Damos el foco al control
    alert('Debe ingresar el Análisis Técnio- Económico'); //Mostramos el mensaje
    return false; //devolvemos el foco
  }
  if(formulario.datepicker.value.length==0) { //¿Tiene 0 caracteres?
    formulario.datepicker.focus();    // Damos el foco al control
    alert('Debe seleccionar la fecha de envio a presidencia '); //Mostramos el mensaje
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
$(function () {
$.datepicker.setDefaults($.datepicker.regional["es"]);
$("#datepicker1").datepicker({
dateFormat: 'yy-mm-dd',
changeMonth: true,
changeYear: true,
yearRange: "1950:2014"
});
});
$(function () {
$.datepicker.setDefaults($.datepicker.regional["es"]);
$("#datepicker2").datepicker({
dateFormat: 'yy-mm-dd',
changeMonth: true,
changeYear: true,
yearRange: "1950:2014"
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
$(function () {
$.datepicker.setDefaults($.datepicker.regional["es"]);
$("#datepicker4").datepicker({
dateFormat: 'yy-mm-dd',
changeMonth: true,
changeYear: true,
yearRange: "1950:2014"
});
});
function conMayusculas(field) {
field.value = field.value.toUpperCase()
}
 function isNumberKey(evt)
  {
     var charCode = (evt.which) ? evt.which : event.keyCode
     if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
         return true;
  }
  
  function valido(e){
  tecla = (document.all) ? e.keyCode : e.which;
  tecla = String.fromCharCode(tecla)
  return /^[0-9\%]+$/.test(tecla);
}
javascript</script>
