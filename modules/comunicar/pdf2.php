<?php
require("../../conexiones_config.php");
session_start();
if(!isset($_SESSION[md5('usuario_datos'.$ecret)])) {ir("../../index.php");}
$usuario_datos = $_SESSION[md5('usuario_datos'.$ecret)];
$usuario_permisos = $_SESSION[md5('usuario_permisos'.$ecret)];
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
	notificar("Usted no tiene permisos para esta Seccion/Modulo", "dashboard.php?data=notificar", "notify-error");
	_wm($usuario_datos[9],'Acceso Denegado en: '.ucwords(array_pop(explode('/', __dir__))),'S/I');
} 
_wm($usuario_datos[9],'Acceso Autorizado en: '.ucwords(array_pop(explode('/', __dir__))),'S/I');
if ($_SESSION['tokeconst']!=$_GET['token']){
  alerta('Autenticacion de token de seguridad fallido, se procederá a recargar la página, Disculpen las molestias causadas, pero recuerde que es por seguridad.');
	ir("../../dashboard.php?data=constancias");
}
unset($_SESSION['tokeconst']);
?>
<head>
  <title>Constancia de Trabajo <?php echo $usuario_datos[3]?></title>
<style>
  body{
    margin-top: 25px;
    font-family: Arial;
    overflow: hidden;
  }
  
  h1 {
    text-align: left;
    font-size: 22px;
    margin: 10px auto 10px auto;
    font-variant: small-caps;
  }
  
  h2 {
    text-align: center;
    font-size: 22px;
    margin: 10px auto 10px auto;
    font-variant: small-caps;
  }
  
  p {
    font-size: 12px;
    line-height: 16px;
  }
  
  .contenedor{
    /*    border: solid 1px #DDD;*/
    width: 690px;
    height: 980px;
    margin: 0 auto;
    padding: 15px; 
  }
  
  .header{
    /*    border: solid 1px #DDD;*/
    width: 680px;
    height: 200px;
    margin: 0 auto;
  }
  
  .img-logo{
    /*    border: solid 1px #DDD;*/
    width: 180px;
    margin: 0 auto;
  }
  
  .img-empleado{
    border: solid 5px #DDD;
    width: 100px;
    margin: 0;
    float: right;
  }
  
  span.rif {
    font-style: 110%;
    font-weight: bold;
  }

.firma {
  width:300px;
  position:absolute;
  left:45%;
  margin-left:-175px;
  top:620px;
  display: none;
}


.sello {
  width:110px;
  position:absolute;
  left:800px;
  margin-left:-250px;
  top:600px;
  display: none;
}

.qr {
  width:200px;
  height:225px;
  position:absolute;
  left:110px;
  margin-left:-100px;
  margin-bottom: 10px;
  top:580px;
  text-align: center;
  display: none;
  
}

.pieword {
font-size: 6px;
font-variant: small-caps;
border-bottom: 3px solid #666;
height: 9px;
display: none;
}

.pie{
  display: none;
}

.botonimprimir {
width: 100%;
height: 100%;
color: #fff;
background-color: #d9534f;
border-color: #d43f3a;
color: #fff;
background-color: #d9534f;
border-color: #d43f3a;
display: inline-block;
padding: 6px 12px;
margin-bottom: 0;
font-size: 14px;
font-weight: normal;
line-height: 1.428571429;
text-align: center;
white-space: nowrap;
vertical-align: middle;
cursor: pointer;
-webkit-user-select: none;
-moz-user-select: none;
-ms-user-select: none;
-o-user-select: none;
user-select: none;
background-image: none;
border: 1px solid transparent;
border-radius: 4px;
}

.contenedor-boton {
width: 250px;
height: 60px;
position: absolute;
left: 50%;
margin-left: -125px;
top: 630px;
text-align: center;
}

.cuerpo {
  min-height: 55%;
}  

.notapie {
  display: none;
}

@media print {
  body{
    margin: 0px;
    padding: 0px;
    font-family: Arial;
    overflow: hidden;
  }
  
  .firma {
    display: inherit;
  }
  .sello {
      display: inherit;
  }
  .qr {
    display: block;
  }
  .contenedor-boton {
    display: none;
  }  
  .pieword {
    display: inherit;
  }
  .pie{
    display: inherit;
  }
  .notapie{
    display: inherit;
  }
}
</style>
    
</head> 

<?php
$cedula_empleado =$usuario_datos[3];
$dirigidoa = strtoupper(_antiXSS($_POST['da']));
$titulo='CONSTANCIA DE TRABAJO';
$nombre_empleado =  strtoupper($usuario_datos[1] . ' ' . $usuario_datos[2]);
$tipo_nomina=strtoupper(_dametipoempyfechainicio($cedula_empleado,1)); 
$ubic_empleado=explode(' - ', $usuario_datos[14]); $ubic_empleado=$ubic_empleado[1];
$fecha_ingreso=_damefechaenletras(_dametipoempyfechainicio($cedula_empleado,2)); 
$fecha_ingreso2=_dametipoempyfechainicio($cedula_empleado,2);
$cargo_empleado=_damecargo($cedula_empleado); 
$fre_pag='MENSUAL'; 
/*preparacion de salarios*/
$salario=_damesalarios($cedula_empleado, 1);
$salarioi=_damesalarios($cedula_empleado, 2);
/*************************/
$sal_nor='Bs. ' . number_format($salario, 2, ',', '.');
$sal_nor_letra=strtoupper(_ALetras($salario,1)); 
$sal_int='Bs. ' . number_format($salarioi, 2, ',', '.');
$sal_int_letra=strtoupper(_ALetras($salarioi,1)); 
$hoy=_damefechaenletrasparaconstancia();
$check=damecodigo(5); 
$usu=$usuario_datos[9];
 

$LOC_fecha_creacion=date('Y-m-d');
$LOC_fecha_vencimiento = date("Y-m-d", strtotime("$LOC_fecha_creacion + 90 days"));
$LOC_destino=$dirigidoa;
$LOC_foto="http://intranet.metrodemaracaibo.gob.ve/src/images/FOTOS/".$cedula_empleado.".jpg";
$LOC_nombre_grrhh=$cargo_empleado;
$LOC_nombre_empleado=$nombre_empleado;
$LOC_cedula_empleado=$cedula_empleado;
$LOC_tipo_nomina_empleado=$tipo_nomina;
$LOC_ubicacion_laboral_empleado=$ubic_empleado;
$LOC_fecha_ing_empleado=$fecha_ingreso2;
$LOC_tipo_salario_empleado=$fre_pag;
$LOC_monto_salario_num=number_format($salario, 2, '.', '');
$LOC_monto_salario_let=$sal_nor_letra;
$LOC_monto_salarioi_num=number_format($salarioi, 2, '.', '');
$LOC_monto_salarioi_let=$sal_int_letra;
$LOC_usuario=$usu;
$LOC_fecha_creacion_let=$hoy;
$LOC_codigo=$check;

_bienvenido_mysql();
$sql ="INSERT INTO ctrabajo_datos (fecha_creacion, fecha_vencimiento, destino, foto, nombre_grrhh, nombre_empleado, cedula_empleado, tipo_nomina_empleado, ubicacion_laboral_empleado, fecha_ing_empleado, tipo_salario_empleado, monto_salario_num, monto_salario_let, monto_salarioi_num, monto_salarioi_let, usuario, fecha_creacion_let, codigo)";
$sql .=" VALUES('".$LOC_fecha_creacion."','".$LOC_fecha_vencimiento."','".$LOC_destino."','".$LOC_foto."','".$LOC_nombre_grrhh."','".$LOC_nombre_empleado."','".$LOC_cedula_empleado."','".$LOC_tipo_nomina_empleado."','".$LOC_ubicacion_laboral_empleado."','".$LOC_fecha_ing_empleado."','".$LOC_tipo_salario_empleado."',".$LOC_monto_salario_num.",'".$LOC_monto_salario_let."',".$LOC_monto_salarioi_num.",'".$LOC_monto_salarioi_let."','".$LOC_usuario."','".$LOC_fecha_creacion_let."','".$LOC_codigo."');";
$result = mysql_query($sql);
if(!$result){
  if ($SQL_debug=='1'){ die('Error Auditando - Respuesta del Motor: ' . mysql_error());} else {die('Error Auditando');}	
}


?>





<body>
  <div class="contenedor">
    <div class="header">
      <img class="img-empleado" src="../../src/images/FOTOS/<?php echo $cedula_empleado; ?>.jpg" />
      <img class="img-logo" src="../../src/images/logo678.png" />
      <br><span class="rif">G-20008841-9</span><br><br>
      <p>Señores:<br><b><?php echo $dirigidoa; ?></b><br>Presente.-</p>
    </div>
    <div class="cuerpo">
      <h2 style="margin-top:40px"><?php echo $titulo; ?></h2>
      <p style="line-height:26px; text-align: justify; margin-top: 40px;">
      Quien suscribe Jhony José Barroso, en mi carácter de Gerente de la Oficina de Recursos 
      Humanos de la Empresa Socialista Metro de Maracaibo, C.A., mediante la presente hago constar
      que el ciudadano: <?php echo $nombre_empleado; ?>, titular de la CEDULA DE IDENTIDAD Nro.
      <?php echo number_format($cedula_empleado, 0, ',', '.'); ?>, presta sus servicios en esta 
      empresa en la nomina de <?php echo $tipo_nomina; ?> para la <?php echo $ubic_empleado; ?> desde el 
      <?php echo $fecha_ingreso; ?>, ocupando el cargo de <?php echo $cargo_empleado; ?>, devengando un salario 
      normal <?php echo $fre_pag; ?> de <?php echo $sal_nor_letra; ?> (<?php echo $sal_nor; ?>) y un 
      salario integral <?php echo $fre_pag; ?> de <?php echo $sal_int_letra; ?> (<?php echo $sal_int; ?>).
      <br><br>
      Constancia que se expide a petición del interesado en Maracaibo <?php echo $hoy; ?>
      </p>
    </div>    
    <div class="contenedor-boton" style="text-align:center;"><button class="botonimprimir" onclick="window.print();">Imprimir Constancia de Trabajo</button></div>
    <div class="pie-cuerpo">
      <div class="firma"><img style="width:400px" src="../../src/images/f1.png" /></div>
      <div class="sello"><img style="width:100px" src="../../src/images/f2.png" /></div>
      <?php
        $parametros ="ct=".$check; 
        $parametros = _desordenar($parametros); 
        $enlace= "https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=http%3A%2F%2Fextranet.metrodemaracaibo.gob.ve%2Fdashboarde.php?data=validarc%26".$parametros;
        
        ?>
      <div class="qr"><img src=<?php echo $enlace?> title="Verificador Interactivo" />
      <div style="margin-left: 20px;display:block; padding: 5px; border: 1px solid black; width: 70%"><b><?php echo $check; ?></b></div>
</div>
      
<p class="notapie" style="font-weight: bold; text-align: center; font-family: arial; margin-bottom: 20px; ">
  Este documento podra ser validado a traves de http://www.metrodemaracaibo.gob.ve/validar introduciendo 
  el codigo de 7 digitos que se encuentra debajo del codigo QR de seguridad. </p>
    </div>
    <div class="pieword">   
      <SPAN STYLE="FLOAT: LEFT"> AV. DON MANUEL BELLOSO, SECTOR ALTOS DE LA VANEGA, EDIF. ADMINISTRATIVO. TELF:(58-261)7186921</SPAN>
      <SPAN STYLE="FLOAT: RIGHT">FAX:(58-261)7355287. MARACAIBO - VENEZUELA - RIF.: G-20008841-9 - WWW.METRODEMARACAIBO.GOB.VE</SPAN>
    </div>   
    <div class="pie">
      <div style="background-color:#fff;height:55px;">
      <div style="float:left;"><img style="height:55px;" src="../../src/images/cint5.jpg"></div>
      <div style="float:right;"><img style="height:55px;" src="../../src/images/cint4.jpg"></div>
    </div>
    </div>
  </div>
</body>