<?php
	$conexion = mysql_connect("localhost", "root", "still001mx");
	mysql_select_db('notas');
	mysql_set_charset('utf8',$conexion);
if($conexion)
{
	//echo "Usted esta conectado con la base de datos<br><br>";
}else
{
	die (" Error en la conexion". mysql_error());
}

?>
