<!-- Registro de estudiante  -->
<!DOCTYPE html>

<html lang="es">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/menu.css" type="text/css" />
	<title>Registro de Estudiante</title>
	<script src="./js/jquery-1.11.2.min.js"></script>
	<script src="./js_admin/modificar_notas.js"></script>
</head>
<body>
	
	<center>
		<form action="admin/proc_mod_notas.php" method="POST" name="Registro">
			<h4>Modificar Nota de Estudiante</h4>
				<input class="campos" name="cod_estudiante" id="cod_estudiante" type="text" maxlength="9" size="20" placeholder="Código Estudiante" required>	
				<input class="campos" id="nombre" name="nombre" type="text" size="40" placeholder="Nombre y Apellido" readonly="readonly" required><br>
				<input class="campos" id="cod_mat" name="cod_mat" type="text" Placeholder="Código Materia" size="20" required>
				<input class="campos" type="text" name="nom_mat" id="nom_mat" placeholder="Nombre de la Materia" readonly="readonly" size="40"><br>
				<input class="campos" id="periodo" name="periodo" type="text" size="20" placeholder="Periodo" required>
				<input class="campos" id="descripcion" name="descripcion" type="text" size="40" placeholder="Descripción del Periodo" readonly="readonly"><br>
				<input class="campos" id="porcentaje" name="porcentaje" type="text" size="10" Placeholder="% Materia" readonly="readonly">
				<input class="campos" id="nota" name="nota" type="text" maxlength="2" size="6" Placeholder="Nota" required>
				<br>
				<input class="boton" type="reset" value="Borrar">
				<input class="boton" type="submit" name="enviar" value="Enviar"><br>
		</form>
	</center>	

</body>
</html>
