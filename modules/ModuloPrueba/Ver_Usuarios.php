<?php
if (array_pop(explode('/', $_SERVER['PHP_SELF'])) != 'dashboard.php') {
    header("Location: ../../dashboard.php");
}
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
    notificar("Usted no tiene permisos para esta Sección/Módulo", "dashboard.php?data=notificar", "notify-error");
    _wm($usuario_datos[9], 'Acceso Denegado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
}
_wm($usuario_datos[9], 'Acceso Autorizado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
?>


<div id="contentHeader">
    <h2>Lista de Usuarios/Prueba</h2>
</div> <!-- #contentHeader -->	

<div class="container">
    <?php include('notificador.php'); ?>
    <div class="grid-24">	
        <div class="widget widget-plain">
            <?php
            _bienvenido_mysql();
            mysql_query("set names utf8");

            $sqlcode = "SELECT * ";
            $sqlcode.="FROM ";
            $sqlcode.="metro_inextranet.Prueba_User ";
            $sqlcode.="WHERE status = 0";

            $sql = mysql_query($sqlcode);
            ?>
            <div class="widget-content">
                <div class="dashboard_report first activeState">
                    <div class="pad">
                        <span class="value"><?php echo mysql_num_rows($sql); ?></span> Total de Usuarios/Prueba
                    </div> <!-- .pad -->
                </div>
            </div> <!-- .widget-content -->

        </div> <!-- .widget -->	
    </div> <!-- .grid -->

    <div class="grid-24">	
        <div class="widget widget-table">
            <div class="widget-header">
                <span class="icon-list"></span>
                <h3 class="icon chart">Registro de Usuarios/Prueba</h3>		
                <span class="icon-user"></span>
                <h3 class="icon chart"><a href="dashboard.php?data=pruebainsert" style="color: white;text-decoration: none;">Agregar Usuario</a></h3>		
            </div>
            <div class="widget-content">
                <table class="table table-bordered table-striped data-table">
                    <thead>
                        <tr>
                            <th style="width:30%">Nombre y Apellido</th>
                            <th style="width:20%">Cedula</th>
                            <th style="width:35%">Correo</th>
                            <th style="width:15%">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysql_fetch_array($sql)) {
                            ?>
                            <tr class="gradeA">
                                <td><?php echo $row[1] ?></td>
                                <td><?php echo $row[2] ?></td>
                                <td><?php echo $row[3] ?></td>
                                <td class="center">
                                    <?php
                                    $parametros = 'id=' . $row[0];
                                    $parametros = _desordenar($parametros);
                                    ?>  
                                    <a href="dashboard.php?data=pruebaupdate&flag=1&<?php echo $parametros; ?>" id="editar" title="Editar" >
                                        <div class="icons-holder" style="float:left;margin-left:15px"><span class="icon-pen-alt-fill"></span></div>
                                    </a>
                                    <a href="javascript:eliminar('<?php echo $row["Nombre"] ?>','dashboard.php?data=pruebadelete&flag=1&<?php echo $parametros; ?>')" id="eliminar-us" title="Eliminar" >
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
</div> <!-- .container -->
<script type="text/javascript">
    function eliminar(perfil, param) {
        $.alert({
            type: 'confirm'
            , title: 'Alerta'
            , text: '<h3>¿Desea eliminar el Usuario: <u>' + perfil + '</u> ?</h3>'
            , callback: function() {
                window.location = param;
            }
        });
    }
</script>