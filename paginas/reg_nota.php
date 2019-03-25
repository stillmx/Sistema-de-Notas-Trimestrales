<!DOCTYPE html>
<html lang="es">
<head>
	<meta name="viewport" content="width=device-width, user-scalable=no"/>
	<title>Control de Notas Trimestrales PNFI</title>
	<link rel="stylesheet" href="./css/bootstrap.min.css"/>
	<link rel="stylesheet" href="./css/menu.css"/>
	<script src="./js/jquery-1.11.2.min.js"></script>
	<script type="text/javascript">
$(document).ready(function(e){
	$.ajax('./paginas/busqueda_consultas.php',{data:{oper:'materias'}, type:'POST', dataType:'json', 
		success:function(data, textStatus, jqXHR){
			if(data.success)
				$.each(data.info, function(i, e){
					$("#cod_comp").append($("<option>", e));
				});
		},
		
	});
	$("#cod_comp", $("#form_busqueda")).bind("change", function(e){
		var _t=$(this);
		$.ajax('./paginas/busqueda_consultas.php',
			{
			data:{oper:'secciones_docente', cod_comp:function(){return $(_t).val();}}, type:'POST', dataType:'json', context:$("#materia"),
			success:function(data, textStatus, jqXHR){
				var element=$(this);
				if(data.success)
					$.each(data.info, function(i, e){
						$(element, $("#form_busqueda")).append($("<option>", e));
					});
			},
			error:function(jqXHR, textStatus, errorThrow){
				alert("Ocurrio un error en el sistema al consultar las materias")
			} 
		});
	});
	$("#cod_mat", $("#form_busqueda")).on('change', function(e){
		var this_val=$.trim($(this).val());
		$(":submit", $("#form_busqueda")).attr({disabled:this_val==''});
		if(this_val=='')
			return true;
	});	
});
</script>

</head>	
<body>
	
	<center>

	<form action="include.php?pagina=notas_docentes" method="POST" name="Registro" id="form_busqueda">
		<h4>Registrar Notas</h4>
		<div class="profesor">
			<select class="campos" name="cod_comp" id="cod_comp">
				<option value="">Materias...</option>
			</select><br>
			<!-- <select class="campos" name="cod_prof" id="cod_prof">
				<option value="">Profesores...</option>
			</select><br> -->
			<select class="campos" name="materia" id="materia">
				<option value="">Secciones...</option>
			</select>
			<br><br>
			<input class="boton" type="submit" name="enviar" value="Enviar" >
		</div>
	</form>
		<!-- <form id="reg_nota" action="include.php?pagina=notas_docentes" method="POST" name="Registro">
			<h4>Registrar Notas de Estudiantes</h4>
				<input type="hidden" name="oper" id="oper" value="buscar_nomina">
				<input class="campos" id="materia" name="materia" type="text" maxlength="6" size="15" placeholder="Cod. Materia"><br>
				<input class="boton" type="submit" name="enviar" value="Enviar"> -->
		</form>
	</center>
</body>
</html>
 