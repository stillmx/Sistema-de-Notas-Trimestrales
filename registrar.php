<?php 
header("Content-type: text/html; charset=utf8");
require_once ("includes/db.php");
$response_json=array("num_rows"=>0,"success"=>false, "info"=>array(), "mensaje"=>"Faltaron datos para procesar la infomaci&oacute;n");
if(isset($_POST["evento"])){
	switch($_POST["evento"]){
		case "validar_usuario":
			$sql=sprintf("SELECT u.cod_reg FROM usuario AS u WHERE usuario='%s'", $_POST["usuario"]);
			$consulta=mysql_query($sql, $conexion) or die($sql);
			if(!$consulta){
				echo"Error de Consulta", mysql_errno(), mysql_error();
				exit; 
			}
			$response_json['success']=true;
			$response_json['num_rows']=mysql_num_rows($consulta);
			if($response_json['num_rows']==0){
				$response_json['status']="Disponible";
				
			}
			else
			{
				$response_json['status']="No Disponible";
				$estilo = 'color2';
			}
		break;
		case "nuevo":
			$field=($_POST["tipousuario"]=="Estudiante")?"u.cod_estu":"u.cod_prof";
			$sql=sprintf("SELECT u.cod_reg FROM usuario AS u WHERE %s=%d", $field, $_POST["codigo"]);
			$consulta=mysql_query($sql, $conexion) or die($sql);
			if(!$consulta){
				echo"Error de Consulta", mysql_errno(), mysql_error();
				exit; 
			}
			$response_json['num_rows']=mysql_num_rows($consulta);
			if($response_json['num_rows']!=0){
				$response_json['mensaje']="No Disponible";	
				break;
			}
			if($_POST["tipousuario"]=="Estudiante")
				$sql=sprintf("SELECT e.cod_estu AS codigo FROM estudiante AS e
				 WHERE e.ced_estu='%s'", $_POST["cedula"]);
			else
				$sql=sprintf("SELECT p.cod_prof AS codigo FROM profesor AS p
				 WHERE p.ced_prof='%s' ", $_POST["cedula"]);
			$consulta=mysql_query($sql, $conexion) or die($sql);
			if(!$consulta){
				echo"Error de Consulta", mysql_errno(), mysql_error();
				exit; 
			}
			$response_json['num_rows']=mysql_num_rows($consulta);
			if($response_json['num_rows']==1){
				$row_usuario = mysql_fetch_assoc($consulta);
				if($row_usuario["codigo"]!=$_POST["codigo"]){
					$response_json['mensaje']="Los datos de cedula no coinciden con el codigo";
					break;
				}
				$a_tipo_user=array("Estudiante"=>2, "Profesor"=>1);
				$mx='$stelmas$%/=zeck001mx$/';
				$clave = $mx.sha1(md5($_POST['contraseña']));
				$id_estudiante=($_POST["tipousuario"]=="Estudiante")?$row_usuario["codigo"]:null;
				$id_profesor=($_POST["tipousuario"]!="Estudiante")?$row_usuario["codigo"]:null;
				$consulta=mysql_query(sprintf("INSERT INTO usuario (usuario, tipo_usuario, clave, cod_estu, cod_prof, pregunta, respuesta) 
					VALUES (upper('%s'), '%s','%s',%d,%d, '%s', '%s')", $_POST["usuario"], $a_tipo_user[$_POST["tipousuario"]],
					$clave,$id_estudiante, $id_profesor, $_POST["pregunta"], $_POST["respuesta"]));
				
				if(!$consulta){
					echo"Error de Consulta", mysql_errno(), mysql_error();
					exit; 
				}
				$response_json['success']=true;
				$sql_estudiante=sprintf("UPDATE estudiante SET tel_estu='%s', ce_estu='%s' WHERE cod_estu=%d", $_POST["telefono"], $_POST["email"], $_POST["codigo"]);
				$sql_docente=sprintf("UPDATE profesor SET tel_prof='%s', ce_prof='%s'  WHERE cod_prof=%d", $_POST["telefono"], $_POST["email"], $_POST["codigo"]);
				$sql=($_POST["tipousuario"]=="Estudiante")?$sql_estudiante:$sql_docente;
				$consulta=mysql_query($sql, $conexion) or die($sql);
				if(!$consulta){
					echo"Error de Consulta", mysql_errno(), mysql_error();
					exit; 
				}
				$response_json['affected_rows']=mysql_affected_rows();
				$response_json['mensaje']=($response_json['affected_rows']==1)?"Los datos fueron guardados satisfactoriamente":"No se registaron los datos";
			}
		break;
	}
}elseif(isset($_POST['cedula']) && !empty($_POST['cedula'])){
	$consulta= mysql_query("SELECT e.cod_estu, e.nom_estu, u.usuario FROM estudiante AS e 
		LEFT OUTER JOIN usuario AS u ON e.ced_estu='" .$_POST['cedula'].
		"'WHERE e.cod_estu = u.cod_estu");
	
		if(mysql_num_rows($consulta)==0)
		$consulta= mysql_query(sprintf("SELECT e.cod_estu, e.nom_estu, u.usuario FROM estudiante AS e LEFT OUTER JOIN usuario AS u ON e.cod_estu = u.cod_estu WHERE e.ced_estu='%s'", $_POST["cedula"]));


	
	if(!$consulta){
		echo"Error de Consulta", mysql_errno(), mysql_error();
		exit; 
	}
	$response_json['success']=true;
	$response_json['num_rows']=mysql_num_rows($consulta);
	$response_json['mensaje']="";
	if($response_json['num_rows']==1){
		$fila = mysql_fetch_assoc($consulta);
		$response_json['info']['nombre']=$fila['nom_estu'];
		if(isset($fila["usuario"])){
			$response_json['mensaje']="Usuario ya se encuentra registrado";
		}
		$response_json['info']['usuario']=$fila['usuario'];
		$response_json['info']['codigo']=$fila['cod_estu'];
		$response_json['info']['tipousuario']='Estudiante';
	}else{
		$sql=sprintf("SELECT p.cod_prof, p.nom_prof, u.usuario FROM profesor AS p LEFT OUTER JOIN usuario AS u ON p.cod_prof = u.cod_prof WHERE p.ced_prof='%s' ", $_POST["cedula"]);
		$consulta=mysql_query($sql, $conexion) or die($sql);
		if(!$consulta){
				echo"Error de Consulta", mysql_errno(), mysql_error();
				exit; 
		}
		$response_json['num_rows']=mysql_num_rows($consulta);
		if($response_json['num_rows']==1){
			$fila = mysql_fetch_assoc($consulta);
			$response_json['info']['nombre']=$fila['nom_prof'];
			$response_json['info']['codigo']=$fila['cod_prof'];
			$response_json['info']['usuario']=$fila['usuario'];
			$response_json['info']['tipousuario']='Profesor';
		}
	}
}
echo json_encode($response_json);
mysql_close($conexion);
?>