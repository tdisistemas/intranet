<?php 
if (array_pop(explode('/', $_SERVER['PHP_SELF']))!='dashboard.php') {header("Location: ../../dashboard.php");}
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
	notificar("Usted no tiene permisos para esta Seccion/Modulo", "dashboard.php?data=notificar", "notify-error");
	_wm($usuario_datos[9],'Acceso Denegado en: '.ucwords(array_pop(explode('/', __dir__))),'S/I');
} 
_wm($usuario_datos[9],'Acceso Autorizado en: '.ucwords(array_pop(explode('/', __dir__))),'S/I');
?>

<div id="contentHeader">
	<h2>Lista de Usuarios/Empleados</h2>
</div> <!-- #contentHeader -->	

<div class="container">
	<?php include('notificador.php'); ?>
  
  
  
	<div class="grid-24">	
  	<div class="widget widget-plain">
					
					<div class="widget-content">
				
<?php
      _bienvenido_mysql();
			
      $sql="";$sql ="SELECT ";$sql.="count(*) ";$sql.="FROM ";$sql.="usuario_bkp ";
      $sql.="LEFT JOIN autenticacion ON autenticacion.cedula = usuario_bkp.usuario ";
      $sql.="LEFT JOIN perfiles ON autenticacion.perfil = perfiles.id ";
      $sql.="LEFT JOIN datos_empleado_rrhh ON usuario_bkp.usuario = datos_empleado_rrhh.cedula ";
      $sql.="WHERE usuario_bkp.habilitado=1;";
			$result = mysql_query ($sql);
			if(!$result){
				if ($SQL_debug=='1'){ die('Error en Consulta de Auth - Respuesta del Motor: ' . mysql_error());	} else {die('Error en Consulta de Auth');}
			}
			$reg=mysql_fetch_array($result);
			$a=$reg[0];

      
      $sql="";$sql ="SELECT ";$sql.="count(*) ";$sql.="FROM ";$sql.="usuario_bkp ";
      $sql.="LEFT JOIN autenticacion ON autenticacion.cedula = usuario_bkp.usuario ";
      $sql.="LEFT JOIN perfiles ON autenticacion.perfil = perfiles.id ";
      $sql.="LEFT JOIN datos_empleado_rrhh ON usuario_bkp.usuario = datos_empleado_rrhh.cedula ";
      $sql.="WHERE usuario_bkp.habilitado=1 AND usuario_bkp.correo_principal='';";
			$result = mysql_query ($sql);
			if(!$result){
				if ($SQL_debug=='1'){ die('Error en Consulta de Auth - Respuesta del Motor: ' . mysql_error());	} else {die('Error en Consulta de Auth');}
			}
			$reg=mysql_fetch_array($result);
			$b=$reg[0];      
      

      
      $sql="";$sql ="SELECT ";$sql.="count(*) ";$sql.="FROM ";$sql.="usuario_bkp ";
      $sql.="LEFT JOIN autenticacion ON autenticacion.cedula = usuario_bkp.usuario ";
      $sql.="LEFT JOIN perfiles ON autenticacion.perfil = perfiles.id ";
      $sql.="LEFT JOIN datos_empleado_rrhh ON usuario_bkp.usuario = datos_empleado_rrhh.cedula ";
      $sql.="WHERE usuario_bkp.habilitado=1 AND usuario_bkp.usuario_int='';";
			$result = mysql_query ($sql);
			if(!$result){
				if ($SQL_debug=='1'){ die('Error en Consulta de Auth - Respuesta del Motor: ' . mysql_error());	} else {die('Error en Consulta de Auth');}
			}
			$reg=mysql_fetch_array($result);
			$c=$reg[0];      
      
      
      
      $sql="";$sql ="SELECT ";$sql.="count(*) ";$sql.="FROM ";$sql.="usuario_bkp ";
      $sql.="LEFT JOIN autenticacion ON autenticacion.cedula = usuario_bkp.usuario ";
      $sql.="LEFT JOIN perfiles ON autenticacion.perfil = perfiles.id ";
      $sql.="LEFT JOIN datos_empleado_rrhh ON usuario_bkp.usuario = datos_empleado_rrhh.cedula ";
      $sql.="WHERE usuario_bkp.habilitado=1 AND isnull(autenticacion.perfil);";
			$result = mysql_query ($sql);
			if(!$result){
				if ($SQL_debug=='1'){ die('Error en Consulta de Auth - Respuesta del Motor: ' . mysql_error());	} else {die('Error en Consulta de Auth');}
			}
			$reg=mysql_fetch_array($result);
			$d=$reg[0];      
      
      
      
      
			_adios_mysql();

?>
						
						<div style="margin-left: 400px;" class="dashboard_report first activeState">
							<div class="pad" align="center">
								<span class="value"><?php echo $a; ?></span> Total de Empleados
							</div> <!-- .pad -->
						</div>
						
						
						
					</div> <!-- .widget-content -->
					
				</div> <!-- .widget -->	
	</div> <!-- .grid -->

  <div class="grid-24">	
		<div class="widget widget-table">
			<div class="widget-header">
				<span class="icon-list"></span>
				<h3 class="icon chart">Registro de Usuarios/Empleados</h3>		
				<span class="icon-user"></span>
							</div>
			<div class="widget-content">
				<table class="table table-bordered table-striped data-table">
					<thead>
						<tr>
							<th style="width:15%">Cedula</th>
							<th style="width:23%">Nombre y Apellido</th>
							<th style="width:35%">Gerencia</th>
							
							<th style="width:12%">Opciones</th>
						</tr>
					</thead>
					<tbody>
						<?php
							_bienvenido_mysql();
							mysql_query("set names utf8");

              $sqlcode ="call usuario() ";                                                        



              $sql=mysql_query($sqlcode);
							while($row=mysql_fetch_array($sql)){
						?>
						<tr class="gradeA">
							<td><?php echo $row[3]?></td>
							<td><?php echo $row[1] . " " . $row[2] ?></td>
							<td><?php echo $row[14]?></td>
							
							<td class="center">
						<?php 
							$parametros = 'id='.$row["id_usuario"]; 
							$parametros = _desordenar($parametros);
						?>  
								<a href="dashboard.php?data=usuario-ed&flag=1&<?php echo $parametros; ?>" id="editar" title="Editar" >
									<div class="icons-holder" style="float:left;margin-left:15px"><span class="icon-pen-alt-fill"></span></div>
								</a>
															</td>
						</tr>									
						<?php } ?> 
					</tbody>
				</table>
			</div> <!-- .widget-content -->
		</div>
	</div> <!-- .grid -->
</div> <!-- .container -->
<script type="text/javascript">
function eliminar(perfil, param){
		$.alert ({ 
			type: 'confirm'
			, title: 'Alerta'
			, text: '<h3>¿Desea eliminar el perfil: <u>'+perfil+'</u> ?</h3>'
			, callback: function () {window.location=param;}	
		});		
}
</script>