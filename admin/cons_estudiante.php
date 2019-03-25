<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"/>
	<link rel="stylesheet" href="./css/menu.css" type="text/css" />
	<script src="./js/jquery-1.11.2.min.js"></script>
	
	<title>Control de Notas Trimestrales PNFI</title>
</head>	
<body>
	<center>
		<form action="include.php?admin=reporte_estudiante" method="POST" name="Registro" id="cons_estudiante">
			<h4>Consultar Estudiante</h4>
				<div class="estudiante">
					<input class="campos" id="estudiante" name="estudiante" type="text" maxlength="9" size="15" placeholder="C.I. o Cod. Estudiante">
					<input class="campos" id="nombre" name="nombre" type="text" value="" size="40" placeholder="Apellido y Nombre" readonly="readonly">
					<br><br>
					<label for="periodo" class="t">Todos los Periodos</label> 
					<input type="radio" name="periodo" id="periodo" value="1" checked="checked"/>
					<label for="periodo">Por Periodos</label>
					<input type="radio" name="periodo" id="periodo" value="2"/><br>
					<select class="campos" id="lapsodesde" name="lapsodesde">
						<option value="">Desde</option>
					</select>
					<select class="campos" id="lapsohasta" name="lapsohasta">
						<option value="">Hasta</option>
					</select>
					<br><br>
					<input align="left" class="boton" type="submit" name="enviar" value="Enviar">
				</div>
		</form>
	</center>
<?php /*
require_once('reporte_estudiante.php');
if(isset($_POST['estudiante'], $_POST['periodo']) && !empty($_POST['estudiante'])){
	require_once ("includes/db.php");
	$filtro=is_numeric(substr($_POST['estudiante'],0,1))?"e.cod_estu=".$_POST['estudiante']:"e.ced_estu='".$_POST['estudiante']."'";
	$sql="SELECT e.nom_estu, e.ced_estu, p.nom_prof, n.*, m.nom_mat, m.uc_mat FROM estudiante AS e LEFT OUTER JOIN notas AS n ON n.cod_estu=e.cod_estu LEFT OUTER JOIN materia AS m ON m.cod_comp=n.cod_comp LEFT OUTER JOIN profesor AS p ON p.cod_prof=n.cod_prof WHERE ".$filtro;
	if($_POST['periodo']==2){
		$sql.=" AND n.cod_per BETWEEN '".$_POST['lapsodesde']."' AND '".$_POST['lapsohasta']."'";
		//Consulta completa
	}
	
}*/
?>
<script>$(document).ready(function(e){
	
	$("#estudiante",$("#cons_estudiante")).bind("focus", function(e){
		var value=$.trim($(this).val());
		if(value.length==0)
			$(this).val("V");
	});

	
	$("#estudiante",$("#cons_estudiante")).on('blur', function(){
		var _this=$(this);
		$.ajax('./admin/proc_cons_estudiante.php',
			{type:'POST',dataType:'json', data:$(_this).serialize(), 
				beforeSend:function(){
					$(":submit",$("#cons_estudiante")).attr({disabled:'disabled'});
					$("select.campos",$("#cons_estudiante")).children(':not(:first-child)').remove();
				}, 
				success:function(data, textStatus, jqXHR){
					console.log(data.success, data.num_rows)
					if(data.success && data.num_rows>0){
						$(":submit",$("#cons_estudiante")).removeAttr('disabled');
						$("#nombre",$("#cons_estudiante")).val(data.info.estudiante);
						$.each(data.info.lapsos, function(i, e){
							$("#lapsodesde, #lapsohasta",$("#cons_estudiante")).append($("<option>",{value:e,text:e}));
						});
					}
				}
			}
		);
	});
	$("select",$("#cons_estudiante")).attr({disabled:'disabled'});
	$(":radio",$("#cons_estudiante")).on('click', function(e){
		if($(this).val()==1){
			$("select",$("#cons_estudiante")).attr({disabled:'disabled'}).val('');
		}else
			$("select",$("#cons_estudiante")).removeAttr('disabled');
	});
});
</script>
</body>
</html>
