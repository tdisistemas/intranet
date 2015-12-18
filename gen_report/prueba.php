<?php
//require_once("../JavaBridge/java/Java.inc");
	$formato = $_POST['formato'];//Extencion archivo pdf o xlsx
	$name = $_POST['nombresalida'].".".$formato;//   NOMBRE DEL ARCHIVO + la extencion
	$Parametros = $_POST['array'];// Parametros recibidos como areglo bidimencional
	$report_jasper = $_POST['jasper'];//direccion del archivo.jasper --> platilla generada en iReport

	
	echo $formato."<br>";
	echo $name."<br>";
	function array_recibe($url_array) {
		$tmp = stripslashes($url_array);
		$tmp = urldecode($tmp);
		$tmp = unserialize($tmp);
	   return $tmp;
	}
	$parametros = array_recibe($Parametros);
	$c = count($parametros);
	echo "=====Array=====</br>";
	  for($i = 0; $i<$c; $i++){
		  echo $parametros[$i][0]." = ".$parametros[$i][1]."<br>";
	  }
	  echo "=====Array=====</br>";
	echo $report_jasper."<br><br>";

$imagen1 = $parametros[1][1];
$imagen2 = $parametros[2][1];
?>
<html>
<head> <title>PRUEBA</title>
</head>
	<body>
		<?php
		echo <<<HTML
            <img src="$imagen1" ALT="$imagen1"  BORDER=1  width="100" height="100">
            <img src="$imagen2" ALT="$imagen2"  BORDER=1  width="100" height="100">
HTML;
 ?>
	</body>


</html>