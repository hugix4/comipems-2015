<?php 
class conexionD{// Parametros a configurar para la conexion de la base de datos 
	var $hostBD = "localhost";    // Dirección del servidor BD 	
	var $usuarioBD = "cgl";    // Usuario para acceder a la BD 
	var $claveBD = "Cgl.2015";    // Clave de acceso de nuestra BD
	var $nombreBD = "cgl";    // Nombre de nuestra BD 
	var $enlaceBD=null;

	// Fin de los parametros a configurar para la conexion de la base de datos 
	function conectar(){
	$respuesta=0;	
	if($this->enlaceBD = mysql_connect($this->hostBD,$this->usuarioBD,$this->claveBD) or trigger_error(mysql_error(),E_USER_ERROR)){
			mysql_select_db($this->nombreBD,$this->enlaceBD) or die(mysql_error());
			$respuesta=1;
		}
		return $respuesta;
	}
	
	function consulta($sql){
		$resultado_sql=mysql_query($sql) or die(mysql_error());
		return $resultado_sql;
	}
	
	function imprime($row,$condicion,$columna,$ancho,$referencia,$color){		
		if($row[$columna]==$condicion){
			 echo"<td width=".$ancho."%><u><a href='".$referencia."'><font color='".$color."'><b>".$row[$columna]."</b></font></a></u></td>";
			  //return $impreso;
		}else{   echo"<td width=".$ancho."%>".$row[$columna]."</td>";
			  //return $impreso;
		}
	}
	
	function imprimeSinVinculo($row,$condicion,$columna,$ancho,$color){		
		if($row[$columna]==$condicion){
			echo"<td width=".$ancho."%><font color='".$color."'><b>".$row[$columna]."</b></font></td>";
			//return $impreso;
			}else{   echo"<td width=".$ancho."%>".$row[$columna]."</td>";
			//return $impreso;
		}
	}
	
	function consultaUnica($datoConsultar){
		$resultado=mysql_query($datoConsultar);
		$datoUnico=mysql_fetch_array($resultado);
		return $datoUnico[0];
	}
	
	function desconectar(){
		//echo"A continuación se cerrará la conexión con la BD";
		mysql_close();
	}		
}
?> 