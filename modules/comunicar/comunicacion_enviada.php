<?php 
if (array_pop(explode('/', $_SERVER['PHP_SELF']))!='dashboard.php') {ir("../../dashboard.php");}
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
	notificar("Usted no tiene permisos para esta Sección/Módulo", "dashboard.php?data=notificar", "notify-error");
	_wm($usuario_datos[9],'Acceso Denegado en: '.ucwords(array_pop(explode('/', __dir__))),'S/I');
} 
_wm($usuario_datos[9],'Acceso Autorizado en: '.ucwords(array_pop(explode('/', __dir__))),'S/I');
?>
<div id="contentHeader">
  <h2>Comunicaciones </h2>  
</div>
<div class="container">
  <div class="grid-24">
    <form class="form uniformForm" action="#" method="post">
     <br />
    </form>
    <div class="widget widget-table">
      <div class="widget-header"> <span class="icon-cog"></span>
         <?php
          _bienvenido_mysql();
$ui=$usuario_datos[1] . ' ' . $usuario_datos[2];
          ?>
          <h3 class="icon chart">Comunicaciones Enviadas</h3>
      </div>
      <div class="widget-content">
        <table class="table table-bordered table-striped data-table">
          <thead>
            <tr>
                 
                <th width="100">Para</th>
                
                <th width="150">Asunto</th>  
                  <th width="150">Destino </th>
               <th width="50">Fecha</th>
                <th width="50">Código</th> 
                       
             <th style="width:8%">Opciones</th>
                           </tr>
          </thead>
          <tbody>
            <?php  
_bienvenido_mysql();

$sql=mysql_query("SELECT  * 
FROM  `comunicacion_codigo` 
WHERE  `de` LIKE  '%$ui%' and tipo like '%int%' order by id_com asc");
while($row_cont=mysql_fetch_array($sql)){

    $id_com=$row_cont['id_com'];
    $de=$row_cont['de'];
    $para=$row_cont['para'];
    $gerencia=$row_cont['gerencia'];
    $asunto=$row_cont['asunto'];
    
    $codigo=$row_cont['consecutivo'];
    $cuerpo=$row_cont['cuerpo'];
    $fecha=$row_cont['fecha'];
$para1=(explode("-",$para));


?>
            <tr class="gradeA">
                <td><?php echo $para1[0];?></td>
                <td><?php echo $row_cont["asunto"]?></td>
               
                <td><?php echo $row_cont["destino"]?></td>
                                <td><?php echo $row_cont["fecha"]?></td>
                <td><?php echo $row_cont["consecutivo"]?></td>   
                                    
                  <td class="center">
                      
							<a href="modules/comunicar/ver_com.php?&token=<?php
                                                        echo  $anticachecret;?>&paso=<?php echo $id_com;?>" target="blank" id="editar" title="Abrir" >
									<div style="float:left;margin-left:15px"> <img src="iconos/enviados.jpg"/></div></a>
								
							</td> 
						</tr>									
						<?php } ?>  </tbody>  
        </table>
         <br> <br>

         
      </div> 
    </div>
  
 </div>
    </div>
          
     </div>
    </div>
 

            


            
            
