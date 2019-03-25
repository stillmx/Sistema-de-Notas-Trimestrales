		<!-- Aqui esta la caja de autenticar-->
		


		<div id='contenido'>
			<br>
			
			<center>
			
			<form class="f_clear" name="f_activar" id="f_activar" action="include.php?admin=activar_notas" method="post">
				<h4>Activar Ingreso de Notas</h4>
				<input class="campos" name="fecha_ini" id="fecha_ini" type="date" value="<?php echo date("Y-m-d");?>" required>
				<label style="color:#05258c;">Fecha Inicio</label><br>
				<input class="campos" name="fecha_fin" id="fecha_fin" type="date" value="<?php echo date("Y-m-d");?>" required>
				<label style="color:#05258c;">Fecha Final</label><br>
				<input class="campos" id="bloquear" name="bloquear" type="checkbox"/>
				<label style="color:red;">Seleccione si desea bloquear el ingreso de notas</label> 
				<br><br>
				<input class="boton" id="boton" type="submit" name="enviar" value="Enviar"/>
				<input type="reset" id="btn_limpiar" name="btn_limpiar" value="Limpiar" style="display:none;" />
				
			</form>
			</center>

	

