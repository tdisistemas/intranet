<?php 
if (array_pop(explode('/', $_SERVER['PHP_SELF']))!='dashboard.php') {header("Location: ../../dashboard.php");}
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
	notificar("Usted no tiene permisos para esta Seccion/Modulo", "dashboard.php?data=notificar", "notify-error");
	_wm($usuario_datos[9],'Acceso Denegado en: '.ucwords(array_pop(explode('/', __dir__))),'S/I');
} 
_wm($usuario_datos[9],'Acceso Autorizado en: '.ucwords(array_pop(explode('/', __dir__))),'S/I');
?>

<div id="contentHeader">
	<h2>Lista de Perfiles</h2>
</div> <!-- #contentHeader -->	

<div class="container">
	<?php echo $permisos; include('notificador.php'); ?>
	<div class="grid-16">	
		<div class="widget widget-table">
			<div class="widget-header">
				<span class="icon-list"></span>
				<h3 class="icon chart">Registro de Perfiles de Usuario</h3>		
			</div>
			<div class="widget-content">
				<table class="table table-bordered table-striped data-table">
					<thead>
						<tr>
							<th>Perfil</th>
							<th>Descripción</th>
							<th>Opciones</th>
						</tr>
					</thead>
					<tbody>
						<?php
						_bienvenido_mysql();
						mysql_query("set names utf8");
						$sql=mysql_query("SELECT * FROM perfiles ORDER BY id ASC");
						while($row=mysql_fetch_array($sql)){
						?>
						<tr class="gradeA">
							<td><?php echo $row["perfil"]?></td>
							<td><?php echo $row["dperfil"]?></td>
							<td class="center">
                <?php 
                  $parametros = 'id='.$row["id"]; 
                  $parametros = _desordenar($parametros);
                ?>  
                <a href="dashboard.php?data=editar-pe&flag=1&<?php echo $parametros; ?>" id="editar" title="Editar" >
									<div class="icons-holder" style="float:left;margin-left:15px"><span class="icon-pen-alt-fill"></span></div>
								</a>
                <a href="javascript:eliminar('<?php echo $row["perfil"]?>','dashboard.php?data=eliminar-pe&flag=1&<?php echo $parametros; ?>')" id="eliminar-mi" title="Eliminar" >
									<div class="icons-holder" style="float:left;margin-left:15px"><span class="icon-x-alt"></span></div>
								</a>
							</td>
						</tr>									
						<?php } ?>
					</tbody>
				</table>
			</div> <!-- .widget-content -->
		</div>
	</div> <!-- .grid -->
	<div class="grid-8">
		<div id="gettingStarted" class="box">
			<h3>Estimado, <?php echo $usuario_datos[1] . ' ' . $usuario_datos[2]  ; ?></h3>
			<p>En esta seccion podra gestionar los perfiles del sistema</p>
        <div class="box plain">
            <a href="dashboard.php?data=agregar-pe" class="btn btn-primary btn-large dashboard_add">Agregar Perfil</a>
        </div>
		</div>
	</div>
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