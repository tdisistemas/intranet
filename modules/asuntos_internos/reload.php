<?php 
if (array_pop(explode('/', $_SERVER['PHP_SELF']))!='dashboard.php') {header("Location: ../../dashboard.php");}
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
	notificar("Usted no tiene permisos para esta Seccion/Modulo", "dashboard.php?data=notificar", "notify-error");
	_wm($usuario_datos[9],'Acceso Denegado en: '.ucwords(array_pop(explode('/', __dir__))),'S/I');
} 
_wm($usuario_datos[9],'Acceso Autorizado en: '.ucwords(array_pop(explode('/', __dir__))),'S/I');
?>

<?php
      $sql="";
      $sql ="SELECT ";
      $sql.="usuario_bkp.id_usuario, ";
      $sql.="usuario_bkp.nombre, ";
      $sql.="usuario_bkp.apellido, ";
      $sql.="usuario_bkp.usuario, ";
      $sql.="autenticacion.clave, ";
      $sql.="usuario_bkp.correo_corporativo, ";
      $sql.="usuario_bkp.correo_principal, ";
      $sql.="usuario_bkp.telefono, ";
      $sql.="usuario_bkp.habilitado, ";
      $sql.="usuario_bkp.usuario_int, ";
      $sql.="'disponible', ";
      $sql.="autenticacion.perfil, ";
      $sql.="perfiles.perfil AS perfil_nom, ";
      $sql.="perfiles.role AS role, ";
      $sql.="usuario_bkp.ubicacion_laboral ";
      $sql.="FROM ";
      $sql.="usuario_bkp ";
      $sql.="LEFT JOIN autenticacion ON autenticacion.cedula = usuario_bkp.usuario ";
      $sql.="LEFT JOIN perfiles ON autenticacion.perfil = perfiles.id ";
      $sql.="WHERE usuario ='".$usuario_datos[3]."'";
      $sql.=" AND usuario_bkp.habilitado=1;";
                             
      
      
      
			$result = mysql_query ($sql);

			if(!$result){
				if ($SQL_debug=='1'){ die('Error en Consulta de Auth - Respuesta del Motor: ' . mysql_error());	} else {die('Error en Agregar Registro');}
			}

			$reg=mysql_fetch_array($result);
			$num_rows = mysql_num_rows($result);
      
			if ($num_rows==1) {		
        $_SESSION[md5('usuario_permisos'.$ecret)]=unserialize($reg['role']);
        $usuario_permisos = $_SESSION[md5('usuario_permisos'.$ecret)];
        alerta('Roles recargados');
				ir("dashboard.php");
			}	
      else {
        alerta('Roles no recargados, consulte al Administrador del Sistema - '.$num_rows);
				ir("dashboard.php");
      }
       

?>