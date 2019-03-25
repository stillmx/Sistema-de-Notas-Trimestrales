<div id="contenedor">
	<div id='encabezado'>
		<?php require ('includes/encabezado.php');?>
	</div>

	<!-- Aqui esta la caja de autenticar-->
	<div id="p_inicio">
		<br>
		<center>

			<form class="form_css" action="index1.php" method="post" name="ingreso" >
				<h4><b>Ingresar al Sistema de Notas</b></h4>
				<input id="usuario" class="campos ingreso" type="text" name="usuario" maxlength="20" size="20" placeholder="Usuario" required><br>
				<input id="contraseña" class="campos ingreso" type="password" name="pass" maxlength="20" size="20" placeholder="Contraseña" required><br>
				<!-- <input class="campos ingreso" type="text" name="captcha" maxlength="5" size="20" placeholder="Ingresa el código" required/>
				<center><img src="captcha/captcha.php" border="0" width="200"/></center> -->
				<input class="boton" type="submit" name="enviar" value="Entrar"><br>
			</form>

			<div class="registrarse">
				<button class="registrar" onclick=location="form_registrar.php">Registrarse</button>
				<button class="recordar" onclick=location="form_recuperar.php">Recordar Contraseña</button>
			</div>
		</center>
	</div>
	<div id='pie'>
		<?php require ('includes/pie.php');?>
	</div>
</div>
