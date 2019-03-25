<script src="./js/jquery-1.11.2.min.js"></script>
	<link rel="stylesheet" href="css/pass.css"/>
	<script>
		$(document).ready(function() {
			$("#cedula").bind("focus", function(e){
			var value=$.trim($(this).val());
			if(value.length==0)
			$(this).val("V");
		})				
		$("#cedula", $("#f_recuperar")).on('blur', function(){
			var _this=$(this);
			var valor=$.trim($(this).val());
			if(valor=="")
			return -1;
			$.ajax({
				type:'POST',
				dataType:'json', 
				data:$(_this).serialize(), 
				url:'recordar.php', 
				beforeSend:function(){
					//$(":text, :submit", $("#f_recuperar")).attr({disabled:"disabled"});				
				}, 
				success:function(data){
					if(data.success && data.num_rows==1){
						if(data.mensaje!=""){
							alert(data.mensaje);
							$(":reset", $("#f_recuperar")).trigger("click");
							return -1;
						}
						$(":text", $("#f_recuperar")).removeAttr("disabled");
						$.each(data.info, function(i,e){ $("#"+i).val(e); });
					}
					else{
						alert("No coinciden registro con la cedula indicada");
						$(":reset", $("#f_recuperar")).trigger("click");
					}
						
				}
			});

		});
	});
		
	</script>
	
	
		<!-- Aqui esta la caja de autenticar-->
		


		<div id='contenido'>
			<br>
			
			<center>
			
			<form class="f_clear" name="f_recuperar" id="f_recuperar" action="include.php?admin=generar_pass" method="post">
				<h4>Desbloquear Usuario</h4>
				<input class="campos" name="cedula" id="cedula" type="text" maxlength="9" placeholder="Nº Cédula" required><br>
				<input type="hidden" id="codigo" name="codigo" value="" />
				<input class="campos" id="usuario" name="usuario" type="text" size="20" placeholder="Usuario" readonly><br>
				<input class="campos" id="estado_contraseña" name="st_clave" type="text" size="40" placeholder="Estatus del Usuario" readonly><br>
				<input class="campos" id="email" name="email" type="text" size="40" placeholder="Escriba un Email" required><br>
				<input class="campos" id="bloquear" name="bloquear" type="checkbox"/>
				<label style="color:red;">Seleccione si desea bloquear este Usuario</label> 
				<br><br>
				<input class="boton" id="boton" type="submit" name="enviar" value="Enviar"/>
				<input type="reset" id="btn_limpiar" name="btn_limpiar" value="Limpiar" style="display:none;" />
				
			</form>
			</center>

	

