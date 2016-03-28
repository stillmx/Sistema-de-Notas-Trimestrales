<!DOCTYPE html>
<html lang="es">
<head>
	<meta name="viewport" content="width=device-width, user-scalable=no"/>
	<title>Control de Notas Trimestrales PNFI</title>
	<link rel="stylesheet" href="./css/bootstrap.min.css"/>
	<link rel="stylesheet" href="./css/menu.css"/>
	<script src="./js/jquery-1.11.2.min.js"></script>
	<script src="./js/registrar_nota.js"></script>
</head>	
<body>
	
	<center>
		<form action="include.php?admin=notas_docentes" method="POST" name="Registro">
			<h4>Registrar Notas de Estudiantes</h4>
				<input type="hidden" name="oper" id="oper" value="buscar_nomina">
				<input class="campos" name="profesor" id="profesor" type="text" maxlength="10" size="15" placeholder="C.I. Profesor">
				<input class="campos" id="materia" name="materia" type="text" maxlength="6" size="15" placeholder="Cod. Materia"><br>
				<input class="boton" type="submit" name="enviar" value="Enviar">
		</form>
	</center>
</body>
</html>
