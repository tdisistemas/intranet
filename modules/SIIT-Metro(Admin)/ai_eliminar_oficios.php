<?php
if (array_pop(explode('/', $_SERVER['PHP_SELF'])) != 'dashboard.php') {
    header("Location: ../../dashboard.php");
}
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
    notificar("Usted no tiene permisos para esta Seccion/Modulo", "dashboard.php?data=notificar", "notify-error");
    _wm($usuario_datos[9], 'Acceso Denegado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
}
_wm($usuario_datos[9], 'Acceso Autorizado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
if (!$_GET["flag"]) {
    ir('dashboard.php?data=oficios-ai');
}

if ($_GET["flag"]) {
    decode_get2($_SERVER["REQUEST_URI"], 2);
    $iddenun = _antinyeccionSQL($_GET["id"]);
    _bienvenido_mysql();
    $sql = "UPDATE ai_denuncias SET status = 9 WHERE idOficio = " . $iddenun;
    $result = mysql_query($sql) or die('Error Eliminando Oficio - ' . mysql_error());
    if ($result) {
        notificar("Oficio eliminado con exito", "dashboard.php?data=oficios-ai", "notify-error");
    } else {
        die(mysql_error());
    }
} else {
    ir("dashboard.php?data=oficios-ai");
}
?>
