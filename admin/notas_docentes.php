<script src="./js/jquery-1.11.2.min.js"></script>
<script src="./js/jquery.validate.js"></script>

<script>
	$(document).ready(function() {
		
		$(':text.validate_nota',$('#notas')).bind('blur',function(e){
			e.preventDefault();
			e.stopPropagation();
			var _t = $(this);
			var n = $(_t).val();
			console.log("aq");
			if(n>=0 && n<=20 && n.trim()!=''){
				return false;
			}else{
				$(_t).val('');
				$(_t).focus();
				alert("Debe elegir una nota entre 0 y 20");
			}
			
		});
		$('#porcentaje',$('#notas')).bind('blur',function(){
			
			var p = $('#porcentaje').val();
			
			if(p>1 && p<=100)
				return false;
			else	{
				alert("Debe elegir una % entre 0 y 100");
			$('#porcentaje').val('');
		}
		});
		var vf_notas=$("#notas").validate({
			rules:{porcentaje:{required:true, range:[1,100]}},
			messages:{
				porcentaje:{required:"Es obligatorio el %", 
				range:"Ingrese un valor de 1 a 100"}
			}
		});
	});
</script>
<form name="form_notas" action="./include.php?admin=guardar_notas" method="post">
<?php
if(isset($_POST['profesor'], $_POST['materia']) && !empty($_POST['profesor'])  && !empty($_POST['materia']) ){
	require_once ("./includes/db.php");
	$filtro=is_numeric(substr($_POST['profesor'],0,1))?"p.cod_prof=".$_POST['profesor']:"p.ced_prof='".$_POST['profesor']."'";
	//Datos del profesor
	$sql="SELECT p.cod_prof, p.nom_prof FROM profesor AS p WHERE ".$filtro;
	$consulta= mysql_query($sql, $conexion) or die($sql);
	if(!$consulta){
		echo"Error de Consulta", mysql_errno(), mysql_error();
		exit;
	}
	$num_rows=mysql_num_rows($consulta);
	if($num_rows==1)
		$docente=mysql_fetch_assoc($consulta);
	$cod_mat=$_POST['materia'];
	//Datos de la nomina asignada al profesor con los datos del alumno	
	$sql="SELECT p.ced_prof, p.nom_prof, m.nom_mat, m.uc_mat, n.cod_estu, n.cod_per, n.cod_mat, e.ced_estu, e.nom_estu, n.nota, n.porc_mat FROM notas AS n LEFT OUTER JOIN estudiante AS e ON e.cod_estu=n.cod_estu LEFT OUTER JOIN materia AS m ON m.cod_comp=n.cod_comp LEFT OUTER JOIN profesor AS p ON p.cod_prof=n.cod_prof WHERE n.cod_prof=".$docente['cod_prof']." AND n.cod_mat='".$cod_mat."' AND ISNULL(n.nota)";
	$consulta= mysql_query($sql, $conexion) or die($sql);
	if(!$consulta){
		echo"Error de Consulta", mysql_errno(), mysql_error();
		exit;
	}
	if(mysql_num_rows($consulta)>0){
		$cod_mat=$_POST['materia']; 
		$profesor=mysql_fetch_assoc($consulta);
		$consulta= mysql_query($sql, $conexion) or die($sql);
		if(!$consulta){
			echo"Error de Consulta", mysql_errno(), mysql_error();
			exit;
		}	
		$contador=0;
		while($fila = mysql_fetch_assoc($consulta)){
			$contador2 = $contador / 2;
		if(is_int($contador2)) { 
			$estilo = 'bg2'; 
		} else {
			$estilo = 'bg1'; 
		}
			if(!isset($print_header)){
				echo"<div class='profesor'><h2>Datos del Profesor:</h2></div>";
				echo "<input type='hidden' name='cod_per' id='cod_per' value='"
				.$fila['cod_per']."'><input type='hidden' name='cod_mat' id='cod_mat' value='"
				.$_POST['materia']."'><input type='hidden' name='cod_prof' id='cod_prof' value='"
				.$docente['cod_prof']."' >";
				echo "<div class='datos'><b>Cédula: </b>".$fila['ced_prof']."<b>Nombre y Apellido: </b>
				".$fila['nom_prof']."<b>Materia: </b>".$fila['nom_mat']."<b>U.C: </b>
				".$fila['uc_mat']."<b>Porc. Materia: </b><input type='text' class='campos' 
				name='porcentaje' maxlength='3' style='width:50px;' id='porcentaje' value='".$fila['porc_mat']."'>"."</div>";
				
				
				echo"<br>";
				echo"<div class='estudiante'><h2>Datos del Estudiante:</h2></div>";
				echo "<div class='datos'><b>Periodo: </b>
				".$fila['cod_per']."<b>Sección: </b>
				".$fila['cod_mat']."</div>";
				echo "<br><br>";
				echo "<br><div class='datos'><div class='codigo'><b>Código</div>
				<div class='cedula'>Cédula</div><div class='apellido'>
				Apellidos y Nombres</div><div class='nota'>Nota:</b></div></div>";
				
				$print_header=true;
			}
			
			echo "<div class='datos'><div class='$estilo'><div class='codigo'>"
			.$fila['cod_estu']."</div><div class='cedula'>".$fila['ced_estu']
			."</div><div class='apellido'>".$fila['nom_estu']
			."</div><input class='campos validate_nota' id='nota' type='text' style='width:50px;' 
			value='' maxlength='2' name='nota[".$fila['cod_estu']."]' required></div></div>";
			$contador++;
		}
		echo "<input type='submit' name='enviar' class='boton' id='enviar' value='Registrar'>";
	}else
		echo "No existen alumnos para este Profesor en la materia a buscar";
	mysql_close($conexion);
}
?>
</table>
</form>
