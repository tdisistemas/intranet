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
    <h2>Lista de Investigadores</h2>
</div> <!-- #contentHeader -->	

<div class="container">
    <?php
    include('notificador.php');
    _bienvenido_mysql();
    mysql_query("set names utf8");

    $sqlcode = "SELECT "
            . "i.id_invest,"
            . "i.cedula_invest,"
            . "d.cargo,d.nombre,"
            . "d.apellido,"
            . "i.status,"
            . "d.gerencia "
            . "FROM ai_investigadores i "
            . "INNER JOIN datos_empleado_rrhh d "
            . "WHERE i.cedula_invest = d.cedula ";

    $sql = mysql_query($sqlcode);
    $a = mysql_num_rows($sql);
    ?>

    <div class="grid-18">	
        <div class="widget widget-table">
            <div class="widget-header">
                <span class="icon-list"></span>
                <h3 class="icon chart">Registro de Investigadores</h3>
            </div>
            <div class="widget-content">
                <table class="table table-bordered table-striped data-table">
                    <thead>
                        <tr>
                            <th style="width:10%">Cédula</th>
                            <th style="width:40%">Nombre y Apellido</th>
                            <th style="width:5%">Estatus</th>
                            <th style="width:35%">Cargo</th>
                            <th style="width:10%">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysql_fetch_array($sql)) {
                            switch ($row['status']) {
                                case 0: $st = "Activo";
                                    $act = "Inactivo";
                                    $tit_act = "Desactivar";
                                    $titulo = 'Activo';
                                    break;
                                case 1: $st = "Inactivo";
                                    $act = "Activo";
                                    $tit_act = "Activar";
                                    $titulo = 'Inactivo';
                                    break;
                            }
                            ?>
                            <tr class="gradeA">
                                <td><?php echo $row['cedula_invest'] ?></td>
                                <td><?php echo $row['nombre'] . " " . $row['apellido'] ?></td>
                                <td style="text-align: center"><span><?php echo iconosIntranet($st, $titulo,false,false,false)?></span></td>
                                <td><?php echo $row['cargo'] ?></td>
                                <td class="center">
                                    <?php
                                    $row['status'] == '1' ? $acc = '0' : $acc = '1';
                                    $parametros = 'id=' . $row["id_invest"] . '&acc=' . $acc;
                                    $parametros = _desordenar($parametros);
                                    $parametros2 = 'cedula=' . $row["cedula_invest"];
                                    $parametros2 = _desordenar($parametros2);
                                    ?>  
                                    <a href="dashboard.php?data=investigador-ai-info&flag=1&<?php echo $parametros2; ?>" id="editar" title="Información" >
                                        <?php echo iconosIntranet('Informacion', 'Información',true,'black',false)?>
                                    </a>
                                    <a href="javascript:CambiarStatus_Investigador('<?php echo $row['nombre'] . " " . $row['apellido'] ?>','dashboard.php?data=investigador-ai-eliminar&flag=1&<?php echo $parametros; ?>','<?= $row['status'] ?>')" id="eliminar-us" title="<?= $tit_act ?>" >
                                        <?php echo iconosIntranet($act, $tit_act,true,'black',false)?>
                                    </a>
                                </td>
                            </tr>									
                            <?php
                        }
                        ?> 
                    </tbody>
                </table>
            </div> <!-- .widget-content -->
        </div>
    </div> <!-- .grid -->
    <div class="grid-6">
        <div id="gettingStarted" class="box">
            <h3>Estimado, <?php echo $usuario_datos['nombre'] . " " . $usuario_datos['apellido']; ?></h3>
            <p>En esta sección podrá la lista de los investigadores de Asuntos Internos</p>
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th style="font-weight:bold">Estatus de Investigadores</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo iconosIntranet('Activo', '',false,'black','12px')?></td>
                        <td>- Activo.</td>
                    </tr>
                    <tr>
                        <td><?php echo iconosIntranet('Inactivo', '',false,'black','12px')?></td>
                        <td>- Inactivo.</td>
                    </tr>
                </tbody>
            </table>
            <br>
            <div class="box plain">
                <a href="dashboard.php?data=add_investigadores" class="btn btn-primary btn-large dashboard_add">Agregar Investigador</a>
                <a class="btn btn-primary btn-large dashboard_add" onclick="javascript:window.history.back();">Regresar</a>
            </div>
        </div>
    </div>

</div> <!-- .container -->
<?php
_adios_mysql();
?>
<script type="text/javascript">
    function CambiarStatus_Investigador(perfil, param, tipo) {
        var tipo_accion;
        if (tipo == 1) {
            tipo_accion = "reactivar";
        } else {
            tipo_accion = "desactivar";
        }
        $.alert({
            type: 'confirm'
            , title: 'Alerta'
            , text: '<h3>¿Desea ' + tipo_accion + ' al investigador: <u>' + perfil + '</u> ?</h3>'
            , callback: function () {
                window.location = param;
            }
        });
    }
</script>