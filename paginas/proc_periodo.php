<!-- Aqui comienza mi página web en html -->
<html>
<head>
	<meta charset="UTF-8">
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


$cod_per = $_POST['periodo'];
$des_per = $_POST['descripcion'];


$s_sql="SELECT * FROM periodo WHERE cod_per = '$cod_per'";
	$result_query = mysql_query($s_sql);
		if(mysql_num_rows($result_query)==1){
			$query="UPDATE periodo SET des_per='$des_per' WHERE cod_per = '$cod_per'";
			$actualiza_periodo = mysql_query($query);
			echo "<script type=\"text/javascript\">alert(\"EL PERIODO ".$cod_per." SE ACTUALIZO CORRECTAMENTE\");history.go(-1);</script>";
            //  echo $query,'<br/>';
		}else{
			$query="INSERT INTO periodo (cod_per, des_per) VALUES ('$cod_per', '$des_per')";
		//echo $query,'<br/>';
		$nuevo_periodo = mysql_query($query);
		echo "<script type=\"text/javascript\">alert(\"EL PERIODO ".$nom_per." SE REGISTRO CORRECTAMENTE\");history.go(-1);</script>";
        exit();        
	}    
         
mysql_close($conexion);

?>
