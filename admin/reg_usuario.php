<!-- Aqui comienza mi página web en html -->
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, user-scalable=no"/>
	<title>Control de Notas Trimestrales PNFI</title>
	<link rel="stylesheet" href="css/bootstrap.min.css"/>
	<link rel="stylesheet" href="css/menu.css"/>

<body>
	<center>
	<!-- Aqui esta la caja de autenticar-->
		<br><br>
		<h1>Registrar Usuario</h1>

<table width="90%" id='formulario'>
<tr>
<form action="include.php?admin=proc_admon" method="post" name="Ingreso">
<td style="text-align:right;">Usuario: </td><td> <input class="campos" type="text" name="usuario" maxlength="20" placeholder="PNFI" required></td><br>
<tr><td style="text-align:right;">Contraseña:</td><td> <input class="campos" type="password" name="pass" placeholder="*******" required></td><br>
<br>
</tr>
<tr><th colspan="2" align="right">
<input class="boton" type="reset" value="Borrar">
<input class="boton" type="submit" name="enviar" value="Enviar"><br>

</form>
</th>
</tr>
</tr>
</table>


	</div>

</center>
</body>

</html>
