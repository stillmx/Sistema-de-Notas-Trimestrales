<script src="./js/jquery-1.11.2.min.js"></script>
<?php 


	require_once ("./includes/db.php");


		if(isset($_POST["codigo_2"])){
		$sql="SELECT e.nom_estu, e.ced_estu, p.nom_prof, n.*, m.nom_mat, m.uc_mat 
		FROM estudiante AS e LEFT OUTER JOIN notas AS n ON n.cod_estu=e.cod_estu 
		LEFT OUTER JOIN materia AS m ON m.cod_comp=n.cod_comp LEFT OUTER JOIN profesor 
		AS p ON p.cod_prof=n.cod_prof WHERE e.cod_estu=".$_POST["codigo_2"];
	}
	else{
		$sql="SELECT e.nom_estu, e.ced_estu, p.nom_prof, n.*, m.nom_mat, m.uc_mat 
		FROM estudiante AS e LEFT OUTER JOIN notas AS n ON n.cod_estu=e.cod_estu 
		LEFT OUTER JOIN materia AS m ON m.cod_comp=n.cod_comp LEFT OUTER JOIN profesor 
		AS p ON p.cod_prof=n.cod_prof WHERE e.cod_estu=".$_SESSION["id_usuario"];
	}
	if($_POST['periodo']==2){
		$sql.=" AND n.cod_per BETWEEN '".$_POST['lapsodesde']."' AND '".$_POST['lapsohasta']."'";
		//Consulta completa
	}
	$consulta= mysql_query($sql, $conexion) or die($sql);
	if(!$consulta){
		echo"Error de Consulta", mysql_errno(), mysql_error();
		exit;
	}
	$encabezado=0;
	$contador=0;
	$aprobados=0;
	$reprobados=0;
	$sinregistro=0;
	
	
	while($fila = mysql_fetch_assoc($consulta)){
		$contador2 = $contador / 2;
		if(is_int($contador2)) { 
			$estilo = 'bg2'; 
		} else {
			$estilo = 'bg1'; 
		}
		if($encabezado==0){
			echo"<div class='estudiante'><h2>Datos del Estudiante:</h2></div>";
			echo"<div class='datos'><b>Código:</b>".$fila['cod_estu']."<b>Cédula:</b>
			".$fila['ced_estu']."<b>Nombre:</b>".$fila['nom_estu']."</div><br><br>";
			echo"<div class='datos'><div class='codigo'><b>Código</div>
			<div class='materia'>Materia</div><div class='uc'>U.C.</div>
			<div class='periodo'>Periodo</div><div class='nota'>Nota</div>
			<div class='porcentaje'>Porcentaje</b></div></div>";

			$encabezado=1;
		}
		echo "<div class='datos'><div class='$estilo'><div class='codigo'>
		".$fila['cod_mat']."</div><div class='materia'>".$fila['nom_mat'].
		"</div><div class='uc'>".$fila['uc_mat']."</div><div class='periodo'>
		".$fila['cod_per']."</div><div class='nota'>".$fila['nota']."</div>
		<div class='porcentaje'>".$fila['porc_mat']." %"."</div></div></div>";
		$contador++;
		if($fila['nota']>=12){
			$aprobados++;
			}elseif($fila['nota']==NULL){
				$sinregistro++;
		}else{
			$reprobados++;
		}
	}
	/*echo "<div class='datos'><br><b>Aprobadas: </b>".$aprobados."<br><br>";
	echo "<b>Reprobadas: </b>".$reprobados."<br><br>";
	echo "<b>Sin Registro: </b>".$sinregistro."<br><br></div>";*/
	echo "<br/><br/><br/>";
	echo "<center> Elier Nieto <br> Jefe de Ingeniería en Informática de la UPTAG</center>";

	echo "<div class='export_pdf'><form id='export_pdf' name='export_pdf'
		 target='file_pdf' method='post' action='./paginas/reporte_pdf.php'>
		 <input type='submit' value='exportar' style='display:none;' >
		 <input class='boton' type='button' id='btn_pdf' name='btn_pdf'
		 value='Exportar PDF'/><input type='hidden' name='str_html' id='str_html' value='' >
		 </form></div>";	
	mysql_close($conexion);
?>
<iframe name="file_pdf" id="file_pdf" style="width:0px; height:0px; display:none;" ></iframe>
<script type="text/javascript" language="javascript">
$("#btn_pdf").bind("click",function(e){
	$("#str_html").val($("div#contenido").html());
	$(":submit", $('#export_pdf')).trigger('click');
});
</script>