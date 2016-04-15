<?php 
class conexionD{// Parametros a configurar para la conexion de la base de datos 
	var $hostBD = "localhost";    // Dirección del servidor BD 	
	var $usuarioBD = "cgl";    // Usuario para acceder a la BD 
	var $claveBD = "Cgl.2015";    // Clave de acceso de nuestra BD
	var $nombreBD = "cgl";    // Nombre de nuestra BD 
	//Estos 2 tal vez se puedan remover
	var $enlaceBD=null;
	var $conexionBD=null;
	
	function conectar(){
		//Crear conexión
		$respuesta=0;
		$conn = new mysqli($hostBD, $usuarioBD, $claveBD, $nombreBD);	
		//Verifica la conexión
		if ($conn->connect_error) {
			die("Conexión fallida: " . $conn->connect_error);
			$respuesta=0;
		}
		else{
			$respuesta=1;
		}
		return $respuesta;
	}
	
	function consulta($sql){
		if ($conn->query($sql) === FALSE) {
			echo "Error al realizar consulta la BD: " . $conn->error;//No se realizó adecuadamente la consulta
		} 
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
		$resultado=$conn->query($datoConsultar);
		//$datoUnico=mysqli_query($resultado);
		return $resultado;//O $datoUnico;
	}
	
	function desconectar(){
		mysqli_close($conn);
	}		
}
?> 