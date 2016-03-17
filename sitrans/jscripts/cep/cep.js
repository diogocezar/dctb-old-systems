/**
* Script que retorna informações de endereço a partir de um cep informado
* Para habilitar a validação em um input, deve-se alterar seu id para "get_cep"
* nome do input cep: "*_getCep";
*
*/

var Cep = {
	/* Armazena o cep */
	cep: '',
	/* Armazena o tipo do logradouro. Ex.: Rua, Avenida, etc... */
	tipo: '',
	/* Armazena o nome correspondente a ao tipo. */
	nome_tipo: '',
	/* Armazena o bairro */
	bairro: '',
	/* Armazena a localidade */
	localidade: '',
	/* Armazena a uf */
	uf: '',
	
	/* Inputs que receberão os dados : */
	id_input_rua:'',
	id_input_bairro:'',
	id_input_cidade:'',
	id_input_estado:'',
	
	/* Inputs que receberão os dados para um cep alternativo : */
	id_input_rua_alt:'',
	id_input_bairro_alt:'',
	id_input_cidade_alt:'',
	id_input_estado_alt:'',
	
	init: function(){
		if(jQuery("#get_cep")){
			jQuery("#get_cep").blur(Cep.getCep);
			jQuery("#get_cep_alt").blur(Cep.getCepAlt);
		}
	},
	
	getCep: function(){
		Cep.cep = jQuery("#get_cep").attr('value');
		Cep.lockFields();
		x_getCep(Cep.cep, Cep.callback_getCep);
	},
	
	getCepAlt: function(){
		Cep.cep = jQuery("#get_cep_alt").attr('value');
		Cep.lockFieldsAlt();
		x_getCep(Cep.cep, Cep.callback_getCepAlt);
	},	
	
	callback_getCep: function(data){
		Cep.unLockFields();
		Cep.cep = jQuery("#get_cep").val(url_decode(data['cep']));
		jQuery(Cep.id_input_rua).val(url_decode(data['tipo'])+' '+url_decode(data['nome_tipo']));
		jQuery(Cep.id_input_bairro).val(url_decode(data['bairro']));
		jQuery(Cep.id_input_cidade).val(url_decode(data['localidade']));
		jQuery(Cep.id_input_estado).selectOptions(url_decode(data['uf']));
		
	},
	
	callback_getCepAlt: function(data){
		Cep.unLockFieldsAlt();
		Cep.cep = jQuery("#get_cep_alt").val(url_decode(data['cep']));
		jQuery(Cep.id_input_rua_alt).val(url_decode(data['tipo'])+' '+url_decode(data['nome_tipo']));
		jQuery(Cep.id_input_bairro_alt).val(url_decode(data['bairro']));
		jQuery(Cep.id_input_cidade_alt).val(url_decode(data['localidade']));
		jQuery(Cep.id_input_estado_alt).selectOptions(url_decode(data['uf']));
		
	},	
	
	lockFields: function(){
		jQuery("#get_cep").val('carregando...');
		jQuery(Cep.id_input_rua).val('carregando...');
		jQuery(Cep.id_input_bairro).val('carregando...');
		jQuery(Cep.id_input_cidade).val('carregando...');
		jQuery("#get_cep").attr("disabled", true);
		jQuery(Cep.id_input_rua).attr("disabled", true);
		jQuery(Cep.id_input_bairro).attr("disabled", true);
		jQuery(Cep.id_input_cidade).attr("disabled", true);
		jQuery(Cep.id_input_estado).attr("disabled", true);
	},
	
	lockFieldsAlt: function(){
		jQuery("#get_cep_alt").val('carregando...');
		jQuery(Cep.id_input_rua_alt).val('carregando...');
		jQuery(Cep.id_input_bairro_alt).val('carregando...');
		jQuery(Cep.id_input_cidade_alt).val('carregando...');
		jQuery("#get_cep_alt").attr("disabled", true);
		jQuery(Cep.id_input_rua_alt).attr("disabled", true);
		jQuery(Cep.id_input_bairro_alt).attr("disabled", true);
		jQuery(Cep.id_input_cidade_alt).attr("disabled", true);
		jQuery(Cep.id_input_estado_alt).attr("disabled", true);
	},
	
	unLockFields: function(){
		jQuery("#get_cep").removeAttr("disabled"); 
		jQuery(Cep.id_input_rua).removeAttr("disabled"); 
		jQuery(Cep.id_input_bairro).removeAttr("disabled"); 
		jQuery(Cep.id_input_cidade).removeAttr("disabled"); 
		jQuery(Cep.id_input_estado).removeAttr("disabled"); 
	},
	
	unLockFieldsAlt: function(){
		jQuery("#get_cep_alt").removeAttr("disabled"); 
		jQuery(Cep.id_input_rua_alt).removeAttr("disabled"); 
		jQuery(Cep.id_input_bairro_alt).removeAttr("disabled"); 
		jQuery(Cep.id_input_cidade_alt).removeAttr("disabled"); 
		jQuery(Cep.id_input_estado_alt).removeAttr("disabled"); 
	}	
}
jQuery(document).ready(function(){
	Cep.init();
});