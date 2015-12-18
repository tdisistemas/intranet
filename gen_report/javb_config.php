<?php
	require_once("../../JavaBridge/java/Java.inc");
	$user = "root";
	$password = "123456";
	$database = "metro_inextranet";
    java( 'java.lang.Class' )->forName( 'com.mysql.jdbc.Driver' );
?>
