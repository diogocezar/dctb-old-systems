/**
* F I L T R E D   R E G I S T E R S
*/

/**
* call_getFiltredRegisters();
*/
function call_getFiltredRegisters(inicio, event){
	var filtra = false;
	if(inicio){
		filtra = true;
	}
	try{
		var whichCode = (window.Event) ? event.which : event.keyCode;
		if (whichCode == 13){
			filtra = true;
		}
	}
	catch(ex){}
	
	if(filtra){
	addContDiv(idDetalhes, "&nbsp;CLIQUE EM UM REGISTRO PARAR VISUALIZAR SEUS DETALHES.");
	var digitado = url_encode(document.getElementById('digitado').value);
	x_getFiltredRegisters(digitado, tabela, campo, return_getFiltredRegisters);
	addContDiv(idItens, '<img src="../images/loadingAnimation.gif"> Aguarde, carregando...');
	}
}

function return_getFiltredRegisters(retorno){
	addContDiv(idItens, url_decode(retorno));
}

/**
* call_getFiltredRegistersPessoa();
*/
function call_getFiltredRegistersPessoa(inicio, event){
	var filtra = false;
	if(inicio){
		filtra = true;
	}
	try{
		var whichCode = (window.Event) ? event.which : event.keyCode;
		if (whichCode == 13){
			filtra = true;
		}
	}
	catch(ex){}
	
	if(filtra){
	addContDiv(idDetalhes, "&nbsp;CLIQUE EM UM REGISTRO PARAR VISUALIZAR SEUS DETALHES.");
	var digitado = url_encode(document.getElementById('digitado').value);
	x_getFiltredRegistersPessoa(digitado, tabela, campo, return_getFiltredRegistersPessoa);
	addContDiv(idItens, '<img src="../images/loadingAnimation.gif"> Aguarde, carregando...');
	}	
}

function return_getFiltredRegistersPessoa(retorno){
	addContDiv(idItens, url_decode(retorno));
}

/**
* call_getFiltredRegistersColeta();
*/
function call_getFiltredRegistersColeta(inicio, event){
	var filtra = false;
	if(inicio){
		filtra = true;
	}
	try{
		var whichCode = (window.Event) ? event.which : event.keyCode;
		if (whichCode == 13){
			filtra = true;
		}
	}
	catch(ex){}
	
	if(filtra){
	addContDiv(idDetalhes, "&nbsp;CLIQUE EM UM REGISTRO PARAR VISUALIZAR SEUS DETALHES.");
	var digitado = url_encode(document.getElementById('digitado').value);
	x_getFiltredRegistersColeta(digitado, tabela, campo, return_getFiltredRegistersColeta);
	addContDiv(idItens, '<img src="../images/loadingAnimation.gif"> Aguarde, carregando...');
	}	
}

function return_getFiltredRegistersColeta(retorno){
	addContDiv(idItens, url_decode(retorno));
}

/**
* call_getFiltredRegistersColetaCliente();
*/
function call_getFiltredRegistersColetaCliente(inicio, event){
	var filtra = false;
	if(inicio){
		filtra = true;
	}
	try{
		var whichCode = (window.Event) ? event.which : event.keyCode;
		/* debug ie */
		if (whichCode == 13 || event.keyCode == 13){
			filtra = true;
		}
	}
	catch(ex){}
	
	if(filtra){
	addContDiv(idDetalhes, "&nbsp;CLIQUE EM UM REGISTRO PARAR VISUALIZAR SEUS DETALHES.");
	var digitado = url_encode(document.getElementById('digitado').value);
	x_getFiltredRegistersColetaCliente(digitado, tabela, campo, return_getFiltredRegistersColetaCliente);
	addContDiv(idItens, 'Aguarde, carregando...');
	}	
}

function return_getFiltredRegistersColetaCliente(retorno){
	addContDiv(idItens, url_decode(retorno));
}

/**
* call_getFiltredRegistersContato();
*/
function call_getFiltredRegistersContato(inicio, event){
	var filtra = false;
	if(inicio){
		filtra = true;
	}
	try{
		var whichCode = (window.Event) ? event.which : event.keyCode;
		/* debug ie */
		if (whichCode == 13 || event.keyCode == 13){
			filtra = true;
		}
	}
	catch(ex){}
	
	if(filtra){
	addContDiv(idDetalhes, "&nbsp;CLIQUE EM UM REGISTRO PARAR VISUALIZAR SEUS DETALHES.");
	var digitado = url_encode(document.getElementById('digitado').value);
	x_getFiltredRegistersContato(digitado, tabela, campo, return_getFiltredRegistersContato);
	addContDiv(idItens, 'Aguarde, carregando...');
	}	
}

function return_getFiltredRegistersContato(retorno){
	addContDiv(idItens, url_decode(retorno));
}

/**
* call_getFiltredRegistersConhecimento();
*/
function call_getFiltredRegistersConhecimento(inicio, event){
	var filtra = false;
	if(inicio){
		filtra = true;
	}
	try{
		var whichCode = (window.Event) ? event.which : event.keyCode;
		/* debug ie */
		if (whichCode == 13 || event.keyCode == 13){
			filtra = true;
		}
	}
	catch(ex){}
	
	if(filtra){
	addContDiv(idDetalhes, "&nbsp;CLIQUE EM UM REGISTRO PARAR VISUALIZAR SEUS DETALHES.");
	var digitado = url_encode(document.getElementById('digitado').value);
	x_getFiltredRegistersConhecimento(digitado, tabela, campo, return_getFiltredRegistersConhecimento);
	addContDiv(idItens, 'Aguarde, carregando...');
	}	
}

function return_getFiltredRegistersConhecimento(retorno){
	addContDiv(idItens, url_decode(retorno));
}

/**
* call_getFiltredRegistersManifesto();
*/
function call_getFiltredRegistersManifesto(inicio, event){
	var filtra = false;
	if(inicio){
		filtra = true;
	}
	try{
		var whichCode = (window.Event) ? event.which : event.keyCode;
		/* debug ie */
		if (whichCode == 13 || event.keyCode == 13){
			filtra = true;
		}
	}
	catch(ex){}
	
	if(filtra){
	addContDiv(idDetalhes, "&nbsp;CLIQUE EM UM REGISTRO PARAR VISUALIZAR SEUS DETALHES.");
	var digitado = url_encode(document.getElementById('digitado').value);
	x_getFiltredRegistersManifesto(digitado, tabela, campo, return_getFiltredRegistersManifesto);
	addContDiv(idItens, 'Aguarde, carregando...');
	}	
}

function return_getFiltredRegistersManifesto(retorno){
	addContDiv(idItens, url_decode(retorno));
}


/**
* R E G I S T E R  D E T A I S
*/


/**
* call_registerDetais(key);
*/
function call_registerDetais(key){
	x_registerDetais(key, tabela, return_registerDetais);
}

function return_registerDetais(retorno){
	addContDiv(idDetalhes, url_decode(retorno));
	//new Ajax.InPlaceEditor('id_titulo_detalhe_valor', 'teste.php');
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
* call_registerDetaisColeta(key);
*/
function call_registerDetaisColeta(key, versao){
	x_registerDetaisColeta(key, versao, tabela, return_registerDetaisColeta);
}

function return_registerDetaisColeta(retorno){
	addContDiv(idDetalhes, url_decode(retorno));
}

/**
* call_registerDetaisColetaCliente(key);
*/
function call_registerDetaisColetaCliente(key, versao){
	x_registerDetaisColetaCliente(key, versao, tabela, return_registerDetaisColetaCliente);
}

function return_registerDetaisColetaCliente(retorno){
	addContDiv(idDetalhes, url_decode(retorno));
}

/**
* call_registerDetaisConhecimento(key);
*/
function call_registerDetaisConhecimento(key){
	x_registerDetaisConhecimento(key, tabela, return_registerDetaisConhecimento);
}

function return_registerDetaisConhecimento(retorno){
	addContDiv(idDetalhes, url_decode(retorno));
}

/**
* call_registerDetaisManifesto(key);
*/
function call_registerDetaisManifesto(key){
	x_registerDetaisManifesto(key, tabela, return_registerDetaisManifesto);
}

function return_registerDetaisManifesto(retorno){
	addContDiv(idDetalhes, url_decode(retorno));
}

/**
* D E L E T E  R E G I S T E R
*/

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
	Effect.SwitchOff('id_item_'+retorno);
	setTimeout("call_getFiltredRegisters(true, event);", 1000);
	//call_getFiltredRegisters();
}

function reloadTime(){
	setTimeout("window.location.reload();", 1000);	
}

/**
* call_deleteRegisterPessoa(key);
*/
function call_deleteRegisterPessoa(key, tabela){
	var vDeleteRegister = confirm("Deseja realmente excluir o registro?");
	if(vDeleteRegister){
		x_deleteRegisterPessoa(key, tabela, return_deleteRegisterPessoa);
	}
}

function return_deleteRegisterPessoa(retorno){
	Effect.SwitchOff('id_item_'+retorno);
	setTimeout("call_getFiltredRegistersPessoa(true, event);", 1000);
}

/**
* call_deleteRegisterColeta(key);
*/
function call_deleteRegisterColeta(key, tabela){
	var vDeleteRegister = confirm("Deseja realmente excluir o registro?");
	if(vDeleteRegister){
		x_deleteRegisterColeta(key, tabela, return_deleteRegisterColeta);
	}
}

function return_deleteRegisterColeta(retorno){
	Effect.SwitchOff('id_item_'+retorno);
	setTimeout("call_getFiltredRegistersColeta(true, event);", 1000);
}

/**
* call_deleteRegisterConhecimento(key);
*/
function call_deleteRegisterConhecimento(key){
	var vDeleteRegister = confirm("Deseja realmente excluir o registro?");
	if(vDeleteRegister){
		x_deleteRegisterConhecimento(key, tabela, return_deleteRegisterConhecimento);
	}
}

function return_deleteRegisterConhecimento(retorno){
	Effect.SwitchOff('id_item_'+retorno);
	setTimeout("call_getFiltredRegistersConhecimento(true, event);", 1000);
}

/**
* call_deleteRegisterManifesto(key);
*/
function call_deleteRegisterManifesto(key){
	var vDeleteRegister = confirm("Deseja realmente excluir o registro?");
	if(vDeleteRegister){
		x_deleteRegisterConhecimento(key, tabela, return_deleteRegisterManifesto);
	}
}

function return_deleteRegisterManifesto(retorno){
	Effect.SwitchOff('id_item_'+retorno);
	setTimeout("call_getFiltredRegistersManifesto(true, event);", 1000);
}