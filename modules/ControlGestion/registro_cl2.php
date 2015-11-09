<?php 
if (array_pop(explode('/', $_SERVER['PHP_SELF']))!='dashboard.php') {header("Location: ../../dashboard.php");}
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
	notificar("Usted no tiene permisos para esta Seccion/Modulo", "dashboard.php?data=notificar", "notify-error");
	_wm($usuario_datos[9],'Acceso Denegado en: '.ucwords(array_pop(explode('/', __dir__))),'S/I');
} 
_wm($usuario_datos[9],'Acceso Autorizado en: '.ucwords(array_pop(explode('/', __dir__))),'S/I');
?>

<div id="contentHeader">
	<h2>Registro de Proyectos</h2>
</div> <!-- #contentHeader -->	

<div class="container">
	<?php include('notificador.php'); ?>
  
  
	<div class="grid-24">	
  	<div class="widget widget-plain">
					
					<div class="widget-content">
				

						
						<div class="dashboard_report first activeState">
							<div class="pad">
								<span class="value"><?php echo $a; ?></span> Total de Empleados
							</div> <!-- .pad -->
						</div>
						
						<div class="dashboard_report defaultState">
							<div class="pad">
								<span class="value"><?php echo $b; ?></span> Total sin correos personal
							</div> <!-- .pad -->
						</div>
						
						<div class="dashboard_report defaultState">
							<div class="pad">
								<span class="value"><?php echo $c; ?></span> Total sin usuario institucional
							</div> <!-- .pad -->
						</div>
						
						<div class="dashboard_report defaultState last">
							<div class="pad">
								<span class="value"><?php echo $d; ?></span> Total sin perfil asignado
							</div> <!-- .pad -->
						</div>
						
					</div> <!-- .widget-content -->
					
				</div> <!-- .widget -->	
	</div> <!-- .grid -->

  <div class="grid-24">	
		<div class="widget widget-table">
			<div class="widget-header">
				<span class="icon-list"></span>
				<h3 class="icon chart">Registro de Proyectos</h3>		
				<span class="icon-folder-fill"></span>
				<h3 class="icon chart"><a href="dashboard.php?data=insertar_cl2" style="color: white;text-decoration: none;">Agregar Proyecto</a></h3>		
			</div>
			<div class="widget-content">
				<table class="table table-bordered table-striped data-table">
					<thead>
						<tr>
							<th style="width:15%">N° de Proceso</th>
							<th style="width:23%">Fecha de Ingreso</th>
                                                        <th style="width:35%">Gerencia Requiriente</th>
                                                        <th style="width:15%">Responsable</th>
							<th style="width:12%">Opciones</th>
						</tr>
					</thead>
					<tbody>
                            <?php
						_bienvenido_mysql();
						mysql_query("set names utf8");
						$sql=mysql_query("SELECT *FROM control_gestion WHERE clase='ClaseII' or clase='ClaseIV'");
						while($row=mysql_fetch_array($sql)){
						?>
                            <tr class="gradeA">
                                <td><?php echo $row[2] ?></td>
                                <td><?php echo $row[3] ?></td>
                                <td><?php echo $row[4] ?></td>
                                <td><?php echo $row[5] ?></td>
                                <td class="center">
                                    <?php
                                    $parametros = 'id=' . $row[0];
                                    $parametros = _desordenar($parametros);
                                    $parametro = 'np=' . $row[2];
                                    $parametro = _desordenar($parametro);
                                    ?>  
                                    <!--<a href="dashboard.php?data=edicion_reg&flag=1&<?php echo $parametros; ?>" id="editar" title="Editar" >
                                        <div class="icons-holder" style="float:left;margin-left:15px"><span class="icon-pen-alt-fill"></span></div>
                                    </a>-->
                                    <?php
                                     
                                        $botons=  mysql_query("SELECT * FROM `control_gestion2` "
                                                . "WHERE `id_cgestion` = '$row[2]'");
                                        $res=  mysql_num_rows($botons);
                                    if($res<=0){
                                                                            
                                    ?>
                                    <a href="dashboard.php?data=seg_fase1&flag=1&<?php echo $parametro; ?>" id="insertar" title="Insertar Segunda Fase" >
                                        <div class="icons-holder" style="float:left;margin-left:15px"><span class="icon-folder-stroke"></span></div>
                                    </a>
                                    <?php
                                    }
                                    ?>
                                    <a href="dashboard.php?data=consultar&flag=1&<?php echo $parametro; ?>" id="consultar" title="Consultar">
                                        <div class="icons-holder" style="float:left;margin-left:15px"><span class="icon-magnifying-glass"></span></div>
                                    </a>
                                    
                                    <!--<a href="javascript:eliminar('<?php echo $row["Nombre"] ?>','dashboard.php?data=pruebadelete&flag=1&<?php echo $parametros; ?>')" id="eliminar-us" title="Eliminar" >
                                        <div class="icons-holder" style="float:left;margin-left:15px"><span class="icon-x-alt"></span></div>
                                    </a-->
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