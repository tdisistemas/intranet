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
    ir('dashboard.php?data=investigadores');
}

if ($_GET["flag"]) {
    decode_get2($_SERVER["REQUEST_URI"], 2);
    _bienvenido_mysql();

    $idinvest = _antinyeccionSQL($_GET["id"]);
    $st = _antinyeccionSQL($_GET["acc"]);
    $sqlConsulta = "SELECT perfil, cedula_invest FROM ai_investigadores WHERE id_invest = " . $idinvest;
    $ConsultaResult = mysql_fetch_array(mysql_query($sqlConsulta));
    if ($st == '1') {
        
        $sqlPerfil = "UPDATE autenticacion SET perfil=" . $ConsultaResult['perfil'] . " WHERE cedula = " . $ConsultaResult['cedula_invest'];
        mysql_query($sqlPerfil);
        $accion = "desactivado";
        
    } elseif ($st == '0') {
        
        $sqlPerfil = "UPDATE autenticacion SET perfil=38 WHERE cedula = " . $ConsultaResult['cedula_invest'];
        mysql_query($sqlPerfil);
        $accion = "activado";
        
    }
    $sql = "UPDATE ai_investigadores SET status = " . $st . " WHERE id_invest = " . $idinvest;
    $result = mysql_query($sql) or die('Error Eliminando Investigador - ' . mysql_error());
    if ($result) {
        notificar("Investigador ".$accion." con éxito", "dashboard.php?data=investigadores", "notify-success");
    } else {
        die(mysql_error());
    }
} else {
    ir("dashboard.php?data=investigadores");
}
?>
