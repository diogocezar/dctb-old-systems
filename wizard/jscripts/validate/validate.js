/**
* Script que valida todos os campos de um form.
* Para habilitar a valida��o em um form, deve-se alterar
* a sua classe para: 'checkForm'.
* Dentro do formul�rio, os objetos que tiverem como prefixo do id:
* 'frm_obg' -> N�o podem ficar em branco;
* 'frm_ema' -> Se se n�o vazio, faz a valida��o de e-mail;
*/

var Validate = {
	
	error: false,

	init: function(){
		if($("#enviar")) $("#enviar").click(Validate.validateFields);
	},
	
	voltar: function(){
		history.go(-1);
	},
	
	msg: function(msg, campo){
		alert(msg);
		campo.focus();
		Validate.error = true;
	},
	
	msgEmptyField: function(campo){
		alert("O campo '" + campo.name.toUpperCase() + "' est� vazio.");
		campo.focus();
		Validate.error = true;
	},
		
	validateField: function(campo){
		if(campo.value == ""){
			Validate.msgEmptyField(campo);
		}
	},
	
	validateFieldEmail: function(campo){
		if(campo.value != ""){
			if(campo.value.indexOf('@') == -1 || campo.value.indexOf('.') == -1){
				Validate.msg('O e-mail digitado n�o � valido.', campo);
			}
		}
	},
	
	validateFields: function(){
		 Validate.error = false;
		 var prefixoId;
		 $(document).find("form").each(function(){
			 if($(this).attr("className") == "checkForm"){
				 $(this).find("input, textarea, select").each(function(){
					if($(this).attr("type") != 'submit'){
						prefixoId = $(this).attr("id").substring(0,7).toLowerCase();
						switch(prefixoId){
							case "frm_obg":
								Validate.validateField(this);	
							break;
							
							case "frm_ema":
								Validate.validateFieldEmail(this);	
							break;
						}
					}
				})
				if(!Validate.error){
					$(this).submit();	
				}
			}
		})
	}
}

$(function(){
	Validate.init();
});