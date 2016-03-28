	<div id="contenedor">
		<div id='encabezado'>
			<?php require ('includes/encabezado.php');?>
		</div>
		<!-- Aqui esta la caja de autenticar-->

		<div id='contenido'>
			<br>
			
			<center>
			<form class="form_css" action="index2.php" method="post" name="ingreso" >
				<h4 style="color:red"><b>Ingresar al Sistema Administrador</b></h4>
				<input id="usuario" class="campos ingreso" type="text" name="usuario" maxlength="20" size="20" placeholder="Usuario" required><br>
				<input id="contraseña" class="campos ingreso" type="password" name="pass" maxlength="20" size="20" placeholder="Contraseña" required><br>
				<br>
				<input class="boton" type="submit" name="enviar" value="Entrar"><br>
			</form>
			
			
			
			</center>
		</div>

		<div id='pie'>
			<?php require ('includes/pie.php');?>
		</div>
	</div>

	