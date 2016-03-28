$(document).ready(function(e)

		{
		$("#cod_estudiante").on('blur', function(e){
			var this_val=$.trim($(this).val());
			if(this_val=='')
				return true;
			$.ajax('./admin/busqueda_consultas.php', {data:{oper:'estudiante', cod_estu:function(){return this_val;}}
				,type:'POST', dataType:'json',
				beforeSend:function(){
					$("#nombre, #cod_mat, #porcentaje, #periodo, #descripcion, #nota").val('');
				},
				success:function(d, t, j){
					if(d.success && d.num_rows==1)
						$("#nombre").val(d.info.nombre);
					else
						alert(d.mensaje)
				}
			});
		});
	});