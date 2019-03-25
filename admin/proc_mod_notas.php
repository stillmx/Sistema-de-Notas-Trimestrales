<?php
require_once ("./includes/db.php");
if(isset($_POST['estudiante']) && (!empty($_POST['estudiante']))){

$sql= mysql_query("SELECT * FROM notas WHERE !ISNULL(nota) 
	AND cod_estu='".$_POST["estudiante"]."' AND cod_mat='".$_POST["cod_mat"]."' 
	AND cod_per='".$_POST["periodo"]."'");
if(mysql_num_rows($sql)==1){
	$sql= mysql_query("UPDATE notas SET nota='".$_POST['nota']."' WHERE !ISNULL(nota) AND cod_estu=".$_POST["estudiante"]." 
	AND cod_mat='".$_POST["cod_mat"]."' AND cod_per='".$_POST["periodo"]."'"); 
	
	$sql= mysql_query("SELECT n.nota, e.nom_estu, m.nom_mat FROM estudiante AS e 
		LEFT OUTER JOIN notas AS n ON e.cod_estu=n.cod_estu LEFT OUTER JOIN materia AS m
		ON n.cod_comp=m.cod_comp WHERE n.cod_estu=".$_POST['estudiante']." 
		AND n.cod_mat='".$_POST['cod_mat']."' AND n.cod_per='".$_POST['periodo']."'");
	while ($fila=mysql_fetch_assoc($sql)) {
		echo "<script type=\"text/javascript\">alert(\"LA NOTA DEL ESTUDIANTE ".$fila['nom_estu']." EN LA MATERIA: ".$fila['nom_mat']." SE ACTUALIZO A ".$fila['nota']." PUNTOS\");location.href='include.php?admin=mod_notas';</script>";
    
	}
	       
}else
	
	echo "<script type=\"text/javascript\">alert(\"NO EXISTE REGISTRO DE NOTA, DEL ESTUDIANTE ".$_POST['nombre']."\");history.go(-1);</script>";         

}
$consulta= ($conexion) or die($conexion);
		if(!$consulta){
			echo"Error de Consulta", mysql_errno(), mysql_error();
			exit;
		}
mysql_close($conexion);
?>
