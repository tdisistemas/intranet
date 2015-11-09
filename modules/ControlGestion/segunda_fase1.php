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

    <h2>Insertar Tipo de solicitud <?= $_GET["estatus"]; ?></h2>
</div> <!-- #contentHeader -->	

<?php
if (isset($_POST['enviar'])) {

    $id_cgestion2=$_POST['id_cgestion2'];
    $tipo_soli=$_POST['tipo_soli'];
    $monto=$_POST['monto'];
    $estatus2=$_POST['estatus'];
    $gerente_costo=$_POST['gerente_costo'];
    $enviado_presi=$_POST['enviado_presi'];
    $recibido_presi=$_POST['recibido_presi'];
    $instrucciones=$_POST['instruccion']; 
    $fecha_egreso=$_POST['fecha_egreso']; 
    $entregado=$_POST['entregado'];
    $observaciones=$_POST['observaciones'];
    
    _bienvenido_mysql();


    decode_get2($_SERVER["REQUEST_URI"], 2);
    $id = _antinyeccionSQL($_GET["np"]);
   
    $sql = "INSERT INTO `control_gestion2` (`tipo_solicitud`,monto,`estatus2`, `gerente_costo`, `enviado_presidencia`, `recibido_presidencia`, `instruccion`, `fecha_egreso`,  `entregado`, `observaciones`, id_cgestion) VALUES"
        . " ('" . $tipo_soli . "','" . $monto . "','" . $estatus2 . "', '" . $gerente_costo . "','" . $enviado_presi . "','" . $recibido_presi . "','" . $instrucciones . "','" . $fecha_egreso . "','" . $entregado . "','" . $observaciones . "', '" . $id . "')";
    $result = mysql_query($sql);
    if ($result) {
        notificar("Usuario ingresado con exito", "dashboard.php?data=controlcl", "notify-success");
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
    <div class="grid-24">
      <div class="widget">
        <div class="widget-header"> <span class="icon-layers"></span>
          <h3>Cargar Datos </h3>
        </div>
        
<div class="widget-content">
							
<form class="form validateForm" action="#" method="post"  onsubmit="return validate()" enctype="multipart/form-data" >


<div class="grid-4">
<label>Tipo de Solicitud:<br></label>   
<select name="tipo_soli" id="tipo_soli" style="width:130px" >
    <option>Seleccione</option>
    <option value="EC">Estimados de Costo</option>
    <option value="ATE">Análisis Técnico-Económico</option>
    <option value="AP">Ajuste de Precio</option>
</select>
</div>	

<div class="grid-4">
<label for="required">Monto Bs.:</br></label>
<input type="text" name="monto" id="monto" size="14" class="validate[required]" placeholder="Monto Bs."/>	
</div>

    
<div class="grid-4">		
<label for="datepicker">VoBo Gerente de Costos:</br></label>
<input type="date" name="gerente_costo" id="datepicker" size="14" class="validate[required]" placeholder="Fecha Gerente de Costo"/>
</div>

<div class="grid-4">		
<label for="datepicker">Enviado a Presidencia:</br></label>
<input type="date" name="enviado_presi" id="datepicker" size="14" class="validate[required]" placeholder="Enviado a presidencia"/>
</div>


<div class="grid-4">		
<label for="datepicker">Recibido de Presidencia:</br></label>
<input type="date" name="recibido_presi" id="datepicker" size="14" class="validate[required]" placeholder="Enviado a presidencia"/>
</div>

<div class="grid-4">
<label>Instrucción del Presidente:<br></label>   
<select name="instruccion" id="instruccion" style="width:130px" >
    <option>Seleccione</option>
    <option value="Aprobado">Aprobado</option>
    <option value="Rechazado">Rechazado</option>
    
</select>
</div>	
<div class="grid-4">		
<label for="datepicker">Fecha de Egreso del Expediente de Costos:</br></label>
<input type="date" name="fecha_egreso" id="datepicker" size="14" class="validate[required]" placeholder="Enviado a presidencia"/>
</div>
    
<div class="grid-4">
<label for="required">Entregado a:</br></label>
<input type="text" name="entregado" id="nombre_empre" size="14" class="validate[required]" placeholder="Nombre de la Empresa y/o Constructor"/>	
</div>    

<div class="grid-4">
<label for="required">Observaciones:</br></label>
<input type="text" name="observaciones" id="nombre_empre" size="14" class="validate[required]" placeholder="Nombre de la Empresa y/o Constructor"/>	
</div>  

<div class="grid-4 ">
<label>Estatus del Tramite:<br></label>   
<select  name="estatus" id="estatus" style="width:130px">
<option>Seleccione</option>
<option value="R">Revisión</option>
<option value="ET">En tramite</option>
<option value="D">Devuelto</option>
<option value="E">Entregado</option>
</select>
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
      <td input type="button" name="Atras" onclick="javascript:window.history.back();" class="btn btn-error" value="Regresar" >Regresar</td>
  </tr>
</table>
</div>


</form>
</div>
</div>
</div>
</div>
</div>
</div>


