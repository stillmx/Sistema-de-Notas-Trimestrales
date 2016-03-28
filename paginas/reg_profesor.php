<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, user-scalable=no"/>
	<title>Control de Notas Trimestrales PNFI</title>
	<link rel="stylesheet" href="css/bootstrap.min.css"/>
	<link rel="stylesheet" href="css/menu.css"/>
</head>
<body>
	<center>
		<form action="include.php?pagina=proc_profesor" method="post" name="Subir Archivo" enctype="multipart/form-data" id="formulario">
			<h4>Cargar Registro de Profesores</h4>
				<input type="file" id="archivo" class="campos"  name="archivo" required><br>
				<input type="submit" name="enviar" value="Enviar" class="boton"><br>
		</form>
	</center>
</body>
</html>
