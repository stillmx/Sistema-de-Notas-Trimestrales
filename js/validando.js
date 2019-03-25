$( document ).ready(function() {
	
	$("#f_registro").validate({
 		rules: {cedula: {required: true},nombre: {required: true},usuario: {required: true, minlength: 2},telf: {minlength: 2, maxlength: 15},email: {required:true, email: true}},
        messages: {cedula: {required:"Debe introducir un numero C.I. válido"}, nombre: {required:"introducir un nombre válido"},
	    usuario: {required:"Debe introducir un nombre de usuario."},telf: {minlegth:"El numero debe tener mas de 1 caracteres.", maxlegth:""},email: {required:"Email es obligatorio", email:"Debe introducir un email válido."} },
		sumitHandler: function(form){
	        $.ajax("registrar.php", {
				type:'POST', dataType:'json', data:$("#f_registro").serialize(),
				beforeSend:function(){
					$(":text, :submit", $("#f_registro")).attr({disabled: "disabled"});
				},
				success:function(d, t, jxhr){
					$(":text, :submit", $("#f_registro")).val()!="";
					alert("lleno");
					if(d.success && (d.affected_rows==1 || d.num_rows==1))
						alert(d.mensaje);
				$(":reset", $("#f_registro")).trigger("click");
				}
			});
        }
      });
});