/**
* Script que valida todos os campos de um form.
* Para habilitar a validação em um form, deve-se alterar
* a sua classe para: 'checkForm'.
* Dentro do formulário, os objQueryetos que tiverem como prefixo do id:
* 'frm_obg' -> Não podem ficar em branco;
* 'frm_ema' -> Se se não vazio, faz a validação de e-mail;
*/

var Validate = {
	
	error: false,
	
	msgErrorr: '',
	
	fieldFocus:'',
	
	firstCheck: 0,

	init: function(){
		if(jQuery("#send_button")) jQuery("#send_button").click(Validate.validateFields);
		if(jQuery("#back_button")) jQuery("#back_button").click(Validate.goBack);
	},
	
	initAlerts: function(){
		Validate.msgError = '';
		Validate.firstCheck = 0;
		Validate.fieldFocus = '';
	},
	
	goBack: function(){
		history.go(-1);
	},
	
	msg: function(msg, field){
		alert(msg);
		field.focus();
		Validate.error = true;
	},
	
	msgEmptyField: function(field){
		var nameCmp = field.name.toUpperCase().replace("[]", "");
		Validate.msgError += "O campo '" + nameCmp + "' está vazio. \n";
		if(Validate.firstCheck == 0){
			Validate.firstCheck++;
			Validate.fieldFocus = field;
		}
		field.focus();
		Validate.error = true;
	},
	
	validateCombos: function(){
		if(jQuery("#frm_opt_fornecedor").attr("disabled") && jQuery("#frm_opt_cliente").attr("disabled") && jQuery("#frm_opt_agregado").attr("disabled")){
			alert('Selecione uma pessoa para cadastrar um contato.');
			Validate.error = true;
		}	
	},
	
	validateField: function(field){
		if(field.value == "" || field.value == "NULL"){
			Validate.msgEmptyField(field);
		}
	},
	
	validateFieldEmail: function(field){
		if(field.value != ""){
			if(field.value.indexOf('@') == -1 || field.value.indexOf('.') == -1){
				Validate.msg('O e-mail digitado não é valido.', field);
			}
		}
	},
	
	validateFields: function(){
		 Validate.error = false;
		 var prefixoId;
		 jQuery(document).find("form").each(function(){
			 if(jQuery(this).attr("className") == "checkForm"){
				 jQuery(this).find("input, textarea, select").each(function(){
					if(jQuery(this).attr("type") != 'submit'){
						prefix_id = jQuery(this).attr("id").substring(0,7).toLowerCase();
						switch(prefix_id){
							case "frm_obg":
								Validate.validateField(this);	
							break;
							
							case "frm_ema":
								Validate.validateFieldEmail(this);	
							break;
							
							case "frm_lst":
								Validate.validateField(this);
							break;
						}
					}
				})
				Validate.validateCombos();
				if(!Validate.error){
					jQuery(this).submit();	
				}
				else{
					alert(Validate.msgError);
					Validate.fieldFocus.focus();
					Validate.initAlerts();
				}
			}
		})
	}
}

jQuery(document).ready(function(){
	Validate.init();
});