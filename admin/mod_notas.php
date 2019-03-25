<!-- Registro de estudiante  -->
<!DOCTYPE html>

<html lang="es">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/menu.css" type="text/css" />
	<title>Registro de Estudiante</title>
	<script src="./js/jquery-1.11.2.min.js"></script>
	
</head>
<body>
	
	<center>
		<form action="include.php?admin=proc_mod_notas" method="POST" name="registro" id="mod_notas">
			<h4>Modificar Nota de Estudiante</h4>
			<div class="modificar">
				<input class="campos" name="estudiante" id="estudiante" type="text" 
				maxlength="5" size="20" placeholder="Código Estudiante" required>	
				<input class="campos" id="nombre" name="nombre" type="text" size="40" 
				placeholder="Nombre y Apellido" readonly="readonly" required><br>
				<select class="campos" id="periodo" name="periodo">
						<option value="">Periodo</option>
					</select>
				<!--<input class="campos" id="periodo" name="periodo" type="text" size="20" placeholder="Periodo" required>-->
				<input class="campos" id="descripcion" name="descripcion" type="text" size="40" placeholder="Descripción del Periodo" readonly="readonly"><br>
				<select class="campos" id="materia" name="materia">
						<option value="">Materia</option>
					</select>
				<input class="campos" id="cod_mat" name="cod_mat" type="text" 
				Placeholder="Código Materia" size="20" readonly="readonly" required><br>
				<label for="porcentaje" id="tit_porc" style="display:none; color:blue;">Porcentaje:</label>
				
				<input class="campos" id="porcentaje" name="porcentaje" type="text" size="10" Placeholder="% Materia" readonly="readonly" required>
				<label for="porcentaje" id="tit_nota" style="display:none; color:blue;">Nota:</label>
				<input class="campos" id="nota" name="nota" type="text" maxlength="5" size="6" Placeholder="Nota" required>
				<br>
				<input class="boton" type="reset" value="Borrar">
				<input class="boton" type="submit" name="enviar" value="Enviar"><br>
				</div>
		</form>
	</center>	

<script>$(document).ready(function(e){
	
	$("#estudiante",$("#mod_notas")).on('blur', function(){
		var _this=$(this);
		$.ajax('./admin/consulta_mod_notas.php',
			{type:'POST',dataType:'json', data:$(_this).serialize(), 
				beforeSend:function(){
					$(":submit").attr({disabled:'disabled'});
					$("select.campos").children(':not(:first-child)').remove();
				}, 
				success:function(data, textStatus, jqXHR){
					console.log(data.success, data.num_rows)
					if(data.success && data.num_rows>0){
						$("#nombre").val(data.info.estudiante);
						$.each(data.info.lapsos, function(i, e){
							$("#periodo").append($("<option>",{value:e,text:e}));
						});
					}
				}
			}
		);
	});

	$("#periodo",$("#mod_notas")).on('blur', function(){
		var _this=$(this);//$("#estudiante, #periodo").serialize();
		$.ajax('./admin/consulta_mod_notas.php',
			{type:'POST',dataType:'json', data:$("#estudiante, #periodo").serialize(), 
				beforeSend:function(){
					$(":submit").attr({disabled:'disabled'});
					
				}, 
				success:function(data, textStatus, jqXHR){
					console.log(data.success, data.num_rows)
					if(data.success && data.num_rows>0){
						$("#descripcion").val(data.info.descripcion);
						$.each(data.info.materia, function(i, e){
							$("#materia").append($("<option>",e));
						});
					}
				}
			}
		);
	});

	$("#materia",$("#mod_notas")).on('blur', function(){
		var _this=$(this);//$("#estudiante, #periodo").serialize();
		$.ajax('./admin/consulta_mod_notas.php',
			{type:'POST',dataType:'json', data:$("#estudiante, #periodo, #materia").serialize(), 
				beforeSend:function(){
					$(":submit").attr({disabled:'disabled'});
					
				}, 
				success:function(data, textStatus, jqXHR){
					console.log(data.success, data.num_rows)
					if(data.success && data.num_rows>0){
						$(":submit").removeAttr('disabled');
						$("#cod_mat").val(data.info.codigo_mat);
						$("#porcentaje").on('mouseover', function() {
							$("#tit_porc").fadeIn(1000);
						});
						
						$("#porcentaje").val(data.info.porcentaje);
						$("#nota").on('mouseover', function() {
							$("#tit_nota").fadeIn(1000);
						});
						
						$("#nota").val(data.info.nota);
					}
				}
			}
		);
	});
	$('#nota').bind('blur',function(e){
			e.preventDefault();
			e.stopPropagation();
			var _t = $(this);
			var n = $(_t).val();
			
			if(n>=0 && n<=100 && n.trim()!=''){
				return false;
			}else{
				$(_t).val('');
				$(_t).focus();
				alert("Debe elegir una nota entre 0 y 100");
			}
			
		});
});
</script>
</body>
</html>
