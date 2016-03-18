<?php
require("../../conexiones_config.php");
session_start();
if (!isset($_SESSION[md5('usuario_datos' . $ecret)])) {
  ir("../../index.php");
}
$usuario_datos = $_SESSION[md5('usuario_datos' . $ecret)];
$usuario_permisos = $_SESSION[md5('usuario_permisos' . $ecret)];
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
  //notificar("Usted no tiene permisos para esta Seccion/Modulo", "dashboard.php?data=notificar", "notify-error");
  _wm($usuario_datos[9], 'Acceso Denegado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
}
_wm($usuario_datos[9], 'Acceso Autorizado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');

if ($_SESSION['tokenplanvac']==$_POST['token']) {
  unset($_SESSION['tokenplanvac']);
  ob_start();
  header("Content-type: application/vnd.ms-excel; name='excel'");
  //header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;");
  header("Content-Disposition:attachment; filename=Reporte-Plan-Vacacional-MM-2015-".date('U').".xls");
  header("Pragma: no-cache");
  header("Expires: 0");
  ob_end_flush();
}
else {
  alerta('Autenticacion de token de seguridad fallido, se procedera a recargar la pagina, Disculpen las molestias causadas');
  ir("../../dashboard.php?data=control_gestion_reporte");
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
<?php
//decode_get2($_SERVER["REQUEST_URI"], 2);

$desde = _antinyeccionSQL($_POST['desde']);
$hasta = _antinyeccionSQL($_POST['hasta']);
//$edad_desde = _antinyeccionSQL($_POST['edad_desde']);
//$edad_hasta = _antinyeccionSQL($_POST['edad_hasta']);
//$ubicacion_emp = _antinyeccionSQL($_POST['gerencia']);
//$sexo = _antinyeccionSQL($_POST['sexo']);
//$hasta_c = date('Y-m-d', strtotime("$hasta - 1 day"));
//$hasta_m = date('Y-m-d', strtotime("$hasta + 1 day"));
?>


<div><br><br><br><br><br><br><br><br><br>
  <?php
  

  
  
  $sql = "SELECT * from gc_control_gestion2 ";
  $sql .= "WHERE ";
  $sql .= "fecha_ingreso >= '" . $desde . "' and fecha_ingreso <= '" . $hasta_m . "'";
     
  //if ($edad_desde or $edad_hasta) {
  //$sql .= "AND edad >= '".$edad_desde."' and  edad <='".$edad_hasta."'";
  //}
  
//  if ($ubicacion_emp) {
//  $sql .= "AND gerencia = '".$ubicacion_emp."' ";
//  }
//  
//  if ($sexo) {
//    $sql .= "AND sexo = '".$sexo."'";
//  }
//
//  $sql .= " order by cedula_emp asc";
  
 _bienvenido_mysql();
  $reg_det_qry = mysql_query($sql);
  if ($reg_det_qry) { ?>
  <div class="datagrid" style="width: 50%; margin: 0 auto; height: 400px;border: 1px solid;padding: 50px;">
      <table id="Exportar_a_Excel">
        <thead>
          <tr>
            <td colspan="5">
              <img src="http://intranet.metrodemaracaibo.gob.ve/src/images/logo.png" style="float:left; width:180px; margin-top: 25px " />
            </td>
          </tr>
          <tr><td colspan="5">&nbsp;</td></tr>
                    <tr><td colspan="5">&nbsp;</td></tr>
                              <tr><td colspan="5">&nbsp;</td></tr>
                                                  
        </thead>
        
        
        
        <thead>
          <tr>
            <td colspan = 22>
              <div style="text-align:center; font-size: 160%"><b>Reporte Participantes Plan Vacacional <?php echo date('Y'); ?> </b></div>
            </td>    
          </tr>
          <tr>
            <td colspan = 22>
              <div style="text-align:center; font-size: 100%"><b> Per&iacute;odo	del <?php echo $desde; ?> al <?php echo $hasta; ?></b></div><br /><br /></div>
            </td>
          </tr>
        </thead>
        <thead>
          <tr>
            <th colspan="10" align="left">     DATOS DEL EMPLEADO    <th>
            <th colspan="24" align="left">     DATOS DEL PARTICIPANTE      <th>
          </tr>
          <tr>
            <th>No.</th>
            <th>C&eacute;dula</th>
            <th>Apellido</th>
            <th>Nombre</th>
           
            
            
          </tr>
        </thead>
        <tbody>
          <?php while ($reg = mysql_fetch_array($reg_det_qry)) {
              $hermanos= $reg["n_proceso"]; 
              $hermano=  mysql_query("SELECT COUNT(  `n_proceso` ) AS tipo_solicitud 
WHERE  `n_proceso` =$hermanos and estatus =1" );
              $listo=  mysql_fetch_array($hermano);
            
              $registro++; ?>
            <tr>
              <td rowspan='1' align ='justify'>	<?php echo $registro; ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["n_proceso"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["tipo_solicitud"]); ?></td>
              
             
              
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