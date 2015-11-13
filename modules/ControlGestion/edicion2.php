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
    $result = mysql_query("SELECT * FROM control_gestion2 WHERE id_cgestion2 = " . $id);
    $reg = mysql_fetch_array($result);
$parametros = 'id=' . $id;
 $parametros = _desordenar($parametros);
    $num_rows = mysql_num_rows($result);

    if ($num_rows == 1) {
        $id_2 = $reg["id_cgestion"];
        $punto_cuenta1 = $reg["punto_cuenta"];
        $tiposoli = $reg[2];
        $monto = $reg[3];
        $estatu = $reg[4];
        $gerente_costo = $reg[5];
        $enviado_presi = $reg[6];
        $recibido_presi = $reg[7];
        $instrucciones = $reg[8];
        $fecha_egreso = $reg[9];
        $entregado = $reg[10];
        $observaciones = $reg[11];
    } else {
        notificar("No Existen Registros", "dashboard.php?data=consultar", "notify-error");
    }
if (isset($_POST['Submit'])) {
    
    $id = $_POST["id_cgestion2"];
    $punto_cuenta=$_POST["punto_cuenta"];
    $monto = $_POST["monto"];
    $estatus = $_POST["estatus"];
    $gerente_costo = $_POST["gerente_costo"];
    $enviado_presi = $_POST["enviado_presi"];
    $recibido_presi = $_POST["recibido_presi"];
    $instrucciones = $_POST["instruccion"];
    $fecha_egreso = $_POST["fecha_egreso"];
    $entregado = $_POST["entregado"];
    $observaciones = $_POST["observaciones"];
    $parametro = 'np=' . $id_2;
    $parametro = _desordenar($parametro);
       
 $auditoria=mysql_query("INSERT INTO `control_auditoria` ( `usuario`, antes,`accion`, `cambio`, `n_proceso`,`punto_cuenta`) VALUES ('$usuario_datos[9]', '$estatu', 'Update', '$estatus','$id_2', '$punto_cuenta1')");  
 $sql="UPDATE control_gestion2 SET  punto_cuenta='".$punto_cuenta."',monto='".$monto."', "
          . "estatus2='".$estatus."', gerente_costo='".$gerente_costo."', enviado_presidencia='".$enviado_presi."', "
          . "recibido_presidencia='".$recibido_presi."',instruccion='".$instrucciones."', fecha_egreso='".$fecha_egreso."',"
          . "entregado='".$entregado."', observaciones='".$observaciones."' WHERE id_cgestion2=".$id;
  
  $result = mysql_query($sql) or die('Error al Modificar Registro ' . mysql_error());
  
  if($result){
    notificar("Segunda Fase Modificada con Exito" ,"dashboard.php?data=consultar2&flag=1&$parametro", "notify-success");
  }
  else { 
    die(mysql_error());
  }			
}
?>
<!-- #contentHeader -->
<div class="container">
    <div class="row">
        <div class="grid-17">
            <div class="widget">
                <div class="widget-header"  > <span class="icon-folder-fill"></span>
                    <h3>Edición de la Segunda Fase <?php echo $id_2 ?></h3>
                </div>

                <div class="widget-content">
                    <div class="row">
                        <form class="form validateForm" action="#" method="post">

                            <div class="grid-24">
                              
                                                                
                             <div class="field-group" align="center">
                                    <label for="required">Punto de Cuenta:</label>    
                                    <div class="field">
                                        <input type="text"  name="punto_cuenta" id="NombreUser" size="14"  value="<?php echo $punto_cuenta; ?>" />
                                    </div>
                                </div>
                          </div>
                            <div class="grid-3">
                            </div>
                            <div class="grid-6">
                                <div class="field-group">
                                    <label>Tipo de Solicitud:<br></label>   
                                    <div class="field">
                                        <input type="text" name="tipo_soli" id="CedulaUser" size="14"  value="<?php echo $tiposoli; ?>" disabled />
                                    </div>
                                </div>
                                <div class="field-group">
                                    <label for="datepicker">Enviado a Presidencia:</br></label>   
                                    <div class="field">
                                    <input id="datepicker" name="enviado_presi" size="14"  value="<?php echo $enviado_presi; ?>">
                                    </div>
                                </div>
                                
                                <div class="field-group">
                                    <label for="datepicker">Fecha de Egreso:</br></label> 
                                    <div class="field">
                                    <input type="date" name="fecha_egreso" id="datepicker1" size="14" placeholder="Enviado a presidencia" value="<?php echo $fecha_egreso; ?>"/>
                                    </div>
                                </div>
                            </div>
                            
                       
                     
                            <div class="grid-6">
                                <div class="field-group">
                                    <label for="required">Monto Bs.:</br></label>   
                                    <div class="field">
                                   <input type="text" name="monto" id="monto" size="14" value="<?php echo $monto; ?>"/>
                                    </div>
                                </div>
                                
                                <div class="field-group">
                                    <label for="datepicker">Recibido de Presidencia:</br></label>   
                                    <div class="field">
                                   <input type="date" name="recibido_presi" id="datepicker2" size="14"  value="<?php echo $recibido_presi; ?>" />
                                    </div>
                                </div>
                                
                                <div class="field-group">
                                    <label for="required">Entregado a:</br></label> 
                                    <div class="field">
                                   <input type="text" name="entregado" id="nombre_empre" size="14" placeholder="Nombre de la Empresa y/o Constructor" value="<?php echo $entregado; ?>"onChange="conMayusculas(this)"/>	
                                    </div>
                                </div>
                            </div>
                            
                            <div class="grid-6">
                                <div class="field-group">
                                    <label for="datepicker">Fecha de Aprobación:</br></label>   
                                    <div class="field">
                                   <input type="date" name="gerente_costo" id="datepicker3" size="14" value="<?php echo $gerente_costo; ?>" />
                                    </div>
                                </div>
                                <div class="field-group">
                                    <label>Instrucción Presidente:<br></label>      
                                    <div class="field">
                                   <select name="instruccion" id="instruccion" style="width:130px" value="<?php echo $instrucciones; ?>">
                                    <option>Seleccione</option>
                                    <option value="Aprobado">Aprobado</option>
                                    <option value="Rechazado">Rechazado</option>

                                </select>
                                    </div>
                                </div>
                          
                                <div class="field-group">
                                    <label>Estatus:<br></label>         
                                    <div class="field">
                                   <select  name="estatus" id="estatus" style="width:130px">
                                       <option value="">Seleccione</option>
                                        <option value="REVISIÓN">Revisión</option>
                                        <option value="EN TRAMITE">En tramite</option>
                                        <option value="DEVUELTO">Devuelto</option>
                                        <option value="ENTREGADO">Entregado</option>
                                    </select>
                                    </div>
                                </div>
                                
                            </div>
                                
                                <div class="grid-24">
                              
                                                                
                             <div class="field-group" align="center">
                                    <label for="required">Observaciones:</label>    
                                    <div class="field">
                                        
                                        <textarea name="observaciones" id="observaciones" cols="60" rows="4" onChange="conMayusculas(this)"><?php echo $observaciones; ?></textarea>
                  <label for="date"></label>	
                                    </div>
                                </div>
                          </div>

                            <input type="hidden" name="id_cgestion2" value="<?php echo $id; ?>" />

                                <div class="grid-24" align="center">
                                    <table >
                                        <tr>
                                            <td align="center">
                                                <div id="cargador" style="display:none;font-size:14px"> <img src="src/images/loaders/indicator-big.gif" width="10" height="10" /> Cargando </div> 
                                                <div id="cargador_2" style="display:none;font-size:14px"> <img src="src/images/loaders/indicator-big.gif" width="10" height="10" /> Cargando </div>

                                            </td>
                                        </tr>
                                        <tr>
                                            <div class="actions">
                                            
                                                <td align="center"><button type="submit" name="Submit" onclick="javascript:window.history.back(5);" class="btn btn-primary">Enviar</button></td>
                                            <td align="center"><button type="button" name="Atras" onclick="javascript:window.history.back();" class="btn btn-error"/>Regresar</button></td>
                                            </div>
                                            </tr>
                                    </table>
                                </div>


                        </form>
                    </div>
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
            <p>En esta sección podrá editar los datos de la segunda fase del proceso</p>
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

function conMayusculas(field) {
field.value = field.value.toUpperCase()
}
javascript</script>


