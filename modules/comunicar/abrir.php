<?php 


if (isset($_GET['paso'])){
	
	
	$paso=$_GET['paso'];
	
$sql_bloq=mysql_query("SELECT * FROM `comunicacion_codigo` WHERE id_com='$paso'");

while($row_bloq=mysql_fetch_array($sql_bloq)){
$bloqueado=$row_bloq['status'];
  

}

if ($bloqueado=='0')
    
{
$no='1';
$R=mysql_query("UPDATE comunicacion_codigo SET status='$no' WHERE id_com='$paso'"); 	


	
notificar(" fue desbloqueado ", "modules/comunicar/ver_com_rec.php?&paso=$paso", "notify-success");
	
	
}

 

	}
	

	
?>
