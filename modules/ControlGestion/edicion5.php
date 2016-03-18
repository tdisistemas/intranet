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
<style>
        .titulo {

        margin-top: 10px;
        font-weight: bold;
        font-size: 13px;
        color: #b22222;
    }
    </style>
    <?php //decode_get2($_SERVER["REQUEST_URI"],1);  ?>

    <h2>Edición de los Servicios</h2>
</div> <!-- #contentHeader -->	

<?php
       
    decode_get2($_SERVER["REQUEST_URI"], 2);
     $id = _antinyeccionSQL($_GET["id"]);
    $id_np = _antinyeccionSQL($_GET["np"]);
   _bienvenido_mysql();
  
       
       $tipo_soli =['tipo_solicitud'];
   $segunda_fase = mysql_query("SELECT  tipo_solicitud,servicio, montoec, enviado_presidencia, recibido_presidencia, recibido_por FROM `gc_control_gestion2` WHERE  `id_cgestion2`= $id");
   
   $editar_ec=  mysql_fetch_array($segunda_fase);
  
if (isset($_POST['enviar'])) {
    
    $id_2 = $_POST["id_cgestion2"];
    
    $recibido_presi = $_POST["recibido_presi"];
    
    $parametro = 'np=' . $id_2;
    $parametro = _desordenar($parametro);


$sql="UPDATE gc_control_gestion2 SET  ". "recibido_presidencia='".$recibido_presi."' WHERE id_cgestion2=".$id;

 $result = mysql_query($sql) or die('Error al Modificar Registro ' . mysql_error());
  
  if($result){
    notificar("Modificación realizada con exito","dashboard.php?data=consultar&flag=1&$parametro", "notify-success");
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
                    <h3><?php echo $editar_ec['tipo_solicitud'].'-00'.$editar_ec['servicio'].'-'.substr(date('Y'), -2) ;?></h3>
                </div>

                <div class="widget-content">
                    <div class="row">
                        <form class="form validateForm" action="#" method="post"  onsubmit="return validarForm(this)" >
                            
                            <div class="grid-4">
                            </div>
                            <div class="grid-8">
                                <div class="field-group">
                                    <div class="titulo">Tipo de Solicitud:</div>   
                                    <div class="field">
                                        <input type="text" name="tipo_soli" size="16" value="<?php echo $editar_ec['tipo_solicitud'];?>" disabled/>
                                    </div>
                                </div>
                                
                                 <div class="field-group">
                                     <div class="titulo">Fecha de Envio:</div>   
                                    <div class="field">
                                        <input type="text" name="enviado_presi" size="16" value="<?php echo $editar_ec['enviado_presidencia'];?>" disabled>
                                    </div>
                                </div>
                               
                            </div>
                   
                            <div class="grid-12">
                                <div class="field-group">
                                    <div class="titulo">Monto Estimación de Costo:</div>   
                                    <div class="field">
                                        <input type="text" name="monto1" id="monto1" size="16" value="<?php echo number_format($editar_ec['montoec'], 2, ',', '.');?>" disabled/><span style="font-size: 13px; font-weight: bold;"> Bs.f</span>
                                    </div>
                                </div>
                                  <div class="field-group">
                                      <div class="titulo">Fecha de Recepción:</div>   
                                    <div class="field">
                                        <input id="datepicker1" name="recibido_presi" size="14" value="<?php echo $editar_ec['recibido_presidencia'];?>"  readonly/>
                                    </div>
                                </div>
                                
                             
                                <input  name="id_cgestion2" style="display:none" value="<?php echo $id_np ?>">
                                <input  name="servicio" style="display:none">
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
            <p>En esta sección podrá editar los servicios que tienen los procesos.</p>
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
yearRange: "1950:2014",
minDate: '0',
onSelect: function (fecha,event){$('#datepicker1').datepicker("option","minDate",fecha);}
});
});

function conMayusculas(field) {
field.value = field.value.toUpperCase()
}
</script>
