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
    <h2>Lista de Denuncias</h2>
</div> <!-- #contentHeader -->	

<div class="container">
    <?php
    include('notificador.php');
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
                            <th style="width:10%">Código</th>
                            <th style="width:10%">Fecha</th>
                            <th style="width:25%">Denunciante</th>
                            <th style="width:5%">Estatus</th>
                            <th style="width:5%">Tipo</th>
                            <th style="width:35%">Descripción</th>
                            <th style="width:10%">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysql_fetch_array($sql)) {
                            $color = false;
                            switch ($row['status']) {
                                case 0: $st = "Espera";
                                    $titulo = "En espera.";
                                    break;
                                case 1: $st = "Activo";
                                    $titulo = "Averiguación Abierta.";
                                    break;
                                case 2: $st = "Cerrar";
                                    $titulo = "Averiguación Finalizada.";
                                    Break;
                                case 9: $st = "Eliminar";
                                    $color = 'red';
                                    $titulo = "Descartada.";
                                    break;
                            }
                            ?>
                            <tr class="gradeA">
                                <td><?php echo $row['codigo'] ?></td>
                                <td><?php echo $row['fecha'] ?></td>
                                <td style="text-align: left"><?php echo $row['nombre'] . " " . $row['apellido'] ?></td>
                                <td><span><?php echo iconosIntranet($st, $titulo,false,$color,false)?></span></td>
                                <td><?php echo $row['tipo'] ?></td>
                                <td style="text-align: left"><?php echo $row['descripcion'] ?></td>

                                <td style="text-align: left" class="center" >
                                    <?php
                                    $parametros = 'id=' . $row["idDenuncia"];
                                    $parametros = _desordenar($parametros);
                                    ?>  
                                    <a href="dashboard.php?data=denuncia-ai-info&flag=1&<?php echo $parametros; ?>" id="editar" title="Información" >
                                        <?php echo iconosIntranet('Informacion', 'Información',true,'black',false)?>
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
            <p>En esta sección podrá visualizar la lista de Denuncias registradas.</p>
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th style="font-weight:bold">Estatus de Denuncias</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo iconosIntranet('Espera', '',false,'black','12px')?></td>
                        <td>- En Espera.</td>
                    </tr>
                    <tr>
                        <td><?php echo iconosIntranet('Activo', '',false,'black','12px')?></td>
                        <td>- Averiguación Abierta.</td>
                    </tr>
                    <tr>
                        <td><?php echo iconosIntranet('Cerrar', '',false,'black','12px')?></td>
                        <td>- Averiguación Finalizada.</td>
                    </tr>
                    <tr>
                        <td><?php echo iconosIntranet('Eliminar', '',false,'red','12px')?></td>
                        <td>- Descartado.</td>
                    </tr>
                </tbody>
            </table>
            <br>
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