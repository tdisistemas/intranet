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
<style>
    .gradeA > td{
        vertical-align:middle;
        text-align: center;
    }
</style>
<div id="contentHeader">
    <h2>Lista de Oficios</h2>
</div> <!-- #contentHeader -->	

<div class="container">
    <?php
    include('notificador.php');
    _bienvenido_mysql();
    mysql_query("set names utf8");

    $sqlcode = "SELECT "
            . "d.idOficio,"
            . "d.fecha,"
            . "d.tipo,"
            . "d.status,"
            . "d.descripcion,"
            . "d.codigo "
            . "FROM ai_oficios d ";



    $sql = mysql_query($sqlcode);
    $a = mysql_num_rows($sql);
    ?>

    <div class="grid-18">	
        <div class="widget widget-table">
            <div class="widget-header">
                <span class="icon-list"></span>
                <h3 class="icon chart">Registro de Oficios</h3>
            </div>
            <div class="widget-content">
                <table class="table table-bordered table-striped data-table">
                    <thead>
                        <tr>
                            <th style="width:15%">Código</th>
                            <th style="width:10%">Fecha</th>
                            <th style="width:10%">Tipo</th>
                            <th style="width:5%">Estatus</th>
                            <th style="width:50%">Descripción</th>
                            <th style="width:10%">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysql_fetch_array($sql)) {
                            switch ($row['status']) {
                                case 0: $st = "clock-o";
                                    $color = "#8B8B8B";
                                    $titulo = "En espera.";
                                    break;
                                case 1: $st = "check";
                                    $color = "#1100CD";
                                    $titulo = "Averiguación Abierta.";
                                    break;
                                case 2: $st = "lock";
                                    $color = "green";
                                    $titulo = "Averiguación Finalizada.";
                                    Break;
                                case 9: $st = "trash";
                                    $color = "red";
                                    $titulo = "Descartado.";
                                    break;
                            }
                            ?>
                            <tr class="gradeA">
                                <td><?php echo $row['codigo'] ?></td>
                                <td><?php echo $row['fecha'] ?></td>
                                <td><?php echo $row['tipo'] ?></td>
                                <td><span><i class="fa fa-<?= $st ?>" title="<?= $titulo ?>" style="vertical-align: central; cursor: pointer; font-size: 15px; color: <?php echo '#8B8B8B'//$color   ?>" ></i></span></td>
                                <td style="text-align: left"><?php echo $row['descripcion'] ?></td>

                                <td style="text-align: left" >
                                    <?php
                                    $parametros = 'id=' . $row["idOficio"];
                                    $parametros = _desordenar($parametros);
                                    ?>  
                                    <a href="dashboard.php?data=oficios-ai-info&flag=1&<?php echo $parametros; ?>" id="editar" title="Información" >
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
            <p>En esta sección podrá visualizar la lista de Oficios registrados.</p>
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th style="font-weight:bold">Estatus de Oficios</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><i class="fa fa-clock-o"></i></td>
                        <td>- En Espera.</td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-trash"></i></td>
                        <td>- Descartado.</td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-check"></i></td>
                        <td>- Averiguación Abierta.</td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-lock"></i></td>
                        <td>- Averiguación Finalizada.</td>
                    </tr>
                </tbody>
            </table>
            <br>
            <div class="box plain">
                <a class="btn btn-primary btn-large dashboard_add" href="dashboard.php?data=add_oficios" style="color: white;text-decoration: none;">Agregar Oficio</a>
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
            , text: '<h3>¿Desea eliminar el Oficio: <u>' + perfil + '</u> ?</h3>'
            , callback: function () {
                window.location = param;
            }
        });
    }
</script>