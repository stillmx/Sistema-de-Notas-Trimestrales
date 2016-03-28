<?php
	require_once ("./includes/db.php");
	$usuario=$_SESSION['usuario_entrar'];
	
	$sql="SELECT usuario FROM usuario where usuario = '$usuario'";

	$resultado = mysql_query($sql, $conexion);
		if(!$resultado){
		echo"Error de Consulta", mysql_errno(), mysql_error();
		exit;
	}
		while($fila = mysql_fetch_assoc($resultado)){
			//echo $fila['nombre'].$fila['apellido'];
	echo"<div class='contenido'>Bienvenid@: "."<b>"
	." ".$fila['usuario']."</b>"." "."</div>";
}
	?>


