<script src="./js/jquery-1.11.2.min.js"></script>
<?php
if(isset($_POST['cod_per'], $_POST['cod_mat']) && !empty($_POST['cod_per']) && !empty($_POST['cod_mat'])){
	require_once ("./includes/db.php");
	$sql="SELECT n.cod_prof, p.ced_prof, p.nom_prof, n.cod_estu, e.nom_estu, n.nota, m.nom_mat, 
	n.cod_per, n.porc_mat FROM notas AS n LEFT OUTER JOIN estudiante AS e ON e.cod_estu=n.cod_estu 
	LEFT OUTER JOIN profesor AS p ON p.cod_prof=n.cod_prof LEFT OUTER JOIN materia AS m 
	ON m.cod_comp=n.cod_comp WHERE n.cod_mat='".$_POST['cod_mat']."' AND n.cod_per='".$_POST['cod_per'].
	"' AND n.cod_prof=".$_SESSION['id_usuario']." ORDER BY e.nom_estu";
	$consulta= mysql_query($sql, $conexion) or die($sql);
	if(!$consulta){
		echo"Error de Consulta", mysql_errno(), mysql_error();
		exit;
	}	
	$encabezado=0;
	$contador=1;
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
			echo"<div class='profesor'><h2>Datos del Profesor:</h2></div>";
			echo "<div class='datos'><b>Cédula: </b>".$fila['ced_prof'],"<b>Profesor:</b>".$fila['nom_prof'].
			"<b>Materia:</b>".$fila['nom_mat']."<b>Periodo:</b>",$fila['cod_per'].
			"<b>Porcentaje Materia:</b>".$fila['porc_mat']."</div><br><br>";
			
			echo"<div class='estudiante'><h2>Notas de los Estudiantes:</h2></div>";
			echo"<div class='datos'><div class='codigo'><b>Código:</div><div class='apellido'>
			 Apellidos y Nombres:</div><div class='nota'>Nota:</b></div></div>";
			$encabezado=1;
		}
		echo "<div class='datos'><div class='$estilo'><div class='codigo'>".$fila['cod_estu'].
		"</div><div class='apellido'>".$fila['nom_estu']."</div><div class='nota'>",
		$fila['nota']."</div></div></div>";

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
	echo "<div class='export_pdf'><form id='export_pdf' name='export_pdf'
		 target='file_pdf' method='post' action='./paginas/reporte_pdf.php'>
		 <input type='submit' value='exportar' style='display:none;' >
		 <input class='boton' type='button' id='btn_pdf' name='btn_pdf'
		 value='Exportar PDF'/><input type='hidden' name='str_html' id='str_html' value='' >
		 </form></div>";
	mysql_close($conexion);
}
?>

<iframe name="file_pdf" id="file_pdf" style="width:0px; height:0px; display:none;" ></iframe>
<script type="text/javascript" language="javascript">
$("#btn_pdf").bind("click",function(e){
	$("#str_html").val($("div#contenido").html());
	$(":submit", $('#export_pdf')).trigger('click');
});
</script>