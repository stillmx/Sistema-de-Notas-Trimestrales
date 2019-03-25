<?php
header("Content-type: text/html; charset=utf8");
//:: No permite ingreso a enlaces directos 
	if(!$_SERVER['HTTP_REFERER']){ 
	header ('Location: error.php');
	}else{
?>
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
			<br>
			<center>
			<form class="f_clear" name="f_recuperar" id="f_recuperar" action="#" method="post">
				<h4>Formulario de Registro</h4>
				<select class="campos" id="pregunta" name="pregunta" required>
					<option value="" selected>Selecciona una pregunta de seguridad</option>
					<option value="Color Favorito">Color Favorito</option>
					<option value="Lugar para vacacionar">Lugar para vacacionar</option>
					<option value="Actor o actriz que te guste">Actor o actriz que te guste</option>
					<option value="Canción favorita">Canción favorita</option>
					<option value="Nombre maestra de primaria">Nombre maestra de primaria</option>
				</select><br>
				<input class="campos" id="respuesta" name="respuesta" type="text" size="40" placeholder="Escriba una Respuesta de Seguridad" required><br>
				<input class="boton" id="boton" type="submit" name="enviar" value="Enviar"/>
				<input type="reset" id="btn_limpiar" name="btn_limpiar" value="Limpiar" style="display:none;" />	
			</form>
			</center>
			
<?php 
require_once ('includes/db.php');
$usuario = $_SESSION["usuario_entrar"];

	//::::::::::Determinar si la variable está definida::::::::::::::::
	if(isset ($_POST['pregunta'])){
	//::::::::: "limpiamos" los campos del formulario de posibles códigos maliciosos:::::::::: 
	$resp1_entrada = addslashes(mysql_real_escape_string($_POST['respuesta'])); 
	//::::::::::Encriptamos clave::::::::         
	$mx='$stelmas$%/=zeck001mx$/';
	$resp = $mx.sha1(md5($resp1_entrada));
	$preg = $_POST["pregunta"];
	$consulta=mysql_query("UPDATE usuario SET pregunta = '$preg', respuesta = '$resp', n_intentos=0, r_intentos=0
	 WHERE usuario='$usuario'");
	
	if(!$consulta){
		echo"Error de Consulta", mysql_errno(), mysql_error();
		
		if(mysql_num_rows($consulta)==0){
			echo "<script type='text/javascript'>
			alert('NO SE PUDO REALIZAR EL CAMBIO DE CLAVE, CONSULTE AL ADMINISTRADOR');</script>";
		exit;
		}
	}else{
			echo "<script type='text/javascript'>
			alert('EL CAMBIO DE CONTRASEÑA SE HA REGISTRADO CON EXITO');</script>";
		//echo" <SCRIPT LANGUAGE='javascript'>location.href = './';</SCRIPT>";

		}
	}else{
		return false;
	}
} 
?>
