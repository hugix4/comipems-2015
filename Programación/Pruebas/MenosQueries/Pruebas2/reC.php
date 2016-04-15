<?php
//header("Content-Type: text/html;charset=utf-8");
require('secure_C.php');
require('fxPreguntas.php');
require_once('cnxD.php');
//$_SESSION['a1']=1;
//require_once('cnxD.php');
$funciones=new fxpreguntas();
$conexion=new conexionD();
$conexion->conectar();
$tituloEx='Examen Diagnóstico de Inglés 2015';
$Npreguntas=10;
$responderD='N';//Activar o dasactivar que se responda todo como D con un S o N
$nombreBD='comipemsv2';
$bdPreguntas='pSuayed15';
$ultimaEt=6;
$numPreguntas=60;
$pExamen='reC.php';
//echo"<br/>Del post los seg son: $segTotal";
if (empty($_POST['min'])) { $minTotal=0;} else { $minTotal=$_POST['min'];}
//$minTotal=$_POST['min'];
if($minTotal==''){
	//echo"Aparece como empty con minTotal de: $minTotal";
	$minTotal=59;//$funciones->consultaUnica("select Minutos from $nombreBD where Folio=$_SESSION[Folio]");	
}
if (empty($_POST['seg'])) { $segTotal=0;} else { $segTotal=$_POST['seg'];}
//echo"Del post los seg son: $segTotal";
if($segTotal==''){
	$segTotal=60;//$funciones->consultaUnica("select Segundos from $nombreBD where Folio=$_SESSION[Folio]");
}
if (empty($_POST['vuelta'])) { $vueltaTotal=0;} else { $vueltaTotal=$_POST['vuelta'];}
//echo"Del post los seg son: $segTotal";
if($vueltaTotal==''){
	$vueltaTotal=0;//$funciones->consultaUnica("select Vuelta from $nombreBD where Folio=$_SESSION[Folio]");
}


//:::::::::::::::::: Función para webservice WS_EDI de DGAE :::::::::::::::::://
/**
 * Función para consulta al webservice de Examen Diagnóstico de Inglés de DGAE
 * 
 * @author fhuerta
 * @param folio 	String de 6 posiciones correspondiente al folio del aspirante
 * @param periodo 	String de 4 posiciones que indica el periodo al que 
	*					corresponde el folio
 * @return	array[0]: 	true si se logra comunicar con el WS y responde conforme a los esperado, 
	*						false en caso contrario
	*			array[1]: 	1 si el update fue exitoso (array[0] es true)
	*						0 si el update no fue exitoso (array[0] es true)
	*						texto si con el error (array[0] es false)
 */
function consultaWSEDI($folio, $periodo){	
	//Validación simple de longitud de parámetros
	$folio = trim($folio);
	$periodo = trim($periodo);
	if (strlen($folio) != 6 ){
		return array(false, "Folio con longitud inválida");
	}
	if (strlen($periodo) != 4 ){
		return array(false, "Periodo con longitud inválida");
	}
	
	//Establece los parámetros como arreglo para enviarlos al WebService
	$params = array('folio' => $folio,
	'periodo' => $periodo);
	
	try{
        //Conecta al WS
		$clienteSOAP = new SoapClient('http://webser.dgae.unam.mx:8280/services/ExamenDiagIngles?wsdl', 
		array('encoding'=>'ISO-8859-1','trace'=>1));
		
		//Invoca al método deseado del WS
		$response = $clienteSOAP->setEDI($params);   
        
		//Trae la respuesta y la convierte en array
		$arrayRespuesta = json_decode(json_encode($response->EDI), true);
		
		//Verifica la respuesta dentro del tag "status" y la devuelve
		if (isset($arrayRespuesta['status']) && ($arrayRespuesta['status']==0 || $arrayRespuesta['status']==1) ){
			return 	array(true, $arrayRespuesta['status']);
			}else{
			return 	array(false, "Respuesta no esperada: " . $arrayRespuesta['status']);
		}		
		}catch(SoapFault $e){
		//Si hay excepción la capta y devuelve false
        $excepcionMsj = print_r ($e, true);
		return 	array(false, "Excepción en el WS: " . $excepcionMsj);
	}
}
//:::::::::::::::::: FIN  Función para webservice  WS_EDI de DGAE :::::::::::::::::://

?>
<!doctype html>
<html lang="es">
	<head>
		<title>Coordinaci&oacute;n General de Lenguas</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">	
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"><!-- Bootstrap Latest compiled and minified CSS -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script><!-- jQuery library --> <!--JavaScript -->	
		<link rel="stylesheet" href="hugix.css" type="text/css" media="screen" /><!-- Mi hoja de estilos-->
		<link rel="stylesheet" href="css/hugixBS.css" type="text/css" media="screen" /><!-- Mi 2a hoja de estilos-->
		<link href="Favicon.ico" type="image/x-icon" rel="shortcut icon" />
		<script>
		  $(document).ready(function(){
			
			$('ul.tabs li').click(function(){
				var tab_id = $(this).attr('data-tab');

				$('ul.tabs li').removeClass('current');
				$('.tab-content').removeClass('current');

				$(this).addClass('current');
				$("#"+tab_id).addClass('current');
					})

				})
				
			$(document).ready(function()
			{		
				$("#boton").click(function ()
				{ //($i=(1+$Nactual);$i<=($Npreguntas+$Nactual);$i++)
				
				var neutro="";
				var radio;
				var txt="";
				var i;
				var j;
				var sel=0;
				var nombre=document.getElementsByName("Et")[0].value;
				var v2=0;
				
				if(nombre==12)
				{
				var v2=5;
				//alert("Nombre es: "+nombre+" y v2 es: "+v2);			
				}
				
				var v1=(nombre*10)-9;
				for(var i=v1;i<=(v1+9-v2);i++){
				   neutro="p"+i;
				   //alert("neutro tiene un valor en "+i+" de "+neutro);       
				   radio=document.getElementsByName(""+neutro); 
				   for(j=0;j<radio.length;j++){
					//alert("Hola "+j);
					if(radio[j].checked){     
					 sel++;
					}
				   }
				}
				if(sel==0){
				 alert("No has respondido nada");
				 return false;
				}
				if(sel>0 && sel<(10-v2)){
				 alert("Te faltan preguntas por responder");
				 return false;
				}
				if(sel==10-v2){
				 //alert("Bien, finalizaste la etapa");
				 $("#examen").submit();
				}
				
				});
			});
						
			function todas($valor){
				var allElems = document.getElementsByTagName('input');
				for (i = 0; i < allElems.length; i++) {
					if (allElems[i].type == 'radio' && allElems[i].value != $valor) {
						allElems[i].checked = true;
					}
				}
			}	
				
			
			function hola(minuto,seg,vuelta){
				//alert("Minuto "+minuto+" y seg es "+seg+" y la vuelta es "+vuelta);
				//setTimeout(function(){ hola(44,23,5) }, 2000);
				seg=seg-1;
				if(minuto==59){
				document.getElementById('mins').value='Tiempo restante: ' +minuto+'m';
				}
				if(seg<=-1 && vuelta<60){
					//alert("Entró al if de seg<=1 y vuelta < 60")
					//alert("Valor de vuelta es: "+vuelta );
					//alert("Tiempo ha llegado a 0");
					seg=59;
					vuelta++;
					//alert("Minutos antes: "+minutos);
					minuto--;
					//alert("Minutos despues "+minuto+" y  vuelta: "+vuelta);
					if(minuto<=0){
						//alert("Valor de vuelta es "+vuelta);
						return;
					}
					document.getElementById('mins').value='Tiempo restante: ' +minuto+'m : '+seg+'s';
					document.getElementById('min').value=minuto;
					//alert("Alert posterior al getelement del min");
				}		
								
				if(vuelta==60){
					seg=0;
					minuto=0;
					alert("El tiempo del examen ha terminado, sin embargo aún puedes terminarlo");				
					return;					
				}
				document.getElementById('mins').value='Tiempo restante: ' +minuto+'m : '+seg+'s';
				document.getElementById('seg').value=seg;
				document.getElementById('vuelta').value=vuelta;
				setTimeout(function(){hola(minuto,seg,vuelta) },1000); // 1000ms = 1s
			}
			
		</script>
	</head>
	<body  style="margin-top: -1.5%; font-size:1.4em" onload='hola(<?php echo $minTotal;?>,<?php echo $segTotal;?>,<?php echo $vueltaTotal;?>); ' >	
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
			</div>
			<div id="navbar" class="collapse navbar-collapse">
				  <p style="text-align: right;"><font style="color:#fff;font-size:2em; font-weight:bold;"><br/><?php echo $tituloEx;?></font></p>				  
			</div><!--/.nav-collapse -->
		</nav>
		<br/>
		<div class="container"><!-- Aqu&iacute; se envuelve todo el contenido de la p&aacute;gina -->		
				<!--Funci&oacute;n de php para mostrar la pregunta y registro correspondiente sin tanto rollo-->
				<?php
					/*Esta funci&oacute;n obtiene como arreglo las respuestas seleccionadas de los radiobutton*/
					function getRespuestas($Npreguntas,$Nactual){
						$reI=array();
						for($i=1+$Nactual;$i<=$Npreguntas+$Nactual;$i++){						
							$reI[$i]=$_POST['p'.$i];				
						}
						return $reI;
					}
					
					/*Funci&oacute;n que obtiene un arreglo de 1 y 0 las respuestas bien o mal*/
					function rCorrecta($respuestas,$correctas,$Npreguntas,$Nactual){		
						$rCor=array();
						for($i=1+$Nactual;$i<=$Npreguntas+$Nactual;$i++){
							if($respuestas[$i]==$correctas[$i]){
								$rCor[$i]=1;			
								//echo "La respuesta correcta es: $ansArr[$h]";
							}
							else{
								$rCor[$i]=0;			
							}		
						}
						return $rCor;			
					}
					function preguntaDe4($num,$Pregunta,$OpA,$OpB,$OpC,$OpD, $rBien,$etapa){		
						$ansArr=array($OpA,$OpB,$OpC,$OpD);
						shuffle($ansArr);
						echo "<br/><br/><br/><b><font  color='#08088A'>".$num.". </font><font id='pg".$num."' color='#08088A' >".str_replace("B:","<br/>&nbsp;&nbsp;&nbsp;&nbsp;B:",$Pregunta)."</font></b>
						<br/><br/><input type='radio' name='p".$num."' value='".$ansArr[0]."'><font  color='#08088A'>A. </font>".$ansArr[0]."</input>
						<br/><br/><input type='radio' name='p".$num."' value='".$ansArr[1]."'><font  color='#08088A'>B. </font>".$ansArr[1]."</input>
						<br/><br/><input type='radio' name='p".$num."' value='".$ansArr[2]."'><font  color='#08088A'>C. </font>".$ansArr[2]."</input>
						<br/><br/><input type='radio' name='p".$num."' value='".$ansArr[3]."'><font  color='#08088A'>D. </font>".$ansArr[3]."</input>		
						<input type='hidden' name='R".$num."' value='".$rBien."'>
						<input type='hidden' name='Et' value='$etapa'>			
						</br></br>";
					}
					/*Funci&oacute;n que obtiene los arreglos binarios como una sola cadena*/
					function cadenaBin($Npreguntas,$rBinarias,$Nactual){
						$cadBin='';
						for($i=1+$Nactual;$i<=$Npreguntas+$Nactual;$i++){
							$cadBin.=$rBinarias[$i];
						}
						return $cadBin;
					}										
						$Folio=$_SESSION['Folio'];					
						$FolioU=$_SESSION['FolioU'];
						$Termino=$funciones->consultaUnica("select Termino from $nombreBD where Folio='$Folio'");
						$dePost='';
						if($Termino=='S')
						{					
							echo"<br/>
							<br/>
							Examen terminado.<br/><br/> Tu examen de inglés ha finalizado satisfactoriamente
							<br/>
							";
							echo"<br/><br/><form action='salirEC.php'><input class='btn' type='submit' value='Cerrar Sesión' /></form>";							
						}						
						echo "<input type='text' id='mins' size='26%'  style='position:fixed; top:0%; right:15%;  visibility:visible; background-color : Black; border: none; color : White; font-family : Verdana, Arial, Helvetica; font-size : 8pt; text-align : center;' onfocus=' window.document.getElementById('mins').blur()' value='0' '>";
						
						
						if(empty($_POST['Et']))
						{//$_POST['Et']==null){
							//echo"El valor de post es nulo, por tanto se ocupará; el valor de la BD<br/>";
							
							$Bin1=$funciones->consultaUnica("select Bin1 from $nombreBD where Folio=$Folio");
							if($Bin1=='-'){				
								$etapa=0;
								//echo "<br/>El valor de etapa es: $etapa, dentro del if del Bin1<br/>";
							}
							else{ 
								$Bin2=$funciones->consultaUnica("select Bin2 from $nombreBD where Folio=$Folio");
								if($Bin2=='-'){
								$etapa=1;
								//echo "<br/>El valor de etapa es: $etapa, dentro del if del Bin2<br/>";
								}
								else{
									$Bin3=$funciones->consultaUnica("select Bin3 from $nombreBD where Folio=$Folio");
									if($Bin3=='-'){
										$etapa=2;
										//echo "<br/>El valor de etapa es: $etapa, dentro del if del Bin3<br/>";
									}
									else{
										$Bin4=$funciones->consultaUnica("select Bin4 from $nombreBD where Folio=$Folio");
										if($Bin4=='-'){
											$etapa=3;
											//echo "<br/>El valor de etapa es: $etapa, dentro del if del Bin3<br/>";
										}
										else{
											$Bin5=$funciones->consultaUnica("select Bin5 from $nombreBD where Folio=$Folio");
											if($Bin5=='-'){
												$etapa=4;
												//echo "<br/>El valor de etapa es: $etapa, dentro del if del Bin3<br/>";
											}
											else{
												$Bin6=$funciones->consultaUnica("select Bin6 from $nombreBD where Folio=$Folio");
												if($Bin6=='-'){
													$etapa=5;
													//echo "<br/>El valor de etapa es: $etapa, dentro del if del Bin3<br/>";
												}
												else{
													$etapa=$ultimaEt+1;
												}
											}
										}
									}
								}
							}
							
							//$etapa=$funciones->consultaUnica("select Etapa from $nombreBD where Folio=$_SESSION[Folio]");
							$dePost='N';
							//echo"Sin post Etapa: ".$etapa;
							//echo"<br/>";							
							if($etapa==$ultimaEt+1 && $Termino=='N')
							{								
								//echo"Adentro del if<br/>";		
								//echo "Lo que se envia a la función obtenerArrayBinario es: $ultimaEt, $Folio, $nombreBD";
								$arrayBin=$funciones->obtenerArrayBinarioF($ultimaEt,$Folio,$nombreBD);							
								//echo"El array bin, también se emplea para colocación<br/>";
								//print_r($arrayBin);
								//echo"<br/>";
								//$aciertos=$funciones->obtenerAciertos($numPreguntas,$arrayBin);
								//echo "<br/>Tuvo los siguientes aciertos: ".$aciertos;
								//echo"<br/>";
								$calNum=$funciones->obtenerCalNum($numPreguntas-1,$arrayBin);
								//echo "<br/>La cal num: ".$calNum;
								//echo"<br/>";
								$colocacion=$funciones->colocacionIni($arrayBin);
								//echo "$colocacion <br/>";
								$Seccion=$funciones->Seccion($arrayBin);							
								//echo "Seccion: $Seccion <br/>";
								//echo"Update $nombreBD Set Calificacion='$calNum',Resultado='$colocacion', Termino='S' where Folio='$_SESSION[Folio]'";
								
									$periodo = '1516';
									//echo "Antes de la consulta WSEDI no hay nada";
									//echo "<br/>folioU $FolioU<br/>";
									
									$respuestaEDI = consultaWSEDI($FolioU, $periodo);
									//echo $respuestaEDI;
									if($respuestaEDI[0]==true){
										$sql="Update $nombreBD Set Calificacion='$calNum', Resultado='$colocacion', Seccion='$Seccion', Termino='S' where Folio='$Folio'";
										//echo "<br/>$sql<br/>";		
										//$sqlD=$conexionD->consulta($sql);
										//$cal=serialize($calNum);
										//$col1=serialize($colocacion);
										$sql=$conexion->consulta($sql);
										$conexion->desconectar();										
										echo"<br/><br/>Examen terminado.<br/><br/> Tu examen de inglés ha finalizado satisfactoriamente<br/><br/>";
										echo"<br/><br/><form action='salirEC.php'><input class='btn' type='submit' value='Cerrar Sesión' /></form>";
										//echo "<br/><br/><u><a target='_blank' href='calificaS.php?c=$_SESSION[Folio]&cal=$cal&rs=$col1' style='color:black'>Comprobante en pdf</a></u>";
									}
									else{
										echo"Hubo un error ".$respuestaEDI[1];
									}
							}
							
						}
						
						else
						{	
							$etapa=$_POST['Et'];
							//echo"De post Etapa: ".$etapa."<br/>";
							//echo "Ocuparemos el valor de post<br/>";
							
							$dePost='S';
							$Nactual=($etapa*10)-10;
							//echo "Nactual tiene valor de: $Nactual<br/>";
							
							//if($etapa==5){echo"Si estamos en 5";}
							//echo "Lo que se pasa es: $Npreguntas y $Nactual";
							$respuestas=getRespuestas($Npreguntas,$Nactual);//Aqui se obtienen las respuestas tal cual en un arreglo que empieza en 1 no en 0 y termina en 115 en vez de 114			
							//echo "Respuestas tal cual=";
							//print_r($respuestas);
							//echo"<br/><br/>";
							$correctas=$funciones->getCorrectas($Npreguntas,$Nactual);
							//echo "Correctas tal cual=";
							//print_r($correctas);
							//echo"<br/><br/>";
							$rBinarias=rCorrecta($respuestas,$correctas,$Npreguntas,$Nactual);//Aqui se obtiene el arreglo binario '1010101' que da la suma para la calificacion final
							//echo "Respuestas binarias: ";
							//print_r($rBinarias);
							//echo"<br/><br/>";
							
							$respuestas2='';
							for($i=(1+$Nactual);$i<=($Npreguntas+$Nactual);$i++){				
								$respuestas2.='@'.$i.$respuestas[$i];
							}			
							//echo"Respuestas a separar: $respuestas2";
							//echo"<br/>";
							$cadBin=cadenaBin(10,$rBinarias,$Nactual);  //Esta funci&oacute;n genera el arreglo binario como cadena de texto
							//echo "<br/>Cadena binaria es: $cadBin<br/>";
							//echo "<br/>Contenido de session: $_SESSION[Refrescar]<br/>";			
							//echo "<br/>Termino: $Termino<br/>";
							
							if ($etapa==0 && $dePost=='S')
							{				
								$etapaDB=$etapa+1;				
								$sql="Update $nombreBD Set Bin$etapa='$cadBin', Rc$etapa='$respuestas2', Minutos='$minTotal', Vuelta='$vueltaTotal', Segundos='$segTotal', Etapa='$etapaDB',Inicio=Now() where Folio='$_SESSION[Folio]'";	
								//$sqlD=$conexionD->consulta($sql);
								$sql=$conexion->consulta($sql);
							}
							
							if ($etapa>=1 && $etapa<$ultimaEt && $dePost=='S')
							{				
								$etapaDB=$etapa+1;
								//echo"Update $nombreBD Set Bin$etapa='$cadBin', Rc$etapa='$respuestas2', Etapa='$etapaDB' where Folio='$_SESSION[Folio]'";
								if($etapa==1)
								{
									$sql="Update $nombreBD Set Bin$etapa='$cadBin', Rc$etapa='$respuestas2', Etapa='$etapaDB', Minutos='$minTotal', Vuelta='$vueltaTotal', Segundos='$segTotal', Inicio=Now() where Folio='$_SESSION[Folio]'";	
								}
								else
								{
									$sql="Update $nombreBD Set Bin$etapa='$cadBin', Rc$etapa='$respuestas2', Etapa='$etapaDB', Minutos='$minTotal', Vuelta='$vueltaTotal', Segundos='$segTotal' where Folio='$_SESSION[Folio]'";	
								}				
								//$sqlD=$conexionD->consulta($sql);
								$sql=$conexion->consulta($sql);
							}
							
							else if($etapa==$ultimaEt && $dePost=='S')
							{	
								//echo"Update $nombreBD Set Bin5='$cadBin',  Rc5='$respuestas2', Etapa='6' where Folio='$_SESSION[Folio]'";
								$sql="Update $nombreBD Set Bin$ultimaEt='$cadBin',  Rc6='$respuestas2', Minutos='$minTotal', Vuelta='$vueltaTotal', Segundos='$segTotal', Etapa=$ultimaEt+1 where Folio='$_SESSION[Folio]'";		
								//$sqlD=$conexionD->consulta($sql);
								$sql=$conexion->consulta($sql);				
								echo"<br/><br/><form action='$pExamen'><input class='btn' type='submit' value='Terminar examen' /></form>";
								//echo "<br/><br/><u><a href='$pExamen' style='color:black'>Terminar examen</a></u>";
							}
							
						}							
						if($etapa>=0 && $etapa<=5)
						{	
							echo "<form role='form' align='justify' id='examen' action='$pExamen' method='POST' style='margin-left:20%;'>";
							$pInicial=($etapa*10)+1;
							$pFinal=($etapa*10)+10;
							if($pInicial==1)
								{
									echo"<p style='font-weight=bold;'><h3>LANGUAGE USE</h3></p>
									Complete the sentences or conversations. Choose the correct option <b>a</b>, <b>b</b>, <b>c</b> or <b>d</b>.<br/><br/>";
								}		
							//echo"<br/>El valor de Num es: $Num<br/>";
							$Pregunta='';
							$OpA='';
							$OpB='';
							$OpC='';
							$OpD='';
							$rBien='';
							$sqlQ = "select Numero, Pregunta, A, B, C, D, Respuesta from $bdPreguntas where Numero Between '$pInicial' and '$pFinal'" ;
							//echo "$sqlQ<br/>";
							$sqlQ=$conexion->consulta($sqlQ);							
							while($rowQ=mysql_fetch_array($sqlQ))
							{
								$i=$rowQ["Numero"];
								$Pregunta=$rowQ["Pregunta"];
								$OpA=$rowQ["A"];
								$OpB=$rowQ["B"];
								$OpC=$rowQ["C"];
								$OpD=$rowQ["D"];
								$rBien=$rowQ["Respuesta"];
								preguntaDe4($i,$Pregunta, $OpA, $OpB, $OpC, $OpD,$rBien,($etapa+1));								
							}
							
							echo "<input type='hidden' name='Folio' value='$_SESSION[Folio]'>";							
							echo "<input type='hidden' id='min' name='min'>";
							echo "<input type='hidden' id='seg' name='seg'>";
							echo "<input type='hidden' id='vuelta' name='vuelta'>";
							$prueba=$_SESSION['Refrescar']='S';
							echo "<input type='hidden' name='Refrescar' value='$prueba'><br/>";
							/*echo "<input type='hidden' name='etP1' value='$exP1'><br/>";
							echo "<input type='hidden' name='etP2' value='$exP2'><br/>";
							echo "<input type='hidden' name='etP3' value='$exP3'><br/>";
							echo "<input type='hidden' name='etP4' value='$exP4'><br/>";
							echo "<input type='hidden' name='etP5' value='$exP5'><br/>";*/
							if($etapa==$ultimaEt){
								echo "<br/><br/><input class='btn' type='submit' id='boton' value='Finalizar' style='margin-left:150;'>";
							}else{
							echo "<br/><br/><input class='btn' type='submit' id='boton' value='Continuar' style='margin-left:150;'>";
							}
							if($responderD=='S')
							{
							echo "<br/><br/><input class='btn' type='button' onclick=todas(1) value='Responder todo D' style='margin-left:150;'>";
							}
							//echo "<br/><br/><input type='button' onclick=todas(1) value='Responder todo D' style='margin-left:150;'>";
							//echo "<br/><br/><input type='button' onclick=todas(0) value='Responder Mal' style='margin-left:150;'>";							
							echo "</font>";
							echo "</form>";
						}
						
						$conexion->desconectar();
					?>
					<br/><br/>
		</div><!-- Fin del container fluid -->
		
		<br/><br/><br/><br/>
		<footer class="footer" style="height: 1.5%;">	
			<div class="container">
				<p class="text-muted"><font style="font-size: 0.9em; ">
				Hecho en M&eacute;xico, <a href="http://www.unam.mx">Universidad Nacional Aut&oacute;noma de M&eacute;xico (UNAM)</a>, todos los derechos reservados 2009 - 2015. Esta p&aacute;gina puede ser reproducida con fines no lucrativos, siempre y cuando se cite la fuente completa y su direcci&oacute;n electr&oacute;nica, y no se mutile. De otra forma requiere permiso previo por escrito de la instituci&oacute;n.<a href="creditos.html">Cr&eacute;ditos</a></font>
				</p>
			</div>
		</footer>	
	</body>
	
</html><!--Ingeniero Hugo Luna a.k.a. hugix4-->