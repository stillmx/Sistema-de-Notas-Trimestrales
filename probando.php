<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script src="js/jquery-1.11.2.min.js"></script>
</head>
<body>
	<form action="#" method="post">
		<input id="estudiante" type="text" name="estudiante" value="2735">
		<input type="text" name="periodo" value="2016-1">
		<input type="text" name="materia" value="6052">
		<input id="boton" type="submit" name="boton" value="Boton	">
	</form>

	<script>
	$(document).ready(function() {
		$('input').css({
			'color':'green',
			'background':'yelow',
			'padding':'5px'
		});
		$('#estudiante').val(3527);
	});
		


	</script>
</body>
</html>


<?php
//$periodo= $_POST["periodo"];

require_once ("includes/db.php");
	if(isset($_POST['estudiante'], $_POST['periodo']) 
		&& (empty($_POST['materia']) && !empty($_POST['estudiante']) && !empty($_POST['periodo']))) {

		$filtro="e.cod_estu='".$_POST['estudiante']."'";
		$sql= mysql_query("SELECT e.cod_estu, n.cod_per, e.nom_estu  
		FROM estudiante AS e LEFT OUTER JOIN notas AS n ON n.cod_estu=e.cod_estu 
		WHERE ".$filtro." GROUP BY n.cod_per ");
		
		
		while($fila = mysql_fetch_assoc($sql)){
			echo $fila["nom_estu"];
			echo $fila["cod_per"];
		}
	
	}
    
	elseif(isset($_POST['estudiante'], $_POST['periodo'], $_POST['materia']) 
		&& (!empty($_POST['estudiante']) && !empty($_POST['periodo']) 
		&& !empty($_POST['materia']))) {


		$filtro="e.cod_estu='".$_POST['estudiante']."'";
		$sql= mysql_query("SELECT e.cod_estu, n.cod_per, e.nom_estu, p.des_per, n.cod_comp, m.nom_mat, n.cod_mat 
			FROM estudiante AS e LEFT OUTER JOIN notas AS n ON n.cod_estu=e.cod_estu 
			LEFT OUTER JOIN materia AS m ON n.cod_comp=m.cod_comp
			LEFT OUTER JOIN periodo AS p ON n.cod_per=p.cod_per 
			WHERE n.cod_per='".$_POST["periodo"]."' AND n.cod_comp='".$_POST["materia"]."' AND ".$filtro." GROUP BY n.cod_mat");
		while($fila = mysql_fetch_assoc($sql)){
			
			echo $fila["nom_mat"]." ";
			echo $fila["cod_mat"];
		}
	}
	else
		echo"Esta vacio";
?>