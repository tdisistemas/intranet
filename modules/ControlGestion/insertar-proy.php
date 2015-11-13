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
$estatus=$_POST['estatus'];
$alcance=  isset($_POST['alcance']) ? $_POST['alcance']:'0';
$memoriad= isset($_POST['memoriad']) ? $_POST['memoriad']:'0';
$computos= isset($_POST['computos']) ? $_POST['computos']:'0';
$especificaciones= isset($_POST['especificaciones']) ? $_POST['especificaciones']:'0';
$planos= isset($_POST['planos']) ? $_POST['planos']:'0';
$anexos= isset($_POST['anexos']) ? $_POST['anexos']:'0';

$documentose= $alcance. "," .$memoriad. "," .$computos. "," .$especificaciones. "," .$planos. "," .$anexos; 

  _bienvenido_mysql();
$sql = mysql_query("SELECT conse 
FROM `control_conse`");

while ($row = mysql_fetch_array($sql)) {
    
    $conse  = $row['conse'];

}

$conse1=$conse+1;
$consecutivo=mysql_query("update control_conse set conse='".$conse1."'");


   
  $u      = "INSERT INTO `control_gestion` (clase, n_proceso,`fecha_ingreso`, `gerencia_req`, `responsable`, `obra`,  `estatus`, `documentos_entre`) VALUES"
        . " ('" . $clase . "','".  '00'.$conse1."','" . $fecha_ing . "', '" . $gerencia . "','" . $responsable . "','" . $nombre_obra . "','" . $estatus . "', '" . $documentose . "')";

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

