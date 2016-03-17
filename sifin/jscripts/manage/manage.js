/**
* call_getFiltredRegisters();
*/
function call_getFiltredRegisters(){
	addContDiv(idDetalhes, "&nbsp;PASSE O MOUSE EM UM REGISTRO PARAR VISUALIZAR SEUS DETALHES.");
	var digitado = url_encode(document.getElementById('digitado').value);
	x_getFiltredRegisters(digitado, tabela, campo, return_getFiltredRegisters);
}

function return_getFiltredRegisters(retorno){
	addContDiv(idItens, url_decode(retorno));
}

/**
* call_getFiltredRegistersPessoa();
*/
function call_getFiltredRegistersPessoa(){
	addContDiv(idDetalhes, "&nbsp;PASSE O MOUSE EM UM REGISTRO PARAR VISUALIZAR SEUS DETALHES.");
	var digitado = url_encode(document.getElementById('digitado').value);
	x_getFiltredRegistersPessoa(digitado, tabela, campo, return_getFiltredRegistersPessoa);
}

function return_getFiltredRegistersPessoa(retorno){
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
* call_registerDetaisPessoa(key);
*/
function call_registerDetaisPessoa(key){
	x_registerDetaisPessoa(key, tabela, return_registerDetaisPessoa);
}

function return_registerDetaisPessoa(retorno){
	addContDiv(idDetalhes, url_decode(retorno));
}

/**
* call_deleteRegister(key);
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

function reloadTime(){
	setTimeout("window.location.reload();", 1000);	
}

/**
* call_deleteRegisterPessoa(key);
*/
function call_deleteRegisterPessoa(key){
	var vDeleteRegister = confirm("Deseja realmente excluir o registro?");
	if(vDeleteRegister){
		x_deleteRegisterPessoa(key, return_deleteRegisterPessoa);
	}
}

function return_deleteRegisterPessoa(retorno){
	call_getFiltredRegistersPessoa();
}

function reloadTime(){
	setTimeout("window.location.reload();", 1000);	
}
