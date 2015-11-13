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
    <h2>Lista de Denuncias</h2>
</div> <!-- #contentHeader -->	

<div class="container">
    <?php include('notificador.php'); ?>



    <div class="grid-24">	
        <div class="widget widget-plain">

            <div class="widget-content">

                <?php
                _bienvenido_mysql();
                mysql_query("set names utf8");

                $sqlcode = "SELECT "
                        . "d.idDenuncia,"
                        . "d.fecha,"
                        . "d.denunciante,"
                        . "d.tipo,"
                        . "d.status,"
                        . "d.descripcion,"
                        . "de.nombre,"
                        . "de.cedula,"
                        . "d.codigo,"
                        . "de.apellido "
                        . "FROM ai_denuncias d "
                        . "INNER JOIN datos_empleado_rrhh de "
                        . "WHERE d.denunciante = de.cedula ";



                $sql = mysql_query($sqlcode);
                $a = mysql_num_rows($sql);
                ?>

                <div style="margin-left: 400px;" class="dashboard_report first activeState">
                    <div class="pad" align="center">
                        <span class="value"><?php echo $a; ?></span> Total de Denuncias
                    </div> <!-- .pad -->
                </div>



            </div> <!-- .widget-content -->

        </div> <!-- .widget -->	
    </div> <!-- .grid -->

    <div class="grid-18">	
        <div class="widget widget-table">
            <div class="widget-header">
                <span class="icon-list"></span>
                <h3 class="icon chart">Registro de Denuncias</h3>
            </div>
            <div class="widget-content">
                <table class="table table-bordered table-striped data-table">
                    <thead>
                        <tr>
                            <th style="width:10%">Codigo</th>
                            <th style="width:10%">Fecha</th>
                            <th style="width:25%">Denunciante</th>
                            <th style="width:10%">Tipo</th>
                            <th style="width:30%">Descripción</th>
                            <th style="width:15%">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysql_fetch_array($sql)) {
                            ?>
                            <tr class="gradeA">
                                <td><?php echo $row['codigo'] ?></td>
                                <td><?php echo $row['fecha'] ?></td>
                                <td><?php echo $row['nombre'] . " " . $row['apellido'] ?></td>
                                <td><?php echo $row['tipo'] ?></td>
                                <td><?php echo $row['descripcion'] ?></td>

                                <td class="center" >
                                    <?php
                                    $parametros = 'id=' . $row["idDenuncia"];
                                    $parametros = _desordenar($parametros);
                                    ?>  
                                    <a href="dashboard.php?data=denuncia-ai-info&flag=1&<?php echo $parametros; ?>" id="editar" title="Información" >
                                        <i class="fa fa-info-circle" style="color: black; font-size: 15px"></i>
                                    </a>
                                    <a href="javascript:eliminar('<?php echo $row['codigo'] ?>','dashboard.php?data=denuncia-ai-eliminar&flag=1&<?php echo $parametros; ?>')" id="eliminar-us" title="Eliminar" >
                                        <i class="fa fa-trash-o" style="color: black; font-size: 15px"></i>
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
            <p>En esta seccion podra visualizar la lista de Denuncias registradas.</p>
            <div class="box plain">
                <a class="btn btn-primary btn-large dashboard_add" href="dashboard.php?data=add_denuncias" style="color: white;text-decoration: none;">Agregar Denuncia</a>
                <a class="btn btn-primary btn-large dashboard_add" onclick="javascript:window.history.back();">Regresar</a>
            </div>
        </div>
    </div>
</div> <!-- .container -->
<script type="text/javascript">
    function eliminar(perfil, param) {
        $.alert({
            type: 'confirm'
            , title: 'Alerta'
            , text: '<h3>¿Desea eliminar la denuncia: <u>' + perfil + '</u> ?</h3>'
            , callback: function () {
                window.location = param;
            }
        });
    }
</script>