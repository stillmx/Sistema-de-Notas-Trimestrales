<?php
session_start();
require_once ('includes/db.php');
//::::::::: "limpiamos" los campos del formulario de posibles códigos maliciosos::::::::::
// if(md5($_POST['captcha']) !=$_SESSION['key']){
//     echo "<script type='text/javascript'>
// 	alert('EL CODIGO DEL CAPCHA ES INCORRECTO');</script>";
// 	echo" <SCRIPT LANGUAGE='javascript'>location.href = 'admin.php';</SCRIPT>";
// }
// else{
	$us_entrada = addslashes(mysql_real_escape_string($_POST['usuario']));
	$cl_entrada = addslashes(mysql_real_escape_string($_POST['pass']));

  print_r($us_entrada);
  exit();
	//::::::::::Encriptamos clave::::::::
	$usuario = $us_entrada;
	$mx='$stelmas$%/=zeck001mx$/';
	$clave = $mx.sha1(md5($cl_entrada));
	//:::::::::Consultando Base de Datos::::::::::::
	$sql= "SELECT usuario,clave FROM administrador
	WHERE usuario = '$usuario' and clave = '$clave'";
	$conecta = mysql_query($sql,$conexion);
		if (!$conecta) {
		    echo "Error, no se pudo consultar la base de datos\n". mysql_error();
		    exit;
		}
//::::::::::Comparando Datos:::::::::::
	if($fila = mysql_fetch_assoc($conecta)){
	//::::::::::Creamos la Sesion::::::::::
	$_SESSION['usuario_entrar']= $usuario;
	$_SESSION['pass']= $clave;
	$_SESSION['tipo']= $tipo_usuario;
//:::::::::::Validando la sesion:::::::::::::::
		if(isset($_SESSION['usuario_entrar'])) {
			//$_SESSION["tiempo"]= time();
			$_SESSION["ultimoAcceso"]= date("Y-n-j H:i:s");
		}
	header ('Location: include.php');
	}
	else {
    	echo "<script type='text/javascript'>
	alert('USTED NO ESTA AUTORIZADO PARA INGRESAR');</script>";
    echo" <SCRIPT LANGUAGE='javascript'>location.href = 'admin.php';</SCRIPT>";
		}
// }
mysql_close($conexion);
?>
