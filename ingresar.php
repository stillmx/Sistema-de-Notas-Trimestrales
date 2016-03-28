	<div id="contenedor">
		<div id='encabezado'>
			<?php require ('includes/encabezado.php');?>
		</div>
		<!-- Aqui esta la caja de autenticar-->

		<div id='contenido'>
			<br>
			
			<center>

			<form class="form_css" action="index.php" method="post" name="ingreso" >
				<h4><b>Ingresar al Sistema de Notas</b></h4>
				<input id="usuario" class="campos ingreso" type="text" name="usuario" maxlength="20" size="20" placeholder="Usuario" required><br>
				<input id="contraseña" class="campos ingreso" type="password" name="pass" maxlength="20" size="20" placeholder="Contraseña" required><br>
				<br>
				<input class="boton" type="submit" name="enviar" value="Entrar"><br>
			</form>
			
			<div class="registrarse">
				<button class="registrar" id="mostrar">Registrarse</button>
				<!-- <button class="recordar" id="mostrar2">Recordar Contraseña</button> -->
			</div>
			<!--Aqui formulario Registrar -->
			<div id="registrar"></div>
				<div id="contenedorForm">
					<h4>Formulario de Registro</h4>
					<form class="f_clear" name="f_registro" id="f_registro" action="#" method="post">
					<input class="campos" name="cedula" id="cedula" type="text" maxlength="9" placeholder="Nº Cédula" required><br>
					<input type="hidden" id="codigo" name="codigo" value="" />
					<input class="campos" id="nombre" name="nombre" type="text" size="40" placeholder="Nombre y Apellido" readonly="readonly" required><br>
					<input class="campos" id="tipousuario" name="tipousuario" type="text" size="20" placeholder="Tipo de Usuario" readonly=_"readonly" required><br>
					<input class="campos" id="usuario" name="usuario" type="text" size="20" placeholder="Usuario" required>
					<input id="status" name="status" type="text"/><br>
					<input class="campos" id="telf" name="telefono" type="text" maxlength="11" placeholder="Nº Teléfono" required><br>
					<div id="mens_telf" style="display:none;"> El número es invalido </div>
					<input class="campos" id="email" name="email" type="text" size="40" placeholder="Correo Eléctronico" required><br>
					<div id="mens_email" style="display:none;"> El correo es invalido </div>
					<input class="campos" id="contraseña" name="contraseña" type="password" size="20" placeholder="Contraseña" required><br>
					<input class="campos" id="contraseña2" name="contraseña2" type="password" size="20" placeholder="Conf. Contraseña" required><br>
					<input class="campos" id="pregunta" name="pregunta" type="text" size="40" placeholder="Escriba una Pregunta de Seguridad" required><br>
					<input class="campos" id="respuesta" name="respuesta" type="text" size="40" placeholder="Escriba una Respuesta de Seguridad" required><br>
					<input type="hidden" id="evento" name="evento" value="nuevo" />
					<input class="boton" id="boton" type="button" name="enviar" value="Enviar"/>
					<input type="reset" id="btn_limpiar" name="btn_limpiar" value="Limpiar" style="display:none;" />
					</form>
				</div>
			<!--Aqui Recordar Contraseña -->
			<!-- <div id="recordar"></div>
				<div id="contenedorRec">
					<h4>Recordar Contraseña</h4>
					<form class="f_clear" name="f_registro2" id="f_registro2" action="#" method="post">
					<select class="campos" name="tipo_u" id="tipo_u">
						<option value="0">Tipo de Usuario</option>
						<option value="1">Estudiante</option>
						<option value="2">Profesor</option>
					</select><br><br>
					<input class="campos" name="cedula" id="cedula" type="text" maxlength="9" placeholder="Nº Cédula" required><br>
					<input class="campos" id="pregunta" name="pregunta" type="text" size="40" placeholder="Escriba su Pregunta de Seguridad" required><br>
					<input class="campos" id="respuesta" name="respuesta" type="text" size="40" placeholder="Escriba su Respuesta de Seguridad" required><br>
					<input class="boton" id="boton" type="button" name="enviar" value="Enviar"/>
					<input type="reset" id="btn_limpiar" name="btn_limpiar" value="Limpiar" style="display:none;" />
					</form>
					
				</div> -->
			</center>
		</div>

		<div id='pie'>
			<?php require ('includes/pie.php');?>
		</div>
	</div>

	