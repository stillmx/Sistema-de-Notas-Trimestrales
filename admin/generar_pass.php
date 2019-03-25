<?php

header('Content-Type: text/html; charset=UTF-8');
require_once ("includes/db.php");

$opc_letras = TRUE; //  FALSE para quitar las letras
$opc_numeros = TRUE; // FALSE para quitar los números
$opc_letrasMayus = TRUE; // FALSE para quitar las letras mayúsculas
$opc_especiales = TRUE; // FALSE para quitar los caracteres especiales
$longitud = 10;

 
$letras ="abcdefghijklmnopqrstuvwxyz";
$numeros = "1234567890";
$letrasMayus = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
$especiales =".,#$*?!-_%&";
 $listado ="";
if ($opc_letras == TRUE) {
    $listado .= $letras; }
if ($opc_numeros == TRUE) {
    $listado .= $numeros; }
if($opc_letrasMayus == TRUE) {
    $listado .= $letrasMayus; }
if($opc_especiales == TRUE) {
    $listado .= $especiales; }
str_shuffle($listado);

for($pass='', $n=strlen($listado)-1; strlen($pass) < $longitud;) {
$x=rand(0,$n);
str_shuffle($x);
$pass.= $listado[$x];
}

//echo "<br>".$pass;
//exit();	
$usuario = $_POST['usuario'];


//::::::::::Encriptamos clave::::::::         
	$mx='$stelmas$%/=zeck001mx$/';
	$clave = $mx.sha1(md5($pass));
//::::::::::Validar Variable::::::::::
if(isset ($_POST['cedula'])){
	//:::::::::::Bloquear Usuario:::::::::::::::
	if(!empty($_POST['bloquear'])){
		$consulta=mysql_query("UPDATE usuario SET clave = '$clave', n_intentos=3, r_intentos=3
	 WHERE usuario='$usuario'");
		echo "<script type='text/javascript'>
			alert('EL USUARIO FUE BLOQUEADO');</script>";
		echo" <SCRIPT LANGUAGE='javascript'>location.href = 'include.php?admin=form_generar_clave';</SCRIPT>";

			$email = $_POST['email'];
			$para   = $email;
			$titulo = 'CUENTA ESTÁ BLOQUEADA';
			$mensaje = 'Disculpe, por su seguridad y por la nuestra su'.$titulo. ', '.' para ingresar al Sistema de Notas Trimestrales PNFI'."\n";
			$mensaje .= 'Para desbloquear la cuenta debe comunicarse con el Administrador ';
			$headers = 'From: stillmx@gmail.com' . "\r\n" .
			    'X-Mailer: PHP/' . phpversion();

			mail($para, utf8_decode($titulo), utf8_decode($mensaje), $headers);
		
		exit();
	}
$consulta=mysql_query("UPDATE usuario SET clave = '$clave', n_intentos=0, r_intentos=0
	 WHERE usuario='$usuario'");
	
	if(!$consulta){
		echo"Error de Consulta", mysql_errno(), mysql_error();
		
		if(mysql_num_rows($consulta)==0){
			echo "<script type='text/javascript'>
			alert('NO SE PUDO REALIZAR EL CAMBIO DE CLAVE, LLAME AL SOPORTE TECNICO');</script>";
		exit;
		}
	}else{
			echo "<script type='text/javascript'>
			alert('EL CAMBIO DE CONTRASEÑA SE HA REGISTRADO CON EXITO');</script>";
			echo" <SCRIPT LANGUAGE='javascript'>location.href = 
			'include.php?admin=form_generar_clave';</SCRIPT>";

		}
	}else{
		return false;
	}
$email = $_POST['email'];
$para   = $email;
$titulo = 'CLAVE PROVISIONAL';
$mensaje = 'Aqui te enviamos una '.$titulo. ': '. $pass.' para ingresar al Sistema de Notas Trimestrales PNFI'."\n";
$mensaje .= 'La clave contiene 10 caracteres alfanumericos.';
$headers = 'From: stillmx@gmail.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($para, utf8_decode($titulo), utf8_decode($mensaje), $headers);

?>
