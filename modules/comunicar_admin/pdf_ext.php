<?php
require("../../conexiones_config.php");
session_start();
if (!isset($_SESSION[md5('usuario_datos' . $ecret)])) {
  ir("../../index.php");
}
$usuario_datos = $_SESSION[md5('usuario_datos' . $ecret)];
$usuario_permisos = $_SESSION[md5('usuario_permisos' . $ecret)];
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
  notificar("Usted no tiene permisos para esta Sección/Módulo", "dashboard.php?data=notificar", "notify-error");
  _wm($usuario_datos[9], 'Acceso Denegado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
}
_wm($usuario_datos[9], 'Acceso Autorizado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');

if ($_SESSION['tokenprepahoa']==$_POST['token']) {
  unset($_SESSION['tokenprepahoa']);
  $desde = _antinyeccionSQL($_POST['desde']);
  $hasta = _antinyeccionSQL($_POST['hasta']);
 $gerencia_s = ($_POST['gerencia']);
  $gerencia_d = ($_POST['gerencia_d']);

  ob_start();
  header("Content-type: application/vnd.ms-excel; name='excel'");
  //header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;");
  header("Content-Disposition:attachment; filename=".date('U')."-Reporte-de-Comunicaciones-Desde-$desde-Hasta-$hasta.xls");
  header("Pragma: no-cache");
  header("Expires: 0");
  ob_end_flush();
  
  //decode_get2($_SERVER["REQUEST_URI"], 2);
}
else {
  alerta('Autenticacion de token de seguridad fallido, se procedera a recargar la pagina, Disculpen las molestias causadas');
  ir("../../dashboard.php?data=coadmin");
}
?>

<style>
  body{
    font-family: Arial;
    font-size: 10px;
    overflow: hidden;
  }
  table, th, td, tr{
    font-size: inherit;
    visibility: hidden;
  }
  tr{
    height: 19px;
  }
  .pagina{
    width: 850px;
    margin: 0 auto;
  }
  @media print
  {    
    .no-print, .no-print *
    {
      display: none !important;
    }
  }
</style>
<div><br><br><br><br><br><br><br><br><br>
  
<?php
$sql="SELECT  `id_com`,`de` ,  `para` ,  `asunto` ,  `fecha` , `consecutivo` 
FROM comunicacion_codigo
WHERE fecha >=  '$desde'
AND fecha <=  '$hasta' and tipo='ext'" ;    
  
if ($gerencia) {
  $sql .= "AND gerencia = '".$gerencia_s."' ";
  }
   if ($nom) {
  $sql .= "AND destino = '".$gerencia_d."' ";
  }
   
        
      
         
  _bienvenido_mysql();
  alertadev($sql);
  $reg_det_qry = mysql_query($sql);
  if ($reg_det_qry) { ?>
  <div class="datagrid" style="width: 50%; margin: 0 auto; height: 400px;border: 1px solid;padding: 50px;">
      <table id="Exportar_a_Excel">
        <thead>
          <tr>
            <td colspan="5">
              <img src="http://intranet.metrodemaracaibo.gob.ve/intranet/src/images/logo.png" style="float:left; width:180px; margin-top: 25px " />
            </td>
          </tr>
          <tr><td colspan="5">&nbsp;</td></tr>
          <tr><td colspan="5">&nbsp;</td></tr>
          <tr><td colspan="5">&nbsp;</td></tr>
        </thead>
        <thead>
          <tr>
            <td colspan="10">
              <div style="text-align:center; font-size: 160%"><b>Reporte de Comunicaciones Externas</b></div>
            </td>    
          </tr>
          <tr>
            <td colspan="10">
              <div style="text-align:center; font-size: 100%"><b> Per&iacute;odo	del <?php echo $desde; ?> al <?php echo $hasta; ?></b></div><br /><br /></div>
            </td>
          </tr>
        </thead>
        <thead>
          <tr>
            <th>Nro.</th>
             <th>Origen</th>
            <th>Destinatario</th>
            
            <th>Asunto</th>
            <th>Fecha</th>
    
            
            <th>Consecutivo</th> 
            
      
  
          </tr>
        </thead>
        <tbody>
          <?php while ($reg = mysql_fetch_array($reg_det_qry)) { $registro++; ?>
            <tr>
              <td rowspan='1' align ='justify'>	<?php echo $registro; ?></td>
              
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg[1]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg[2]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg[3]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg[4]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg[5]); ?></td>
         
            </tr>
          <?php } ?>
          <?php } ?>
        </tbody>
    </table>
    </div>
</div> <!-- .row -->
<?php
_adios_mysql();
?>