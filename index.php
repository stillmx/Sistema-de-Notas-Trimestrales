<?php
session_start();
require_once ('includes/db.php');
//::::::::: "limpiamos" los campos del formulario de posibles códigos maliciosos:::::::::: 
$usuario = mysql_real_escape_string($_POST['usuario']); 
$clave = mysql_real_escape_string($_POST['pass']); 
//::::::::::Encriptamos clave::::::::         
$usuario = $_POST['usuario'];
$mx='$stelmas$%/=zeck001mx$/';
$clave = $mx.sha1(md5($_POST['pass']));
//:::::::::Consultando Base de Datos::::::::::::
$sql= "SELECT usuario,clave,tipo_usuario, cod_estu, cod_prof FROM usuario WHERE usuario = '$usuario' and clave = '$clave' ";
$conecta = mysql_query($sql,$conexion);

if (!$conecta) {
    echo "Error, no se pudo consultar la base de datos\n". mysql_error();
    exit;
}
//::::::::::Comparando Datos:::::::::::
if($fila = mysql_fetch_assoc($conecta)){
	$tipo_usuario=$fila['tipo_usuario'];
	
//::::::::::Creamos la Sesion::::::::::
$_SESSION['usuario_entrar']= $usuario;
$_SESSION['pass']= $clave;
$_SESSION['tipo']= $tipo_usuario;
$_SESSION['id_usuario']=($fila["cod_estu"]==0)?$fila["cod_prof"]:$fila["cod_estu"];
//:::::::::::Validando la sesion:::::::::::::::
if(isset($_SESSION['usuario_entrar'])) {
	//$_SESSION["tiempo"]= time();
	$_SESSION["ultimoAcceso"]= date("Y-n-j H:i:s");
	
}
/*if ($tipo_usuario==1){
	header ('Location: include1.php');
}
else{
	header ('Location: include2.php');
}*/
	header ('Location: include.php');    
}else {
    
			header('Location: error.php');
		}
 
mysql_close($conexion);
?>
