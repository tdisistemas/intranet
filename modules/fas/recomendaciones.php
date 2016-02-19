<?php 
if (array_pop(explode('/', $_SERVER['PHP_SELF']))!='dashboard.php') {header("Location: ../../dashboard.php");}
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
	notificar("Usted no tiene permisos para esta Sección/Módulo", "dashboard.php?data=notificar", "notify-error");
	_wm($usuario_datos[9],'Acceso Denegado en: '.ucwords(array_pop(explode('/', __dir__))),'S/I');
} 
_wm($usuario_datos[9],'Acceso Autorizado en: '.ucwords(array_pop(explode('/', __dir__))),'S/I');
?>

<div id="contentHeader">
		<h2>Recomendaciones para el uso</h2>
</div> <!-- #contentHeader -->	

<div class="container">
  <div class="row">

    
    
    				<div class="grid-16">				
						<div class="widget">			
								<div class="widget-header">
										<span class="icon-layers"></span>
										<h3>Usted esta usando el navegador Mozilla Firefox...</h3>
								</div>
								<div class="widget-content">
										<p>Loren IpsunLoren IpsunLoren IpsunLoren IpsunLoren IpsunLoren IpsunLoren IpsunLoren IpsunLoren IpsunLoren IpsunLoren IpsunLoren IpsunLoren IpsunLoren IpsunLoren IpsunLoren IpsunLoren IpsunLoren IpsunLoren IpsunLoren IpsunLoren IpsunLoren IpsunLoren IpsunLoren IpsunLoren IpsunLoren Ipsun :</p>
										<br>
										<p><b>Nota: La Póliza estará vigente  desde el 01  de Enero de 2014  hasta el 31 de Diciembre de 2014.</b></p>
										</div>	

                    <div align="center" style="margin-bottom:20px;">
                      <input style="margin-right:10px;" class="btn btn-error" type="button" align='center' name="volver" value="Volver" onclick="javascript:window.history.back()" />
												<?php	
													$_SESSION['tokenbtokenb'] = $anticachecret;
												?>
												<a href="modules/ame/pdf.php?token=<?php echo $_SESSION['tokenbtokenb']; ?>" target="_blank">
														<input  class="btn btn-error"  type="button" align='center' name="Imprimir" value="Previsualizar Planilla de Inscripción" />
												</a>
										</div>		
								</div>
						</div>					
				</div> <!-- .grid -->
    
    
    
        <div class="grid-8">
				<div id="gettingStarted" class="box">
					<h3>Estimado, <?php echo $usuario_datos[1] . ' ' . $usuario_datos[2]  ; ?></h3>
					<p>En esta Sección podrá imprimir la planilla para la inclusión de AME Zulia, Recuerde que los datos de sus familiares deben de estar actualizados  para imprimir la misma.</p>
					<ul class="bullet secondary">
						<!-- <li><a href="dashboard.php?data=servfami">Servicios para los Familiares</a></li>-->
					</ul>
				</div>
			</div>
		</div> <!-- .row -->
</div> <!-- .container -->