<?php 
require_once ("../includes/db.php");
$response_json=array("num_rows"=>0,"success"=>false, "info"=>array(), "mensaje"=>'Fatan datos para procesar evento');
if(isset($_POST['profesor']) && !isset($_POST['materia']) && !empty($_POST['profesor'])){
	$filtro=is_numeric(substr($_POST['profesor'],0,1))?"p.cod_prof=".$_POST['profesor']:"p.ced_prof='".$_POST['profesor']."'";
	$sql="SELECT p.cod_prof, p.nom_prof FROM profesor AS p WHERE ".$filtro;
	$consulta= mysql_query($sql, $conexion) or die($sql);
	if(!$consulta){
		echo"Error de Consulta", mysql_errno(), mysql_error();
		exit;
	}
	$response_json['success']=true;
	$response_json['num_rows']=mysql_num_rows($consulta);
	if($response_json['num_rows']==1)
		$response_json['info']=mysql_fetch_assoc($consulta);//$lapso[]=$fila["cod_per"];
	$response_json["mensaje"]=($response_json['num_rows']<>1)?'No se encontraron registros de Profesor':'';
}elseif(isset($_POST['materia'], $_POST['profesor']) && !isset($_POST['oper']) && !empty($_POST['materia']) && !empty($_POST['profesor']) ){
	$filtro=is_numeric(substr($_POST['profesor'],0,1))?"p.cod_prof=".$_POST['profesor']:"p.ced_prof='".$_POST['profesor']."'";
	$sql="SELECT p.cod_prof, p.nom_prof FROM profesor AS p WHERE ".$filtro;
	$consulta= mysql_query($sql, $conexion) or die($sql);
	if(!$consulta){
		echo"Error de Consulta", mysql_errno(), mysql_error();
		exit;
	}
	$response_json['num_rows']=mysql_num_rows($consulta);
	if($response_json['num_rows']==1){
		$docente=mysql_fetch_assoc($consulta);//$lapso[]=$fila["cod_per"];
		$sql="SELECT COUNT(n.cod_estu) AS cnt_alum, n.cod_per FROM notas AS n WHERE n.cod_mat='".$_POST['materia']."' AND n.cod_prof=".$docente['cod_prof']." GROUP BY n.cod_mat, n.cod_per";
		$consulta= mysql_query($sql, $conexion) or die($sql);
		if(!$consulta){
			echo"Error de Consulta", mysql_errno(), mysql_error();
			exit;
		}
		$response_json['success']=true;
		$response_json['num_rows']=mysql_num_rows($consulta);
		if($response_json['num_rows']>0){
			while($periodo=mysql_fetch_assoc($consulta))
				array_push($response_json['info'], array("text"=>$periodo['cod_per'], "value"=>$periodo['cod_per']));//$lapso[]=$fila["cod_per"];
		}
		$response_json["mensaje"]=($response_json['num_rows']==0)?'La asignatura no pertenece a este docente':'';
	}	
}elseif(isset($_POST['oper'], $_POST['profesor'], $_POST['materia']) && !empty($_POST['profesor']) && !empty($_POST['materia'])){
	$filtro=is_numeric(substr($_POST['profesor'],0,1))?"p.cod_prof=".$_POST['profesor']:"p.ced_prof='".$_POST['profesor']."'";
	$sql="SELECT p.cod_prof, p.nom_prof FROM profesor AS p WHERE ".$filtro;
	$consulta= mysql_query($sql, $conexion) or die($sql);
	if(!$consulta){
		echo"Error de Consulta", mysql_errno(), mysql_error();
		exit;
	}
	$response_json['num_rows']=mysql_num_rows($consulta);
	if($response_json['num_rows']==1){
		$docente=mysql_fetch_assoc($consulta);//$lapso[]=$fila["cod_per"];
		$sql="SELECT COUNT(n.cod_estu) AS cnt_alum FROM notas AS n WHERE n.cod_mat='".$_POST['materia']."' AND n.cod_prof=".$docente['cod_prof']." AND ISNULL(n.nota) GROUP BY n.cod_mat, n.cod_per";
		$consulta= mysql_query($sql, $conexion) or die($sql);
		if(!$consulta){
			echo"Error de Consulta", mysql_errno(), mysql_error();
			exit;
		}
		$response_json['success']=true;
		$response_json['num_rows']=mysql_num_rows($consulta);
		$response_json["mensaje"]=($response_json['num_rows']==0)?'El docente no tiene nomina asignada':'';
	}}
echo json_encode($response_json);
mysql_close($conexion);
?>
