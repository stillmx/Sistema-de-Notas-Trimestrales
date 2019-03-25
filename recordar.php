<?php
header("Content-type: text/html; charset=utf8");
include_once 'config.php';

	$response_json=array("num_rows"=>0,"success"=>false,
	 "info"=>array());

	if(isset($_POST['cedula']) && !empty($_POST['cedula'])){
	$consulta= mysql_query("SELECT e.cod_estu, e.nom_estu, u.usuario, u.n_intentos,
			u.r_intentos  FROM estudiante
		AS e LEFT OUTER JOIN usuario AS u ON e.ced_estu='" .$_POST['cedula'].
		"'WHERE e.cod_estu = u.cod_estu");

		if(mysql_num_rows($consulta)==0)
		$consulta= mysql_query(sprintf("SELECT e.cod_estu, e.nom_estu, u.usuario,
			u.n_intentos, u.r_intentos
			FROM estudiante AS e LEFT OUTER JOIN usuario AS u ON e.cod_estu = u.cod_estu
			WHERE e.ced_estu='%s'", $_POST["cedula"]));

	if(!$consulta){
		echo"Error de Consulta", mysql_errno(), mysql_error();
		exit;
	}

	$response_json['success']=true;
	$response_json['num_rows']=mysql_num_rows($consulta);
	$response_json['mensaje']="";
	if($response_json['num_rows']==1){
		$fila = mysql_fetch_assoc($consulta);
			if(!isset($fila["usuario"])){
			$response_json['mensaje']="Usuario no se encuentra registrado";
		}


		if(($fila['n_intentos']==3) or ($fila['r_intentos']==3)){
			$estado='USUARIO BLOQUEDADO';
		}else{
			$estado='USUARIO ACTIVO';
		}
		$response_json['info']['n_intentos']=$fila['n_intentos'];
		$response_json['info']['r_intentos']=$fila['r_intentos'];
		$response_json['info']['nombre']=$fila['nom_estu'];
		$response_json['info']['usuario']=$fila['usuario'];
		$response_json['info']['codigo']=$fila['cod_estu'];
		$response_json['info']['tipousuario']='Estudiante';
		$response_json['info']['estado_contraseña']=$estado;
		//$response_json['info']['estado_preg_seguridad']=$estado2;

		}else{
		$sql=sprintf("SELECT p.cod_prof, p.nom_prof, u.usuario,u.n_intentos,
			u.r_intentos FROM profesor AS p
			LEFT OUTER JOIN usuario AS u ON p.cod_prof = u.cod_prof
			WHERE p.ced_prof='%s' ", $_POST["cedula"]);
		$consulta=mysql_query($sql, $conexion) or die($sql);
		if(!$consulta){
				echo"Error de Consulta", mysql_errno(), mysql_error();
				exit;
		}
		$response_json['num_rows']=mysql_num_rows($consulta);
		if($response_json['num_rows']==1){
			$fila = mysql_fetch_assoc($consulta);
			if(!isset($fila["usuario"])){
			$response_json['mensaje']="Usuario no se encuentra registrado";
		}
		if(($fila['n_intentos']==3) or ($fila['r_intentos']==3)){
			$estado='USUARIO BLOQUEDADO';
		}else{
			$estado='USUARIO ACTIVO';
		}
			$response_json['info']['n_intentos']=$fila['n_intentos'];
			$response_json['info']['r_intentos']=$fila['r_intentos'];
			$response_json['info']['nombre']=$fila['nom_prof'];
			$response_json['info']['codigo']=$fila['cod_prof'];
			$response_json['info']['usuario']=$fila['usuario'];
			$response_json['info']['tipousuario']='Profesor';
			$response_json['info']['estado_contraseña']=$estado;
			//$response_json['info']['estado_preg_seguridad']=$estado2;

		}
	}


}
echo json_encode($response_json);
mysql_close($conexion);
?>
