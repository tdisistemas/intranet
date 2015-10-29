<?php 
//CAMBIAR PARAMETROS
require("../../conexiones_config.php");

session_start();
if (!isset($_SESSION[md5('usuario_datos' . $ecret)])) {
    ir("../../index.php");
}
$usuario_datos    = $_SESSION[md5('usuario_datos' . $ecret)];
$usuario_permisos = $_SESSION[md5('usuario_permisos' . $ecret)];
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
    notificar("Usted no tiene permisos para esta Seccion/Modulo", "dashboard.php?data=notificar", "notify-error");
    _wm($usuario_datos[9], 'Acceso Denegado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
}
_wm($usuario_datos[9], 'Acceso Autorizado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');


?>
<?php 

if (isset($_GET['paso'])){
	  
	
	$paso=$_GET['paso'];


mysql_query("UPDATE comunicacion_codigo SET status='3' WHERE id_com=$paso"); 

ir("ver_com_ext.php?&paso=$paso");
}
?>      

      