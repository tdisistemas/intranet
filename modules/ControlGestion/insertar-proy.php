<?php 
if (array_pop(explode('/', $_SERVER['PHP_SELF']))!='dashboard.php') {ir("../../dashboard.php");}
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
	//notificar("Usted no tiene permisos para esta Sección/Módulo", "dashboard.php?data=notificar", "notify-error");
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
$obraextra=  isset($_POST['obraextrasi']) ? $_POST['obraextrasi']:'0';
$obraextra1= $obraextra;
$estatus=$_POST['estatus'];
$alcance=  isset($_POST['alcance']) ? $_POST['alcance']:'0';
$memoriad= isset($_POST['memoriad']) ? $_POST['memoriad']:'0';
$computos= isset($_POST['computos']) ? $_POST['computos']:'0';
$especificaciones= isset($_POST['especificaciones']) ? $_POST['especificaciones']:'0';
$planos= isset($_POST['planos']) ? $_POST['planos']:'0';
$anexos= isset($_POST['anexos']) ? $_POST['anexos']:'0';

$documentose= $alcance. "," .$memoriad. "," .$computos. "," .$especificaciones. "," .$planos. "," .$anexos; 

  
$sql = mysql_query("SELECT caracteristicas, conse 
FROM `gc_controlconse`
WHERE `caracteristicas` = 'GC'");

while ($row = mysql_fetch_array($sql)) {
    
    $caracteristica = $row['caracteristicas'];
    $conse  = $row['conse'];

}

$ano= date('Y');
$actual=(explode("20",$ano));
$conse1=$conse+1;
$consecutivo=mysql_query("update gc_controlconse set conse='".$conse1."' where caracteristicas='GC' ");

if ($obraextra1==1){
    $obraextra1=$conse1;
    
}else
{
    $obraextra1==0;
}
   
  $u      = "INSERT INTO `gc_control_gestion` (clase, n_proceso,`fecha_ingreso`, `gerencia_req`, `responsable`, `obra`, `obra_extra`,  `estatus`, `documentos_entre`,`n_proceso_completo` ) VALUES"
        . " ('" . $clase . "','".  '00'.$conse1."','" . $fecha_ing . "', '" . $gerencia . "','" . $responsable . "','" . $nombre_obra . "','" . $obraextra1 . "','" . $estatus . "', '" . $documentose . "', '".  'GC-'.'00'.$conse1. '-'.$actual[1]."')";

$result=  mysql_query($u);
  if (!$result) {
    if ($SQL_debug == '1') {
        die('Error Auditando - Respuesta del Motor: ' . mysql_error());
    } else {
        die('Error Auditando');
    }
}
 else {
  notificar("Primera Fase del Proyeto Ingresada con Exito", "dashboard.php?data=controlg", "notify-success");
}


?>

