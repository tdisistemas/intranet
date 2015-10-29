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
decode_get2($_SERVER["REQUEST_URI"],2);

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
$cedula_empleado =$usuario_datos[3];
$result = mysql_query($sql);
$sql=mysql_query(" SELECT  * 
FROM  `comunicacion_codigo` 
WHERE id_com=$paso");
while($row_cont=mysql_fetch_array($sql)){

      $de=$row_cont['de'];
    $para=$row_cont['para'];
    $gerencia=$row_cont['gerencia'];
    $asunto=$row_cont['asunto'];
    
    $codigo=$row_cont['consecutivo'];
    $cuerpo=$row_cont['cuerpo'];
    $fecha=$row_cont['fecha'];
$destino=$row_cont['destino'];
$para1=(explode("-",$para));
 $de1=(explode("-",$de)); 


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
            <td colspan="1"><h5><?php echo $para1[0];?><br><?php echo $para1[1];?><br><?php echo $destino;?>
</h5></td>
             <td colspan="1"><h5>N°
<?php echo $codigo;?></h5></td>
        </tr>   
<tr>
 <td colspan="1"><h5>De:</h5></td>
            <td colspan="1"><h5>
<?php echo $de1[0];?><br><?php echo $de1[1];?><br><?php echo $gerencia;?></h5></td>
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
        <h5>  <?php echo $asunto;?>
 </h5>      </div>
    </td> 
        </tr>
    </table>
     
 <div class="cuerpo" >
  
     
    <div class="cuerpo">
      <h2 class="titulo-pp"></h2>
      <p class="parrafo-principal" style="width: 700px;">
      
<?php echo $cuerpo; ?>
        
      </p>
 <div class="flotar-izq"><img style="height: 72px; margin-bottom: 80px; margin-top: 150x;"  src="../../src/images/metropie.jpg"></div>         
  
      
<center>
    
     
</center>      

            
            <?php
$parametros = "ct=" . $check;
$parametros = _desordenar($parametros);}
?>
   </div>
  

  
  
</div>

</div>
  </div>
  </div>
   </div>
   </div>
   <div style="
    width: 126px;
    height: 44px;
" class="contenedor-boton centrar"><button class="botonimprimir" style="margin-top: 125px;"  onclick="cerrarse()">Salir</button>
  
       
       
    <br><br>                                            
   </div>
  
  <center>
      
</body>   
<script> 
function cerrarse(){ 
window.close() 
} 
</script> 