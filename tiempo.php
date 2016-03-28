<?php
//::::::::: No permite ingreso a enlaces directos 
if(!$_SERVER['HTTP_REFERER']){ 
	header ('Location: error.php');
}else{

//::::::::::calculamos el tiempo transcurrido
/*
$inactivo = 10;
 
    if(isset($_SESSION['tiempo']) ) {
    $vida_session = time() - $_SESSION['tiempo'];
        if($vida_session > $inactivo)
        {
            session_destroy();
            echo "<script language='javascript'>window.location='ingresar.php'</script>"; 
            //header('Location: ingresar.php'); 
        }
    }
 }
    $_SESSION['tiempo'] = time();

    */
	//::::::calculamos el tiempo transcurrido 
	if(isset($_SESSION["ultimoAcceso"])){
		$fechaGuardada =$_SESSION["ultimoAcceso"]; 
		$ahora = date("Y-n-j H:i:s"); 
		//::::::::::::::: strtotime para cambiar date a segundos
		$tiempo_transcurrido = (strtotime($ahora) - strtotime($fechaGuardada));
		//::::::::::::::::::::comparamos el tiempo transcurrido 
		//::::::::::::Para colocar el tiempo en segundos de multiplica minutos *60 Ej: 3min. 3*60=180
	}
     if(!isset($tiempo_transcurrido) || $tiempo_transcurrido >= 1200) { 
		//::::::::::::::::si se pasa del tiempo transcurrido
		session_destroy(); 

     	echo "<script type=\"text/javascript\">alert(\"SU TIEMPO FINALIZADO\");</script>";
		
		//echo "<script language='javascript'> location.reload();</script>";
		echo "<script language='javascript'>window.location='ingresar.php';</script>";
		//header('Location: ingresar.php');
		//::::::::::::::::::::sino, se actualiza el tiempo de la sesión 
    }else { 
		$_SESSION["ultimoAcceso"] = $ahora; 
   } 
}

?>