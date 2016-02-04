<?php

header('Content-Type: text/html; charset=UTF-8');

require("variables_config.php");

/* * ** */
$anticache = md5(date('U'));
$anticachecret = md5(date('U') . $ecret);
/* * ** */

/* * ********************************* */
/*  CODIGO CONSECUTIVO                 */
/* * ********************************* */

function _consecutivo($gerencia, $documento, $periodo) {
    require("variables_config.php");
    _bienvenido_mysql();

    $Ver = mysql_fetch_array(mysql_query("SELECT idDoc, contador FROM documentos_metro WHERE documento = '$documento' AND periodo = '$periodo'"));
    if ($Ver) {
        $Upd = mysql_query("UPDATE documentos_metro SET contador = contador + 1 WHERE idDoc = " . $Ver['idDoc']);
        $contador = $Ver['contador'];
    } else {
        mysql_query("INSERT INTO documentos_metro(documento,periodo,contador) VALUES('$documento','$periodo',2)");
        $contador = 1;
    }
    $consecutivo = str_pad($contador, 6, "0", STR_PAD_LEFT);

    _adios_mysql();
    return 'MM-' . $gerencia . '-' . $documento . '-' . $periodo . '-' . $consecutivo;
}

/* * ********************************* */
/*  DESCONEXION GEN					 */
/* * ********************************* */

function _adios_mysql() {
    require("variables_config.php");
    @mysql_close($bienvenido_mysql);
}

/* * ********************************* */
/* CONEXION GENERICA					 */
/* * ********************************* */

function _bienvenido_mysql() {
    require("variables_config.php");
    $bienvenido_mysql = mysql_connect($db0_host, $db0_user, $db0_pass);
    if ($bienvenido_mysql) {
        $db_bienvenido_mysql = mysql_select_db($db0_database, $bienvenido_mysql) or die(mysql_error());
        mysql_query("set names utf8");
    } else {
        if ($SQL_debug == '1') {
            die('Error en Conexion - Respuesta del Motor: ' . mysql_error());
        } else {
            die('Error en Conexion');
        }
    }
}

/* * ********************************* */
/* FUNCION DE AUDITORIA				 */
/* * ********************************* */

function _wm($usu, $msg, $obs) {
    require("variables_config.php");
    if ($wachsam == '1') {
        _bienvenido_mysql();
        $publica = @$_SERVER['REMOTE_ADDR'];
        if ($privada == '')
            $privada = 'S/I';
        $privada = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        if ($publica == '')
            $publica = 'S/I';
        if ($obs == '')
            $obs = 'S/I';
        $sql = "INSERT INTO auditoria (usuario, ip_wan, ip_proxy, operacion, observaciones)";
        $sql .="VALUES('" . $usu . "','" . $publica . "','" . $privada . "','" . $msg . "','" . $obs . "');";
        $result = mysql_query($sql);
        if (!$result) {
            if ($SQL_debug == '1') {
                die('Error Auditando - Respuesta del Motor: ' . mysql_error());
            } else {
                die('Error Auditando');
            }
        }
    }
}

/* * ********************************* */
/* FUNCION DE ENVIO DE MAIL					 */
/* * ********************************* */

function _enviarmail($mensaje, $nombre_de_destino, $destino, $asunto) {
    require("variables_config.php");
    date_default_timezone_set('America/Caracas');
    require_once('/var/www/html/intranet/src/classes/phpmailer/class.phpmailer.php');
    $fecha_hora = date("Y/m/d H:i:s");
    $mail = new PHPMailer();
    $mail->CharSet = 'UTF-8';
    //indico a la clase que use SMTP
    $mail->IsSMTP();
    //permite modo debug para ver mensajes de las cosas que van ocurriendo
    $mail->SMTPDebug = 0;
    //Debo de hacer autenticación SMTP
    $mail->SMTPAuth = true;
    //indico el servidor de Gmail para SMTP
    $mail->Host = "correo.metrodemaracaibo.gob.ve";
    //indico el puerto que usa Gmail
    $mail->Port = 25;
    //indico un usuario / clave de un usuario de gmail
    $mail->Username = "postmaster@metrodemaracaibo.gob.ve";
    $mail->Password = "CF0xiMPi";
    $mail->SetFrom('postmaster@metrodemaracaibo.gob.ve', 'Intranet del Metro de Maracaibo');
    $mail->AddReplyTo('no-responder@metrodemaracaibo.gob.ve', 'Intranet del Metro de Maracaibo');
    $mail->Subject = $asunto;
    $mail->MsgHTML($mensaje);
    //indico destinatario
    $address = $destino;
    $mail->AddAddress($destino, $nombre_de_destino);
    if (!$mail->Send()) {
        alertadev("ss");
        return 0; //"Error al enviar: " . $mail->ErrorInfo;
    } else {
        return 1;
    }
}

/* * ********************************* */
/* FUNCION DE ENVIO DE MAIL					 */
/* * ********************************* */

function _enviarmail_dev($mensaje, $nombre_de_destino, $destino, $asunto) {
    require("variables_config.php");
    $file = fopen("/var/www/intranet/mailmonitor/correos.html", "a");
    if (file) {
        fputs($file, "Para: " . $nombre_de_destino . "<" . $destino . ">");
        fputs($file, "<br />");
        fputs($file, "Fecha: " . date("Y/m/d H:i:s"));
        fputs($file, "<br />");
        fputs($file, "Asunto: " . $asunto);
        fputs($file, "<br />");
        fputs($file, "<p>Mensaje:</p>");
        fputs($file, "<br />");
        fputs($file, "<hr />");
        fputs($file, $mensaje);
        fputs($file, "<hr />");
        fputs($file, "<br />");
        fputs($file, "<br />");
        fclose($file);
    }
}

/* * ********************************* */
/* FUNCION DE DAME SALARIOS 			 */
/* * ********************************* */

function _damesalarios($cedula, $array) {
    require("variables_config.php");
    _bienvenido_mysql();
    $sql = "SELECT cedula_empleado,salario,salarioi FROM ctrabajo_datos_empleados WHERE cedula_empleado = '" . $cedula . "'";
    $result = mysql_query($sql);
    $reg = mysql_fetch_array($result);
    if ($result) {
        return $reg[$array];
    } else {
        return 'Sin Datos';
    }
}

/* * ********************************* */
/* FUNCION DE DAME SALARIOS 			 */
/* * ********************************* */

function _damecargo($cedula) {
    require("variables_config.php");
    _bienvenido_mysql();
    $sql = "SELECT cedula,cargo FROM datos_empleado_rrhh WHERE cedula = '" . $cedula . "'";
    $result = mysql_query($sql);
    $reg = mysql_fetch_array($result);
    if ($result) {
        return $reg[1];
    } else {
        return 'Sin Datos';
    }
}

/* * *************************************** */
/* FUNCION DE CONSTACIA DE CAJA DE AHORROS */
/* * *************************************** */

function _damecajadeahorros($cedula) {
    require("variables_config.php");
    _bienvenido_mysql();
    $sql = "SELECT cedula_empleado, ca_estatus FROM `servicios_rrhh` WHERE cedula_empleado=" . $cedula . " ORDER by cedula_empleado DESC LIMIT 1";
    $result = mysql_query($sql);
    $reg = mysql_fetch_array($result);
    if ($result) {
        return $reg[1];
    } else {
        return 'Sin Datos';
    }
}

/* * ********************************* */
/* FUNCION DE TIPO DE EMPLEADO 			 */
/* * ********************************* */

function _dametipoempyfechainicio($cedula, $array) {
    require("variables_config.php");
    _bienvenido_mysql();
    $sql = "SELECT cedula, den_contrato, fec_ing FROM `encabezado_listin` WHERE cedula=" . $cedula . " ORDER by fec_pago DESC LIMIT 1";
    $result = mysql_query($sql);
    $reg = mysql_fetch_array($result);
    if ($result) {
        return $reg[$array];
    } else {
        return 'Sin Datos';
    }
}

/* * ********************************* */
/* FUNCION DE TIPO DE EMPLEADO 			 */
/* * ********************************* */

function _damefechaenletras($fecha) {

    if ($fecha == null) {
        return '*** ERROR EN FECHA POR FAVOR VERIFICAR ***';
        exit();
    }

    require("variables_config.php");

    $fechaarray = explode('-', $fecha);
    /*
     * 0 = año
     * 1 = mes
     * 2 = dia
     */
    switch ($fechaarray[1]) {
        case "01":
            $mes = "Enero";
            break;

        case "02":
            $mes = "Febrero";
            break;

        case "03":
            $mes = "Marzo";
            break;

        case "04":
            $mes = "Abril";
            break;

        case "05":
            $mes = "Mayo";
            break;

        case "06":
            $mes = "Junio";
            break;

        case "07":
            $mes = "Julio";
            break;

        case "08":
            $mes = "Agosto";
            break;

        case "09":
            $mes = "Septiembre";
            break;

        case "10":
            $mes = "Octubre";
            break;

        case "11":
            $mes = "November";
            break;

        case "12":
            $mes = "Diciembre";
            break;
    }
    return $fechaarray[2] . " de " . $mes . " del " . $fechaarray[0];
}

/* * ********************************** */
/* FUNCION DE FECHA PA LAS CONSTANCIA */
/* * ********************************** */

function _damefechaenletrasparaconstancia() {

    $d = date('d');
    $m = date('m');
    $a = date('Y');

    require("variables_config.php");

    $fechaarray = explode('-', $fecha);
    /*
     * 0 = año
     * 1 = mes
     * 2 = dia
     */

    switch ($m) {
        case "01":
            $mes = "Enero";
            break;

        case "02":
            $mes = "Febrero";
            break;

        case "03":
            $mes = "Marzo";
            break;

        case "04":
            $mes = "Abril";
            break;

        case "05":
            $mes = "Mayo";
            break;

        case "06":
            $mes = "Junio";
            break;

        case "07":
            $mes = "Julio";
            break;

        case "08":
            $mes = "Agosto";
            break;

        case "09":
            $mes = "Septiembre";
            break;

        case "10":
            $mes = "Octubre";
            break;

        case "11":
            $mes = "Noviembre";
            break;

        case "12":
            $mes = "Diciembre";
            break;
    }
    return "a los " . _ALetras($d) . " dias del mes de " . $mes . " del " . _ALetras($a) . " .";
}

/* * ********************************* */
/* FUNCION DE DAME CEDULA 			 */
/* * ********************************* */

function _damecedula_de_autenticacion($usu) {
    require("variables_config.php");
    _bienvenido_mysql();
    $sql = "SELECT * FROM autenticacion WHERE usuario_int = '" . $usu . "'";
    $result = mysql_query($sql);
    $reg = mysql_fetch_array($result);
    if ($result) {
        return $reg[1];
    } else {
        return '0';
    }
}

function _damecedula_de_usuario_bkp($usu) {
    require("variables_config.php");
    _bienvenido_mysql();
    $sql = "SELECT * FROM usuario_bkp WHERE usuario_int = '" . $usu . "'";
    $result = mysql_query($sql);
    $reg = mysql_fetch_array($result);
    if ($result) {
        return $reg[3];
    } else {
        return '0';
    }
}

/* * ********************************* */
/* FUNCION DE ENCRIPTACION           */
/* * ********************************* */

function _desordenar($string) {
    require("variables_config.php");
    $key = $ecret;
    $result = '';
    for ($i = 0; $i < strlen($string); $i++) {
        $char = substr($string, $i, 1);
        $keychar = substr($key, ($i % strlen($key)) - 1, 1);
        $char = chr(ord($char) + ord($keychar));
        $result.=$char;
    }
    return base64_encode($result);
}

function _ordenar($string) {
    require("variables_config.php");
    $key = $ecret;
    $result = '';
    $string = base64_decode($string);
    for ($i = 0; $i < strlen($string); $i++) {
        $char = substr($string, $i, 1);
        $keychar = substr($key, ($i % strlen($key)) - 1, 1);
        $char = chr(ord($char) - ord($keychar));
        $result.=$char;
    }
    return $result;
}

function decode_get2($string, $cantidaddeparametros) {
    $cad = split("[&]", $string); //separo la url desde el ?
    $string = $cad[$cantidaddeparametros]; //capturo la url desde el separador ? en adelante
    $string = _ordenar($string); //decodifico la cadena
    //procedo a dejar cada variable en el $_GET
    $cad_get = split("[&]", $string); //separo la url por &
    foreach ($cad_get as $value) {
        $val_get = split("[=]", $value); //asigno los valosres al GET
        $_GET[$val_get[0]] = utf8_decode($val_get[1]);
    }
}

function _desordenarperfil($string, $key) {
    require("variables_config.php");
    $key = $key . $ecret;
    $result = '';
    for ($i = 0; $i < strlen($string); $i++) {
        $char = substr($string, $i, 1);
        $keychar = substr($key, ($i % strlen($key)) - 1, 1);
        $char = chr(ord($char) + ord($keychar));
        $result.=$char;
    }
    return base64_encode($result);
}

function _ordenarperfil($string, $key) {
    require("variables_config.php");
    $key = $key . $ecret;
    $result = '';
    $string = base64_decode($string);
    for ($i = 0; $i < strlen($string); $i++) {
        $char = substr($string, $i, 1);
        $keychar = substr($key, ($i % strlen($key)) - 1, 1);
        $char = chr(ord($char) - ord($keychar));
        $result.=$char;
    }
    return $result;
}

/* * ********************************* */
/* FUNCION DE ALERTA		 			 */
/* * ********************************* */

function alerta($mensaje) {
    echo '<script type="text/javascript">alert("' . $mensaje . '");</script>';
}

function alertadev($mensaje) {
    echo '<script type="text/javascript">prompt("' . $mensaje . '", "' . $mensaje . '");</script>';
}

/* * ********************************* */
/* FUNCION DE REDIRECCION 			 */
/* * ********************************* */

function ir($url) {
    echo '<script type="text/javascript">window.location.href = "' . $url . '";</script>';
}

function irb($url) {
    echo '<script type="text/javascript">window.location.href = "' . $url . '"; target="_blank";</script>';
}

function irpopup($url, $w, $h) {
    echo '<script type="text/javascript">window.open ("' . $url . '", "reporte","location=1,status=1,scrollbars=1, width=' . $w . ',height=' . $h . '");</script>';
}

/* * ********************************* */
/* FUNCION DE NOTIFICACION			 */
/* * ********************************* */

function notificar($mensaje, $url, $tipo) { // notify-success: = verde | notify-warning: = amarillo 
    $_SESSION['notificar'] = '1';           // notify-error: = rojo | notify-info: = azul |  notify: gris
    $_SESSION['notificartipo'] = $tipo;
    $_SESSION['notificarmensaje'] = $mensaje;
    if ($url != '') {
        echo '<script type="text/javascript">window.location.href = "' . $url . '";</script>';
    }
}

/* <?php include('notificador.php'); ?> */

/* * ********************************* */
/* FUNCION DE GENERAR PASS			 */
/* * ********************************* */

function generapass() {
    $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    $longitudCadena = strlen($cadena);
    $pass = "";
    $longitudPass = 10;
    for ($i = 1; $i <= $longitudPass; $i++) {
        $pos = rand(0, $longitudCadena - 1);
        $pass .= substr($cadena, $pos, 1);
    }
    return $pass;
}

/* * ************************************ */
/* FUNCION DE GENERAR CODIGO CONSTANCIA */
/* * ************************************ */

function damecodigo($long) {

    $salt = "ABCDEFGHJKLMNPQRSTUWXZ";
    if (strlen($salt) == 0) {
        return '';
    }
    $i = 0;
    $str = '';
    srand((double) microtime() * 1000000);
    while ($i < $long) {
        $num = rand(0, strlen($salt) - 1);
        $str .= substr($salt, $num, 1);
        $i++;
    }
    return strtoupper($str . '-' . substr(date('U'), -7));
}

/* * ********************************* */
/* FUNCION DE LISTAR DIRECTORIOS 	 */
/* * ********************************* */

function listarmodulos() {

    $directorio = opendir("./modules");
    while ($archivo = readdir($directorio)) {
        $nombreArch = ucwords($archivo);
        if ($nombreArch != "." && $nombreArch != "..") {

            $listarmodulos[] = $nombreArch;
        }
    }
    return $listarmodulos;
    closedir($directorio);
}

function _antinyeccionSQL($valor) {
    $valor = str_ireplace("INSERT", "", $valor);
    $valor = str_ireplace("DELETE", "", $valor);
    $valor = str_ireplace("UPDATE", "", $valor);
    $valor = str_ireplace("SELECT", "", $valor);
    $valor = str_ireplace("COPY", "", $valor);
    $valor = str_ireplace("DELETE", "", $valor);
    $valor = str_ireplace("DROP", "", $valor);
    $valor = str_ireplace("DUMP", "", $valor);
    $valor = str_ireplace(" OR ", "", $valor);
    $valor = str_ireplace("%", "", $valor);
    $valor = str_ireplace("LIKE", "", $valor);
    $valor = str_ireplace("--", "", $valor);
    $valor = str_ireplace("^", "", $valor);
    $valor = str_ireplace("[", "", $valor);
    $valor = str_ireplace("]", "", $valor);
    $valor = str_ireplace("\\", "", $valor);
    $valor = str_ireplace("!", "", $valor);
    $valor = str_ireplace("¡", "", $valor);
    $valor = str_ireplace("?", "", $valor);
    $valor = str_ireplace("=", "", $valor);
    $valor = str_ireplace("&", "", $valor);
    return $valor;
}

function _antiXSS($data) {
    // Fix &entity\n;
    $data = str_replace(array('&amp;', '&lt;', '&gt;'), array('&amp;amp;', '&amp;lt;', '&amp;gt;'), $data);
    $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
    $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
    $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

    // Remove any attribute starting with "on" or xmlns
    $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

    // Remove javascript: and vbscript: protocols
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

    // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

    // Remove namespaced elements (we do not need them)
    $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

    do {
        // Remove really unwanted tags
        $old_data = $data;
        $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
    } while ($old_data !== $data);

    // we are done...
    return $data;
}

function _dardebajacorreoyproxy($correoInt) {  //username es el  CORREO INSTITUCIONAL JUAN!
    if ($correoInt == '') {
        return '0';
        exit();
    }
    require("variables_config.php");
    $correo_mysql = mysql_connect('190.121.230.146:64110', 'mysqlexterno', 'CF0xiMPi');
    if ($correo_mysql) {
        $db_correo_mysql = mysql_select_db('vmail', $correo_mysql);
        mysql_query("set names utf8");
    } else {
        if ($SQL_debug == '1') {
            alert('Error en Conexion - Respuesta del Motor: ' . mysql_error());
            return '0';
            @mysql_close($correo_mysql);
            exit();
        } else {
            alert('Error en Conexion');
            return '0';
            @mysql_close($correo_mysql);
            exit();
        }
    }
    $sql = "UPDATE mailbox SET active = '0', enabled = '0' WHERE local_part = '" . $correoInt . "';";
    $result = mysql_query($sql);
    if (!$result) {
        if ($SQL_debug == '1') {
            die('Error en Consulta de Sinconizacion con MTA - Respuesta del Motor: ' . mysql_error());
        } else {
            die('Error en Consulta de Sinconizacion con MTA');
        }
    }
    _adios_mysql();
}

function _correo_existe($correoInt) {  //username es el  CORREO INSTITUCIONAL JUAN!
    if ($correoInt == '') {

        return '0';
        exit();
    }
    require("variables_config.php");

    $correo_mysql = mysql_connect('190.121.230.146:64110', 'mysqlexterno', 'CF0xiMPi');

    if ($correo_mysql) {
        $db_correo_mysql = mysql_select_db('vmail', $correo_mysql);
        mysql_query("set names utf8");
    } else {
        if ($SQL_debug == '1') {
            alert('Error en Conexion - Respuesta del Motor: ' . mysql_error());
            return '0';
            @mysql_close($correo_mysql);
            exit();
        } else {
            alert('Error en Conexion');
            return '0';
            @mysql_close($correo_mysql);
            exit();
        }
    }
    $sql = "SELECT * FROM mailbox WHERE username = '" . $correoInt . "';";
    $result = mysql_query($sql);

    if (!$result) {
        if ($SQL_debug == '1') {
            die('Error en Consulta de Sinconizacion con MTA - Respuesta del Motor: ' . mysql_error());
        } else {
            die('Error en Consulta de Sinconizacion con MTA');
        }
    }

    $reg = mysql_fetch_array($result);
    $num_rows = mysql_num_rows($result);
    if ($num_rows >= 1) {
        return 'SI';
    } else {
        return 'NO';
    }
    _adios_mysql();
}

function _cambio_pass_rc($username, $clave) {  //username es el  CORREO INSTITUCIONAL JUAN!
    if ($username == '') {
        return '0';
        exit();
    } if ($clave == '') {
        return '0';
        exit();
    }

    require("variables_config.php");

    $correo_mysql = mysql_connect('190.121.230.146:64110', 'mysqlexterno', 'CF0xiMPi');

    if ($correo_mysql) {
        $db_correo_mysql = mysql_select_db('vmail', $correo_mysql);
        mysql_query("set names utf8");
    } else {
        If ($SQL_debug == '1') {
            alert('Error en Conexion - Respuesta del Motor: ' . mysql_error());
            return '0';
            @mysql_close($correo_mysql);
            exit();
        } else {
            alert('Error en Conexion');
            return '0';
            @mysql_close($correo_mysql);
            exit();
        }
    }

    $sql = "SELECT * FROM mailbox WHERE username = '" . $username . "';";
    $result = mysql_query($sql);
    if (!$result) {
        if ($SQL_debug == '1') {
            die('Error en Consulta de Sinconizacion con MTA - Respuesta del Motor: ' . mysql_error());
        } else {
            die('Error en Consulta de Sinconizacion con MTA');
        }
    }

    $reg = mysql_fetch_array($result);
    $num_rows = mysql_num_rows($result);

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    if ($num_rows == 1) {
        $result = mysql_query("UPDATE mailbox SET password = ENCRYPT('" . $clave . "',CONCAT('$1$',MD5(RAND()))), password_proxy = md5('" . $clave . "') WHERE username='" . $username . "'");
        if (!$result) {
            alerta('Actuamente no es posible su cambio de contraseña, por favor intente mas tarde, o comuniquese con la División de Sistemas de la Gerencia de Tecnología.');
            ir('dashboard.php');
        }

        if ($result) {
            return '1';
        } else {
            return '0';
        }
        @mysql_close($correo_mysql);
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    else {  // SI NO EXISTE!!!!!!!!!!!!!!!
        $usuario = explode("@", $username);
        $nombre = explode(".", $usuario[0]);

        $sql = "INSERT INTO vmail.mailbox ";
        $sql.="VALUES  ";
        $sql.="( ";
        $sql.="'" . $usuario[0] . $miedominio . "',  ";
        $sql.="ENCRYPT('" . $clave . "',CONCAT('$1$',MD5(RAND()))),  ";
        $sql.="md5('$clave'),  ";
        $sql.="'" . ucwords($nombre[0]) . " " . ucwords($nombre[1]) . "',  ";
        $sql.="'en_US',  ";
        $sql.="'/var/vmail',  ";
        $sql.="'vmail1',  ";
        $sql.="'metrodemaracaibo.gob.ve/" . substr($usuario[0], 0, 1) . "/" . substr($usuario[0], 1, 1) . "/" . substr($usuario[0], 2, 1) . "/" . $usuario[0] . "-" . date('Y.m.d.h.m.s') . "/',  ";
        $sql.="'512',  ";
        $sql.="'metrodemaracaibo.gob.ve',  ";
        $sql.="'',  ";
        $sql.="'',  ";
        $sql.="'normal',  ";
        $sql.="'',  ";
        $sql.="'0',  ";
        $sql.="'0',  ";
        $sql.="'1',  ";
        $sql.="'1',  ";
        $sql.="'1',  ";
        $sql.="'1',  ";
        $sql.="'1',  ";
        $sql.="'1',  ";
        $sql.="'1',  ";
        $sql.="'1',  ";
        $sql.="'1',  ";
        $sql.="'1',  ";
        $sql.="'1',  ";
        $sql.="'1',  ";
        $sql.="'1',  ";
        $sql.="'1',  ";
        $sql.="'1',  ";
        $sql.="'1',  ";
        $sql.="'0000-00-00 00:00:00',  ";
        $sql.="'0',  ";
        $sql.="'',  ";
        $sql.="NULL,  ";
        $sql.="NULL,  ";
        $sql.="NULL,  ";
        $sql.="NULL,  ";
        $sql.="NULL,  ";
        $sql.="NULL,  ";
        $sql.="'0000-00-00 00:00:00',  ";
        $sql.="'0000-00-00 00:00:00',  ";
        $sql.="'0000-00-00 00:00:00',  ";
        $sql.="'9999-12-31 00:00:00',  ";
        $sql.="'1',  ";
        $sql.="'" . $usuario[0] . "',  ";
        $sql.="'1'); ";

        //alertadev($sql);

        $result = mysql_query($sql);

        if (!$result) {
            alerta('Actuamente no es posible la creacion de su Correo Electronico, por favor intente mas tarde, o comuniquese con la División de Sistemas de la Gerencia de Tecnología.');
            ir('dashboard.php');
        }

        $usuario_correo = $usuario[0];
        $l1 = substr($usuario_correo, 0, 1);
        $l2 = substr($usuario_correo, 1, 1);
        $l3 = substr($usuario_correo, 2, 1);
        $fecha_formato_vmail = date("Y.m.d.H.m.s");

        //$cmd="echo m3Tr0Mail2 | sudo -S mkdir /var/vmail/vmail1/metrodemaracaibo.gob.ve/".$l1."/".$l2."/".$l3."/".$usuario_correo."-".$fecha_formato_vmail;
        //exec('sshpass -p "m3Tr0Mail2" ssh adminserver@190.51.230.146 -p4664 "'.$cmd.'"');
    }
    _adios_mysql();
}

function execInBackground($cmd) {
    if (substr(php_uname(), 0, 7) == "Windows") {
        pclose(popen("start /B " . $cmd, "r"));
    } else {
        exec($cmd . " > /dev/null &");
    }
}

////////////////////////////////////////////////////////////////////////////////
//////////////////////////////// FUNCIONES DE CONVERSION DE NUMEROS A LETRAS.  /
////////////////////////////////////////////////////////////////////////////////


function _ALetras($x, $moneda) {
    if ($x < 0) {
        $signo = "menos ";
    } else {
        $signo = "";
    }
    $x = abs($x);
    $C1 = $x;

    $G6 = floor($x / (1000000));  // 7 y mas 

    $E7 = floor($x / (100000));
    $G7 = $E7 - $G6 * 10;   // 6 

    $E8 = floor($x / 1000);
    $G8 = $E8 - $E7 * 100;   // 5 y 4 

    $E9 = floor($x / 100);
    $G9 = $E9 - $E8 * 10;  //  3 

    $E10 = floor($x);
    $G10 = $E10 - $E9 * 100;  // 2 y 1 


    $G11 = round(($x - $E10) * 100, 0);  // Decimales 
////////////////////// 

    $H6 = unidades($G6);

    if ($G7 == 1 AND $G8 == 0) {
        $H7 = "Cien ";
    } else {
        $H7 = decenas($G7);
    }

    $H8 = unidades($G8);

    if ($G9 == 1 AND $G10 == 0) {
        $H9 = "Cien ";
    } else {
        $H9 = decenas($G9);
    }

    $H10 = unidades($G10);

    if ($moneda == '1') {
        if ($G11 < 10) {
            $H11 = "0" . $G11;
        } else {
            $H11 = $G11;
        }
    }
///////////////////////////// 
    if ($G6 == 0) {
        $I6 = " ";
    } elseif ($G6 == 1) {
        $I6 = "Millón ";
    } else {
        $I6 = "Millones ";
    }

    if ($G8 == 0 AND $G7 == 0) {
        $I8 = " ";
    } else {
        $I8 = "Mil ";
    }

    if ($moneda == '1') {
        $I10 = "Bolivares Fuertes con ";
        $I11 = "/100 centimos. ";
    }
    $C3 = $signo . $H6 . $I6 . $H7 . $I7 . $H8 . $I8 . $H9 . $I9 . $H10 . $I10 . $H11 . $I11;

    return $C3; //Retornar el resultado 
}

function unidades($u) {
    if ($u == 0) {
        $ru = " ";
    } elseif ($u == 1) {
        $ru = "Un ";
    } elseif ($u == 2) {
        $ru = "Dos ";
    } elseif ($u == 3) {
        $ru = "Tres ";
    } elseif ($u == 4) {
        $ru = "Cuatro ";
    } elseif ($u == 5) {
        $ru = "Cinco ";
    } elseif ($u == 6) {
        $ru = "Seis ";
    } elseif ($u == 7) {
        $ru = "Siete ";
    } elseif ($u == 8) {
        $ru = "Ocho ";
    } elseif ($u == 9) {
        $ru = "Nueve ";
    } elseif ($u == 10) {
        $ru = "Diez ";
    } elseif ($u == 11) {
        $ru = "Once ";
    } elseif ($u == 12) {
        $ru = "Doce ";
    } elseif ($u == 13) {
        $ru = "Trece ";
    } elseif ($u == 14) {
        $ru = "Catorce ";
    } elseif ($u == 15) {
        $ru = "Quince ";
    } elseif ($u == 16) {
        $ru = "Dieciseis ";
    } elseif ($u == 17) {
        $ru = "Decisiete ";
    } elseif ($u == 18) {
        $ru = "Dieciocho ";
    } elseif ($u == 19) {
        $ru = "Diecinueve ";
    } elseif ($u == 20) {
        $ru = "Veinte ";
    } elseif ($u == 21) {
        $ru = "Veintiun ";
    } elseif ($u == 22) {
        $ru = "Veintidos ";
    } elseif ($u == 23) {
        $ru = "Veintitres ";
    } elseif ($u == 24) {
        $ru = "Veinticuatro ";
    } elseif ($u == 25) {
        $ru = "Veinticinco ";
    } elseif ($u == 26) {
        $ru = "Veintiseis ";
    } elseif ($u == 27) {
        $ru = "Veintisiente ";
    } elseif ($u == 28) {
        $ru = "Veintiocho ";
    } elseif ($u == 29) {
        $ru = "Veintinueve ";
    } elseif ($u == 30) {
        $ru = "Treinta ";
    } elseif ($u == 31) {
        $ru = "Treintayun ";
    } elseif ($u == 32) {
        $ru = "Treintaydos ";
    } elseif ($u == 33) {
        $ru = "Treintaytres ";
    } elseif ($u == 34) {
        $ru = "Treintaycuatro ";
    } elseif ($u == 35) {
        $ru = "Treintaycinco ";
    } elseif ($u == 36) {
        $ru = "Treintayseis ";
    } elseif ($u == 37) {
        $ru = "Treintaysiete ";
    } elseif ($u == 38) {
        $ru = "Treintayocho ";
    } elseif ($u == 39) {
        $ru = "Treintaynueve ";
    } elseif ($u == 40) {
        $ru = "Cuarenta ";
    } elseif ($u == 41) {
        $ru = "Cuarentayun ";
    } elseif ($u == 42) {
        $ru = "Cuarentaydos ";
    } elseif ($u == 43) {
        $ru = "Cuarentaytres ";
    } elseif ($u == 44) {
        $ru = "Cuarentaycuatro ";
    } elseif ($u == 45) {
        $ru = "Cuarentaycinco ";
    } elseif ($u == 46) {
        $ru = "Cuarentayseis ";
    } elseif ($u == 47) {
        $ru = "Cuarentaysiete ";
    } elseif ($u == 48) {
        $ru = "Cuarentayocho ";
    } elseif ($u == 49) {
        $ru = "Cuarentaynueve ";
    } elseif ($u == 50) {
        $ru = "Cincuenta ";
    } elseif ($u == 51) {
        $ru = "Cincuentayun ";
    } elseif ($u == 52) {
        $ru = "Cincuentaydos ";
    } elseif ($u == 53) {
        $ru = "Cincuentaytres ";
    } elseif ($u == 54) {
        $ru = "Cincuentaycuatro ";
    } elseif ($u == 55) {
        $ru = "Cincuentaycinco ";
    } elseif ($u == 56) {
        $ru = "Cincuentayseis ";
    } elseif ($u == 57) {
        $ru = "Cincuentaysiete ";
    } elseif ($u == 58) {
        $ru = "Cincuentayocho ";
    } elseif ($u == 59) {
        $ru = "Cincuentaynueve ";
    } elseif ($u == 60) {
        $ru = "Sesenta ";
    } elseif ($u == 61) {
        $ru = "Sesentayun ";
    } elseif ($u == 62) {
        $ru = "Sesentaydos ";
    } elseif ($u == 63) {
        $ru = "Sesentaytres ";
    } elseif ($u == 64) {
        $ru = "Sesentaycuatro ";
    } elseif ($u == 65) {
        $ru = "Sesentaycinco ";
    } elseif ($u == 66) {
        $ru = "Sesentayseis ";
    } elseif ($u == 67) {
        $ru = "Sesentaysiete ";
    } elseif ($u == 68) {
        $ru = "Sesentayocho ";
    } elseif ($u == 69) {
        $ru = "Sesentaynueve ";
    } elseif ($u == 70) {
        $ru = "Setenta ";
    } elseif ($u == 71) {
        $ru = "Setentayun ";
    } elseif ($u == 72) {
        $ru = "Setentaydos ";
    } elseif ($u == 73) {
        $ru = "Setentaytres ";
    } elseif ($u == 74) {
        $ru = "Setentaycuatro ";
    } elseif ($u == 75) {
        $ru = "Setentaycinco ";
    } elseif ($u == 76) {
        $ru = "Setentayseis ";
    } elseif ($u == 77) {
        $ru = "Setentaysiete ";
    } elseif ($u == 78) {
        $ru = "Setentayocho ";
    } elseif ($u == 79) {
        $ru = "Setentaynueve ";
    } elseif ($u == 80) {
        $ru = "Ochenta ";
    } elseif ($u == 81) {
        $ru = "Ochentayun ";
    } elseif ($u == 82) {
        $ru = "Ochentaydos ";
    } elseif ($u == 83) {
        $ru = "Ochentaytres ";
    } elseif ($u == 84) {
        $ru = "Ochentaycuatro ";
    } elseif ($u == 85) {
        $ru = "Ochentaycinco ";
    } elseif ($u == 86) {
        $ru = "Ochentayseis ";
    } elseif ($u == 87) {
        $ru = "Ochentaysiete ";
    } elseif ($u == 88) {
        $ru = "Ochentayocho ";
    } elseif ($u == 89) {
        $ru = "Ochentaynueve ";
    } elseif ($u == 90) {
        $ru = "Noventa ";
    } elseif ($u == 91) {
        $ru = "Noventayun ";
    } elseif ($u == 92) {
        $ru = "Noventaydos ";
    } elseif ($u == 93) {
        $ru = "Noventaytres ";
    } elseif ($u == 94) {
        $ru = "Noventaycuatro ";
    } elseif ($u == 95) {
        $ru = "Noventaycinco ";
    } elseif ($u == 96) {
        $ru = "Noventayseis ";
    } elseif ($u == 97) {
        $ru = "Noventaysiete ";
    } elseif ($u == 98) {
        $ru = "Noventayocho ";
    } else {
        $ru = "Noventaynueve ";
    }
    return $ru; //Retornar el resultado 
}

function decenas($d) {
    if ($d == 0) {
        $rd = "";
    } elseif ($d == 1) {
        $rd = "Ciento ";
    } elseif ($d == 2) {
        $rd = "Doscientos ";
    } elseif ($d == 3) {
        $rd = "Trescientos ";
    } elseif ($d == 4) {
        $rd = "Cuatrocientos ";
    } elseif ($d == 5) {
        $rd = "Quinientos ";
    } elseif ($d == 6) {
        $rd = "Seiscientos ";
    } elseif ($d == 7) {
        $rd = "Setecientos ";
    } elseif ($d == 8) {
        $rd = "Ochocientos ";
    } else {
        $rd = "Novecientos ";
    }
    return $rd; //Retornar el resultado 
}

function getIP() {
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if (isset($_SERVER ['HTTP_VIA']))
        $ip = $_SERVER['HTTP_VIA'];
    else if (isset($_SERVER ['REMOTE_ADDR']))
        $ip = $_SERVER['REMOTE_ADDR'];
    else
        $ip = null;
    return $ip;
}

/* * ********************************* */
/* ICONOS DASHBOARD FONT-AWESOME		 */
/* * ********************************* */

function iconosIntranet($nombre, $titulo, $puntero, $color, $tamaño) {
    switch ($nombre) {
        case 'Espera': $st = "clock-o";
            break;
        case 'Activo': $st = "check";
            break;
        case 'Cerrar': $st = "lock";
            Break;
        case 'Editar': $st = "edit";
            Break;
        case 'Enviar': $st = "sign-out";
            Break;
        case 'Eliminar': $st = "trash";
            break;
        case 'Inactivo': $st = "ban";
            break;
        case 'Informacion': $st = "info-circle";
            break;
        case 'Archivar': $st = "archive";
            break;
    }
    $color ? $colorSt = $color : $colorSt = '#8B8B8B';
    $puntero ? $punteroSt = 'pointer' : $punteroSt = 'default';
    $tamaño ? $size = $tamaño : $size = '15px';

    return '<i class="fa fa-' . $st . '" title="' . $titulo . '" style="vertical-align: middle; cursor:' . $punteroSt . '; font-size: ' . $size . '; color: ' . $colorSt . '" ></i>';
}

function parametrosReporte($array) {
    $tmp = serialize($array);
    $tmp = urlencode($tmp);
    return $tmp;
}


?>
