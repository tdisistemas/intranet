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
<?php   
$paso=$_GET['paso'];
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

_bienvenido_mysql();

$result = mysql_query($sql);
$sql=mysql_query(" SELECT  * 
FROM  `comunicacion_codigo` 
WHERE id_com=$paso");
while($row_cont=mysql_fetch_array($sql)){

    
    $para=$row_cont['para'];
          $codigo=$row_cont['consecutivo'];
    $cuerpo=$row_cont['cuerpo'];
    $fecha=$row_cont['fecha'];


  
?>


<body style="overflow: scroll;">
  <div class="contenedor">
    <div class="header">
      
      <img class="img-logo" src="../../src/images/logo678.png" />
      <br>
<p align="left">N° <u><?php echo $codigo;?></u></p><p align="right">Maracaibo,<?php echo $fecha;?></p>
      <p>Señores:<br><b><?php echo $para;?></b><br>Su Despacho.-</p>

    </div>
     <div class="cuerpo">
      <h2 class="titulo-pp"></h2>
      <p class="parrafo-principal">
       
<?php echo $cuerpo; ?>
    
      </p>
    </div>    
  
    <div class="contenedor-boton centrar"><button class="botonimprimir" onclick="window.print();">Imprimir Comunicación Externa</button>
        <?php  if ($row_cont['status']=='0'){?>

        <button class="botonimprimir1" style="
    margin-top: 50px;" onclick="window.location=('aprobado.php?&paso=<?php echo $paso;?>');">Aprobar</button>

    
<?php }}?>
     </div>
        <div class="pieword" style="  
    margin-top: 180px;
" >
        <SPAN class="flotar-izq" > AV. DON MANUEL BELLOSO, SECTOR ALTOS DE LA VANEGA, EDIF. ADMINISTRATIVO. TELF:(58-261)TELF:(58-261)7307202</SPAN>
      <SPAN class="flotar-der">FAX:(0261)7355287. MARACAIBO, VENEZUELA - RIF: G-20008841-9 - WWW.METRODEMARACAIBO.GOB.VE</SPAN>
  
    </div>   
    <div class="pie piedepagina">
      <div style="background-color:#fff;height:55px;">
      <div class="flotar-izq"><img style="height:55px;" src="../../src/images/cint5.jpg"></div>
      <div class="flotar-der"><img style="height:55px;" src="../../src/images/cint4.jpg"></div>
    </div>
    </div>
  </div>
</body>       