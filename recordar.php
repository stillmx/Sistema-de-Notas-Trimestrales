<?php 
header("Content-type: text/html; charset=utf8");
require_once ("includes/db.php");

	$response_json=array("num_rows"=>0,"success"=>false,
	 "info"=>array("tipo_u"=>NULL, "cedula"=>NULL, "respuesta"=>NULL, "mensaje"=>"bien"));
	
	if($_POST["tipo_u"]==1){	
		
		$estudiante="e.ced_estu='".$_POST['cedula']."'";
		$sql="SELECT e.cod_estu, u.pregunta, e.nom_estu  FROM estudiante AS e LEFT OUTER JOIN 
		usuario AS u ON u.cod_estu=e.cod_estu WHERE ".$estudiante." GROUP BY u.pregunta ";
		//$response_json['info']['mensaje']='estudiante';
	}elseif ($_POST["tipo_u"]==2){

		$profesor="p.ced_prof='".$_POST['cedula']."'";
		$sql="SELECT p.cod_prof, u.pregunta, p.nom_prof  FROM profesor AS p LEFT OUTER JOIN 
		usuario AS u ON u.cod_prof=p.cod_prof WHERE ".$profesor." GROUP BY u.pregunta ";
		$response_json['info']['mensaje']='profesor';
	}
	
	
	$consulta= mysql_query($sql, $conexion) or die($sql);
	if(!$consulta){
		echo"Error de Consulta", mysql_errno(), mysql_error();
		exit;
	}
	$response_json['success']=true;
	$response_json['num_rows']=mysql_num_rows($consulta);
	while($fila = mysql_fetch_assoc($consulta)){
		if(!isset($response_json['info']['cedula'])){
			$response_json['info']['cedula']=$fila['pregunta'];
		}
		/*if($response_json['num_rows']>1) {
		$resp="u.respuesta='".$_POST['respuesta']."'";
		$sql="SELECT u.usuario, u.clave FROM estudiante AS e LEFT OUTER JOIN usuario AS u ON u.cod_estu=e.cod_estu WHERE ".$resp." GROUP BY u.clave ";
			$response_json['info']['respuesta']=$fila['clave'];
			$response_json['info']['mensaje']="Su contraseña";
		}*/

	}
	echo json_encode($response_json);
	mysql_close($conexion);
	
?>
