<script type="text/javascript">
		$.ajax('./admin/busqueda_consultas.php',{
			data:{oper:'materias'}, type:'POST', dataType:'json', 
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
</script>

<center>
	<form action="include.php?admin=reporte_profesor" method="POST" name="Registro" id="form_mat_admin">
		<h4>Consultar Profesores</h4>
		<div class="profesor">
			<select class="campos" name="cod_comp" id="cod_comp">
				<option value="">Materias...</option>
			</select><br>
			<select class="campos" name="cod_prof" id="cod_prof">
				<option value="">Profesores...</option>
			</select><br>
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
