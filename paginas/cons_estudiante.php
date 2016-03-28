<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"/>
	<link rel="stylesheet" href="./css/menu.css" type="text/css" />
	<script type="text/javascript" language="javascript" src="./js/jquery-1.11.2.min.js"></script>
	<script src="./js/cons_estudiante.js"></script>
	<title>Control de Notas Trimestrales PNFI</title>
</head>	
<body>
	<center>
		<form action="include.php?pagina=reporte_estudiante" method="POST" name="Registro">
			<h4>Consultar Estudiante</h4>
				<div class="estudiante">
				<!--
					<input class="campos" id="estudiante" name="estudiante" type="text" maxlength="9" size="15" placeholder="C.I. Estudiante">
					<input class="campos" id="nombre" name="nombre" type="text" value="" size="40" placeholder="Apellido y Nombre" readonly="readonly">
					<br><br>
				-->
					
					<label for="periodo" class="t">Todos los Periodos</label> 
					<input type="radio" name="periodo" id="periodo" value="1" checked="checked"/>
					<label for="periodo">Por Periodos</label>
					<input type="radio" name="periodo" id="periodo2" value="2"/><br>
					<select class="campos" id="lapsodesde" name="lapsodesde">
						<option value="">Desde</option>
					</select>
					<select class="campos" id="lapsohasta" name="lapsohasta">
						<option value="">Hasta</option>
					</select>
					<br><br>
					<input align="left" class="boton" type="submit" name="enviar" value="Enviar">
				</div>
		</form>
	</center>
</body>
</html>
