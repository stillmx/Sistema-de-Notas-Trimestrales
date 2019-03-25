<?php 
header("Content-type: text/html; charset=utf8");
require_once "includes/db.php";
$nombreArchivo = $_FILES['archivo']['name'];
$tipoArchivo = $_FILES['archivo']['type'];
$archivo = $_FILES['archivo']['tmp_name'];
$enviar = $_POST['enviar'];
$_SESSION["usuario_enviar"]= $enviar; 

if($tipoArchivo !='text/csv' || $nombreArchivo !='inscripcion.csv'){
	echo "<script type=\"text/javascript\">alert(\"EL ARCHIVO CARGADO ES INVALIDO\");history.go(-1);</script>";
	exit();
}
//:::::::::::Validando la sesion:::::::::::::::
if(isset($_SESSION['usuario_enviar'])) {

	//::::::::::Leyendo archivo CSV:::::::::::::
    $abrir = fopen($archivo,"r");
    
    //$alternar=true;
    $cont=0;
    $consulta = ($conexion);
	if(!$consulta) {
    echo "Error, no se pudo consultar la base de datos\n". mysql_error();
    while (($fileop = fgetcsv($abrir,0,";")) !== false){
		$cod_estu = $fileop[0];
		$cod_mat = $fileop[1];
	  	$cod_prof = $fileop[2];
	  	$cod_comp = $fileop[3];
	  	$dato = mysql_query("SELECT cod_per FROM periodo ORDER BY cod_per DESC LIMIT 1");
	  	$dato2= mysql_fetch_assoc($dato);
	  	$cod_per=$dato2['cod_per'];
	  	$inscripcion = mysql_query("SELECT * FROM notas WHERE cod_estu ='$cod_estu' 
	  	AND cod_prof='$cod_prof' AND cod_comp='$cod_comp' AND cod_per='$cod_per'");
	  			
	  	if(mysql_num_rows($inscripcion)==0){
			$cont++;
			
		 	$inscripcion=mysql_query("INSERT INTO notas (cod_prof, cod_estu, cod_per,
		 	cod_mat, cod_comp) VALUES ($cod_prof, $cod_estu, '$cod_per', '$cod_mat', 
		 	$cod_comp)");
		}
	}

	}	 	
	
	if($cont != 0){
		if($cont ==1){
			echo "<script type=\"text/javascript\">alert(\"SE HA REGISTRADO: $cont Inscripción\");history.go(-1);</script>";
		}
		echo "<script type=\"text/javascript\">alert(\"SE HA REGISTRADO: $cont Inscripciones\");history.go(-1);</script>";
	}
	else{
		echo "<script type=\"text/javascript\">alert(\"EL REGISTRO DE INSCRIPCIONES YA EXISTE!\");history.go(-1);</script>";				 
	}               
	
}
else {
	echo "<script type=\"text/javascript\">alert(\"USTED NO ESTA AUTORIZADO PARA INGRESAR\");</script>";
    echo" <SCRIPT LANGUAGE='javascript'>location.href = 'index.php';</SCRIPT>";
} 

mysql_close($conexion);
?>
	