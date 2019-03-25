$(document).ready(function(e){
	
	$("#materia", $("#reg_nota")).on('blur', function(){
		var _this=$(this);
		var param=($(_this).attr('name')=='profesor')?"#profesor, #oper":"#profesor, #materia, #oper";
		$.ajax('./paginas/proc_cons_profesor.php',
			{type:'POST',dataType:'json', data:$(param).serialize(), 
				beforeSend:function(){
					//$(":text").not(_this).attr({disabled:'disabled'});
				}, 
				success:function(data, textStatus, jqXHR){
					//$(":text").removeAttr('disabled');
					if(!data.success || data.num_rows!=1)
						alert(data.mensaje)
				}
			}
		);
	});
	
});