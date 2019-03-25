
<script src="./js/jquery-1.11.2.min.js"></script>
<script type="text/javascript">
$(document).ready(function(e){
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
		$("#materia",$("#form_mat_admin")).on('blur', function(){
				var _this=$(this);
				var value=$.trim($(this).val());
				if(value=='')
					return true;
				var param=($(_this).attr('name')=='profesor')?"#profesor":"#profesor, #materia";
				$.ajax('./admin/proc_cons_profesor.php',
					{type:'POST',dataType:'json', data:$(param).serialize(), 
						beforeSend:function(){
							$(":radio, select").attr({disabled:'disabled'});
							$(":text").not(_this).attr({disabled:'disabled'});
							$("#periodos").children(":not(:first-child)").remove();
						}, 
						success:function(data, textStatus, jqXHR){
							$(param).removeAttr('disabled');
							if(data.success && data.num_rows>0){
								$(":text, :radio, select").removeAttr('disabled');
								if($(_this).attr('name')=="materia")
									$.each(data.info, function(i,e){
										$("#periodos").append($("<option>", e));
									});
							}else
								alert(data.mensaje)
						}
					}
				);
			});


			$("#cod_comp","#form_mat_admin").on('change', function(e){
				var this_val=$.trim($(this).val());
				if(this_val=='')
					return true;
				$.ajax('./admin/busqueda_consultas.php',{ type:'POST', dataType:'json',
					data:{oper:'docentes', cod_comp:function(){return this_val;}},
					beforeSend:function(){
						$("#cod_prof, #cod_mat, #cod_per").children(':not(:first-child)').remove();
						$(":submit").attr({disabled:'disabled'});
					},
					success:function(d, t, j){
						if(d.success)
							$.each(d.info, function(i,e){
								$("#cod_prof").append($("<option>", e));
							});
					}
				});
			});		
			$("#cod_prof","#form_mat_admin").on('change', function(e){
				var this_val=$.trim($(this).val());
				if(this_val=='')
					return true;
				$.ajax('./admin/busqueda_consultas.php',{ type:'POST', dataType:'json',
					data:{oper:'secciones', cod_comp:function(){return $("#cod_comp").val();}, cod_prof:function(){return this_val;}},
					beforeSend:function(){
						$("#cod_mat, #cod_per").children(':not(:first-child)').remove();
						$(":submit").attr({disabled:'disabled'});
					},
					success:function(d, t, j){
						if(d.success)
							$.each(d.info, function(i,e){
								$("#cod_mat").append($("<option>", e));
							});
					}
				});
			});
			
			$("#cod_mat","#form_mat_admin").on('change', function(e){
				var this_val=$.trim($(this).val());
				if(this_val=='')
					return true;
				$.ajax('./admin/busqueda_consultas.php',{ type:'POST', dataType:'json',
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
			$("#cod_per","#form_mat_admin").on('change', function(e){
				var this_val=$.trim($(this).val());
				$(":submit").attr({disabled:'disabled'});
				if(this_val=='')
					return true;
				$(":submit").removeAttr('disabled');
			});
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
