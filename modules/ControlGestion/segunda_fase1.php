<?php
//alerta('Modulo Deshabilitado por codigo');
//ir('dashboard.php');
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

    <?php 
decode_get2($_SERVER["REQUEST_URI"], 2);
    $id = _antinyeccionSQL($_GET["np"]);
//decode_get2($_SERVER["REQUEST_URI"],1);  ?>
    
    <h2>Segunda Fase del Proyecto</h2>
</div> <!-- #contentHeader -->	

<?php
if (isset($_POST['enviar'])) {

    $id_cgestion2 = $_POST['id_cgestion2'];
    $tipo_soli = $_POST['tipo_soli'];
    $monto1 = $_POST['monto1'];
    $monto2 = $_POST['monto2'];
    $monto3 = $_POST['monto3'];
    $deviacion = $_POST['deviacion'];
    

    $sql = mysql_query("SELECT caracteristicas, conse 
    FROM `control_conse`
    WHERE `caracteristicas` = '$tipo_soli'");

    while ($row = mysql_fetch_array($sql)) {

        $caracteristica = $row['caracteristicas'];
        $conse = $row['conse'];
    }
    
    $correlativo=(explode('-',$id));
    $ano = date('Y');
    $actual = (explode("20", $ano));
    $conse1 = $conse + 1;
    $consecutivo = mysql_query("update control_conse set conse='" . $conse1 . "' where caracteristicas='$tipo_soli' ");
    $pdc = $caracteristica .'-'. $id. '-00'.$conse1.'-' . $actual[1] ;
    $status = mysql_query("update control_gestion set estatus_servi=2 where n_proceso='$id' ");
    
    $sql = "INSERT INTO `control_gestion2` (punto_cuenta,`tipo_solicitud`,montoec,`montooc`, `deviacion`, `montoate`, n_proceso) VALUES"
            . " ('" . $pdc . "','" . $tipo_soli . "','" . $monto1 . "','" . $monto2 . "', '" . $deviacion . "','" . $monto3 . "', '" . $id . "')";
    $result = mysql_query($sql);
    if ($result) {
        notificar("Segunda Fase del Proceso Ingresada con exito", "dashboard.php?data=controlg", "notify-success");
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
                            
                            <div class="grid-4">
                            </div>
                            <div class="grid-8">
                                <div class="field-group">
                                    <label>Tipo de Solicitud:<br></label>   
                                    <div class="field">
                                    <select name="tipo_soli" id="tipo_soli" style="width:130px" >
                                        <option value="">Seleccione</option>
                                    <option value="ATE">Análisis Técnico- Económico</option>
                                    
                                </select>
                                    </div>
                                </div>
                                <div class="field-group">
                                    <label for="required">Monto Oferta Comercial:</br></label>   
                                    <div class="field">
                                   <input type="text" name="monto2" id="monto2" size="16" placeholder="Monto Bsf OC."/>
                                    </div>
                                </div>
                              
                                  <div class="field-group">
                                    <label for="required">Monto ATE:</br></label>   
                                    <div class="field">
                                   <input type="text" name="monto3" id="monto3" size="16" placeholder="Monto Bsf ATE."/>
                                    </div>
                                </div>
                            </div>
                   
                            <div class="grid-12">
                                <div class="field-group">
                                    <label for="required">Monto Estimación de Costo:</br></label>   
                                    <div class="field">
                                   <input type="text" name="monto1" id="monto1" size="16" placeholder="Monto Bsf EC."/>
                                    </div>
                                </div>
                                  <div class="field-group">
                                    <label for="required">Deviación:</br></label>   
                                    <div class="field">
                                   <input type="text" name="deviacion" id="deviacion" size="16" placeholder="% de Deviación."/>
                                    </div>
                                </div>
                             
                                
                            </div>
                          
               
                                <div class="grid-24" align="center">
                                    <table >
                                        
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
javascript</script>
