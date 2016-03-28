<script type="text/javascript">
$(document).ready(function(e){
	$.ajax('./paginas/busqueda_consultas.php',{data:{oper:'materias'}, type:'POST', dataType:'json', 
		success:function(data, textStatus, jqXHR){
			if(data.success)
				$.each(data.info, function(i, e){
					$("#cod_comp").append($("<option>", e));
				});
		},
		error:function(jqXHR, textStatus, errorThrow){
			alert("Ocurrio un error en el sistema al consultar las materias")
		} 
	});
	$("#cod_comp", $("#form_materia")).bind("change", function(e){
		var _t=$(this);
		$.ajax('./paginas/busqueda_consultas.php',
			{
			data:{oper:'secciones_docente', cod_comp:function(){return $(_t).val();}}, type:'POST', dataType:'json', context:$("#cod_mat"),
			success:function(data, textStatus, jqXHR){
				var element=$(this);
				if(data.success)
					$.each(data.info, function(i, e){
						$(element).append($("<option>", e));
					});
			},
			error:function(jqXHR, textStatus, errorThrow){
				alert("Ocurrio un error en el sistema al consultar las materias")
			} 
		});
	});
			$("#cod_mat", $("#form_materia")).on('change', function(e){
				var this_val=$.trim($(this).val());
				if(this_val=='')
					return true;
				$.ajax('./paginas/busqueda_consultas.php',{ type:'POST', dataType:'json',
					data:{oper:'periodos', cod_prof:function(){return $("#cod_prof").val();}, cod_mat:function(){return this_val;}},
					beforeSend:function(){
						$("#cod_per").children(':not(:first-child)').remove();
						$(":submit").attr({disabled:'disabled'});
					},
					success:function(d, t, j){
						if(d.success)
							$.each(d.info, function(i,e){
								$("#cod_per").append($("<option>", e));
							});
						
					}
				});
			});

});
</script>
<center>
	<form action="include.php?pagina=reporte_profesor" method="POST" name="Registro" id="form_materia">
		<h4>Consultar Profesores</h4>
		<div class="profesor">
			<select class="campos" name="cod_comp" id="cod_comp">
				<option value="">Materias...</option>
			</select><br>
			<!-- <select class="campos" name="cod_prof" id="cod_prof">
				<option value="">Profesores...</option>
			</select><br> -->
			<select class="campos" name="cod_mat" id="cod_mat">
				<option value="">Secciones...</option>
			</select><br>
			<select class="campos" name="cod_per" id="cod_per">
				<option value="">Periodos...</option>
			</select>
			<br><br>
			<input class="boton" type="submit" name="enviar" value="Enviar" disabled="disabled">
		</div>
	</form>
	</center>
