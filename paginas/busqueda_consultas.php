<?php 
session_start();
require_once ("../includes/db.php");
$response_json=array("num_rows"=>0,"success"=>false, "info"=>array(), "mensaje"=>'Fatan datos para procesar evento');
$a_eventos=array('materias', 'docentes', 'secciones','periodos', 'estudiante', 'materia', 'nota_estudiante', 'secciones_docente');
if(isset($_POST['oper']) && !empty($_POST['oper']) && in_array($_POST['oper'], $a_eventos)){
	switch($_POST['oper']){
		case 'nota_estudiante':
			if(!isset($_POST['cod_mat'], $_POST['cod_estu'], $_POST['periodo']) || empty($_POST['periodo']) || empty($_POST['cod_mat']) || empty($_POST['cod_estu']))
				break;
			$sql="SELECT n.porc_mat AS porcentaje, p.des_per AS descripcion, n.nota FROM notas AS n LEFT OUTER JOIN periodo AS p ON p.cod_per=n.cod_per WHERE !ISNULL(n.nota) AND n.cod_mat='".$_POST['cod_mat']."' AND n.cod_estu=".$_POST['cod_estu']." AND n.cod_per='".$_POST['periodo']."'";
			$consulta= mysql_query($sql, $conexion) or die($sql);
			if(!$consulta){
				echo"Error de Consulta", mysql_errno(), mysql_error();
				exit;
			}
			$response_json['success']=true;
			$response_json['num_rows']=mysql_num_rows($consulta);
			$response_json['mensaje']=($response_json['num_rows']==0)?'No tiene nota para este periodo':'Hay mas de un registro con dicho codigo';
			if($response_json['num_rows']!=1)
				break;
			$response_json['info']=mysql_fetch_assoc($consulta);		
		break;
		case 'materia':
			if(!isset($_POST['cod_mat'], $_POST['cod_estu']) || empty($_POST['cod_mat']) || empty($_POST['cod_estu']))
				break;
			$sql="SELECT n.cod_mat, n.cod_comp, m.nom_mat FROM notas AS n LEFT OUTER JOIN materia AS m ON m.cod_comp=n.cod_comp WHERE n.cod_mat='".$_POST['cod_mat']."' AND n.cod_estu=".$_POST['cod_estu']." GROUP BY n.cod_mat";
			$consulta= mysql_query($sql, $conexion) or die($sql);
			if(!$consulta){
				echo"Error de Consulta", mysql_errno(), mysql_error();
				exit;
			}
			$response_json['success']=true;
			$response_json['num_rows']=mysql_num_rows($consulta);
			$response_json['mensaje']=($response_json['num_rows']==0)?'Estudiante no Existe':'Hay mas de un registro con dicho codigo';
			if($response_json['num_rows']!=1)
				break;
			$response_json['info']=mysql_fetch_assoc($consulta);
		break;
		case 'estudiante':
			if(!isset($_POST['cod_estu']) || empty($_POST['cod_estu']))
				break;
			
			$sql="SELECT e.nom_estu AS nombre FROM estudiante AS e WHERE e.cod_estu=".$_POST['cod_estu'];
			$consulta= mysql_query($sql, $conexion) or die($sql);
			if(!$consulta){
				echo"Error de Consulta", mysql_errno(), mysql_error();
				exit;
			}
			$response_json['success']=true;
			$response_json['num_rows']=mysql_num_rows($consulta);
			$response_json['mensaje']=($response_json['num_rows']==0)?'Estudiante no Existe':'Hay mas de un registro con dicho codigo';
			if($response_json['num_rows']!=1)
				break;
			$response_json['info']=mysql_fetch_assoc($consulta);
		break;
		case 'periodos':
			if(!isset($_POST['cod_mat'], $_POST['cod_prof']) || empty($_POST['cod_mat']) || empty($_POST['cod_prof']))
				break;
			$consulta= mysql_query("SELECT n.cod_per, p.des_per FROM notas AS n LEFT OUTER JOIN periodo AS p ON p.cod_per=n.cod_per WHERE n.cod_mat='".$_POST['cod_mat']."' AND n.cod_prof=".$_SESSION["id_usuario"]." GROUP BY n.cod_per");
			
			if(!$consulta){
				echo"Error de Consulta", mysql_errno(), mysql_error();
				exit;
			}
			$response_json['success']=true;
			$response_json['num_rows']=mysql_num_rows($consulta);
			if($response_json['num_rows']==0)
				break;
			while($mat=mysql_fetch_assoc($consulta))
				array_push($response_json['info'], array("value"=>$mat['cod_per'], "text"=>sprintf('%s - %s', $mat['cod_per'], $mat['des_per'])));			
		break;
		case 'secciones':
			if(!isset($_POST['cod_comp']) || empty($_POST['cod_comp']))
				break;
			$sql="SELECT n.cod_mat FROM notas AS n LEFT OUTER JOIN materia AS m ON m.cod_comp=n.cod_comp WHERE n.cod_comp=".$_POST['cod_comp']." AND n.cod_prof=".$_SESSION["id_usuario"]." GROUP BY n.cod_mat";
			$consulta= mysql_query($sql, $conexion) or die($sql);
			if(!$consulta){
				echo"Error de Consulta", mysql_errno(), mysql_error();
				exit;
			}
			$response_json['success']=true;
			$response_json['num_rows']=mysql_num_rows($consulta);
			if($response_json['num_rows']==0)
				break;
			while($mat=mysql_fetch_assoc($consulta))
				array_push($response_json['info'], array("value"=>$mat['cod_mat'], "text"=>$mat['cod_mat']));			
		break;
		
		case 'docentes':
			if(!isset($_POST['cod_comp']) || empty($_POST['cod_comp']))
				break;
			$sql="SELECT n.cod_prof, p.nom_prof  FROM notas AS n LEFT OUTER JOIN profesor AS p ON p.cod_prof=n.cod_prof WHERE n.cod_comp=".$_POST['cod_comp']." GROUP BY n.cod_prof";
			$consulta= mysql_query($sql, $conexion) or die($sql);
			if(!$consulta){
				echo"Error de Consulta", mysql_errno(), mysql_error();
				exit;
			}
			$response_json['success']=true;
			$response_json['num_rows']=mysql_num_rows($consulta);
			if($response_json['num_rows']==0)
				break;
			while($mat=mysql_fetch_assoc($consulta))
				array_push($response_json['info'], array("value"=>$mat['cod_prof'], "text"=>$mat['nom_prof']));			
		break;
		case 'secciones_docente':
			$response_json["debug"]=$_POST;
			if(!isset($_POST['cod_comp']) || empty($_POST['cod_comp']))
				break;
			$sql="SELECT n.cod_comp, n.cod_mat, m.nom_mat, m.uc_mat FROM notas AS n LEFT OUTER JOIN materia AS m ON m.cod_comp=n.cod_comp WHERE n.cod_prof=".$_SESSION['id_usuario']." AND n.cod_comp='".$_POST['cod_comp']."' GROUP BY n.cod_mat";
			$consulta= mysql_query($sql, $conexion) or die($sql);
			if(!$consulta){
				echo"Error de Consulta", mysql_errno(), mysql_error();
				exit;
			}
			$response_json['debug']=$sql;
			$response_json['success']=true;
			$response_json['num_rows']=mysql_num_rows($consulta);
			if($response_json['num_rows']==0)
				break;
			while($mat=mysql_fetch_assoc($consulta))
				array_push($response_json['info'], array("value"=>$mat['cod_mat'], "text"=>sprintf("%s", $mat['cod_mat'])));
		break;
		case 'materias':
			$sql="SELECT m.cod_comp, m.nom_mat, m.uc_mat FROM materia AS m LEFT OUTER JOIN notas AS n ON m.cod_comp=n.cod_comp WHERE n.cod_prof=".$_SESSION['id_usuario']."  ORDER BY nom_mat ASC";
			$sql="SELECT n.cod_comp, n.cod_mat, m.nom_mat, m.uc_mat FROM notas AS n LEFT OUTER JOIN materia AS m ON m.cod_comp=n.cod_comp WHERE n.cod_prof=".$_SESSION['id_usuario']." GROUP BY n.cod_comp";
			$consulta= mysql_query($sql, $conexion) or die($sql);
			if(!$consulta){
				echo"Error de Consulta", mysql_errno(), mysql_error();
				exit;
			}
			$response_json['debug']=$sql;
			$response_json['success']=true;
			$response_json['num_rows']=mysql_num_rows($consulta);
			if($response_json['num_rows']==0)
				break;
			while($mat=mysql_fetch_assoc($consulta))
				array_push($response_json['info'], array("value"=>$mat['cod_comp'], "text"=>sprintf("%s (UC: %d)", $mat['nom_mat'], $mat['uc_mat'])));
		break;
	}
}
echo json_encode($response_json);
die();
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
	$consulta=mysql_query("SELECT p.cod_prof, p.nom_prof FROM profesor AS p WHERE ".$filtro);
	
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
