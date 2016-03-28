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
           while (($fileop = fgetcsv($abrir,0,";")) !== false){
			   
			   $cod_prof = $fileop[0]; //Codigo Profesor
			   $ced_prof = "$fileop[1]"."$fileop[2]"; //V, Cedula profesor
			   $nom_prof = "$fileop[3]"." , "."$fileop[4]"; // Nombre y Apellido Profesor
			   //$tit_prof = $fileop[5]; // Titulo Profesor
			   //$ce_prof = $fileop[6]; // Correo Electronico Profesor 
			   //$tel_prof = $fileop[7]; // Telefono Profesor
			   //$nota = $fileop[6];
			   
			   
			  //::::::::::::: Comprobar si nuevo profesor existe::::::::::::::::

$nuevo_profesor=mysql_query("SELECT cod_prof FROM profesor WHERE cod_prof='$cod_prof'"); 

if(mysql_num_rows($nuevo_profesor)==0){
	          //::::::::Ingresar Registros::::::::::::
              $nuevo_profesor = mysql_query("INSERT INTO profesor (cod_prof, ced_prof, nom_prof)
              VALUES ('$cod_prof', '$ced_prof', '$nom_prof')");         
				  $contando++;
			  	  
			  }
		  }
			
	         
         //::::::::::Mostrar, Consultar DB :::::::::::
           $sql= "SELECT * FROM profesor ORDER BY cod_prof DESC LIMIT $contando";
           
	$consulta = mysql_query($sql,$conexion);

	if (!$consulta) {
    echo "Error, no se pudo consultar la base de datos\n". mysql_error();  
}
	if($contando==0){
		echo "<script type=\"text/javascript\">alert(\"EL REGISTRO YA EXISTE\");history.go(-1);</script>";

	}else{
		echo "<script type=\"text/javascript\">alert(\"SE HA REGISTRADO CON EXITO $contando Profesores\");history.go(-1);</script>";
	}
}
else {
	echo "<script type=\"text/javascript\">alert(\"USTED NO ESTA AUTORIZADO PARA INGRESAR\");</script>";
    echo" <SCRIPT LANGUAGE='javascript'>location.href = 'index.php';</SCRIPT>";
    } 
 
mysql_close($conexion);
?>
