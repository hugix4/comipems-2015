<?php
	session_start();
	// remove all session variables
	session_unset();
	session_destroy();
	$tituloEx='Examen Diagnóstico de Inglés 2015';
?>
<html lang="es">
	<head>
		<title>Coordinaci&oacute;n General de Lenguas</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">	
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"><!-- Latest compiled and minified CSS -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script><!-- jQuery library -->
		<link rel="stylesheet" href="hugix.css" type="text/css" media="screen" /><!-- Mi hoja de estilos-->
		<link rel="stylesheet" href="css/hugixBS.css" type="text/css" media="screen" /><!-- Mi 2a hoja de estilos-->
		
		<script>
			function dirCGL()
			{
				var direccion="http://www.cgl.unam.mx";
				location.href=direccion;
			}
			
			function dirUNAM()
			{
				var direccion="http://www.unam.mx";
				location.href=direccion;
			}
		</script>
	</head>
 
	
	<body>
		<nav class="navbar navbar-inverse">
			
				<div class="navbar-header">					
					  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					  </button>					  
					<a class="navbar-brand" href="#">
						<img src="images/LogoUNAMamarillo.png" alt="UNAM" height="80%" width="5.5%" onclick='dirUNAM()' style="cursor:pointer; position:absolute; top:16%; left:5%; height=10%;">
					</a>
					<a class="navbar-brand" href="#">
						<img alt="" src="images/LogoCGLblanco.png" alt="CGL" height="70%" width="12%" onclick='dirCGL()' style="cursor:pointer; position:absolute; top:20%; left:15%;">
					</a>
					
					  <!--<a class="navbar-brand" href="#">CGL</a>-->
				</div>
				<div id="navbar" class="collapse navbar-collapse">
					  <p style="text-align: right;"><font style="color:#fff;font-size:2em; font-weight:bold;"><br/><?php echo $tituloEx;?></font></p>
					  
				</div><!--/.nav-collapse -->				
		  
		</nav>
		
	<div class="container container-fluid">	
		<br><br>
		<h1>Sesi&oacute;n finalizada</h1>
		<br><br>
		Gracias por acceder a la p&aacute;gina
		<br><br>
		Por favor cierra esta ventana
	<br/>	
		Únicamente para pruebas, <u><a href="pEC.html">den clic aquí para regresar a la página de inicio</a></u>
	</div><!-- container -->
	<br/>
	<br/>
	<footer class="footer">
			<div class="container">
			<p class="text-muted"><font style="font-size: 0.9em">
				Hecho en M&eacute;xico, <a href="http://www.unam.mx">Universidad Nacional Aut&oacute;noma de M&eacute;xico (UNAM)</a>, todos los derechos reservados 2009 - 2015. Esta p&aacute;gina puede ser reproducida con fines no lucrativos, siempre y cuando se cite la fuente completa y su direcci&oacute;n electr&oacute;nica, y no se mutile. De otra forma requiere permiso previo por escrito de la instituci&oacute;n.<a href="creditos.html">Cr&eacute;ditos</a></font>
			</p>
			</div>
		</footer>
<!--Ingeniero Hugo Luna a.k.a. hugix4-->
</body>
</html>