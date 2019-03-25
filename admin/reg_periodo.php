<!-- Aqui comienza mi página web en html -->
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, user-scalable=no"/>
	<title>Control de Notas Trimestrales PNFI</title>
	
	<script src="./js/jquery-1.11.2.min.js"></script>


	<script>
		$(document).ready(function() {
			$("#periodo, #boton",$("#form_periodo")).bind("blur",function(){
		
		var expr = /^([0-9]+){4}\-[0-9]{1}$/;	
		var _this = $(this).val();
		if(_this.trim() =="" || !expr.test(_this)){
			$("#periodo").val("");
			$("#mens_per").fadeIn("slow");
			
			
			return false;
		
		}else{
			
			$("#mens_per").fadeOut("slow");
			
			}
		});
	});
		
	</script>
</head>
<body>
	<center>
		<form action="admin/proc_periodo.php" method="post" name="Ingreso" id="form_periodo">
			<h4>Registrar Periodo</h4>
				<input class="campos" id="periodo" type="text" name="periodo" size="8" maxlength="6" placeholder="2016-1" required>
				<div id="mens_per" style="display:none;">El formato de la fecha es. Ejemplo: 2016-1</div>
				<input class="campos" id="desc" type="text" name="descripcion" size="40" maxlength="40" placeholder="COLOCAR MES DE INICIO - MES FINAL" required>
				
				<br><br>
				<input id="boton" class="boton" type="submit" name="enviar" value="Enviar">
		</form>
	</center>
</body>
</html>
