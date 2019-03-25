<div id="contenedor">
	<div id='encabezado'>
		<?php require ('includes/encabezado.php');?>
	</div>
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
			
			<form class="f_clear" name="f_recuperar" id="f_recuperar" action="recuperar_clave.php" method="post">
				<h4>Formulario de Registro</h4>
				<input class="campos" name="cedula" id="cedula" type="text" maxlength="9" placeholder="Nº Cédula" required><br>
				<input type="hidden" id="codigo" name="codigo" value="" />
				<input id="usuario" name="usuario" type="hidden" value="" /><br>
				<input class="campos" id="usuario2" name="usuario2" type="text" size="20" placeholder="Usuario"><br>
				<select class="campos" id="pregunta" name="pregunta" required>
					<option value="" selected>Selecciona una pregunta de seguridad</option>
					<option value="Color Favorito">Color Favorito</option>
					<option value="Lugar para vacacionar">Lugar para vacacionar</option>
					<option value="Actor o actriz que te guste">Actor o actriz que te guste</option>
					<option value="Canción favorita">Canción favorita</option>
					<option value="Nombre maestra de primaria">Nombre maestra de primaria</option>
				</select><br>
				<input class="campos" id="respuesta" name="respuesta" type="text" size="40" placeholder="Escriba una Respuesta de Seguridad" required><br>
				<input class="campos" type="text" name="captcha" maxlength="5" size="20" placeholder="Ingresa el código" required/>
				<img src="captcha/captcha.php" border="0" width="180"/><br><br>
				<input class="boton" id="boton" type="submit" name="enviar" value="Enviar"/>
				<input type="reset" id="btn_limpiar" name="btn_limpiar" value="Limpiar" style="display:none;" />
				
			</form>
		
		<div class="salir">
			<button class="salida" onclick=location="index.php">Salir</button>
		</div>
			</center>
			
		</div>

		<div id='pie'>
			<?php require ('includes/pie.php');?>
		</div>
	</div>

	

