/*
	Feito por : Diogo Cezar Teixeira Batista

	Biblioteca.js
	Conjunto de funções para adicionar ou remover ítens em uma listbox
*/

/*
 * Adiciona uma opção à lista
 */
function adicionaLista(opcao, lista){	
	opcao = document.getElementById(opcao);
	lista = document.getElementById(lista);
	achou = false;
	
	if(opcao.value == ""){
		alert('O campo digitado está vazio.');
		acho = true;
	}
	
	/* Procura pelo elemento */
	for(i=0; i<lista.length; i++){
		if(lista.item(i).value == opcao.value){
			achou = true;
		}
	}
	
	if(achou == false){	
		var obj = document.createElement("OPTION");
		var val = opcao.value;
		var txt = opcao.value;
		obj.value = val;
		obj.text  = txt;
		//lista.add(obj);
		try {
        	lista.add(obj, null);
    	}
    	catch(ex) {
      		lista.add(obj); // IE only
    	}
	}
	opcao.value = "";
}

/*
 * Remove uma opção da lista
 */
function retiraLista(lista){
	lista = document.getElementById(lista);
	if(lista.selectedIndex > -1){
		lista.remove(lista.selectedIndex);
	}
	else{
		alert("Seleciona uma opção para ser removida");
	}
}

/*
 * Seleciona todos os elementos da lista
 */
function selecionaTodosLista(lista){
	lista = document.getElementById(lista);
	for(i=0; i< lista.length; i++){
		lista.item(i).selected = true;
	}
}

/*
 * Desmarca todos os elementos da lista
 */
function desmarcaTodosLista(lista){
	lista = document.getElementById(lista);
	for(i=0; i< lista.length; i++){
		lista.item(i).selected = false;
	}
}