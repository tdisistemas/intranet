<?php 
if (array_pop(explode('/', $_SERVER['PHP_SELF']))!='dashboard.php') {ir("../../dashboard.php");}
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
	notificar("Usted no tiene permisos para esta Sección/Módulo", "dashboard.php?data=notificar", "notify-error");
	_wm($usuario_datos[9],'Acceso Denegado en: '.ucwords(array_pop(explode('/', __dir__))),'S/I');
} 
_wm($usuario_datos[9],'Acceso Autorizado en: '.ucwords(array_pop(explode('/', __dir__))),'S/I');
?>

<?php

$clase=$_POST['clase'];
$fecha_ing=$_POST['fecha_ing'];
$gerencia=$_POST['gerencia'];
$responsable=$_POST['responsable_req'];
$nombre_obra=$_POST['nombre_obra'];
$nombre_empre=$_POST['nombre_empre']; 
$deviacion=$_POST['deviacion']; 
$estatus=$_POST['estatus'];

  _bienvenido_mysql();
$sql = mysql_query("SELECT caracteristicas, conse 
FROM `control_conse`
WHERE `caracteristicas` = 'GC'");

while ($row = mysql_fetch_array($sql)) {
    
    $caracteristica = $row['caracteristicas'];
    $conse  = $row['conse'];

}

$ano         = date('Y');
$actual=(explode("20",$ano));
$conse1=$conse+1;
$consecutivo=mysql_query("update control_conse set conse='".$conse1."' where caracteristicas='GC' ");

   
  $u      = "INSERT INTO `control_gestion` (clase, n_proceso,`fecha_ingreso`, `gerencia_req`, `responsable`, `obra`, `empresa`, `deviacion`,  `estatus`) VALUES"
        . " ('" . $clase . "','".$caracteristica. '-'.$actual[1]. '-00'.$conse1."','" . $fecha_ing . "', '" . $gerencia . "','" . $responsable . "','" . $nombre_obra . "','" . $nombre_empre . "','" . $deviacion . "','" . $estatus . "')";

$result=  mysql_query($u);
  if (!$result) {
    if ($SQL_debug == '1') {
        die('Error Auditando - Respuesta del Motor: ' . mysql_error());
    } else {
        die('Error Auditando');
    }
}
 else {
   ir('dashboard.php?data=controlcl');  
}


?>

