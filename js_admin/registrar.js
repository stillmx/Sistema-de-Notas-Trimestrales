//Aquí codigo de formulario de registro y recuperar contraseña
$(document).ready(function()
{
	$("#mostrar").click(function()
	{
		$("#registrar, #contenedorForm").fadeIn(1000);
	});
	$("#registrar").click(function()
	{
		$("#registrar, #contenedorForm").fadeOut(1000);
	});

	$("#mostrar2").click(function()
	{
		$("#recordar, #contenedorRec").fadeIn(1000);
	});
	$("#recordar").click(function()
	{
		$("#recordar, #contenedorRec").fadeOut(1000);
	});
	$("#recordar, #cedula").bind("focus", function(e){
		var value=$.trim($(this).val());
		if(value.length==0)
			$(this).val("V");
	})
	$("#cedula", $("#f_registro")).on('blur', function()
	{
		var _this=$(this);
		var valor=$(this).val();
		if(valor=="")
			return -1;
		$.ajax({
			type:'POST',
			dataType:'json', 
			data:$(_this).serialize(), 
			url:'registrar.php',
			beforeSend:function(){
				$(":text, :submit", $("#f_registro")).attr({disabled:"disabled"});				
			}, 
			success:function(data){
				if(data.success && data.num_rows==1){
					if(data.mensaje!=""){
						alert(data.mensaje);
						$(":reset", $("#f_registro")).trigger("click");
						return -1;
					}
					$(":text", $("#f_registro")).removeAttr("disabled");
					$.each(data.info, function(i,e){ $("#"+i).val(e); });
				}else{
					alert("No coinciden registro con la cedula indicada");
					$(":reset", $("#f_registro")).trigger("click");
				}
					
			}
		});
	});
	$(":reset", $("#f_registro")).bind("click", function(e){
		$(":text, :submit", $("#f_registro")).attr({disabled:"disabled"});
		$(":text", $("#f_registro")).val("");
		$("#cedula", $("#f_registro")).removeAttr("disabled");
		$("#cedula", $("#f_registro")).focus();
	})
	$("#usuario", $("#f_registro")).bind("blur", function(){
		$.ajax("registrar.php", {
			type:'POST',
			dataType:'json', 
			data:{
				evento:"validar_usuario", tipousuario:function(){
					return $("#tipousuario", $("#f_registro")).val();}, 
					usuario:function(){return $("#usuario").val();}},
					success:function(data){
						if(data.num_rows==0){
							$("#status").css("color", "green");
						}else{
							$("#status").css("color", "red");
						}
						$("#status").val(data.status);
					}			
							
					
		});
	});
	$("#boton").bind("click", function(){
		$.ajax("registrar.php", {
			type:'POST', dataType:'json', data:$("#f_registro").serialize(),
			beforeSend:function(){
				$(":text, :submit", $("#f_registro")).attr({disabled:"disabled"})
			},
			success:function(d, t, jxhr){
				if(d.success && (d.affected_rows==1 || d.num_rows==1))
					alert(d.mensaje);
				$(":reset", $("#f_registro")).trigger("click");
			}
		});
	});
});
