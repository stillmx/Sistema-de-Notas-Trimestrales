	<!-- Aqui esta la caja de autenticar-->
<center>	
	<form action="include.php?admin=proc_admon" method="post" name="Ingreso">
		<h4>Registrar Administrador</h4>
			<input class="campos" type="text" name="nombre" maxlength="20" placeholder="Nombre" required>
			<input class="campos" type="text" name="apellido" maxlength="20" placeholder="Apellido" required><br>
			<input class="campos" type="text" name="usuario" maxlength="20" placeholder="Usuario" required>
			<input class="campos" type="password" name="pass" placeholder="Contraseña" required>
			<br>
			<input class="boton" type="submit" name="enviar" value="Enviar"><br>
	</form>
</center>