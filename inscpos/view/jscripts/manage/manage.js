var Manage = {
	
	init: function(){
		Manage.call_getFiltredRegisters(true);
		if(jQuery('#typed')){
			jQuery('#typed').focus();
			jQuery('#typed').keypress(function(e){Manage.call_getFiltredRegisters(false, e)});
		}
	},
	
	call_getFiltredRegisters: function(start, e){
		var filter = false;
		if(start){
			filter = true;
		}
		try{
			var whichCode = (window.Event) ? e.which : e.keyCode;
			if (whichCode == 13){
				filter = true;
			}
		}
		catch(ex){}
		
		if(filter){
			jQuery('#manage_detail').html("&nbsp;CLIQUE EM UM REGISTRO PARAR VISUALIZAR SEUS DETALHES.");
			var typed = url_encode(jQuery('#typed').attr('value'));
			x_getFiltredRegisters(typed, table, fields, hided, Manage.return_getFiltredRegisters);
			jQuery('#manage_items').html("<img src=\"../view/images/loadingAnimation.gif\"> Aguarde, carregando...");
		}
	},

	return_getFiltredRegisters: function(data){
		jQuery('#manage_items').hide();
		jQuery('#manage_items').html(url_decode(data));
		jQuery('#manage_items').fadeIn();
	},
	
	call_registerDetais: function(key){
		x_registerDetais(key, table, Manage.return_registerDetais);
	},
	
	return_registerDetais: function(data){
		jQuery('#manage_detail').html(url_decode(data));		
	},
	
	call_deleteRegister: function(key){
		var vDeleteRegister = confirm("Deseja realmente excluir o registro?");
		if(vDeleteRegister){
			x_deleteRegister(table, key, Manage.return_deleteRegister);
		}
	},
	
	return_deleteRegister: function(data){
		jQuery('#manage_items_'+data).fadeOut();
		setTimeout("Manage.call_getFiltredRegisters(true);", 1000);
	},
	
	call_desactiveRegister: function(key){
		var vDesactiveRegister = confirm("Deseja realmente desativar o curso?");
		if(vDesactiveRegister){
			x_desactiveRegister(key, Manage.return_desactiveRegister);
		}		
	},
	
	return_desactiveRegister: function(data){
		jQuery('#manage_items_'+data).fadeOut();
		setTimeout("Manage.call_getFiltredRegisters(true);", 1000);		
	},
	
	call_activeRegister: function(key){
		x_activeRegister(key, Manage.return_activeRegister);		
	},
	
	return_activeRegister: function(data){
		jQuery('#manage_items_'+data).fadeOut();
		setTimeout("Manage.call_getFiltredRegisters(true);", 1000);		
	}
}

jQuery(document).ready(function(){
	Manage.init();
});