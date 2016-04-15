<?php
ini_set("session.gc_maxlifetime","18000");//inicio la sesi󮍊session_start();
ini_set("session.cookie_lifetime","18000");
session_start();
require_once('cnxh.php');
$conexion=new conexion();
$conexion->conectar();
$paginaInicio='#';
//comprueba que el usuario sea v⭩do
?>

<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<link href="Favicon.ico" type="image/x-icon" rel="shortcut icon" />
	 <!--[if lt IE 9]> 
	<script type="text/javascript"> 
	   document.createElement("nav"); 
	   document.createElement("header"); 
	   document.createElement("footer"); 
	   document.createElement("section"); 
	   document.createElement("article"); 
	   document.createElement("aside"); 
	   document.createElement("hgroup"); 
	</script> 
	<![endif]-->
		<title>Coordinaci&oacute;n General de Lenguas UNAM</title>
		<link rel="stylesheet" href="css/hugixR.css" type="text/css" media="screen" />
		<link rel="stylesheet" type="text/css" href="print.css" media="print" />
	</head>	

<?php


if($_SESSION["a1"]!="1"){
	//si no existe, se dirige a la p⨩na de inicio 
	echo"<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>Por favor vuelve a ingresar al examen, la sesión ha finalizado.";	
	echo"<br/><br/><b><u><a href='$paginaInicio'>Volver al inicio</a></u></b>.";
	//$sql="update bdIni15 set Etapa='8' where Etapa='9' and Bin9='-'";
	//$sql=$conexion->consulta($sql);	
	//echo"<br/><br/><a href='https://servicios.dgae.unam.mx/Febrero2015/resultados.pdf'><u>Inicio</u></a>";	
	//salimos del script
	exit();
}
?>