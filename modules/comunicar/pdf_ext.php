<?php
//CAMBIAR PARAMETROS
require("../../conexiones_config.php");

session_start();
if (!isset($_SESSION[md5('usuario_datos' . $ecret)])) {
    ir("../../index.php");
}
$usuario_datos    = $_SESSION[md5('usuario_datos' . $ecret)];
$usuario_permisos = $_SESSION[md5('usuario_permisos' . $ecret)];
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
    notificar("Usted no tiene permisos para esta Seccion/Modulo", "dashboard.php?data=notificar", "notify-error");
    _wm($usuario_datos[9], 'Acceso Denegado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
}
_wm($usuario_datos[9], 'Acceso Autorizado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');


?>
<head>
   <?php
   
   
   $pos = strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox');
if ($pos === false) {
?><link rel="stylesheet" type="text/css" href="chrome.css" /><?php
} else {
?><link rel="stylesheet" type="text/css" href="mozilla.css" /><?php
}
?>
</head> 

<?php

$cedula_empleado = $usuario_datos[3];

$gerencia= (explode(" - ",$usuario_datos[14]));
$nombre_empleado = strtoupper($usuario_datos[1] . ' ' . $usuario_datos[2]);
$cargo_empleado  = _damecargo($cedula_empleado);

$mensaje=$_POST['texto'];
$para=$_POST['para'];
$asunto=$_POST['asunto'];
$nota=$_POST['nota'];
$ano=$_POST['ano']; 
$de1=$_POST['de1'];
$des=(explode("-",$de1));

$de=$_POST['de'];

$fecha         = date('d-m-Y');
$ano         = date('Y');
$actual=(explode("20",$ano));
$usu = $usuario_datos[9];

_bienvenido_mysql();
$sql = mysql_query("SELECT id,ge_abre, conse
FROM `gerencias`
WHERE `nombre` LIKE '%$gerencia[0]%'");

while ($row = mysql_fetch_array($sql)) {
    
    $cod = $row['ge_abre'];
    $conse  = $row['conse'];

    $id_ger  = $row['id'];
}

_bienvenido_mysql();
$sql = mysql_query("SELECT  `codigo` 
FROM  `comunicacion_codigo` 
WHERE tipo LIKE '%ext%'
ORDER BY id_com DESC limit 1  ");
$result = mysql_query($sql);

while ($row = mysql_fetch_array($sql)) {
    if($result){
   $a = ($row['codigo']+1);
    }
 else {
   $a=1;    
    } 
}  
   
  $u      = "INSERT INTO `comunicacion_codigo` (`de`, `para`, `asunto`, `fecha`, `codigo`, `usuario_int`, `destino`, `cuerpo`, `gerencia`, `consecutivo`,`tipo`,`status`) VALUES"
        . " ('" . $nombre_empleado . "', '" . $para . "','" . $asunto . "','" . $fecha . "','" . $a . "','" . $usu . "','" . $para . "','" . $mensaje . "','" . $gerencia[0] . "','" .'MM-PSD-'.$actual[1]. '-00' . $a . "','" . 'ext' . "','" . '0' . "')";
/*$sql ="INSERT INTO ctrabajo_datos (fecha_creacion, fecha_vencimiento, destino, foto, nombre_grrhh, nombre_empleado, cedula_empleado, tipo_nomina_empleado, ubicacion_laboral_empleado, fecha_ing_empleado, tipo_salario_empleado, monto_salario_num, monto_salario_let, monto_salarioi_num, monto_salarioi_let, usuario, fecha_creacion_let, codigo)";
$sql .=" VALUES('".$LOC_fecha_creacion."','".$LOC_fecha_vencimiento."','".$LOC_destino."','".$LOC_foto."','".$LOC_nombre_grrhh."','".$LOC_nombre_empleado."','".$LOC_cedula_empleado."','".$LOC_tipo_nomina_empleado."','".$LOC_ubicacion_laboral_empleado."','".$LOC_fecha_ing_empleado."','".$LOC_tipo_salario_empleado."',".$LOC_monto_salario_num.",'".$LOC_monto_salario_let."',".$LOC_monto_salarioi_num.",'".$LOC_monto_salarioi_let."','".$LOC_usuario."','".$LOC_fecha_creacion_let."','".$LOC_codigo."');";*/

$result = mysql_query($u);
if (!$result) {
    if ($SQL_debug == '1') {
        die('Error Auditando - Respuesta del Motor: ' . mysql_error());
    } else {
        die('Error Auditando');
    }
}



?>


<body style="overflow: scroll;">
  <div class="contenedor">
    <div class="header">
      
      <img class="img-logo" src="../../src/images/logo678.png" />
      <br>
<p align="left">N° <u><?php echo 'MM-PSD-'.$actual[1]. '-00' . $a ;?></u></p><p align="right">Maracaibo,<?php echo $fecha;?></p>
      <p>Señores:<br><b><?php echo $para;?></b><br>Su Despacho.-</p>

    </div>
     <div class="cuerpo">
      <h2 class="titulo-pp"><?php echo $titulo; ?></h2>
      <p class="parrafo-principal">
       
  <?php echo $mensaje; ?>
    
      </p>
    </div>    
  
    <div class="contenedor-boton centrar"><button class="botonimprimir" onclick="window.print();">Imprimir Comunicación Externa</button></div>
   
    
    
        <div class="pieword" style="
    margin-top: 180px;
" >
        <SPAN class="flotar-izq" > AV. DON MANUEL BELLOSO, SECTOR ALTOS DE LA VANEGA, EDIF. ADMINISTRATIVO. TELF:(58-261)TELF:(58-261)7307202</SPAN>
      <SPAN class="flotar-der">FAX:(0261)7355287. MARACAIBO, VENEZUELA - RIF: G-20008841-9 - WWW.METRODEMARACAIBO.GOB.VE</SPAN>
  
    </div>   
    <div >
      <div style="background-color:#fff;height:55px;">
      <div class="flotar-izq"><img style="height:55px;" src="../../src/images/cint5.jpg"></div>
      <div class="flotar-der"><img style="height:55px;" src="../../src/images/cint4.jpg"></div>
    </div>
    </div>
  </div>
</body>       
