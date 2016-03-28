$(document).ready(function(e){
	$("#profesor").bind("focus", function(e){
		var value=$.trim($(this).val());
		if(value.length==0)
			$(this).val("V");
	})
	$("#profesor, #materia").on('blur', function(){
		var _this=$(this);
		var param=($(_this).attr('name')=='profesor')?"#profesor, #oper":"#profesor, #materia, #oper";
		$.ajax('./paginas/proc_cons_profesor.php',
			{type:'POST',dataType:'json', data:$(param).serialize(), 
				beforeSend:function(){
					$(":text").not(_this).attr({disabled:'disabled'});
				}, 
				success:function(data, textStatus, jqXHR){
					$(":text").removeAttr('disabled');
					if(!data.success || data.num_rows!=1)
						alert(data.mensaje)
				}
			}
		);
	});
	
});