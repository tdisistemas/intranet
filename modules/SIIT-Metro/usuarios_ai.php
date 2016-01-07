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
                ?>
            </div> <!-- .widget-content -->
        </div> <!-- .widget -->	
    </div> <!-- .grid -->
    <div class="grid-18">	
        <div class="widget widget-table">
            <div class="widget-header">
                <span class="icon-list"></span>
                <h3 class="icon chart">Registro de Usuarios/Empleados</h3>
            </div>
            <div class="widget-content">
                <table class="table table-bordered table-striped data-table">
                    <thead>
                        <tr>
                            <th style="width:15%">Cédula</th>
                            <th style="width:40%">Nombre y Apellido</th>
                            <th style="width:35%">Gerencia</th>
                            <th style="width:10%">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sqlcode = "SELECT usuario_bkp.id_usuario,usuario_bkp.nombre,usuario_bkp.apellido,usuario_bkp.usuario,autenticacion.clave,
                        usuario_bkp.correo_corporativo,usuario_bkp.correo_principal,
                        usuario_bkp.telefono,usuario_bkp.habilitado,usuario_bkp.usuario_int,'disponible',autenticacion.perfil,perfiles.perfil AS perfil_nom,perfiles.role AS role,usuario_bkp.ubicacion_laboral
                        FROM usuario_bkp LEFT JOIN autenticacion ON autenticacion.cedula = usuario_bkp.usuario LEFT JOIN perfiles ON autenticacion.perfil = perfiles.id WHERE usuario_bkp.habilitado =1 ";
                        $sql = mysql_query($sqlcode);
                        while ($row = mysql_fetch_array($sql)) {
                            ?>
                            <tr class="gradeA">
                                <td><?php echo $row[3] ?></td>
                                <td><?php echo $row[1] . " " . $row[2] ?></td>
                                <td><?php echo $row[14] ?></td>
                                <td class="center">
                                    <?php
                                    $parametros = 'cedula=' . $row[3];
                                    $parametros .= '&Origen=admin_ai';
                                    $parametros = _desordenar($parametros);
                                    ?>  
                                    <a href="dashboard.php?data=usuario-ai-info&flag=1&<?php echo $parametros; ?>" id="editar" title="Información" >
                                        <i class="fa fa-info-circle" style="color: black; font-size: 15px"></i>
                                    </a>
                                </td>
                            </tr>									
                        <?php } ?> 
                    </tbody>
                </table>
            </div> <!-- .widget-content -->
        </div>
    </div> <!-- .grid -->
    <div class="grid-6">
        <div id="gettingStarted" class="box">
            <h3>Estimado, <?php echo $usuario_datos['nombre'] . " " . $usuario_datos['apellido']; ?></h3>
            <p>En esta sección podrá visualizar la lista de los Empleados de la Empresa.</p>
            <div class="box plain">
                
            </div>
        </div>
    </div>
</div> <!-- .container -->
<script type="text/javascript">
    function eliminar(perfil, param) {
        $.alert({
            type: 'confirm'
            , title: 'Alerta'
            , text: '<h3>¿Desea eliminar el perfil: <u>' + perfil + '</u> ?</h3>'
            , callback: function () {
                window.location = param;
            }
        });
    }
</script>