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
			   
			   $cod_estu = $fileop[0];
			   $ced_estu = $fileop[1];
			   $nom_estu = $fileop[2];
				$carrera = $fileop[3];				   
			   
//::::::::::::: Comprobar si nuevo estudiante existe::::::::::::::::

$nuevo_estudiante=mysql_query("SELECT cod_estu FROM estudiante WHERE cod_estu='$cod_estu'"); 

if(!(mysql_num_rows($nuevo_estudiante)>0)){
	          //::::::::Ingresar Registros::::::::::::
              $nuevo_estudiante = mysql_query("INSERT INTO estudiante (cod_estu, ced_estu, nom_estu, carrera ) VALUES ('$cod_estu', '$ced_estu', '$nom_estu','$carrera')");         
				  $contando++;
			  
			  }else{
				  echo "<script type=\"text/javascript\">alert(\"EL REGISTRO YA EXISTE\");history.go(-1);</script>";
				  exit();
			  }
		  }
			  
	         
         //::::::::::Mostrar, Consultar DB :::::::::::
           $sql= "SELECT * FROM estudiante ORDER BY cod_estu DESC LIMIT $contando";
           
	$consulta = mysql_query($sql,$conexion);

	if (!$consulta) {
    echo "Error, no se pudo consultar la base de datos\n". mysql_error();  
}else{
echo "<script type=\"text/javascript\">alert(\"SE HA REGISTRADO CON EXITO $contando Estudiantes\");history.go(-1);</script>";

}
}
else {
	echo "<script type=\"text/javascript\">alert(\"USTED NO ESTA AUTORIZADO PARA INGRESAR\");</script>";
    echo" <SCRIPT LANGUAGE='javascript'>location.href = 'index.php';</SCRIPT>";
    } 

mysql_close($conexion);
?>
