<?php 
header("Content-type: text/html; charset=utf8");
require ('../includes/encabezado.php');
require_once ("../includes/db.php");
echo"bien";
mysql_close($conexion);
?>