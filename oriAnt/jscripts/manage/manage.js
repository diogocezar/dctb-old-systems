/**
* call_getFiltredRegisters();
*/
function call_getFiltredRegisters(){
	addContDiv(idDetalhes, "&nbsp;PASSE O MOUSE EM UM REGISTRO PARAR VIZUALIAR SEUS DETALHES.");
	var digitado = url_encode(document.getElementById('digitado').value);
	x_getFiltredRegisters(digitado, tabela, campo, return_getFiltredRegisters);
}

function return_getFiltredRegisters(retorno){
	addContDiv(idItens, url_decode(retorno));
}

/**
* call_registerDetais(key);
*/
function call_registerDetais(key){
	x_registerDetais(key, tabela, return_registerDetais);
}

function return_registerDetais(retorno){
	addContDiv(idDetalhes, url_decode(retorno));
}

/**
* call_x_deleteRegister(key);
*/
function call_deleteRegister(key){
	var vDeleteRegister = confirm("Deseja realmente excluir o registro?");
	if(vDeleteRegister){
		x_deleteRegister(tabela, key, return_deleteRegister);
	}
}

function return_deleteRegister(retorno){
	call_getFiltredRegisters();
}
