<?php
header("Content-type: text/html; charset=utf8");
//:: No permite ingreso a enlaces directos 
	if(!$_SERVER['HTTP_REFERER']){ 
	header ('Location: error.php');
	}else{
?>
	<script src="./js/jquery-1.11.2.min.js"></script>
	<link rel="stylesheet" href="css/recuperar_pass.css"/>
	<script>
		$(document).ready(function() {
			//Validar contraseña 
			$("#contraseña3").keyup(function() {
		        // crear variable contraseña
		        var pswd = $(this).val();
		        
		        //validar cantidad de caracteres
		        if ( pswd.length >= 8 ) {
		            $('#length').removeClass('invalid').addClass('valid');
		            //$(':submit').removeAttr('disabled');
		        } else {
		        	$('#length').removeClass('valid').addClass('invalid');
		        	//$(':submit').attr({disabled:'disabled'});            
		        }

		        //validar letras minuscula
		        if (pswd.match(/[a-z]/)) {
		            $('#letter').removeClass('invalid').addClass('valid');
		        } else {
		            $('#letter').removeClass('valid').addClass('invalid'); 
		        }

		        //validar letra mayuscula
		        if ( pswd.match(/[A-Z]/) ) {
		            $('#capital').removeClass('invalid').addClass('valid');
		        } else {
		            $('#capital').removeClass('valid').addClass('invalid');
		        }

		        //validar numeros
		        if ( pswd.match(/\d/) ) {
		            $('#number').removeClass('invalid').addClass('valid');
		        } else {
		            $('#number').removeClass('valid').addClass('invalid');
		        }
		        
		        //validar caracter especial
		        if(pswd.match(/[.,#$*!?¿¡_%&]/)){
		        	$('#especial').removeClass('invalid').addClass('valid');
		        } else {
		            $('#especial').removeClass('valid').addClass('invalid');
		        }
		        if((pswd.length<8) && (!pswd.match(/[A-Za-z.,#$*!?¿¡_%&]\d/))){
		        	$(':submit').attr({disabled:'disabled'});
		        }else{
		        	$(':submit').removeAttr('disabled');
		        }


		    }).focus(function() {
		        $('#pswd_info').show();
		    }).blur(function() {
		        $('#pswd_info').hide();

		    });
		});    
	</script>
	
	
		<!-- Aqui esta la caja de autenticar-->
	
		<br>
		
		<center>
		
		<form class="f_clear" name="f_recuperar" id="f_recuperar" action="#" method="post">
			<h4>Cambiar Contraseña</h4>
			<input class="campos" id="contraseña3" name="contraseña" type="password" size="20" placeholder="Contraseña" required><br>
			<div id="pswd_info">
			   <h4>La contraseña debe cumplir con los siguientes requerimientos:</h4>
			   <ul>
			      <li id="letter" class="invalid">Debe tener mínimo <strong>una letra minúscula</strong></li>
			      <li id="capital" class="invalid">Debe tener mínimo <strong>una letra mayúscula</strong></li>
			      <li id="number" class="invalid">Debe tener mínimo<strong>un número</strong></li>
			      <li id="length" class="invalid">Debe tener mínimo <strong>8 carácteres</strong></li>
			   	  <li id="especial" class="invalid">Debe tener mínimo<strong>un carácter especial ejemplo:(! # $ % & ? ¿ ¡ _)</strong></li>
			   	
			   </ul>
			</div>
			<input class="campos" id="contraseña2" name="contraseña2" type="password" size="20" placeholder="Conf. Contraseña" required><br><br>
			<input class="boton" id="boton" type="submit" name="enviar" value="Enviar"/>
			<input type="reset" id="btn_limpiar" name="btn_limpiar" value="Limpiar" style="display:none;" />
			
		</form>
		</center>
		
	
<?php 
require_once ('includes/db.php');
$usuario = $_SESSION["usuario_entrar"];

	//::::::::::Determinar si la variable está definida::::::::::::::::
	if(isset ($_POST['contraseña'])){
	//::::::::: "limpiamos" los campos del formulario de posibles códigos maliciosos:::::::::: 
	$clave1_entrada = addslashes(mysql_real_escape_string($_POST['contraseña']));
	$clave2_entrada = addslashes(mysql_real_escape_string($_POST['contraseña2']));

		if($clave1_entrada !== $clave2_entrada){
			
			echo "<script type='text/javascript'>
			alert('LAS CONTRASEÑAS DEBEN SER IGUALES');</script>";
			
		} exit();
		
	//::::::::::Encriptamos clave::::::::         
	$mx='$stelmas$%/=zeck001mx$/';
	$clave = $mx.sha1(md5($clave1_entrada));
	$consulta=mysql_query("UPDATE usuario SET clave = '$clave', n_intentos=0, r_intentos=0
	 WHERE usuario='$usuario'");
	
	if(!$consulta){
		echo"Error de Consulta", mysql_errno(), mysql_error();
		
		if(mysql_num_rows($consulta)==0){
			echo "<script type='text/javascript'>
			alert('NO SE PUDO REALIZAR EL CAMBIO DE CLAVE, CONSULTE AL ADMINISTRADOR');</script>";
		exit;
		}
	}else{
			echo "<script type='text/javascript'>
			alert('EL CAMBIO DE CONTRASEÑA SE HA REGISTRADO CON EXITO');</script>";
			echo" <SCRIPT LANGUAGE='javascript'>location.href = './';</SCRIPT>";

		}
	}else{
		return false;
	}
} 
?>