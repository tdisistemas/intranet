<?php

//CAMBIAR PARAMETROS
require("../../conexiones_config.php");
session_start();
if (!isset($_SESSION[md5('usuario_datos' . $ecret)])) {
    ir("../../index.php");
}
$usuario_datos = $_SESSION[md5('usuario_datos' . $ecret)];
$usuario_permisos = $_SESSION[md5('usuario_permisos' . $ecret)];
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
    notificar("Usted no tiene permisos para esta Seccion/Modulo", "dashboard.php?data=notificar", "notify-error");
    _wm($usuario_datos[9], 'Acceso Denegado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
}
_wm($usuario_datos[9], 'Acceso Autorizado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
/* if ($_SESSION['tokeconst']!=$_GET['token']){
  alerta('Autenticacion de token de seguridad fallido, se procederá a recargar la página, Disculpen las molestias causadas, pero recuerde que es por seguridad.');
  ir("../../dashboard.php?data=fas");
  }
  unset($_SESSION['Fas']); */

_bienvenido_mysql();
$fecha_ingreso = _dametipoempyfechainicio($usuario_datos[3], 2);

$empleado2 = $_POST["familiar"];
$fuma = $_POST["fuma"];
$poliza = $_POST["poliza"];
$maternidad = $_POST["maternidad"];
$intervencion = $_POST["intervencion"];
$nombre_pol = $_POST["nombre_poliza"];
$cedula_fam = $_POST["cedula_fam_emp"];
$tipo_int = $_POST["tipo_int"];
$ano = date('Y');
$estatus = _dameestatus($usuario_datos[3]);
$nombre = _damenombre($cedula_fam);

if ($estatus != 1) {
    $codigo = mysql_fetch_array(mysql_query("select consecutivo('RRHH','FAS','$ano')"));
    $fas = "INSERT INTO `fas_adicional` (`cedula_empleado`, `maternidad`, `posee_fam_emp`, `familiar_empleado_ced`, `nombre_empleado_fam`, `poliza`, `tipo_poliza`, `fuma`, `intervencion`, `tipo_intervencion`,codigo,estatus) VALUES ( '$usuario_datos[3]', '$maternidad', '$empleado2', '$cedula_fam', '$nombre', '$poliza', '$nombre_pol', '$fuma', '$intervencion', '$tipo_int','$codigo[0]','1');";
    $result = mysql_query($fas);
}

if (isset($_POST['familiares']) && !empty($_POST['familiares'])) {
    $bandera = 0;
    $Datos = array();
    foreach ($_POST['familiares'] as $arreglo) {

        $Datos[$bandera] = $arreglo;
        if ($bandera === 3 && ($Datos[2]!= '0' || $Datos[3]=='1')) {
            if ($Datos[3] === '1') {
                $FAS = 'A';
            } else {
                $FAS = 'I';
            }
            $sql = "INSERT INTO `metro_inextranet`.`fas` (cedula_empleado,cedula_familiar,enfermedad,vida,accidente,codigo,fas) VALUES ($usuario_datos[3],'$Datos[0]', '$Datos[1]','$Datos[2]', '$Datos[2]','$codigo[0]','$FAS');";
            $result = mysql_query($sql);
            if (!$result) {
                if ($SQL_debug == '1') {
                    die('Error Auditando - Respuesta del Motor: ' . mysql_error());
                } else {
                    die('Error Auditando');
                }
            }
        }
        if ($bandera === 3) {
            $bandera = 0;
        } else {
            $bandera++;
        }
    }
}

if (!$result) {
    if ($SQL_debug == '1') {
        die('Error Auditando - Respuesta del Motor: ' . mysql_error());
    } else {
        die('Error Auditando');
    }
}
$sqlq = mysql_query("SELECT * FROM `datos_empleado_rrhh` d left join datos_empleado_titulo t on(d.titulo=t.tipo) left join datos_empleado_profesion p on (d.profesion=p.tipo_p) left join datos_empleado_estado e on (e.estado=d.estado) left join datos_empleado_municipio m on (d.municipio=m.municipio) left join datos_empleado_parroquia q on (d.parroquia=q.parroquia) where d.cedula=$usuario_datos[3] ");
$row = mysql_fetch_array($sqlq);
_adios_mysql();
if ($row) {
    notificar("Registro del FAS realizado con éxito", "javascript:window.history.go(-1)", "notify-success");
}
?>   