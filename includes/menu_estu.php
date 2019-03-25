<?php 
	require_once "includes/db.php";

	$dato = mysql_query("SELECT ced_estu FROM estudiante WHERE cod_estu = ".$_SESSION['id_usuario']);
	  $dato2= mysql_fetch_assoc($dato);
	  $cedula=$dato2['ced_estu'];
	  //echo $cedula;

	  $dato3 = mysql_query("SELECT cod_estu FROM estudiante WHERE ced_estu= '$cedula'");
	  
	  while($consulta= mysql_fetch_assoc($dato3)){
	  	if($consulta["cod_estu"]!=$_SESSION['id_usuario'])
	  	$codigo_2= $consulta["cod_estu"];	

		}


	  
?>


<!-- Inicio del Menu -->


<ul>
    
	<li class='nivel1'><a href='#'>Consultar</a>
	<ul>
		<li><a href="include.php?pagina=cons_estudiante">Código <?php echo $_SESSION['id_usuario']; ?></a></li>
		<?php 
			if(isset($codigo_2))
		echo"<li><a href='include.php?pagina=cons_estudiante2'>Código " .$codigo_2."</a></li>";?>
	</ul></li>
	
	<li class="nivel1"><a href="#">Modificar</a>
		<ul>
			<li><a href="include.php?pagina=cambiar_clave_usuario">Contraseña</a></li>
			<li><a href="include.php?pagina=cambiar_pregunta_usuario">Pregunta Secreta</a></li>
		</ul>
	</li>

	
  
  <!--<li class="nivel1"><a target="_blank" href="manual.pdf">Ayuda</a></li>-->
  
</ul>

<!-- Fin del Menu -->
