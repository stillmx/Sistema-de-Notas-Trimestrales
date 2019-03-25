<?php 
//:: No permite ingreso a enlaces directos 
	session_start();
	if(!$_SERVER['HTTP_REFERER']){ 
	header ('Location: error.php');
	}else{
//::: LLamado de los includes 
?>
<div id="contenedor">
	<div id='encabezado'>
		<?php require ('includes/encabezado.php');?>
	</div>
	<div id='contenido'>
		<?php 
			
		//session_start();
			require_once ('includes/db.php');
		//:::::::::::Validamos el Capcha::::::::::::::::::::::::::
			if(md5($_POST['captcha']) !=$_SESSION['key']){
		    	echo "<script type='text/javascript'>
				alert('EL CODIGO DEL CAPCHA ES INCORRECTO');</script>";
				echo" <SCRIPT LANGUAGE='javascript'>location.href = './';</SCRIPT>";
			}
			else{
				//::::::::: "limpiamos" los campos del formulario de posibles códigos maliciosos:::::::::: 
				$ci_entrada = addslashes(mysql_real_escape_string($_POST['cedula'])); 
				$us_entrada = addslashes(mysql_real_escape_string($_POST['usuario2']));
				$preg_entrada = addslashes(mysql_real_escape_string($_POST['pregunta'])); 
				$resp_entrada  = addslashes(mysql_real_escape_string($_POST['respuesta'])); 
				//:::::::::::::Verificacion del usuario:::::::::::
				if(($_POST['usuario']) !== ($_POST['usuario2'])){
					$usuario = $_POST['usuario'];
					$sql1="SELECT r_intentos, n_intentos FROM usuario WHERE usuario = '$usuario'";
					$resp= mysql_query($sql1);
					$acceso=mysql_fetch_assoc($resp);
					if(($acceso['n_intentos']==3) or ($acceso['r_intentos']==3)){
						header("location: error2.php");
						exit();
					}else{
						$cont= $acceso['r_intentos']+1;
			    	mysql_query("UPDATE usuario SET r_intentos='$cont' WHERE usuario='$usuario'");
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
					alert("EL USUARIO ES INCORRECTO, USTED LLEVA '.$cont. " " .$mens.'");
					</script>';

					}

				}

				//::::::::::Encriptamos clave::::::::         
				$usuario = $us_entrada;
				$pregunta = $preg_entrada;
				$mx='$stelmas$%/=zeck001mx$/';
				$respuesta = $mx.sha1(md5($resp_entrada));
				// :::::::::::::::Consultando numero de acceso:::::::
				$sql1="SELECT r_intentos, n_intentos FROM usuario WHERE usuario = '$usuario'";
				$resp= mysql_query($sql1);
				$acceso=mysql_fetch_assoc($resp);
				if(($acceso['n_intentos']==3) or ($acceso['r_intentos']==3)){
				header("location: error2.php");
				exit();
				}
				/*if(mysql_num_rows($resp)==0){
					header("location: error.php");
					exit();
				}*/

				//:::::::::Consultando Base de Datos::::::::::::
				$sql= "SELECT pregunta, respuesta,usuario 
				FROM usuario WHERE pregunta = '$pregunta' and respuesta = '$respuesta' 
				and usuario = '$usuario' ";

				$conecta = mysql_query($sql,$conexion);
				if (!$conecta) {
				    echo "Error, no se pudo consultar la base de datos\n". mysql_error();
				    exit;
				}

				if(mysql_num_rows($conecta)==1){
					header ('Location: cambiar_clave.php?usuario='.$_POST["usuario2"]);  
				}
				else {
					
			    	$cont= $acceso['r_intentos']+1;
			    	mysql_query("UPDATE usuario SET r_intentos='$cont' WHERE usuario='$usuario'");
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
					alert("LA PREGUNTA O RESPUESTA ES INCORRECTA, USTED LLEVA '.$cont. " " .$mens.'");
					</script>';
			   	     
			    	echo" <SCRIPT LANGUAGE='javascript'>location.href = 'form_recuperar.php';</SCRIPT>";

				}

			}
			mysql_close($conexion);
		?>
	</div>
	<div id='pie'>
		<?php require ('includes/pie.php');}?>
	</div>
</div>
