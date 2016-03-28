$(document).ready(function(e){
	$("select").attr({disabled:'disabled'});
	$(":radio").on('click', function(e){
		if($(this).val()==1){
			$("select").attr({disabled:'disabled'}).val('');
		}else
			$("select").removeAttr('disabled');
	});
	$("#estudiante").bind("focus", function(e){
		var value=$.trim($(this).val());
		if(value.length==0)
			$(this).val("V");
	});

	
	$("#estudiante").on('blur', function(){
		var _this=$(this);
		$.ajax('./admin/proc_cons_estudiante.php',
			{type:'POST',dataType:'json', data:$(_this).serialize(), 
				beforeSend:function(){
					$(":submit").attr({disabled:'disabled'});
					$("select.campos").children(':not(:first-child)').remove();
				}, 
				success:function(data, textStatus, jqXHR){
					console.log(data.success, data.num_rows)
					if(data.success && data.num_rows>0){
						$(":submit").removeAttr('disabled');
						$("#nombre").val(data.info.estudiante);
						$.each(data.info.lapsos, function(i, e){
							$("#lapsodesde, #lapsohasta").append($("<option>",{value:e,text:e}));
						});
					}
				}
			}
		);
	});
});
