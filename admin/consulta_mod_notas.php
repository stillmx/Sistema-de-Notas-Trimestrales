<?php 

	require_once ("../includes/db.php");
	$response_json=array("num_rows"=>0,"success"=>false,
	 "info"=>array("estudiante"=>NULL, "descripcion"=>NULL, "materia"=>array(), 
	 	"codigo_mat"=>NULL, "porcentaje"=>NULL, "nota"=>NULL, "lapsos"=>array()));
	if(isset($_POST['estudiante']) && !empty($_POST['estudiante']) 
		&& empty($_POST['periodo'])){

		$filtro="e.cod_estu='".$_POST['estudiante']."'";
		$sql= mysql_query("SELECT e.cod_estu, n.cod_per, e.nom_estu  FROM estudiante AS e LEFT OUTER JOIN notas AS n ON n.cod_estu=e.cod_estu WHERE ".$filtro." GROUP BY n.cod_per ");
		
		$response_json['success']=true;
		$response_json['num_rows']=mysql_num_rows($sql);
		while($fila = mysql_fetch_assoc($sql)){
			if(!isset($response_json['info']['estudiante']))
				$response_json['info']['estudiante']=$fila['nom_estu'];
			array_push($response_json['info']['lapsos'], $fila["cod_per"]);
		}
	
	}
	elseif(isset($_POST['estudiante'], $_POST['periodo']) && (empty($_POST['materia']) 
		&& !empty($_POST['estudiante']) && !empty($_POST['periodo'])) ) {


		$filtro="e.cod_estu='".$_POST['estudiante']."'";
		$sql= mysql_query("SELECT e.cod_estu, n.cod_per, e.nom_estu, p.des_per, n.cod_comp, m.nom_mat, m.uc_mat FROM estudiante AS e LEFT OUTER JOIN notas AS n 
			ON n.cod_estu=e.cod_estu 
			LEFT OUTER JOIN materia AS m ON n.cod_comp=m.cod_comp
			LEFT OUTER JOIN periodo AS p ON n.cod_per=p.cod_per 
			WHERE n.cod_per='".$_POST["periodo"]."' AND ".$filtro." GROUP BY n.cod_mat");
			$response_json['success']=true;
			$response_json['num_rows']=mysql_num_rows($sql);
			while($fila = mysql_fetch_assoc($sql)) {
				if(!isset($response_json['info']['descripcion']))
			$response_json['info']['descripcion']=$fila['des_per'];
			array_push($response_json['info']['materia'],array("value"=>$fila['cod_comp'], "text"=>$fila['nom_mat']));
			}
	}
	elseif(isset($_POST['estudiante'], $_POST['periodo'], $_POST['materia']) 
		&& (!empty($_POST['estudiante']) && !empty($_POST['periodo']) 
		&& !empty($_POST['materia']))) {


		$filtro="e.cod_estu='".$_POST['estudiante']."'";
		$sql= mysql_query("SELECT e.cod_estu, n.cod_per, e.nom_estu, p.des_per, n.cod_comp, m.nom_mat, n.cod_mat, n.porc_mat, n.nota FROM estudiante AS e LEFT OUTER JOIN notas AS n ON n.cod_estu=e.cod_estu
			LEFT OUTER JOIN materia AS m ON n.cod_comp=m.cod_comp
			LEFT OUTER JOIN periodo AS p ON n.cod_per=p.cod_per 
			WHERE n.cod_per='".$_POST["periodo"]."' AND n.cod_comp='".$_POST["materia"]."' AND ".$filtro." GROUP BY n.cod_mat");
			
			$response_json['success']=true;
			$response_json['num_rows']=mysql_num_rows($sql);
			while($fila = mysql_fetch_assoc($sql)) {
				if(!isset($response_json['info']['codigo_mat']))
			$response_json['info']['codigo_mat']=$fila['cod_mat'];
			$response_json['info']['porcentaje']=$fila['porc_mat'];
			$response_json['info']['nota']=$fila['nota'];
			
			}
	}else{
		echo "<script type=\"text/javascript\">alert(\"DEBE COMPLETAR CAMPOS REQUERIDOS ".$nom_estu."\");history.go(-1);</script>";
		}
		
	$consulta= ($conexion) or die($conexion);
		if(!$consulta){
			echo"Error de Consulta", mysql_errno(), mysql_error();
			exit;
		}
	
	echo json_encode($response_json);
	mysql_close($conexion);
	
?>

