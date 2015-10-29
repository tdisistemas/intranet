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
$dese=(explode(" ",$de1));
$de=$_POST['de'];
$der=(explode("-",$de));
$fecha         = date('d-m-Y');
$ano         = date('Y');
$actual=(explode("20",$ano));
$usu = $usuario_datos[9];

_bienvenido_mysql();
/***$sql12 = mysql_query("SELECT  `usuario_int` 
FROM  `usuario_bkp` 
WHERE  `nombre` LIKE  '%$dese[0]%'
AND  `apellido` LIKE  '%$dese[1]%'");

while ($row = mysql_fetch_array($sql12)) {
    
    $usuarioi = $row['usuario_int'];
   $kl=$usuarioi.'@metrodemaracaibo.gob.ve';
}***/


$sql = mysql_query("SELECT id,ge_abre, conse
FROM `gerencias`
WHERE `nombre` LIKE '%$gerencia[0]%'");

while ($row = mysql_fetch_array($sql)) {
    
    $cod = $row['ge_abre'];
    $conse  = $row['conse'];

    $id_ger  = $row['id'];
}

_bienvenido_mysql();
$sql = mysql_query("SELECT MAX( codigo ) AS codigo
FROM `comunicacion_codigo`
WHERE gerencia = '$gerencia[0]'
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
  
    
  $usuario=$usuario_datos[9];

$u      = "INSERT INTO `comunicacion_codigo` (`de`, `para`, `asunto`, `fecha`, `codigo`, `usuario_int`, `destino`, `cuerpo`, `gerencia`, `consecutivo`,`tipo`,`status`) VALUES"
        . " ('" .  $nombre_empleado.'-'. $der[1]. "', '" . $de1. "','" . $asunto . "','" . $fecha . "','" . $a . "','" . $usu . "','" . $des[2] . "','" . $mensaje . "','" . $gerencia[0] . "','" .$cod . '-' . $actual[1]. '-00' . $a .  "','" . 'int' . "','" . '0' . "')";
/*$sql ="INSERT INTO ctrabajo_datos (fecha_creacion, fecha_vencimiento, destino, foto, nombre_grrhh, nombre_empleado, cedula_empleado, tipo_nomina_empleado, ubicacion_laboral_empleado, fecha_ing_empleado, tipo_salario_empleado, monto_salario_num, monto_salario_let, monto_salarioi_num, monto_salarioi_let, usuario, fecha_creacion_let, codigo)";
$sql .=" VALUES('".$LOC_fecha_creacion."','".$LOC_fecha_vencimiento."','".$LOC_destino."','".$LOC_foto."','".$LOC_nombre_grrhh."','".$LOC_nombre_empleado."','".$LOC_cedula_empleado."','".$LOC_tipo_nomina_empleado."','".$LOC_ubicacion_laboral_empleado."','".$LOC_fecha_ing_empleado."','".$LOC_tipo_salario_empleado."',".$LOC_monto_salario_num.",'".$LOC_monto_salario_let."',".$LOC_monto_salarioi_num.",'".$LOC_monto_salarioi_let."','".$LOC_usuario."','".$LOC_fecha_creacion_let."','".$LOC_codigo."');";*/

$result = mysql_query($u);  
         
         /* $mensajedelcorreo="<img src='http://intranet.metrodemaracaibo.gob.ve/iconos/encamail.jpg' /><br><br><h3>HOLA, " . $de1 . "</h3>" . "<br /><h4>Revise su bandeja!</h4>" . "<br /><br />tiene un mensaje pendiente de: " . $de . "<br /><p>Para mayor información comuníquese con la Gerencia de Tecnología de Información, División de Sistemas</p>" . "<br /><img src='http://intranet.metrodemaracaibo.gob.ve/src/images/metropie.jpg'  style='width: 600px;' />";
          _enviarmail($mensajedelcorreo, $reg[1] . ' ' . $reg[2], trim("$kl"), "$asunto");*/
          
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
    <div class="header" >
                <div class="flotar-izq"><img style="height:55px;" src="../../src/images/cint5.jpg"></div>
      <div class="flotar-der"><img style="height:55px;" src="../../src/images/cint4.jpg"></div>
<br><br>
       <h4 class="titulo-pp" align="right">Comunicacion Interna</h4></p>
                    
    <table border="1"  cellspacing="1" style="width: 700px;">
        <tr>
            <td colspan="1"><h5>Para:</h5></td>
            <td colspan="1"><h5><?php echo $des[0];?><br><?php echo $des[1]?><br><?php echo $des[2];?>
</h5></td>
             <td colspan="1"><h5>N°
<?php echo $cod . '-' . $actual[1]. '-00' . $a;?></h5></td>
        </tr>   
<tr>
 <td colspan="1"><h5>De:</h5></td>
            <td colspan="1"><h5>
<?php echo $der[0];?><br><?php echo $der[1];?><br><?php echo $gerencia[0];?></h5></td>
             <td colspan="1"><h5>Fecha:
<?php echo $fecha;?></h5></td>
</tr>        
<tr>  
     
    </td> <td >
        <div width="" height="">
          <h5>Asunto:</h5>
       </div>
    </td> 
<td colspan="2" >
        <div width="" height="">
          <h5><?php echo $asunto;?></h5>
       </div>
    </td> 
        </tr>
    </table>
     
 <div class="cuerpo" >
  
     
    <div class="cuerpo">
      <h2 class="titulo-pp"><?php echo $titulo; ?></h2>
      <p class="parrafo-principal" style="width: 700px;">
      
    <?php echo $mensaje;?>
        
      </p>

       <div class="flotar-izq"><img style="height: 72px; margin-bottom: 80px; margin-top: 50x;"  src="../../src/images/metropie.jpg"></div>         
  
<center>
    
     
</center>      

            
            <?php
$parametros = "ct=" . $check;
$parametros = _desordenar($parametros);
?>
   </div>
  

  
  
</div>
  
  </div>
  </div>
   </div>
   </div>
   <div class="contenedor-boton centrar"><button class="botonimprimir" style="margin-top: 125px;" onclick="cerrarse();">Salir</button>
     <br><br><br>
                                                   
   </div>
  
  <center>
      
</body>  
<script> 
function cerrarse(){ 
window.close() 
} 
</script> 