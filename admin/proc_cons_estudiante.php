<?php 
if(isset($_POST['estudiante']) && !empty($_POST['estudiante'])){
	require_once ("../includes/db.php");
	$response_json=array("num_rows"=>0,"success"=>false,
	 "info"=>array("estudiante"=>NULL, "lapsos"=>array()));
	$filtro=is_numeric(substr($_POST['estudiante'],0,1))?"e.cod_estu=".$_POST['estudiante']:"e.ced_estu='".$_POST['estudiante']."'";
	$sql="SELECT e.cod_estu, n.cod_per, e.nom_estu  FROM estudiante AS e LEFT OUTER JOIN notas AS n ON n.cod_estu=e.cod_estu WHERE ".$filtro." GROUP BY n.cod_per ";
	$consulta= mysql_query($sql, $conexion) or die($sql);
	if(!$consulta){
		echo"Error de Consulta", mysql_errno(), mysql_error();
		exit;
	}
	$response_json['success']=true;
	$response_json['num_rows']=mysql_num_rows($consulta);
	while($fila = mysql_fetch_assoc($consulta)){
		if(!isset($response_json['info']['estudiante']))
			$response_json['info']['estudiante']=$fila['nom_estu'];
		array_push($response_json['info']['lapsos'], $fila["cod_per"]);//$lapso[]=$fila["cod_per"];
	}
	echo json_encode($response_json);
	mysql_close($conexion);
}
?>
