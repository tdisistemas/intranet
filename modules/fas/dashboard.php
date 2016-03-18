<?php 
	require("conexiones_config.php");
	session_start();
	
        session_regenerate_id(true);
	if(!isset($_SESSION[md5('usuario_datos'.$ecret)])) {ir("index.php");}
	$usuario_datos = $_SESSION[md5('usuario_datos'.$ecret)];
	$usuario_permisos = $_SESSION[md5('usuario_permisos'.$ecret)];
	if (!in_array('Dashboard', $usuario_permisos)) {
		alerta("No tiene permisos - Comuníquese con la División de Sistemas de la Gerencia de Tecnología de Información");
		session_unset();
		session_destroy();
		_wm($usuario_datos[9],'Acceso Denegado en: Dashboard','S/I');
		ir("index.php");   
	} 
	_wm($usuario_datos[9],'Acceso Autorizado en: Dashboard','S/I');
/*$sql = mysql_query("SELECT * FROM  `censo_hcm` where cedula_empleado=$usuario_datos[3]");
$cambio=  mysql_query("select * from autenticacion WHERE cedula=$usuario_datos[3]");
$cambio_1=mysql_fetch_array($cambio);
if ($cambio_1 != 37){
$insert=  mysql_query("INSERT INTO `a_cambio` (`cedula`, `perfil`) VALUES ('$usuario_datos[3]', '$cambio_1[4]');");



$encuesta=mysql_num_rows($sql);
                        if ($encuesta<=0){
$cambio=  mysql_query("UPDATE `autenticacion` SET `perfil`=37 WHERE cedula=$usuario_datos[3]");
  
                        }  
        /* $sql = mysql_query("SELECT * FROM  `encuesta_servicios` where cedula_empleado=$usuario_datos[3]");

$encuesta=mysql_num_rows($sql);
	session_start();
         if ($encuesta<1){
             ir("encuesta.php");  
         }
         else{
        
}}*/
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<!--[if lt IE 7]><html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]><html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]><html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head> 
<title>Intranet Metromara v3.0..</title>
	<meta charset="utf-8" />
	<meta name="description" content="" />
	<meta name="author" content="Division de Sistemas" />		
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="shortcut icon" href="src/images/favicon.ico">
	<link rel="stylesheet" href="src/stylesheets/reset.css?<?php echo $anticache; ?>" type="text/css" media="screen" title="no title" />
	<link rel="stylesheet" href="src/stylesheets/text.css?<?php echo $anticache; ?>" type="text/css" media="screen" title="no title" />
	<link rel="stylesheet" href="src/stylesheets/buttons.css?<?php echo $anticache; ?>" type="text/css" media="screen" title="no title" />
	<link rel="stylesheet" href="src/stylesheets/theme-default.css?<?php echo $anticache; ?>" type="text/css" media="screen" title="no title" />
	<link rel="stylesheet" href="src/stylesheets/login.css?<?php echo $anticache; ?>" type="text/css" media="screen" title="no title" />
	<link rel="stylesheet" href="src/stylesheets/all.css?<?php echo $anticache; ?>" type="text/css" />
	<!--[if gte IE 9]><link rel="stylesheet" href="src/stylesheets/ie9.css?<?php echo $anticache; ?>" type="text/css" /><![endif]-->
	<!--[if gte IE 8]><link rel="stylesheet" href="src/stylesheets/ie8.css?<?php echo $anticache; ?>" type="text/css" /><![endif]-->
	<link rel="stylesheet" href="src/stylesheets/QapTcha.jquery.css?<?php echo $anticache; ?>" type="text/css" />
	<link rel="stylesheet" href="src/stylesheets/progressbar.css?<?php echo $anticache; ?>" type="text/css" />
	<script src="src/javascripts/funciones.js?<?php echo $anticache; ?>"></script>
	<script src="src/javascripts/all.js?<?php echo $anticache; ?>"></script>
<link rel="stylesheet" href="css/font-awesome.min.css?<?php echo $anticache; ?>" type="text/css" />

  <style type="text/css">
body {
overflow-x: hidden !important;	
}
/*#content{
    background-attachment:fixed;
}*/
    #topNav{
      top:2px !important;
    }
    #menuProfile{
      top:30px !important;
    }
  </style>
  </head>
    <!--En el Body se el <style="margin-top: -20px;"> Para poder mejorar la interfaz-->
<body style="">	
<div id="wrapper">
<div id="header">
  <div><img src="src/images/logo.png" style="margin-top:10px;" /></div>	
<a href="javascript:;" id="reveal-nav"><span class="reveal-bar"></span><span class="reveal-bar"></span><span class="reveal-bar"></span></a>
</div> <!-- #header -->
  <div id="sidebar">	
  <ul id="mainNav">	
    <li id="inicio" class="nav">
      <span class="icon-home"></span>
      <a href="dashboard.php?data=inicio">Página Principal</a>	
    </li>
         <?php if (in_array('ARI', $usuario_permisos)) { ?>
                                        <li id="ARI" class="nav">
                                            <span class="icon-key-stroke"></span>
                                            <a href="dashboard.php?data=AR-I">Declaración AR-I</a>				
                                        </li>
                                    <?php } ?>
      
    
                  <?php if (in_array ('Hcm_admin', $usuario_permisos)) { ?>
<li id="hcm_admin" class="nav "> 
	<span class="icon-document-alt-stroke"></span>
	
        <a href="javascript:;">Admin H.C.M</a>				
	<ul class="subNav">
        <li><a href="dashboard.php?data=hcm-admin">Admin H.C.M 2016</a></li>
		<li><a href="dashboard.php?data=admin-hcm">Generar Reporte</a></li> 
        </ul>						
</li>
<?php } ?>
            
            <?php if (in_array ('Listines', $usuario_permisos)) { ?>
    <li id="listines" class="nav">
      <span class="icon-layers"></span>

      <a href="dashboard.php?data=listines">Recibos de Pago</a>

    </li>   
    <?php } ?>

    
    <?php if (in_array ('Webmail', $usuario_permisos)) { ?>
    <li id="webmail" class="nav">
      <span class="icon-mail"></span>
      <a href="https://correo.metrodemaracaibo.gob.ve" target="_blank">Correo</a>
    </li> 
    <?php } ?>
    <?php //if (in_array ('Ame', $usuario_permisos)) { ?>
    <!--  <li id="ame" class="nav "> 
        <span class="icon-document-alt-stroke"></span>
        <a href="dashboard.php?data=ame">AME Zulia</a>				
      </li>-->
    <?php
    //<li id="ame" class="nav "> 
    //	<span class="icon-document-alt-stroke"></span>
    //	<a href="javascript:;">AME Zulia</a>				
    //	<ul class="subNav">
    //		<li><a href="dashboard.php?data=ame">Inclusión y Edición</a></li>
    //		<li><a href="dashboard.php?data=amee">Exclusión</a></li>
    //	</ul>						
    //</li>
    ?>
    
<?php //} ?>
  
<?php if (in_array ('Ameadmin', $usuario_permisos)) { ?>
	<li id="ameadmin" class="nav">
		<span class="icon-layers"></span>
		<a href="dashboard.php?data=ameahorro">Reportes de AME Zulia</a>	
	</li><?php } ?> 
  
<?php if (in_array ('Ahorro', $usuario_permisos)) { ?>
<li id="cahorro" class="nav "> 
	<span class="icon-document-alt-stroke"></span>
	<a href="javascript:;">Caja de Ahorro</a>				
	<ul class="subNav">
	              
            <li><a href="dashboard.php?data=cita">Citas</a></li><?php ?>
	   	            <li><a href="dashboard.php?data=cahorro">Inscripción y Edición</a></li>
	    <?php //if ($_SERVER["HTTP_X_FORWARDED_FOR"]=='192.168.0.79'){ ?>
      <?php if (_damecajadeahorros($usuario_datos[3])=="A") { ?>
           <li><a href="dashboard.php?data=cahorro-constancia">Generar Constancia</a></li>
         
     <form name="forma" method="POST" target="_blank" action="http://192.168.0.12/estado.php?token=<?php echo $anticachecret; ?>">
                        <input  type="hidden" name="cedula"   value="<?php echo $usuario_datos[3]?>"/>
                        <div style="cursor:pointer"  onclick="enviar()"><li><a >Estado de Cuenta</a></li></div>
			                              
                       </form>
                          <script>   

function enviar()
{
   document.forma.submit()
}

    </script>
        <li><a href="dashboard.php?data=simulador">Simulador de Préstamo</a></li> 
         <?php/* if (_damecajadeahorros($usuario_datos[3])=="A") { $sql1 ="INSERT INTO utiles_cahorro (cedula_emp, nombre_empleado)";
         $sql1 .=" VALUES('".$cedula_empleado."','".$nombre_empleado."');";
         $rest=  mysql_query($sql1); */?>
           
          <!-- <form name="fora" method="POST" target="_blank" action="modules/ahorro/pdf_utiles.php?token=<?php echo $anticachecret; ?>">  
                        
                    <input  type="hidden" name="cedula"   value="<?php echo $usuario_datos[3]?>"/>
                        <input  type="hidden" name="nombres"   value="<?php echo  strtoupper($usuario_datos[1] . ' ' . $usuario_datos[2])?>"/>
                        <div style="cursor:pointer"  onclick="envi()"><li><a >Utiles Escolares</a></li></div>
			                              
                       </form>
                          <script>   
  
function envi() 
{
   document.fora.submit()
}

    </script>-->
      <?php } ?> 
        
    <?php } ?>  
       
             

  </ul>						  
</li> 


      
        <?php if (in_array ('Ahorroadmin', $usuario_permisos)) { ?>
<li id="ahorroadmin" class="nav "> 
	<span class="icon-document-alt-stroke"></span>
	<a href="javascript:;">Reportes de Caja de Ahorro</a>				
	<ul class="subNav">
        <li><a href="dashboard.php?data=cahorroadmin">Reportes de Inscritos</a></li>
            <li><a href="dashboard.php?data=citadmin">Reportes de Citas</a></li>
	<li><a href="dashboard.php?data=utiladmin">Solicitudes de Utiles Escolares</a></li>
	</ul>						
</li>
        <?php  }?>
    
 
        
       
      
<?php if (in_array ('Planvacacionalfront', $usuario_permisos)) { ?>
	<li id="plan-vacacional" class="nav">
		<span class="icon-layers"></span>
		<a href="dashboard.php?data=plan-vacacional">Plan Vacacional</a>	
	</li><?php } ?>
<?php if (in_array ('Planvacacionaladmin', $usuario_permisos)) { ?>
<li id="plan-vacacional-admin" class="nav">
		<span class="icon-document-alt-stroke"></span>
	<a href="javascript:;">Administrador Plan V</a>				
	<ul class="subNav">
    
   <!-- <li><a href="dashboard.php?data=permisos">Información</a></li>-->
    
   <!--<li><a href="dashboard.php?data=plan-vacacional-admin">Plan Vacacional Nuevos</a></li>-->

   <li><a href="dashboard.php?data=plan-vacacional-admin1">Plan Vacacional</a></li>
  
 
    
	</ul>						
	
	</li>
	<?php } ?>
    
         <?php  if (in_array ('Becas', $usuario_permisos)) { ?>
	  
      <li id="becas" class="nav">
		<span class="icon-layers"></span>
		
                <a href="dashboard.php?data=hijo">Becas</a>	  
	</li><?php } ?>
         
            
              <?php if (in_array ('Becas_admin', $usuario_permisos)) { ?>
<li id="becas_admin" class="nav "> 
	<span class="icon-document-alt-stroke"></span>
	<a href="javascript:;">Becas Admin</a>				
	<ul class="subNav">
        <li><a href="dashboard.php?data=beca-admin">Administrador</a></li>
            <li><a href="dashboard.php?data=beca-admin-1">Inscritos</a></li>
	
	</ul>						
</li>
        <?php  }?>
         <?php if (in_array ('Fas', $usuario_permisos)) { ?>
<li id="fas" class="nav "> 
	<span class="icon-document-alt-stroke"></span>
	<a href="javascript:;">FAS METRO</a>				
	<ul class="subNav">
      
            <li><a href="dashboard.php?data=Fas">Inscripción</a></li>
           <?php
                      $_SESSION['fas'] = $anticachecret;
                      if (_dameestatus($usuario_datos[3])==1){
                      ?>
            <li><a href="modules/fas/planilla_fas.php?token=<?php echo $anticachecret;?>">Consultar Planilla</a></li>
	               <?php  }?>                
	</ul>						
</li>
        <?php  }?>
      
       <?php if (in_array ('Fas_admin', $usuario_permisos)) { ?>
<li id="fas_admin" class="nav "> 
	<span class="icon-document-alt-stroke"></span>
	<a href="javascript:;">FAS METRO-Admin</a>				
	<ul class="subNav">
      
            <li><a href="dashboard.php?data=fas_admin">Consulta de Empleados</a></li>
                     
	</ul>						
</li>
        <?php  }?>
            
            <?php if (in_array ('Prestaciones', $usuario_permisos)) { ?>

<li id="prestaciones" class="nav "> 
	<span class="icon-document-alt-stroke"></span>
	<a href="javascript:;">Prestaciones</a>				
	<ul class="subNav">
        <li><a href="dashboard.php?data=prestaciones">Anticipo de Prestaciones</a></li>
		
	</ul>						
</li> 
<?php } ?>
       <?php if (in_array('SIIT-Metro', $usuario_permisos)) { ?>
                                        <li id="investigacion" class="nav "> 
                                            <span class="icon-document-alt-stroke"></span>
                                            <a href="javascript:;">SIIT-Metro</a>				
                                            <ul class="subNav">
                                                <li><a href="dashboard.php?data=averiguaciones-ai">Averiguaciones</a></li>
                                                <li><a href="dashboard.php?data=usuario-ai&Origen=investigacion">Usuarios</a></li>
                                            </ul>						
                                        </li>
                                    <?php } ?>
    <?php if (in_array('SIIT-Metro(Admin)', $usuario_permisos)) { ?>
                                        <li id="admin_ai" class="nav">
                                            <span class="icon-key-stroke"></span>
                                            <a href="javascript:;">SIIT-Metro Admin</a>	
                                            <ul class="subNav">
                                                <li><a href="dashboard.php?data=admin_ai">Administrador</a></li>
                                                <li><a href="dashboard.php?data=investigadores">Investigadores</a></li>
                                                <li><a href="dashboard.php?data=denuncias-ai">Denuncias</a></li>
                                                <li><a href="dashboard.php?data=oficios-ai">Oficios</a></li>
                                                <li><a href="dashboard.php?data=reportes-ai">Reportes</a></li>
                                                <li><a href="dashboard.php?data=usuario-ai&Origen=admin_ai">Usuarios</a></li>
                                            </ul>
                                        </li>
                                    <?php } ?>
    

   <?php if (in_array('ControlGestion', $usuario_permisos)) { ?>
                                        <li id="controlgestion" class="nav "> 
                                            <span class="icon-document-alt-stroke"></span>
                                            <a href="javascript:;">Control y Gestión</a>				
                                            <ul class="subNav">
                                                <li><a href="dashboard.php?data=controlg">Gestión de Procesos</a></li>
                                                <li><a href="dashboard.php?data=puntoc">Punto de Cuenta</a></li>
                                            </ul>						
                                        </li>
                                    <?php } ?>
                                    <?php if (in_array('ControlGestionAdmin', $usuario_permisos)) { ?>
                                        <li id="controlgestionadmin" class="nav "> 
                                            <span class="icon-layers"></span>
                                           <a href="dashboard.php?data=control_gestion_reporte">Control y Gestión Admin</a>			
                                            						
                                        </li>
                                    <?php } ?>
    
    
<?php if (in_array ('Comunicaciones', $usuario_permisos)) { ?>
<li id="comunicaciones" class="nav "> 
	<span class="icon-document-alt-stroke"></span>  
	<a href="javascript:;">Comunicaciones</a>				
	<ul class="subNav">
    <li><a href="dashboard.php?data=comunicaciones">Comunicaciones</a></li>
 
  </ul>						
</li>
<?php } ?>    
  
<?php if (in_array ('Directorio', $usuario_permisos)) { ?>
<li id="directorio" class="nav">
	<span class="icon-layers"></span>
	<a href="dashboard.php?data=directorio">Directorio</a>	
</li>
<?php } ?>
<?php if (in_array ('Documentos', $usuario_permisos)) { ?>
<li id="documentos" class="nav">
	<span class="icon-layers"></span>
	<a href="dashboard.php?data=documentos">Documentos de Interés</a>	
</li>
<?php } ?>
<?php if (in_array ('Soporte', $usuario_permisos)) { ?>
<li id="documentos" class="nav">
	<span class="icon-layers"></span>
	</li>
<?php } ?>

<?php  if (in_array ('Constancias', $usuario_permisos)) { ?>
<li id="constancia" class="nav "> 
	<span class="icon-document-alt-stroke"></span>
	<a href="javascript:;">Constancias de Trabajo</a>				
	<ul class="subNav">
       <?php //if ($_SERVER["HTTP_VIA"]!='1.1 localhost (squid/3.1.6)'){ ?>
            <li><a href="dashboard.php?data=constancias">Constancias de Trabajo</a></li>
<?php //}?>
    <li style="display:none"><a href="dashboard.php?data=constancias-recomendaciones">Recomendaciones</a></li>
    <?php if (in_array ('Constanciasadmin', $usuario_permisos)) { ?>
    <li><a href="dashboard.php?data=constanciasadmin">Reportes</a></li>
    <?php } ?>
	</ul>						
</li> 
<?php  } ?>
    
<?php if (in_array ('Permisos', $usuario_permisos)) { ?>
<li id="permisos" class="nav ">   
	<span class="icon-document-alt-stroke"></span>
	<a href="javascript:;">Permisos para RRHH</a>				
	<ul class="subNav">
      
   <li><a href="dashboard.php?data=permiso">Solicitar</a></li>

   <li><a href="dashboard.php?data=status">Estatus del permiso</a></li>
  
 
    
	</ul>						
</li>
<?php } ?>

    
<?php if (in_array ('Permisos_autorizar', $usuario_permisos)) { ?>
<li id="permisos_autorizar" class="nav "> 
	<span class="icon-document-alt-stroke"></span>
	
        <a href="javascript:;">Autorizacion de permisos</a>				
	<ul class="subNav">
        <li><a href="dashboard.php?data=verificarte">Autorizar</a></li>
		<!-- <li><a href="dashboard.php?data=carga-cv-rh">Cargar CV </a></li> -->
	</ul>						
</li>
<?php } ?>

<?php if (in_array ('Soportemr', $usuario_permisos)) { ?>
<li id="soportemr" class="nav "> 
	<span class="icon-document-alt-stroke"></span>
	
        <a href="javascript:;">Soporte MR</a>				
	<ul class="subNav">
        <li><a href="dashboard.php?data=crear-unidad">Registrar Unidad</a></li>
		<li><a href="dashboard.php?data=crear-falla">Registrar Falla </a></li> 
        <li><a href="dashboard.php?data=reportar-falla">Reportar Falla </a></li> 
        <li><a href="dashboard.php?data=crear-taquilla">Registrar Taquilla </a></li> 
	</ul>						
</li>
<?php } ?>


      
      <?php if (in_array ('Clasificados', $usuario_permisos)) { ?>
<li id="clasificados" class="nav "> 
<span class="icon-document-alt-stroke"></span>
<a href="javascript:;">Avisos Clasificados </a>	
<ul class="subNav"> 
 
  <li><a href="dashboard.php?data=suvir">Publicar Producto</a></li>
	<li><a href="dashboard.php?data=list">Lista de Productos</a></li>
    <li><a href="dashboard.php?data=clasificados">Productos por Categoria</a></li>
		<li><a href="dashboard.php?data=mis">Mis publicaciones</a></li>	
   </ul>	
</li>
<?php } ?>

<?php if (in_array ('Daniel', $usuario_permisos)) { ?>
<li id="daniel" class="nav "> 
<span class="icon-document-alt-stroke"></span>
<a href="javascript:;">Administrador de<br>Avisos clasificados</a>	
<ul class="subNav">  
    	<li><a href="dashboard.php?data=autorizar">Autorización</a></li>  
    <li><a href="dashboard.php?data=reporte">Reporte de Clasificados</a></li>

</ul>	
</li>
<?php } ?>
    
   
<?php if (in_array ('Cvadmin', $usuario_permisos)) { ?>
<li id="cvadmin" class="nav "> 
	<span class="icon-document-alt-stroke"></span>
	<a href="javascript:;">Gestión de CV</a>				
	<ul class="subNav">
        <li><a href="dashboard.php?data=cvadmin">Ver Aspirantes</a></li>
		<!-- <li><a href="dashboard.php?data=carga-cv-rh">Cargar CV </a></li> -->
	</ul>						
</li>
<?php } ?>
    <?php if (in_array ('Comunicar', $usuario_permisos)) { ?>  
<li id="comunicar" class="nav "> 
	<span class="icon-document-alt-stroke"></span>
	<a href="javascript:;">Comunicaciones Internas</a>				
	<ul class="subNav">
        <li><a href="dashboard.php?data=comi">Generar Comunicación</a></li>
        <li><a href="dashboard.php?data=como-rec">Bandeja de Entrada</a></li>
         <li><a href="dashboard.php?data=como-env">Buzón de Salida</a></li>
		<!-- <li><a href="dashboard.php?data=carga-cv-rh">Cargar CV </a></li> -->
	</ul>						
</li> 
<?php } ?>
  
    <?php if (in_array ('Comunicaciones_externas', $usuario_permisos)) { ?>
<li id="comunicaciones_externas" class="nav "> 
	<span class="icon-document-alt-stroke"></span>
	<a href="javascript:;">Comunicaciones Externas</a>				
	<ul class="subNav">
       <li><a href="dashboard.php?data=como-ext">Generar Comunicacion</a></li>
   <li><a href="dashboard.php?data=ext-env">Comunicaciones Enviadas</a></li>
		<!-- <li><a href="dashboard.php?data=carga-cv-rh">Cargar CV </a></li> -->
	</ul>						
</li>
<?php } ?>   
    
      <?php if (in_array ('Comunicar_admin', $usuario_permisos)) { ?>
<li id="comunicar_admin" class="nav "> 
	<span class="icon-document-alt-stroke"></span>
	<a href="javascript:;">Comunicaciones Admin</a>				
	<ul class="subNav">
       <li><a href="dashboard.php?data=coadmin"> Comunicaciones Internas</a></li>
       <li><a href="dashboard.php?data=coadmine"> Comunicaciones Externas</a></li>
   
		<!-- <li><a href="dashboard.php?data=carga-cv-rh">Cargar CV </a></li> -->
	</ul>						
</li>
<?php } ?>   
    
<?php if (in_array ('Reintegros', $usuario_permisos)) { ?>
<li id="reintegros" class="nav">
	<span class="icon-layers"></span>
	<a href="dashboard.php?data=reintegros">Reintegros</a>	
</li>
<?php } ?>			
<?php if (in_array ('Desdeelanden', $usuario_permisos)) { ?>
<li id="dea" class="nav "> 
	<span class="icon-document-alt-stroke"></span>
	<a href="javascript:;">Desde El Andén</a>				
	<ul class="subNav">
		<li><a href="dashboard.php?data=dea2013">Ediciones 2013</a></li>
		<li><a href="dashboard.php?data=dea2014">Ediciones 2014</a></li>
                <li><a href="dashboard.php?data=dea2015">Ediciones 2015</a></li>
	</ul>						
</li>
<?php } ?>
<?php if (in_array ('Recepcion', $usuario_permisos)) { ?>
<li id="recep" class="nav">
	<span class="icon-layers"></span>
	<a href="dashboard.php?data=recep">Recepción de Cartas</a>
</li>
<?php } ?>	

  
<?php if (in_array ('Cedulacion', $usuario_permisos)) { ?>
<li id="cedulacion" class="nav">
	<span class="icon-layers"></span>
	<a href="dashboard.php?data=cedulacion">Jornada de Cedulación</a>
</li>
<?php } ?>	
  
  
<?php if (in_array ('Metroinforma', $usuario_permisos)) { ?>
<li id="metroinforma" class="nav">
	<span class="icon-layers"></span>
	<a href="dashboard.php?data=admin-mi">Metro Informa</a>
</li>
<?php } ?>	
			
<?php if (in_array ('Metroexpres', $usuario_permisos)) { ?>
<li id="dea" class="nav "> 
	<span class="icon-document-alt-stroke"></span>
	<a href="javascript:;">Metro Expres</a>				
	<ul class="subNav">
		<li><a href="dashboard.php?data=metroexpres">Ediciones</a></li>
			</ul>						
</li>
<?php } ?>      
           
      <?php if (in_array ('Visitas', $usuario_permisos)) { ?>
<li id="visitas" class="nav "> 
	<span class="icon-document-alt-stroke"></span>
	<a href="javascript:;">Control de visitas</a>				
	<ul class="subNav">
    
    <li><a href="dashboard.php?data=reg_visitas">Registro de visitas</a></li>
    <li><a href="dashboard.php?data=lista">Lista de visitas en espera</a></li>  
	</ul>			     			
</li>  
<?php } ?>
      
           <?php if (in_array ('Visitasp', $usuario_permisos)) { ?>
<li id="visitasp" class="nav "> 
	<span class="icon-document-alt-stroke"></span>
	<a href="javascript:;">Visitas Programadas</a>				
	<ul class="subNav">
    
    <li><a href="dashboard.php?data=v_programadas">Registro de Invitado</a></li>

	</ul>			     			
</li>
<?php } ?>
      

      
    <?php if (in_array ('Visitasadmin', $usuario_permisos)) { ?>
<li id="visitasadmin" class="nav "> 
	<span class="icon-document-alt-stroke"></span>
	<a href="javascript:;">Administrador de Visitas</a>				
	<ul class="subNav">
    
    <li><a href="dashboard.php?data=repor">Reportes</a></li>  

    <li><a href="dashboard.php?data=report">Historial de visitas</a></li> 
	</ul>			     			
</li>
<?php } ?>
        
   
<?php if (in_array ('Generadormd5', $usuario_permisos)) { ?>
<li id="generadormd5" class="nav">
	<span class="icon-layers"></span>
	<a href="dashboard.php?data=genmd5">Mantenimiento de Contraseñas</a>
</li>
<?php } ?>	        
  
<?php if (in_array ('Auth', $usuario_permisos)) { ?>
<li id="auth" class="nav">
	<span class="icon-document-alt-stroke"></span>
		<a href="javascript:;">Accesos</a>				
		<ul class="subNav">
		<li><a href="dashboard.php?data=usuarios">Usuarios</a></li>
		<li><a href="dashboard.php?data=perfiles">Perfiles</a></li>
    <li><a href="dashboard.php?data=auth-reload">Recargar Roles</a></li>
	</ul>						
</li>
<?php } ?>
		
<?php if (in_array ('Admindb', $usuario_permisos)) { ?>
<li id="admindb" class="nav">
		<span class="icon-layers"></span>
		<a href="dashboard.php?data=admindb">Gestor de DB</a>
</li>
<?php } ?>	  
  
   <?php if (in_array ('Encuesta-admin', $usuario_permisos)) { ?>
	<li id="encuesta-admin" class="nav">
		<span class="icon-layers"></span>
		<a href="dashboard.php?data=reporte-encuesta">Reporte Encuesta</a>	
	</li><?php } ?> 
      
      
        

		
	</div> <!-- #sidebar -->
	<div id="content" style="background:url('src/images/logo-t.png') #ffffff no-repeat fixed center 200px;">
    <?php include('_router.php'); ?>
  </div> <!-- #content -->
	<div id="topNav">
		 <ul>
		 	<li>
		 		<a href="#menuProfile" class="menu"><?php echo $usuario_datos['nombre']. ' ' . $usuario_datos['apellido']; ?></a>
		 		<div id="menuProfile" class="menu-container menu-dropdown">
					<div class="menu-content">
						<ul>
              <?php if (in_array ('Perfil', $usuario_permisos)) { ?><li><a href="dashboard.php?data=perfil">Cambio de Contraseña</a></li><?php } ?>
              <?php if (in_array ('Notificaciones', $usuario_permisos)) { ?><li><a href="dashboard.php?data=notihistorial">Notificaciones</a></li><?php } ?>
              <?php if (in_array ('Actualizacion', $usuario_permisos)) { ?><li><a href="dashboard.php?data=actualizar">Consulta de Datos Personales</a></li><?php } ?>
              <?php if (in_array ('Actualizacion', $usuario_permisos)) { ?><li><a href="dashboard.php?data=actualizarcf">Consulta de Datos de Familiares</a></li><?php } ?>
              <li><a href="dashboard.php?data=bye">Cerrar sesión</a></li>  
						</ul>
					</div>
				</div> 
	 		</li>
		 	
		 </ul> 
	</div> <!-- #topNav -->
	
<!-- .quickNav --><!-- .quickNav --><!-- .quickNav --><!-- .quickNav --><!-- .quickNav --><!-- .quickNav --><!-- .quickNav --><!-- .quickNav -->  
<!-- .quickNav --><!-- .quickNav --><!-- .quickNav --><!-- .quickNav --><!-- .quickNav --><!-- .quickNav --><!-- .quickNav --><!-- .quickNav -->

<?php if (in_array ('Notificaciones', $usuario_permisos)) { 
  
 $sql="SELECT a.*, b.nombre, b.apellido FROM mensajeria a, usuario_bkp b WHERE a.usuario_origen=b.usuario AND a.usuario_destino=".$usuario_datos[3]." AND status = 'Enviado' ORDER BY fecha_hora DESC;";
 _bienvenido_mysql();
  $result = mysql_query($sql);
  if (!$result) {
    if ($SQL_debug == '1') {
      die('Error en Query - Respuesta del Motor: ' . mysql_error());
    } else {
      die('Error en Query');
    }
  } 
  $num_rows = mysql_num_rows($result); 
  
?> 

<div id="quickNav">
		<ul>
      <li class="quickNavMail">
				<a href="#menuAmpersand" class="menu"><span class="icon-book"></span></a>		
				<span class="alert"><?php echo $num_rows; ?></span>		
			</li> 
     
      	<div id="menuAmpersand" class="menu-container quickNavConfirm">
					<div class="menu-content cf">							
						
						<div class="qnc qnc_confirm">
							
							<h3>Notificaciones y mensajes nuevos</h3>
              
              <?php while($reg2=mysql_fetch_array($result)){ ?>
              
                <div class="qnc_item">
                  <div class="qnc_content">
                    <span class="qnc_title"><?php echo $reg2[7]; ?></span>
                    <span class="qnc_title" style="font-size:8px; font-style: italic; margin-top: -6px"><?php echo 'De: '.$reg2[8].' '.$reg2[9]; ?></span>
                    <span class="qnc_preview"><?php echo substr($reg2[2], 0, 50)."..." ?></span>
                    <span class="qnc_time"><?php echo date("d/m/Y", strtotime($reg2[1])) . " a las " . date("h:ma", strtotime($reg2[1])); ?></span>
                  </div> <!-- .qnc_content -->
                  <?php 
                    $_SESSION['notitoken'] = $anticachecret;  
                    $parametros = 'msg='.$reg2[0]; 
                    $parametros = _desordenar($parametros);
                  ?>  
                  <div class="qnc_actions">						
                    <button class="btn btn-primary btn-small" onclick="javacript:window.location='dashboard.php?data=notihistorial&token=<?php echo $anticachecret; ?>&<?php echo $parametros; ?>';">Leer</button>
                    <button class="btn btn-quaternary btn-small" onclick="javascript:document.getElementById('menuAmpersand').style.display = 'none';">Mas Tarde</button>
                  </div>
                </div>
              <?php } ?>
							<a href="dashboard.php?data=notihistorial" class="qnc_more">Ver historial de notificaciones</a>
	</div> <!-- .qnc -->	
</div>
</div>
</ul>	
</div> <!-- .quickNav -->

<?php } ?>  
<!-- .quickNav --><!-- .quickNav --><!-- .quickNav --><!-- .quickNav --><!-- .quickNav --><!-- .quickNav --><!-- .quickNav --><!-- .quickNav -->  
<!-- .quickNav --><!-- .quickNav --><!-- .quickNav --><!-- .quickNav --><!-- .quickNav --><!-- .quickNav --><!-- .quickNav --><!-- .quickNav -->
<!--En el footer el <style="margin-top: -20px;"> Para poder mejorar la interfaz-->
<footer style=""><a href="#"  class="go-top">Ir Arriba</a></footer>
<div id="footer">
División de Sistemas - Gerencia de Tecnología para la Información - Empresa Socialista Metro de Maracaibo, C.A &copy; 2014.
</div>
<script type="text/javascript" src="src/javascripts/QapTcha.jquery.js?<?php echo $anticache; ?>"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.QapTcha').QapTcha({<?php echo @$js;?>});
	});
</script>
<script>
	$(document).ready(function() {
		// Show or hide the sticky footer button
		$(window).scroll(function() {
			if ($(this).scrollTop() > 200) {
				$('.go-top').fadeIn(200);
			} else {
				$('.go-top').fadeOut(200);
		 	}
		});
		// Animate the scroll to top
		$('.go-top').click(function(event) {
			event.preventDefault();
			
			$('html, body').animate({scrollTop: 0}, 300);
		})
	});
</script> 

<?php //if ($usuario_datos[3]=='15750647' or $usuario_datos[3]=='15625966' or $usuario_datos[3]=='11285054' or $usuario_datos[3]=='17071066' or $usuario_datos[3]=='19838349') { ?>

<script type="text/javascript">
  //  var $_Tawk_API={},$_Tawk_LoadStart=new Date();
  //  (function(){
   // var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
   // s1.async=true;
  //  s1.src='https://embed.tawk.to/54caf377b37d8bc7b1903d86/default';
   // s1.charset='UTF-8';
   // s1.setAttribute('crossorigin','*');
   // s0.parentNode.insertBefore(s1,s0);
  //  })(); 
  //cargar popup
/***function anden(texto,code){
	$("#div_validacion").html("<center><div class='img_mensaje'></div><p><br><iframe src='http://www.youblisher.com/p/962422-Desde-El-Anden-Edicion-06/' frameborder='0'></iframe></p></center>")
	$("#div_validacion").dialog({
	height: 800,
	width:   600,
	modal: true,
	resizable: false, 
	show:"slide",
	hide:"slide",
						
	});						
}**/
</script>

<?php //} ?>

</body>
</html>
