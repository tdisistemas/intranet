<?php 
if (array_pop(explode('/', $_SERVER['PHP_SELF']))!='dashboard.php') {ir("../../dashboard.php");}
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
	notificar("Usted no tiene permisos para esta Sección/Módulo", "dashboard.php?data=notificar", "notify-error");
	_wm($usuario_datos[9],'Acceso Denegado en: '.ucwords(array_pop(explode('/', __dir__))),'S/I');
} 
_wm($usuario_datos[9],'Acceso Autorizado en: '.ucwords(array_pop(explode('/', __dir__))),'S/I');
?>
<?php 

$cuerpo=$_POST['texto'];

$arc=$_POST['id'];

mysql_query("UPDATE comunicacion_codigo SET cuerpo='$cuerpo' WHERE id_com=$arc"); 

notificar("El expediente número $codigo ha sido actualizado", "modules/comunicar/ver_com_ext.php?&paso=$arc", "notify-success");

?>      



