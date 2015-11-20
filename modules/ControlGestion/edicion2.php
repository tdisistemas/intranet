<?php
if (array_pop(explode('/', $_SERVER['PHP_SELF'])) != 'dashboard.php') {
    header("Location: ../../dashboard.php");
}
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
    notificar("Usted no tiene permisos para esta Sección/Módulo", "dashboard.php?data=notificar", "notify-error");
    _wm($usuario_datos[9], 'Acceso Denegado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
}
_wm($usuario_datos[9], 'Acceso Autorizado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
?>

<div id="contentHeader">

    <?php //decode_get2($_SERVER["REQUEST_URI"],1);  ?>

    <h2>Edición de la Segunda Fase</h2>
</div> <!-- #contentHeader -->	

<?php
        
    decode_get2($_SERVER["REQUEST_URI"], 2);
    $id = _antinyeccionSQL($_GET["id"]);
    _bienvenido_mysql();
    $result = mysql_query("SELECT * FROM gc_control_gestion2 WHERE id_cgestion2 = " . $id);
    $reg = mysql_fetch_array($result);
    $parametros = 'id=' . $id;
    $parametros = _desordenar($parametros);
    $num_rows = mysql_num_rows($result);

    if ($num_rows == 1) {
        $id_2 = $reg["id_cgestion2"];
        $tiposoli = $reg[2];
        $montoec = $reg[3];
        $enviado_presi = $reg[10];
        $recibido_presi = $reg[11];
    } else {
        notificar("No Existen Registros", "dashboard.php?data=consultar", "notify-error");
    }
if (isset($_POST['enviar'])) {
    
    $id = $_POST["id_cgestion2"];
    $tipo_soli = $_POST['tipo_soli'];
    $monto1 = $_POST['monto1'];
    $enviado_presi = $_POST['enviado_presi'];
    $recibido_presi = $_POST['recibido_presi'];
    $parametro = 'np=' . $id_2;
    $parametro = _desordenar($parametro);
       
 
 $sql="UPDATE gc_control_gestion2 SET recibido_presidencia='".$recibido_presi."' WHERE id_cgestion2=".$id_2;
  
  $result = mysql_query($sql) or die('Error al Modificar Registro ' . mysql_error());
  
  if($result){
    notificar("Segunda Fase Modificada con Exito" ,"dashboard.php?data=consultar&flag=1&$id_2", "notify-success");
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
                                        <select name="tipo_soli" id="tipo_soli" style="width:130px" value="<?php echo $tiposoli;?>" disabled >
                                        
                                        <option value="EC" selected>Estimados de Costo</option>
                                    
                                </select>
                                    </div>
                                </div>
                                 <div class="field-group">
                                    <label for="datepicker">Enviado a Presidencia:</br></label>   
                                    <div class="field">
                                        <input id="enviadopresi" name="enviado_presi" size="14" value="<?php echo $enviado_presi;?>" disabled>
                                    </div>
                                </div>
                                
                            </div>
                   
                            <div class="grid-12">
                                <div class="field-group">
                                    <label for="required">Monto Estimación de Costo:</br></label>   
                                    <div class="field">
                                   <input type="text" name="monto1" id="monto1" size="16" placeholder="Monto Bsf EC." value="<?php echo $montoec;?>" disabled/>
                                    </div>
                                </div>
                                  <div class="field-group">
                                    <label for="datepicker">Recibido de Presidencia:</br></label>   
                                    <div class="field">
                                        <input id="datepicker1" name="recibido_presi" size="14">
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

function conMayusculas(field) {
field.value = field.value.toUpperCase()
}
javascript</script>


