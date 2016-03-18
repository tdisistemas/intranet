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
  ir("../../dashboard.php?data=plan-vacacional-admin1");
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
$edad_desde = _antinyeccionSQL($_POST['edad_desde']);
$edad_hasta = _antinyeccionSQL($_POST['edad_hasta']);
$ubicacion_emp = _antinyeccionSQL($_POST['gerencia']);
$sexo = _antinyeccionSQL($_POST['sexo']);
$hasta_c = date('Y-m-d', strtotime("$hasta - 1 day"));
$hasta_m = date('Y-m-d', strtotime("$hasta + 1 day"));
?>


<div><br><br><br><br><br><br><br><br><br>
  <?php
  

  
  
  $sql = "SELECT * from reporte_planvacacional2015 ";
  $sql .= "WHERE ";
  $sql .= "fec_inscripcion >= '" . $desde . "' and fec_inscripcion <= '" . $hasta_m . "'";
     
  if ($edad_desde or $edad_hasta) {
  $sql .= "AND edad >= '".$edad_desde."' and  edad <='".$edad_hasta."'";
  }
  
  if ($ubicacion_emp) {
  $sql .= "AND gerencia = '".$ubicacion_emp."' ";
  }
  
  if ($sexo) {
    $sql .= "AND sexo = '".$sexo."'";
  }

  $sql .= " order by cedula_emp asc";
  
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
            <th>Gerencia</th>
            <th>Cargo</th>
            <th>Direccion Habitacion:</th>
            <th>Telefono Habitacion</th>
            <th>Celular</th>
            <th>Correo Electronico</th>
            <th>Parentesco</th>
            <th>C&eacute;dula del sistema</th>
            <th>C&eacute;dula actual</th>
            <th>Nombre Completo</th>
            <th>Fecha de Nac</th>
            <th>Lugar de Nac</th>
            <th>Edad</th>
            <th>Sexo</th>
            <th>Talla Franela</th>
            <th>Peso</th>
            <th>Tipo de Sangre</th>
            <th>Factor RH</th>
            <th>Sufre Enfermedad</th>
            <th>Cual Enfermedad</th>
            <th>Toma Medicamento</th>
            <th>Cual Medicamento</th>
            <th>Dosis</th>
            <th>Medicamento que no Toma</th>
            <th>Cual Medicamento no Toma</th>
            <th>Alergico</th>
            <th>Alergico a Que</th>
            <th>Trastorno de Conducta</th>
            <th>Explique el Trastorno</th>
            <th>Ataques o Convulsiones </th>
            <th>Explique los Ataques o Convulsiones</th>
            <th>Toxoide</th>
            <th>En que Fecha</th>
            <th>Otras Enfermedades</th>
            <th>Persona de Contacto</th>
            <th>Telefono de Contacto</th>
            <th>Parentesco</th>
            <th>Pediatra</th>
            <th>Telefono de Pediatra</th>
            <th>Comida Favorita</th>
            <th>Comida No Favorita</th>
            <th>Fecha de Inscripcion</th>
            <th>Observaciones</th>
            <th>Hermanos</th>
            
          </tr>
        </thead>
        <tbody>
          <?php while ($reg = mysql_fetch_array($reg_det_qry)) {
              $hermanos= $reg["cedula_emp"]; 
              $hermano=  mysql_query("SELECT COUNT(  `cedula_emp` ) AS hermano,apellido
FROM  `reporte_planvacacional2015` 
WHERE  `cedula_emp` =$hermanos and estatus =1" );
              $listo=  mysql_fetch_array($hermano);
            
              $registro++; ?>
            <tr>
              <td rowspan='1' align ='justify'>	<?php echo $registro; ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["cedula_emp"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["apellido"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["nombre"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["gerencia"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["cargo"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["direccion_habitacion"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["telefono_habitacion"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["celular"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["correo_electronico"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["parentesco"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["cedula"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["cedula_nueva"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["nombres"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["fecha_nacimiento"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["lugar_nacimiento"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["edad"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["sexo"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["talla_franela"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["peso"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["tipo_sangre"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["factor_rh"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["sufre_enfermedad"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["cual_enfermedad"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["toma_medicamento"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["medicamento"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["dosis"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["medicamento_no_toma"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["cual_medicamento_no_toma"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["alergico"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["alergico_a"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["trastorno_conducta"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["explique_trastornos"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["ataques_convulsiones"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["explique_ataques"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["toxoide"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["fecha_toxoide"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["otras_enfermedades"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["persona_contacto"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["telefono_contacto"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["parentesco_contacto"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["pediatra"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["telefono_pediatra"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["comida_favorita"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["comida_no_favorita"]); ?></td>
              <td rowspan='1' align ='justify'>	<?php echo strtoupper($reg["fec_inscripcion"]); ?></td>
              <td rowspan='1' align ='justify'><?php echo strtoupper($reg["observaciones"]); ?></td>
              <td rowspan='1' align ='justify'><?php if ($listo["hermano"]>=2){ ?>Hermanos <?php echo $listo["apellido"];} else {?>No tiene hermanos<?php }?></td>
              
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