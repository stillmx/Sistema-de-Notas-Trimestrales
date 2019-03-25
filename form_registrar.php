<div id="contenedor">
	<div id='encabezado'>
		<?php require ('includes/encabezado.php');?>
	</div>
	<script src="./js/jquery-1.11.2.min.js"></script>
	<script src="./js/jquery.validate.js"></script>
	<link rel="stylesheet" href="css/pass.css"/>
	<script>
		$(document).ready(function() {
			$("#cedula").bind("focus", function(e){
			var value=$.trim($(this).val());
			if(value.length==0)
			$(this).val("V");
		})				
		$("#cedula", $("#f_registro")).on('blur', function(){
			var _this=$(this);
			var valor=$.trim($(this).val());
			if(valor=="")
			return -1;
			$.ajax({
				type:'POST',
				dataType:'json', 
				data:$(_this).serialize(), 
				url:'registrar.php', 
				beforeSend:function(){
					//$(":text, :submit", $("#f_registro")).attr({disabled:"disabled"});				
				}, 
				success:function(data){
					if(data.success && data.num_rows==1){
						if(data.mensaje!=""){
							alert(data.mensaje);
							$(":reset", $("#f_registro")).trigger("click");
							return -1;
						}
						$(":text", $("#f_registro")).removeAttr("disabled");
						$.each(data.info, function(i,e){ $("#"+i).val(e); });
					}
					else{
						alert("No coinciden registro con la cedula indicada");
						$(":reset", $("#f_registro")).trigger("click");
					}
						
				}
			});

		});
		
	/*$("#telf, #email").blur(function(){
		var expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;	
		var expr2 = /^([0-9]+){11}$/;	
		var telef = $("#telf").val();
		var email = $("#email").val();
		if(telef.trim() =="" || !expr2.test(telef)){
			$("#mens_telf").fadeIn("slow");
			
			return false;
		}
		else{
			$("#mens_telf").fadeOut("slow");
			
			if(email.trim() =="" || !expr.test(email)){
			$("#mens_email").fadeIn("slow");
			return false;
			}
			else{
				
				$("#mens_email").fadeOut("slow");
				
			}
		}
	});*/

	
	$("#usuario", $("#f_registro")).bind("blur", function(){
		$.ajax("registrar.php", {
			type:'POST',
			dataType:'json', 
			data:{
				evento:"validar_usuario", tipousuario:function(){
					return $("#tipousuario", $("#f_registro")).val();}, 
					usuario:function(){return $("#usuario").val();}},
					success:function(data){
						if(data.num_rows==0){
							$("#status").css("color", "green");
						}else{
							$("#status").css("color", "red");
						}
						$("#status").val(data.status);
					}			
							
					
		});
	});
	var f_validate= $("#f_registro").validate({onSubmit:false,
 		rules: {
 			cedula: {required: true},
 			nombre: {required: true},
 			usuario: {required: true, minlength: 5},
 			/*telf: {required: true, maxlength: 9},
 			email: {required:true, email: true}, */
 			contraseña3:{required:true, minlength: 8}, 
 			contraseña2:{equalTo:"#contraseña3"}},
        messages: {
        	cedula: {required:"Debe introducir un numero C.I. válido"}, 
        	nombre: {required:"introducir un nombre válido"},
	    	usuario: {required:"Debe introducir un nombre de usuario.", minlength:"El usuario debe tener un mínimo de 5 letras"},
	    	/*telf: {required:"Introduzca un número de  Teléfono", maxlegth:"El numero debe tener 9 caracteres."},
	    	email: {required:"Email es obligatorio", email:"Debe introducir un email válido."}, */
	    	contraseña3:{required:"Introduzca la contraseña", minlength: "Debe tener un minimo de 8 caracteres"}},
		submitHandler: function(form){
			var confirmar = confirm("¿Está seguro que sus datos estan completos?");
			if(confirmar == true){
		        $.ajax("registrar.php", {
					type:'POST', dataType:'json', data:$("#f_registro").serialize(),
					beforeSend:function(){
						//$(":text, :submit", $("#f_registro")).attr({disabled: "disabled"});
					},
					success:function(d, t, jxhr){
						console.log(d);
						$(":text, :submit", $("#f_registro")).val()!="";
						if(d.success && (d.affected_rows==1 || d.num_rows==1))
							alert(d.mensaje);
						$(":reset", $("#f_registro")).trigger("click");
							location.href = './';
					}
				});

	       }else return false;
        }
    });	

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
		


		<div id='contenido'>
			<br>
			
			<center>
			
			<form class="f_clear" name="f_registro" id="f_registro" action="#" method="post">
				<h4>Formulario de Registro</h4>
				<input class="campos" name="cedula" id="cedula" type="text" maxlength="9" placeholder="Nº Cédula" required><br>
				<input type="hidden" id="codigo" name="codigo" value="" />
				<input class="campos" id="nombre" name="nombre" type="text" size="40" placeholder="Nombre y Apellido" readonly required><br>
				<input class="campos" id="tipousuario" name="tipousuario" type="text" size="20" placeholder="Tipo de Usuario" readonly required><br>
				<input class="campos" id="usuario" name="usuario" type="text" size="20" placeholder="Usuario" >
				<input id="status" name="status" type="text" style="border:none; background:none;"/><br>
				<!-- <input class="campos" id="telf" name="telefono" type="text" maxlength="11" placeholder="Nº Teléfono" ><br>
				<div id="mens_telf" style="display:none;"> El número es invalido </div>
				<input class="campos" id="email" name="email" type="text" size="40" placeholder="Correo Eléctronico" ><br>
				<div id="mens_email" style="display:none;"> El correo es invalido </div> -->
				<input class="campos" id="contraseña3" name="contraseña" type="password" size="20" placeholder="Contraseña"><br>
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
				<input class="campos" id="contraseña2" name="contraseña2" type="password" size="20" placeholder="Conf. Contraseña"><br>
				<select class="campos" id="pregunta" name="pregunta" required>
					<option value="" selected>Selecciona una pregunta de seguridad</option>
					<option value="Color Favorito">Color Favorito</option>
					<option value="Lugar para vacacionar">Lugar para vacacionar</option>
					<option value="Actor o actriz que te guste">Actor o actriz que te guste</option>
					<option value="Canción favorita">Canción favorita</option>
					<option value="Nombre maestra de primaria">Nombre maestra de primaria</option>
				</select><br>
				<input class="campos" id="respuesta" name="respuesta" type="text" size="40" placeholder="Escriba una Respuesta de Seguridad" required><br>
				<!--<input class="campos" id="pregunta" name="pregunta" type="text" size="40" placeholder="Escriba una Pregunta de Seguridad" required><br>
				<input class="campos" id="respuesta" name="respuesta" type="text" size="40" placeholder="Escriba una Respuesta de Seguridad" required><br>
				--><input type="hidden" id="evento" name="evento" value="nuevo" />
				<input class="boton" id="boton" type="submit" name="enviar" value="Enviar"/>
				<input type="reset" id="btn_limpiar" name="btn_limpiar" value="Limpiar" style="display:none;" />
				
			</form>
		
		<div class="salir">
			<button class="salida" onclick=location="index.php">Salir</button>
		</div>
			</center>
			
		</div>

		<div id='pie'>
			<?php require ('includes/pie.php');?>
		</div>
	</div>

	

