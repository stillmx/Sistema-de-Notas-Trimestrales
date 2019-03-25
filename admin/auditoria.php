<?php 

if (!$_POST) {


 ?>
</br></br>
<link rel="stylesheet" type="text/css" href="tablas/bootstrap.min.css">
<center>
<form method='post' class='consultar'>
	<select name='seleccion' class="campos">
		<option selected disabled required>Seleccionar...</option>
		<option value='bitacora'>Actividades de Login</option>
		<option value='bitacora_activiades'>Actividades de Usuario</option>
		<option value='bitacora_admin'>Actividades de Administrador</option>
	</select>
	
	<label>General  <input class="campos" type='radio' name='tipo' value='general' required></label>
	<label>Especifica  <input class="campos" type='radio' name='tipo' value='especifico' required></label>
	
	<span class="criterio"></div>
</form>

</center>
<?php }else{
	if($_POST){
		require_once ('includes/db.php');
	
		switch ($_POST['seleccion']) {
			case 'bitacora':
				# code..
			print("<table class ='table' style='background-color:#E8F9FF;'>");
			print("<thead>");
						print("<tr>");
						print("<th>");
						print("Nombre de Usuario");
						print("</th>");
						print("<th>");
						print("Fecha de login");
						print("</th>");
						print("<th>");
						print("Hora de entrada");
						print("</th>");
						print("<th>");
						print("Hora de salida");
						print("</th>");
						print("<th>");
						print("Direccion IP");
						print("</th>");
						print ("</tr>");
			print("</thead>");
			print("<tbody>");
			$tipo=$_POST['tipo'];
				if($tipo=='general'){
					$fecha_inicio=$_POST['fecha_inicio'];
					$fecha_fin=$_POST['fecha_fin'];
					$sql="SELECT * FROM bitacora WHERE fecha_login BETWEEN '".$fecha_inicio."'  AND '".$fecha_fin."';";
					$consulta=mysql_query($sql);
					if($consulta){
					$fila=mysql_num_rows($consulta);
					if($fila==0)
						{
							print("<script>alert('No hay registros');</script>");
							print("<script>window.location.href='include.php?admin=auditoria';</script>	");
							exit;	
						}

					}
					while($resultado=mysql_fetch_array($consulta)){
						print("<tr>");
						print("<td>");
						print($resultado['usuario']);
						print("</td>");
						print("<td>");
						print($resultado['fecha_login']);
						print("</td>");
						print("<td>");
						print($resultado['hora_entrada']);
						print("</td>");
						print("<td>");
						print($resultado['hora_salida']);
						print("</td>");
						print("<td>");
						print($resultado['direccion_ip']);
						print("</td>");
						print("</tr>");
					}
				}else if ($tipo=='especifico') {
					$fecha_inicio=$_POST['fecha_inicio'];
					$fecha_fin=$_POST['fecha_fin'];
					$nombre=$_POST['nombre'];
					$sql="SELECT * FROM bitacora WHERE fecha_login BETWEEN '".$fecha_inicio."' AND '".$fecha_fin."' AND usuario='".$nombre."';";
					$consulta=mysql_query($sql);
					if($consulta)
						{$fila=mysql_num_rows($consulta);
							if($fila==0)
							{
								print("<script>alert('No hay registros');</script>");
								print("<script>window.location.href='include.php?admin=auditoria';</script>	");
								exit;	
							}}
					while($resultado=mysql_fetch_array($consulta)){
					print("<tr>");
						print("<td>");
						print($resultado['usuario']);
						print("</td>");
						print("<td>");
						print($resultado['fecha_login']);
						print("</td>");
						print("<td>");
						print($resultado['hora_entrada']);
						print("</td>");
						print("<td>");
						print($resultado['hora_salida']);
						print("</td>");
						print("<td>");
						print($resultado['direccion_ip']);
						print("</td>");
						print("</tr>");
					}
				}

			break;
			
			case 'bitacora_activiades':
			print("<table class ='table' style='background-color:#E8F9FF;'>");
			print("<thead>");
						print("<tr>");
						print("<th>");
						print("Nombre de Usuario");
						print("</th>");
						print("<th>");
						print("Actividad");
						print("</th>");
						print("<th>");
						print("Fecha");
						print("</th>");
						print("<th>");
						print("Hora de la Actividad");
						print("</th>");
						print("<th>");
						print("Direccion IP");
						print("</th>");
						print ("</tr>");
			print("</thead>");
			print("<tbody>");	
			$tipo=$_POST['tipo'];
				if($tipo=='general'){
					$fecha_inicio=$_POST['fecha_inicio'];
					$fecha_fin=$_POST['fecha_fin'];
					$sql="SELECT * FROM bitacora_actividades WHERE fecha BETWEEN '".$fecha_inicio."'  AND '".$fecha_fin."';";
					$consulta=mysql_query($sql);
					if($consulta){
					$fila=mysql_num_rows($consulta);
					if($fila==0)
						{
							print("<script>alert('No hay registros');</script>");
							print("<script>window.location.href='include.php?admin=auditoria';</script>	");
							exit;	
						}

					}
					while($resultado=mysql_fetch_array($consulta)){
						print("<tr>");
						print("<td>");
						print($resultado['usuario']);
						print("</td>");
						print("<td>");
						print($resultado['actividad']);
						print("</td>");
					    print("<td>");
						print($resultado['fecha']);
						print("</td>");
						print("<td>");
						print($resultado['hora']);
						print("</td>");
						print("<td>");
						print($resultado['direccion_ip']);
						print("</td>");
						print("</tr>");
					}
				}else if ($tipo=='especifico') {
					$fecha_inicio=$_POST['fecha_inicio'];
					$fecha_fin=$_POST['fecha_fin'];
					$nombre=$_POST['nombre'];
					$sql="SELECT * FROM bitacora_actividades WHERE fecha BETWEEN '".$fecha_inicio."' AND '".$fecha_fin."' AND usuario='".$nombre."';";
					$consulta=mysql_query($sql);
					if($consulta)
						{$fila=mysql_num_rows($consulta);
							if($fila==0)
							{
								print("<script>alert('No hay registros');</script>");
								print("<script>window.location.href='include.php?admin=auditoria';</script>	");
								exit;	
							}}
					while($resultado=mysql_fetch_array($consulta)){
						print("<tr>");
						print("<td>");
						print($resultado['usuario']);
						print("</td>");
						print("<td>");
						print($resultado['actividad']);
						print("</td>");
					    print("<td>");
						print($resultado['fecha']);
						print("</td>");
						print("<td>");
						print($resultado['hora']);
						print("</td>");
						print("<td>");
						print($resultado['direccion_ip']);
						print("</td>");
						print("</tr>");
					}
				}

			break;

			case 'bitacora_admin':
			print("<table  class ='table' style='background-color:#E8F9FF;'>");
			print("<thead>");
						print("<tr>");
						print("<th>");
						print("Nombre de Usuario");
						print("</th>");
						print("<th>");
						print("Actividad");
						print("</th>");
						print("<th>");
						print("Fecha");
						print("</th>");
						print("<th>");
						print("Hora de la Actividad");
						print("</th>");
						print("<th>");
						print("Direccion IP");
						print("</th>");
						print ("</tr>");
			print("</thead>");
			print("<tbody>");	
			$tipo=$_POST['tipo'];
				if($tipo=='general'){
					$fecha_inicio=$_POST['fecha_inicio'];
					$fecha_fin=$_POST['fecha_fin'];
					$sql="SELECT * FROM bitacora_admin WHERE fecha BETWEEN '".$fecha_inicio."'  AND '".$fecha_fin."';";
					$consulta=mysql_query($sql);
					if($consulta){
					$fila=mysql_num_rows($consulta);
					if($fila==0)
						{
							print("<script>alert('No hay registros');</script>");
							print("<script>window.location.href='include.php?admin=auditoria';</script>	");
							exit;	
						}

					}
					while($resultado=mysql_fetch_array($consulta)){
						print("<tr>");
						print("<td>");
						print($resultado['usuario']);
						print("</td>");
						print("<td>");
						print($resultado['actividad']);
						print("</td>");
					    print("<td>");
						print($resultado['fecha']);
						print("</td>");
						print("<td>");
						print($resultado['hora']);
						print("</td>");
						print("<td>");
						print($resultado['direccion_ip']);
						print("</td>");
						print("</tr>");
					}
				}else if ($tipo=='especifico') {
					$fecha_inicio=$_POST['fecha_inicio'];
					$fecha_fin=$_POST['fecha_fin'];
					$nombre=$_POST['nombre'];
					$sql="SELECT * FROM bitacora_admin WHERE fecha BETWEEN '".$fecha_inicio."' AND '".$fecha_fin."' AND usuario='".$nombre."';";
					$consulta=mysql_query($sql);
					if($consulta)
						{$fila=mysql_num_rows($consulta);
							if($fila==0)
							{
								print("<script>alert('No hay registros');</script>");
								print("<script>window.location.href='include.php?admin=auditoria';</script>	");
								exit;	
							}}
					while($resultado=mysql_fetch_array($consulta)){
						print("<tr>");
						print("<td>");
						print($resultado['usuario']);
						print("</td>");
						print("<td>");
						print($resultado['actividad']);
						print("</td>");
					    print("<td>");
						print($resultado['fecha']);
						print("</td>");
						print("<td>");
						print($resultado['hora']);
						print("</td>");
						print("<td>");
						print($resultado['direccion_ip']);
						print("</td>");
						print("</tr>");
					}
				}

			break;


		}

	}
	print ("</tbody>
</table>");
} ?>


<script src='js/jquery.1.7.1.js'></script>
<script>
		$(document).ready(function () {
			$('input[type="radio"]').change(function(event){
				event.preventDefault();
				var criterio=$('.criterio');
				if($(this).val()=='general'){
					criterio.html("<input class='campos' type='date' name='fecha_inicio' placeholder='fecha de entrada' required/><input class='campos' type='date' placeholder='fecha de salida' name='fecha_fin' required /><input class='boton' type='submit' value='BUSCAR'>");
				}
				if($(this).val()=='especifico'){
					criterio.html("<input class='campos' type='text' placeholder='Nombre de usuario' name='nombre'/><input class='campos' type='date' placeholder='Desde' name='fecha_inicio'/><input class='campos' type='date' placeholder='Hasta' name='fecha_fin'/><input class='boton' type='submit' value='BUSCAR'>");
				}
			})	

				

		})
</script>