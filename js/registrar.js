//Aquí codigo de formulario de registro y recuperar contraseña
$(document).ready(function()
{{
	$("#mostrar").click(function()
	{
		$("#registrar, #contenedorForm").fadeIn(1000);
	});
	$("#registrar").click(function()
	{
		$("#registrar, #contenedorForm").fadeOut(1000);
	});
	$("#recordar,#cedula").bind("focus", function(e){
		var value=$.trim($(this).val());
		if(value.length==0)
			$(this).val("V");
	})				
	$("#cedula", $("#f_registro")).on('blur', function()
	{
		var _this=$(this);
		var valor=$.trim($(this).val());
		if(valor=="")
			return -1;
		$.ajax({
			type:'POST',
			dataType:'json', 
			data:$(_this).serialize(), 
			url:'registrar.php', 
			beforeSend:function(){
				//$(":text, :submit", $("#f_registro")).attr({disabled:"disabled"});				
			}, 
			success:function(data){
				if(data.success && data.num_rows==1){
					if(data.mensaje!=""){
						alert(data.mensaje);
						$(":reset", $("#f_registro")).trigger("click");
						return -1;
					}
					//$(":text", $("#f_registro")).removeAttr("disabled");
					$.each(data.info, function(i,e){ $("#"+i).val(e); });
				}else{
					alert("No coinciden registro con la cedula indicada");
					$(":reset", $("#f_registro")).trigger("click");
				}
					
			}
		});

	});
		

	$("#telf, #email").blur(function(){
		var expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;	
		var expr2 = /^([0-9]+){11}$/;	
		var telef = $("#telf").val();
		var email = $("#email").val();
		if(telef.trim() =="" || !expr2.test(telef)){
			$("#mens_telf").fadeIn("slow");
			$("#email").attr({disabled:"disabled"});
			return false;
		}
		else{
			$("#mens_telf").fadeOut("slow");
			$("#email").removeAttr("disabled");
			if(email.trim() =="" || !expr.test(email)){
			$("#mens_email").fadeIn("slow");
			return false;
			}
			else{
				
				$("#mens_email").fadeOut("slow");
				
			}
		}
	});

	
	$("#contraseña3, #contraseña2").blur(function(){

		var c1 = $("#contraseña3").val();
		
		var c2 = $("#contraseña2").val();
		
		if(c1 != c2 || c1.trim() && c2.trim() ==""){
					$("#clave").fadeIn("slow");
					return false;
				}else
				{
					$("#clave").fadeOut("slow");
					
				}
	});
	
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
		var confirmar = confirm("¿Sus datos estan completos?");
		if(confirmar==true){
			$.ajax("registrar.php", {
				type:'POST', dataType:'json', data:$("#f_registro").serialize(),
				
				success:function(d, t, jxhr){
					if(d.success && (d.affected_rows==1 || d.num_rows==1)){
						alert(d.mensaje);
					$(":reset", $("#f_registro")).trigger("click");
				}
					else
						alert(data.mensaje);
				}
			});
	    }else return false;

	});
	


	
	

});



