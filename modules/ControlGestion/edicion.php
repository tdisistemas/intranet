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

    <h2>Modificar Usuario</h2>
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
        $punto_cuenta = $reg[1];
        $tiposoli = $reg[2];
        $monto = $reg[3];
        $estatus = $reg[4];
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
    $punto_cuenta = $_POST["punto_cuenta"];
    $tiposoli = $_POST["tipo_soli"];
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
       
  $sql="UPDATE control_gestion2 SET tipo_solicitud='".$tiposoli."', monto='".$monto."', "
          . "estatus2='".$estatus."', gerente_costo='".$gerente_costo."', enviado_presidencia='".$enviado_presi."', "
          . "recibido_presidencia='".$recibido_presi."',instruccion='".$instrucciones."', fecha_egreso='".$fecha_egreso."',"
          . "entregado='".$entregado."', observaciones='".$observaciones."' WHERE id_cgestion2=".$id;
  
  $result = mysql_query($sql) or die('Error al Modificar Registro ' . mysql_error());
  
  if($result){
    notificar("Perfil modificado con exito" ,"dashboard.php?data=consultar&flag=1&$parametro", "notify-success");
  }
  else { 
    die(mysql_error());
  }			
}
?>

<div class="container">
    <div class="grid-24">
        <div class="widget">
            <div class="widget-content">

                <form class="form uniformForm validateForm" name="from_envio_mi" method="post" action="#" >

                    <div class="field-group">
                        <label for="NombreUser">Punto de Cuenta:</label>
                        <div class="field">
                            <input type="text"  name="punto_cuenta" id="NombreUser" size="32"  value="<?php echo $punto_cuenta; ?>" />	
                        </div>
                    </div> <!-- .field-group -->

                    <div class="field-group">
                        <label for="CedulaUser">Tipo de Solicitud:</label>
                        <div class="field">
                            <input type="text" name="tipo_soli" id="CedulaUser" size="32"  value="<?php echo $tiposoli; ?>" />
                        </div>
                    </div> <!-- .field-group -->

                    <div class="field-group">
                        <label for="CorreoUser">Monto:</label>
                        <div class="field">
                            <input id="CorreoUser" name="monto" size="32"  value="<?php echo $monto; ?>">
                        </div>
                    </div> <!-- .field-group -->
                     <div class="field-group">
                        <div class="field-group ">
                        <label>Estatus del Tramite:<br></label>   
                        <select  name="estatus" id="estatus" style="width:130px">
                        <option>Seleccione</option>
                        <option value="R">Revisión</option>
                        <option value="ET">En tramite</option>
                        <option value="D">Devuelto</option>
                        <option value="E">Entregado</option>
                        </select>
                        </div>
                    </div> <!-- .field-group -->
                     <div class="field-group">
                        <label for="CorreoUser">VoBo Gerente de Costos:</label>
                        <div class="field">
                            <input id="CorreoUser" name="gerente_costo" size="32"  value="<?php echo $gerente_costo; ?>">
                        </div>
                    </div> <!-- .field-group -->
                     <div class="field-group">
                        <label for="CorreoUser">Enviado de Presidencia:</label>
                        <div class="field">
                            <input id="CorreoUser" name="enviado_presi" size="32"  value="<?php echo $enviado_presi; ?>">
                        </div>
                    </div> <!-- .field-group -->
                     <div class="field-group">
                        <label for="CorreoUser">Recibido de Presidencia:</label>
                        <div class="field">
                            <input id="CorreoUser" name="recibido_presi" size="32"  value="<?php echo $recibido_presi; ?>">
                        </div>
                    </div> <!-- .field-group -->
                     <div class="field-group">
                        <label for="CorreoUser">Instrucción:</label>
                        <div class="field">
                            <input id="CorreoUser" name="instruccion" size="32"  value="<?php echo $instrucciones; ?>">
                        </div>
                    </div> <!-- .field-group -->
                     <div class="field-group">
                        <label for="CorreoUser">Fecha de Egreso:</label>
                        <div class="field">
                            <input id="CorreoUser" name="fecha_egreso" size="32"  value="<?php echo $fecha_egreso; ?>">
                        </div>
                    </div> <!-- .field-group -->
                     <div class="field-group">
                        <label for="CorreoUser">Entregado a:</label>
                        <div class="field">
                            <input id="CorreoUser" name="entregado" size="32"  value="<?php echo $entregado; ?>">
                        </div>
                    </div> <!-- .field-group -->
                    <div class="field-group">
                        <label for="CorreoUser">Observaciones:</label>
                        <div class="field">
                            <input id="CorreoUser" name="observaciones" size="32"  value="<?php echo $observaciones; ?>">
                        </div>
                    </div> <!-- .field-group -->
                    

                    <input type="hidden" name="id_cgestion2" value="<?php echo $id; ?>" />

                    <div class="actions" style="text-aling:right">
                        <button name="Submit" type="submit" onclick="javascript:window.history.back(5);" class="btn btn-error">Modificar Registro</button>
                        <input type="button" name="Atras" onclick="javascript:window.history.back();" class="btn btn-error" value="Regresar" />
                    </div> <!-- .actions -->
                </form>


            </div> <!-- .widget-content -->

        </div> <!-- .widget -->	
    </div>
</div> <!-- .container -->


