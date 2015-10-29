<?php 
if (array_pop(explode('/', $_SERVER['PHP_SELF']))!='dashboard.php') {header("Location: ../../dashboard.php");}
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
	notificar("Usted no tiene permisos para esta Seccion/Modulo", "dashboard.php?data=notificar", "notify-error");
	_wm($usuario_datos[9],'Acceso Denegado en: '.ucwords(array_pop(explode('/', __dir__))),'S/I');
} 
_wm($usuario_datos[9],'Acceso Autorizado en: '.ucwords(array_pop(explode('/', __dir__))),'S/I');
if (!$_GET["flag"]){ir('dashboard.php?data=perfiles');}
?>

<div id="contentHeader">
<h2>Eliminar Perfil de Usuario - <?php echo 'ID: ' . strip_tags($_GET["id"]); ?></h2>
</div> <!-- #contentHeader -->	

<?php 

if($_GET["flag"]){
	decode_get2($_SERVER["REQUEST_URI"],2);
  @$idmi= _antinyeccionSQL($_GET["id"]);
  _bienvenido_mysql();
  $sql="DELETE FROM perfiles WHERE id = ". $idmi;
	$result = mysql_query($sql) or die('Error Eliminando Metro informa - ' . mysql_error());
	if($result){
		notificar("Metro informa eliminado con exito", "dashboard.php?data=perfiles", "notify-error");
	}
	else {
		die(mysql_error());
	}			
}
else { 
  ir("dashboard.php?data=perfiles");
} ?>
