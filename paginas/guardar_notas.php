<?php
if(isset($_POST['cod_per'], $_POST['cod_mat'], $_POST['cod_prof'], $_POST['nota'], $_POST['porcentaje']) && is_array($_POST['nota']) && !empty($_POST['porcentaje'])){
	require_once ("./includes/db.php");
	$i=0;
	
	foreach($_POST['nota'] as $codigo => $nota){
		$sql="UPDATE notas SET nota='".$nota."', porc_mat=".$_POST['porcentaje']." 
		WHERE cod_estu=".$codigo." AND cod_prof=".$_POST['cod_prof']." 
		AND cod_mat='".$_POST['cod_mat']."' AND cod_per='".$_POST['cod_per']."' AND ISNULL(nota)";
		$consulta= mysql_query($sql, $conexion) or die($sql);
		if(!$consulta){
			echo"Error de Consulta", mysql_errno(), mysql_error();
			exit;
		}
		if(mysql_affected_rows()>0)
				$i++;
	}
	if($i==count($_POST['nota'])){
		echo "<script type=\"text/javascript\">alert(\"Se registraron todas las notas\");</script>";
		echo" <SCRIPT LANGUAGE='javascript'>location.href = 'include.php';</SCRIPT>";
	}
		//echo "Se registraron todas las notas satisfactoriamente";
	else{
		echo "Se registraron ", $i, " de un total de ", count($_POST['nota']), " estudiantes";
	}
	}

?>
