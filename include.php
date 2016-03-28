<?php 
//:: No permite ingreso a enlaces directos 
session_start();
if(!$_SERVER['HTTP_REFERER']){ 
header ('Location: error.php');
}else{
//::: LLamado de los includes 
?>

<div id='contenedor'>	
	<div id='encabezado'>
		<?php
			require ('includes/encabezado.php');
			echo"<div class='control'>Bienvenid@: "."<b>".$_SESSION['usuario_entrar']."</b>"." ".
			"<a href='salir.php'><button class='salir' type='submit'> Salir</button></a></div>";
		?>
		
	</div>
	
	<div id='menu'>
		<?php 

		if($_SESSION['tipo']==1){
			require ('includes/menu_prof.php');
		}
		elseif($_SESSION['tipo']==2){
			require ('includes/menu_estu.php');
		}
		else{
			require ('includes/menu.php');
		}

		?>	
	</div>

	<div id='contenido'>
		<?php
		if(($_SESSION['tipo']==1) or ($_SESSION['tipo']==2)){
		 require ('includes/paginas.php');
		}
		else{
			require ('includes/p_admin.php');
		}
		 ?>
		<br style='clear:both;'/>	
	</div>

	<div id='pie'>
		<?php require ('includes/pie.php');?>	
	</div>
</div>
<?php }?>
