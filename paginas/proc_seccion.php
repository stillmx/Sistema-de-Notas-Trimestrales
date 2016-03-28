<?php 
header("Content-type: text/html; charset=utf8");
require_once "includes/db.php";
$tipoArchivo = $_FILES['archivo']['type'];
$archivo = $_FILES['archivo']['tmp_name'];
$enviar = $_POST['enviar'];
$_SESSION["usuario_enviar"]= $enviar; 

	if($tipoArchivo !='text/csv')
   		{
   			echo "<script type=\"text/javascript\">alert(\"EL ARCHIVO CARGADO ES INVALIDO\");history.go(-1);</script>";
   			exit();
   		}

//:::::::::::Validando la sesion:::::::::::::::
if(isset($_SESSION['usuario_enviar'])) {
	$contando=0;
	//::::::::::Leyendo archivo CSV:::::::::::::
    $abrir = fopen($archivo,"r");
    
    //$alternar=true;
    while (($fileop = fgetcsv($abrir,1000,";")) !== false){
	  $cod_estu = $fileop[0];
	  $cod_per = $fileop[1];
	  $cod_mat = $fileop[2];
	  //$porc_mat = $fileop[3];
	  $cod_prof = $fileop[3];
	  $cod_comp = $fileop[4];
	  //$nota = $fileop[5];
	  //$cod_comp=1;		  
	//$s_sql="SELECT * FROM notas WHERE cod_estu = '$cod_estu' AND cod_comp='$cod_comp' AND cod_per='$cod_per' AND cod_prof='$cod_prof'";
	//$result_query = mysql_query($s_sql);
	$sql="INSERT INTO notas (cod_prof, cod_estu, cod_per, cod_mat, cod_comp) VALUES ($cod_prof, $cod_estu, '$cod_per', '$cod_mat', $cod_comp)";
	$nueva_registro = mysql_query($sql);
		if(mysql_affected_rows()>0)
			$contando++;	
	}//WHILE DEL ARCHIVO     
         //::::::::::Mostrar DB :::::::::::
    $sql= "select * FROM estudiante, notas, materia, profesor WHERE estudiante.cod_estu = notas.cod_estu and notas.cod_comp = materia.cod_comp and profesor.cod_prof=notas.cod_prof ORDER BY notas.cod_estu DESC LIMIT $contando";
	$consulta = mysql_query($sql,$conexion);
	if (!$consulta) {
		die("Error, no se pudo consultar la base de datos\n");  
	}
	echo "<script type=\"text/javascript\">alert(\"SE HA REGISTRADO CON EXITO $contando Inscripciones\");history.go(-1);</script>";
	
}else {
	echo "<script type=\"text/javascript\">alert(\"USTED NO ESTA AUTORIZADO PARA INGRESAR\");</script>";
    echo" <SCRIPT LANGUAGE='javascript'>location.href = 'index.php';</SCRIPT>";
    } 
mysql_close($conexion);
?>
