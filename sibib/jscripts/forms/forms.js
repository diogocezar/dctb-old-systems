/**
* Adicionar acervo na lista de acervos 
*/

var Acervos = {
	
	init: function(option){
		if(jQuery("#add_acervo")) jQuery("#add_acervo").click(Acervos.addAcervo);
		if(jQuery("#del_acervo")) jQuery("#del_acervo").click(Acervos.delAcervo);
	},
	
	addAcervo: function(){
		opcao = document.getElementById("frm_opt_acervos");
		lista = document.getElementById("frm_lst_lista_acervos");
		achou = false;
		
		/* Procura pelo elemento */
		for(i=0; i<lista.length; i++){
			if(lista.item(i).value == opcao.value){
				achou = true;
			}
		}
		
		if(achou == false){	
			var obj = document.createElement("OPTION");
			var val = opcao.item(opcao.selectedIndex).value;
			var txt = opcao.item(opcao.selectedIndex).text;
			obj.value = val;
			obj.text = txt;
			try {
				lista.add(obj, null);
			}
			catch(ex) {
				lista.add(obj); // IE only
			}
		}
	},
	
	delAcervo: function(){
		lista = document.getElementById('frm_lst_lista_acervos');
		if(lista.selectedIndex > -1){
			lista.remove(lista.selectedIndex);
		}
		else{
			alert("Selecione uma opção para ser removida.");
		}
	},
	
	selectAll: function(){
		lista = document.getElementById('frm_lst_lista_acervos');
		for(i=0; i< lista.length; i++){
			lista.item(i).selected = true;
		}	
	}
}

jQuery(document).ready(function(){
	Acervos.init();
});