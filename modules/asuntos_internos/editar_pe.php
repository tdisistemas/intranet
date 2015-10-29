<?php error_reporting( E_ALL ); ?>
<?php 
	if (array_pop(explode('/', $_SERVER['PHP_SELF']))!='dashboard.php') {header("Location: ../../dashboard.php");}
	if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {notificar("Usted no tiene permisos para esta Seccion/Modulo", "dashboard.php?data=notificar", "notify-error");} 
	_wm($usuario_datos[9],'Acceso Autorizado en: '.ucwords(array_pop(explode('/', __dir__))),'S/I');
	if (!$_GET['flag']){ir('dashboard.php?data=perfiles');}  
?>

<div id="contentHeader">
<h2>Agregar Perfil de Usuario</h2>
</div> <!-- #contentHeader -->	

<?php 

if (@$_POST['perfil']){
  
  decode_get2($_SERVER["REQUEST_URI"],2);
  $id = _antinyeccionSQL($_GET['id']);
   
  $perfil=$_POST["perfil"];
  $dperfil=$_POST["dperfil"];
  $permisos = serialize($_POST["checkboxvar"]);
    
  _bienvenido_mysql();
  
  $sql="UPDATE perfiles SET perfil='".$perfil."', dperfil='".$dperfil."', role='".$permisos."' WHERE id=".$id;
  
  $result = mysql_query($sql) or die('Error al Modificar Registro ' . mysql_error());
  
  if($result){
    notificar("Perfil modificado con exito", "dashboard.php?data=perfiles", "notify-success");
  }
  else {
    die(mysql_error());
  }			
}
else { 
  decode_get2($_SERVER["REQUEST_URI"],2);
  $id = _antinyeccionSQL($_GET['id']);

  _bienvenido_mysql();

  $sql  = "SELECT ";
  $sql .= "* ";
  $sql .= "FROM ";
  $sql .= "perfiles ";
  $sql .= "WHERE id='".$id."'";

  $perfil_qry = mysql_query ($sql) or die("Error en Query " . mysql_error());

  $reg=mysql_fetch_array($perfil_qry);

  $num_rows = mysql_num_rows($perfil_qry);

  if ($num_rows==1) {		
    $perfil = $reg['perfil'];
    $dperfil = $reg['dperfil'];
    $role = unserialize($reg['role']);     
  }		
  else {
    // SI NO ENCUENTRA REGISTROS SENCILLAMENTE ALGO PASO DEMACIADO RARO!
  }	
  _adios_mysql();
?>
<div class="container">
  <div class="row">
    <form class="form uniformForm validateForm" id="from_envio_pe" name="from_envio_pe" method="post" action="#" >
      <div class="grid-16">
        <div class="widget">
           <div class="widget-content">
              <div class="field-group">
                <label for="email">Perfil:</label>
                <div class="field">
                  <input type="text" name="perfil" id="perfil" size="32" class="validate[required]" value="<?php echo $perfil; ?>" />	
                </div>
              </div> <!-- .field-group -->
              <div class="field-group">
                <label for="date">Descripcion:</label>
                <div class="field">
                  <textarea name="dperfil" id="dperfil" rows="10" cols="50" class=""><?php echo $dperfil; ?></textarea>
                  <label for="date"></label>	
                </div>
              </div> <!-- .field-group -->
              <div class="actions" style="text-aling:right">
                <button name="Send" type="submit" class="btn btn-error">Modificar Perfil</button>
                <input type="button" name="Atras" onclick="javascript:window.history.back();" class="btn btn-error" value="Regresar" />
              </div> <!-- .actions -->
           </div> <!-- .widget-content -->
          </div> <!-- .widget -->	
        </div><!-- .grid -->	
        <div class="grid-8">				
          <div class="widget">			
            <div class="widget-header">
            <span class="icon-layers"></span>
              <h3>Modulos Instalados</h3>
            </div>
            <div style="float:right;font-size:80%;margin: 5px 5px 10px 0;">  <a href="#" class="seleccciona">Marcar todos</a> | <a href="#" class="resetea">Marcar ninguno</a> </div>
            <div class="widget-content">
              <div class="field-group control-group">	
                <?php 
                $modulos = listarmodulos();
                $tamanio = count($modulos);
                for ($x=0;$x<$tamanio; $x++){ ?>
                <div class="field">
                  <div class="checker" id="uniform-<?php echo $modulos[$x]; ?>">
                    <span>
                      <input type="checkbox" name="checkboxvar[]" id="checkbox-<?php echo $modulos[$x]; ?>" value="<?php echo $modulos[$x]; ?>" <?php echo $habilito; ?> />
                    </span>
                  </div>
                  <label for="checkbox-<?php echo $modulos[$x]; ?>"><?php echo $modulos[$x]; ?></label>
                </div>
                <?php } 
                $cuantoroles = count($role);   
                for ($x=0;$x<$cuantoroles; $x++){   
                  echo '<script language="javascript">document.getElementById("checkbox-'.$role[$x].'").checked=true;</script>';
                } ?>
              </div>
           </div>
         </div>					
        </div> <!-- .grid -->	
      </form>
  </div><!-- .row -->
</div> <!-- .container -->
<?php } ?>