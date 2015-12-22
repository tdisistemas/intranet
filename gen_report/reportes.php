<?php
include 'javb_config.php';
//
// import ==============Libreias iReport 5.6.0=============================
use net\sf\jasperreports\engine\export\ooxml\JRXlsxExporter as Exporter;
use net\sf\jasperreports\export\SimpleXlsxReportConfiguration as SimpleConfig;
use net\sf\jasperreports\export\SimpleExporterInput as Sei;
use net\sf\jasperreports\export\SimpleOutputStreamExporterOutput as Soseo;
//=========================================================================
	$conn = java( 'java.sql.DriverManager' )->getConnection("jdbc:mysql://localhost/$database?zeroDateTimeBehavior=convertToNull&user=$user&password=$password" );			
//=======POST=============================
$directorio = dirname(__FILE__);
	$formato = $_POST['formato'];//Extencion archivo pdf o xlsx
	$name = $_POST['nombresalida']."_".date("YmdHis").".".$formato;//   NOMBRE DEL ARCHIVO + la extencion
	$Parametros = $_POST['array'];// Parametros recibidos como areglo bidimencional
	$report_jasper = $directorio."/../reportes/".$_POST['jasper'];//direccion del archivo.jasper --> platilla generada en iReport

//==========Configuracion de reporte XLSX=========
	
	$sDCT = false;//setDetectCellType
	$sCRS = false;//setCollapseRowSpan
	$sWPB = true;//setWhitePageBackground
	
//===============================================

//=Fin===POST=============================
	function array_recibe($url_array) {
		$tmp = stripslashes($url_array);
		$tmp = urldecode($tmp);
		$tmp = unserialize($tmp);
	   return $tmp;
	}	
	$parametros = array_recibe($Parametros);
	$c = count($parametros);
	
	  $params = new java("java.util.HashMap");
	  for($i = 0; $i<$c; $i++){
		  $params->put($parametros[$i][0], $parametros[$i][1]);
	  }
//$dirRoot = realpath(".");
	  $fm = java('net.sf.jasperreports.engine.JasperFillManager');
	  //echo $report_jasper."<br>".$dirRoot."<br>";
	  try{
	  	$jpm = $fm->fillReport($report_jasper, $params, $conn);
	  }catch(Exception $ex){
	  	echo $ex;
	  }
	  
//echo "linea 55<br>";
//=========================================================================
	$outputPath = realpath(".")."/tmp_report/temp";
	
	if($formato == "xlsx"){//xlsx
		try{
			$outputStream = new Java ("java.io.FileOutputStream", new Java("java.io.File", $outputPath));
			
			$byteArrayOutputStream = new Java ("java.io.ByteArrayOutputStream");
			
			$exporter = new Exporter();
			$repConfig = new SimpleConfig();
			$exporter->setExporterInput(new Sei($jpm));
			$exporter->setExporterOutput(new Soseo($byteArrayOutputStream));
			$repConfig->setDetectCellType($sDCT);
			$repConfig->setCollapseRowSpan($sCRS);
			$repConfig->setWhitePageBackground($sWPB);
			$exporter->setConfiguration($repConfig);
			$exporter->exportReport();

			$outputStream->write($byteArrayOutputStream->toByteArray());
			$outputStream->flush();
			$outputStream->close();

			header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"); 
			
		}catch(Exception $ex){
			//echo $ex;
		}
	}
	
	if($formato == "pdf"){
		try{
		$JRExporterParameter = new java("net.sf.jasperreports.engine.JRExporterParameter");
		$outputStream = new Java ("java.io.FileOutputStream", new Java("java.io.File", $outputPath));
		
		$byteArrayOutputStream = new Java ("java.io.ByteArrayOutputStream");
		$exporter = new java("net.sf.jasperreports.engine.export.JRPdfExporter");

		$exporter->setParameter($JRExporterParameter->CHARACTER_ENCODING, "UTF-8");
		$exporter->setParameter($JRExporterParameter->JASPER_PRINT, $jpm);
		$exporter->setParameter($JRExporterParameter->OUTPUT_STREAM, $byteArrayOutputStream);
		$exporter->exportReport();                                                                                  
		$outputStream->write($byteArrayOutputStream->toByteArray());
		$outputStream->flush();
		$outputStream->close();

		header('Content-Type: application/pdf');
		}catch(Exception $ex){
			//echo $ex;
		}
	}
    try{
        $conn->close();
    }  catch (Exception $ex){
        //echo $ex;
    }
	header('Content-disposition: inline; filename="' . $name . '"');
	header('Cache-Control: public, must-revalidate, max-age=0');
	header('Pragma: public');
	header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
	header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
	readfile($outputPath);
	unlink($outputPath);
        
?>
