<?php
session_start();

$us_entrada = addslashes($_POST['usuario']);
$cl_entrada  = addslashes($_POST['pass']);




//::::::::::Encriptamos clave::::::::
$usuario = $us_entrada;
$mx='$stelmas$%/=zeck001mx$/';
$clave = $mx.sha1(md5($cl_entrada));
// :::::::::::::::Consultando numero de acceso:::::::
$sql1="SELECT n_intentos, r_intentos FROM usuario WHERE usuario = '$usuario'";
$resp= mysql_query($sql1);
$acceso=mysql_fetch_assoc($resp);
if(($acceso['n_intentos']==3) or ($acceso['r_intentos']==3)){

header("location: error2.php");
exit();
}
if(mysql_num_rows($resp)==0){
	header("location: error.php");
	exit();
}


//:::::::::Consultando Base de Datos::::::::::::
$sql= "SELECT usuario,clave,tipo_usuario, cod_estu, cod_prof
FROM usuario WHERE usuario = '$usuario' and clave = '$clave' ";
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
//$_SESSION['ingresar']=$ingresar;
//:::::::::::Validando la sesion:::::::::::::::
if(isset($_SESSION['usuario_entrar'])) {
	//$_SESSION["tiempo"]= time();
	$_SESSION["ultimoAcceso"]= date("Y-n-j H:i:s");

}
	header ('Location: include.php');
}
else {

    	$cont= $acceso['n_intentos']+1;
    	mysql_query("UPDATE usuario SET n_intentos='$cont' WHERE usuario='$usuario'");
    	if($cont ==1){
    		$mens='INTENTO';
    	}else{
    		$mens='INTENTOS, A LA TERCERA SERA BLOQUEADO';
    	}
    	if($cont==3){
    		header('Location: error2.php');
    		exit();
    	}

    	echo '<script type="text/javascript">
	       alert("EL USUARIO O CLAVE ES INCORRECTA, USTED LLEVA  '.$cont . " ".$mens.'");</script>';

        echo" <SCRIPT LANGUAGE='javascript'>location.href = './';</SCRIPT>";


		}

// }
mysql_close($conexion);
?>
