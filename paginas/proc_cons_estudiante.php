<?php 
require_once ("../includes/db.php");
session_start();
	
	$response_json=array("num_rows"=>0,"success"=>false,
	 "info"=>array("lapsos"=>array()));
		if($_POST['periodo']==2){
			$sql="SELECT n.cod_per FROM estudiante AS e LEFT OUTER JOIN notas AS n 
			ON n.cod_estu=e.cod_estu WHERE e.cod_estu=".$_SESSION["id_usuario"]." GROUP BY n.cod_per ";
		}	
	$consulta= mysql_query($sql, $conexion) or die($sql);
	if(!$consulta){
		echo"Error de Consulta", mysql_errno(), mysql_error();
		
	}
	$response_json['success']=true;
	$response_json['num_rows']=mysql_num_rows($consulta);

	while($fila = mysql_fetch_assoc($consulta)){
		
		array_push($response_json['info']['lapsos'], $fila["cod_per"]);
	}
	echo json_encode($response_json);
	mysql_close($conexion);



?>