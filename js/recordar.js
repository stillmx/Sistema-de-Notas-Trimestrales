$(document).ready(function()
{
	$("#mostrar2").click(function()
	{
		$("#recordar, #contenedorRec").fadeIn(1000);
	});
	$("#recordar").click(function()
	{
		$("#recordar, #contenedorRec").fadeOut(1000);
	});

	
	$("#recordar, #cedula").bind("focus", function(){
		var value=$.trim($(this).val());
		if(value.length==0)
			$(this).val("V");
	});


	$("#recordar, #cedula").on('blur', function()
	{
		var _this=$(this);
		var valor=$(this).val();
		
		$.ajax({
			type:'POST',
			dataType:'json', 
			data:$(_this).serialize(), 
			url:'recordar.php', 
			
			beforeSend:function(){
					$(":submit").attr({disabled:'disabled'});
					$("select.campos").children(':not(:first-child)').remove();
				}, 
				success:function(data, textStatus, jqXHR){
					console.log(data.success, data.num_rows)
					if(data.success && data.num_rows>0){
						$(":submit").removeAttr('disabled');
						$("#recordar,#pregunta").val(data.info.cedula);
						
					}
				}

		});

	});

	/*$("#recordar, #boton").bind("click", function(){
		$.ajax({
			type:'POST',
			dataType:'json', 
			data:$(_this).serialize(), 
			url:'recordar.php',
			
			success:function(d, t, jxhr){
				console.log(data.success, data.num_rows)
				if(data.success && (data.num_rows==1))
					alert(data.info.mensaje);
				$("#recordar,#boton, :reset");
			}
		});
	});*/
});	
