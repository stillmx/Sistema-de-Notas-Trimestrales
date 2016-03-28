<!-- Aqui comienza mi página web en html -->
<html>
<head>
	<meta http-equiv="content-type" content="text/html" charset="UTF-8">
	<link rel="stylesheet" href="../css/menu.css" type="text/css" />
	<title>Control de Notas Trimestrales PNFI</title>
</head>

<body>
	<div id='encabezado'>
	<?php echo"<br>"."<table class='logo'><tr><td>
	<img src='imagenes/pnfi.jpg'width='140' hight='80'></td><td><h2><b>Sistema de Notas Trimestrales PNFI - IUTAG</b>
	</h2></td></tr></table>";
	?>
	</div>
	<!-- Aqui esta la caja de autenticar-->

	<div id='contenido'>
	</div>
	<div id='pie'>
	<?php require ('../includes/pie.php');?>
	</div>
<?php
require_once "../includes/db.php";

$cod = $_POST['codigo'];
$nom = $_POST['nombres'];
$ape = $_POST['apellidos'];
$ced = $_POST['ced'];
$fnac = $_POST['f_nac'];
$tel1 = $_POST['cel_1'];
$tel2 = $_POST['cel_2'];
$nom_r = $_POST['nom_r'];
$fing = $_POST['f_ing'];
$insc = $_POST['inscripcion'];
$mes = $_POST['mes1'];

$s_sql="SELECT * FROM notas AS n WHERE !ISNULL(n.nota) AND n.cod_estu=$cod_estu AND n.cod_mat='".$cod_mat."' AND n.cod_per='".$cod_per."'";
$result_query = mysql_query($s_sql, $conexion) or die($s_sql);
if(mysql_num_rows($result_query)==1){
	$query="UPDATE notas SET nota='".$nota."' WHERE !ISNULL(nota) AND cod_estu=".$cod_estu." AND cod_mat='".$cod_mat."' AND cod_per='".$cod_per."'";
	$actualiza_nota = mysql_query($query, $conexion) or die($query);
	$actualizo=mysql_affected_rows();
	echo "<script type=\"text/javascript\">alert(\"LA NOTA DEL ESTUDIANTE ".$_POST['nombre']." SE ACTUALIZO CORRECTAMENTE\");history.go(-1);</script>";
           //  echo $query,'<br/>';
}else
	echo "<script type=\"text/javascript\">alert(\"NO EXISTE REGISTRO DE NOTA DEL ESTUDIANTE ".$nom_estu."\");history.go(-1);</script>";         
mysql_close($conexion);
?>
