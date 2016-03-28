<?php 
if(isset($_POST['estudiante'], $_POST['periodo']) && !empty($_POST['estudiante'])){
	require_once ("includes/db.php");
	$filtro=is_numeric(substr($_POST['estudiante'],0,1))?"e.cod_estu=".$_POST['estudiante']:"e.ced_estu='".$_POST['estudiante']."'";
	$sql="SELECT e.nom_estu, e.ced_estu, p.nom_prof, n.*, m.nom_mat, m.uc_mat FROM estudiante AS e LEFT OUTER JOIN notas AS n ON n.cod_estu=e.cod_estu LEFT OUTER JOIN materia AS m ON m.cod_comp=n.cod_comp LEFT OUTER JOIN profesor AS p ON p.cod_prof=n.cod_prof WHERE ".$filtro;
	if($_POST['periodo']==2){
		$sql.=" AND n.cod_per BETWEEN '".$_POST['lapsodesde']."' AND '".$_POST['lapsohasta']."'";
		//Consulta completa
	}
	$consulta= mysql_query($sql, $conexion) or die($sql);
	if(!$consulta){
		echo"Error de Consulta", mysql_errno(), mysql_error();
		exit;
	}
	
	while($fila = mysql_fetch_assoc($consulta)){
		echo "<PRE>";
		print_r($fila);
		//echo $fila['nom_estu'];
		echo "</PRE>"; 
		//echo $fila['nota'].'<br>';
	}
	mysql_close($conexion);
}
?>
