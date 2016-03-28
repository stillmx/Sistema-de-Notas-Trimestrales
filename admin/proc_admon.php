<?php
require_once ('./includes/db.php');  

		
//:::::::::::Validando la sesion:::::::::::::::
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$usuario = $_POST['usuario'];
$mx='$stelmas$%/=zeck001mx$/';
$clave = $mx.sha1(md5($_POST['pass']));

// "limpiamos" los campos del formulario de posibles códigos maliciosos 
			$nombre = mysql_real_escape_string($nombre);
			$apellido = mysql_real_escape_string($apellido);
            $usuario = mysql_real_escape_string($usuario); 
            $clave = mysql_real_escape_string($clave); 
            
//::::::::::::: Comprobar si nuevo usuario existe::::::::::::::::

$nuevo_usuario=mysql_query("SELECT usuario FROM administrador WHERE usuario='$usuario'"); 

if(mysql_num_rows($nuevo_usuario)>0){
	echo "<script type=\"text/javascript\">alert(\"EL USUARIO YA EXISTE, INTENTE CON OTRO!\");history.go(-1);</script>";
}else{
	
//:::::::::Insertando en la Base de Datos::::::::::::
$sql= "INSERT INTO administrador (nombre, apellido, usuario, clave) VALUES ('$nombre', '$apellido', upper('$usuario'), '$clave')";
}

//:::::::::::Validando la sesion:::::::::::::::

if (mysql_query($sql,$conexion))
{
		echo "<script type=\"text/javascript\">alert(\"EL USUARIO SE HA REGISTRADO CON EXITO\");history.go(-1);</script>";
		
	}else{

    echo "Error, no se pudo conectarse la base de datos\n";
    echo mysql_errno();
    echo mysql_error();
  }
    exit;

mysql_close($conexion);
?>

