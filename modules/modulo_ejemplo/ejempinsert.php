<?php
if (array_pop(explode('/', $_SERVER['PHP_SELF'])) != 'dashboard.php') {
    header("Location: ../../dashboard.php");
}
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
    notificar("Usted no tiene permisos para esta Seccion/Modulo", "dashboard.php?data=notificar", "notify-error");
    _wm($usuario_datos[9], 'Acceso Denegado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
}
_wm($usuario_datos[9], 'Acceso Autorizado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
?>

<?php 
include("coneccion.php");

    $sql = 'SELECT cedula, nombre, apellido, correo, telefono FROM t_ejemplo';
    $exce_query = mysql_query($sql);
    $numRows = 0;
?>

<div id="contentHeader">
    <h2>Administración del Módulo Ejemplo</h2>
</div> <!-- #contentHeader -->	

<div class="container">
    <div class="row">
        <div class="grid-16">				
            <div class="widget">			

                <div class="widget-header">
                    <span class="icon-layers"></span>
                    <h3>Registros de Prueba</h3>
                </div>

                <div class="widget-content">
                    <p>Usuarios Registrados</p>
                    <br/>
                    <table class="table table-striped" border="1" cellpadding="2" cellspacing="0" align="center">
                        <tbody>
                            <tr>
                                <td align="center"><b>Cédula</b></td>
                                <td align="center"><b>Nombres</b></td>
                                <td align="center"><b>Apellidos</b></td>
                                <td align="center"><b>Correo</b></td>
                                <td align="center"><b>Teléfono</b></td>
                            </tr>
                                 <?php while($row_cont = mysql_fetch_array($exce_query)){
                                    $numRows++; ?>
                                    <tr >
                                    <td align="center"><?php echo $row_cont["cedula"] ?></td>
                                     <td align="center"><?php echo $row_cont["nombre"] ?></td>
                                     <td align="center"><?php echo $row_cont["apellido"]?></td>
                                     <td align="center"><?php echo $row_cont["correo"] ?></td>
                                     <td align="center"><?php echo $row_cont["telefono"]?></td>
                                   </tr>
                                <?php }  ?>  
                        </tbody>
                    </table>
                    <?php if($numRows == 0){?>
                            
                        <p align="center"><b>No existen registros</b></p>

                    <?php }else{?> 
                        <p>Numero de registros: <?php echo $numRows;?></p>
                   <?php }  ?>                 
                        
                        
                </div>

            </div>					
        </div> <!-- .grid -->

        <div class="grid-8">				
            <div class="widget">			

                <!--							<div class="widget-header">
                                                                <span class="icon-layers"></span>
                                                                        <h3>8 Columns</h3>
                                                                </div>-->

                <div class="widget-content">
                    <h3>Estimado, <?php echo $usuario_datos[1] . ' ' . $usuario_datos[2]; ?></h3>
                    <p>En esta sección podrá registrar, editar, eliminar y buscar usuarios de la tabla ejemplo</p>
                </div>

            </div>					
        </div> <!-- .grid -->	
    </div> <!-- .row -->
</div> <!-- .container -->
