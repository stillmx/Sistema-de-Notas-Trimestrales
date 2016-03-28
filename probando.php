<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script src="./js/jquery-1.11.2.min.js"></script>
	
</head>
<body>
	<script type="text/javascript">
	var expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var expr2 = /^([0-9]+){11}$/;
		$(document).ready(function() {
		
			
			$("#telef","#f_registro").blur(function()
					
				var telef = $("#telf").val();
				var email = $("#email").val();

				if(telef =="" || !expr2.test(telef)){
					$("#mens_telf").fadeIn("slow");
					return false;
				}
				else{
					$("#mens_telf").fadeOut("slow");
				
					if(email=="" || !expr.test(email)){
						$("#mens_email").fadeIn("slow");
						return false;
					}
					else{
						$("#mens_email").fadeOut("slow");
					}
				}
			});
		});
	</script>
	<h4>Formulario de Registro</h4>
		<form id="f_registro" action="#" method="post">
		<input class="campos" name="cedula" id="cedula" type="text" placeholder="Nº Cédula" ><br>
		<input class="campos" id="telf" name="telefono" type="text" placeholder="Nº Teléfono" ><br>
		<div id="mens_telf"> El número es invalido </div>
		<input class="campos" id="email" name="email" type="text" size="40" placeholder="Correo Eléctronico" ><br>
		<div id="mens_email"> El correo es invalido </div>
		<input class="boton" id="boton" type="submit" name="enviar" value="Enviar"/>
		</form>
</body>
</html>