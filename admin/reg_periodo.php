<!-- Aqui comienza mi página web en html -->
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, user-scalable=no"/>
	<title>Control de Notas Trimestrales PNFI</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css"/>
	<link rel="stylesheet" href="../css/menu.css"/>
</head>
<body>
	<center>
		<form action="admin/proc_periodo.php" method="post" name="Ingreso">
			<h4>Registrar Periodo</h4>
				<input class="campos" id="periodo" type="text" name="periodo" size="8" maxlength="6" placeholder="Periodo" required>
				<input class="campos" id="desc" type="text" name="descripcion" size="40" maxlength="40" placeholder="Descripción del Periodo" required>
				<br><br>
				<input class="boton" type="submit" name="enviar" value="Enviar">
		</form>
	</center>
</body>
</html>
