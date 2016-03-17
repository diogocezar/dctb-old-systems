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
	addContDiv(idDetalhes, "&nbsp;PASSE O MOUSE EM UM REGISTRO PARAR VISUALIZAR SEUS DETALHES.");
	var digitado = url_encode(document.getElementById('digitado').value);
	x_getFiltredRegisters(digitado, tabela, campo, return_getFiltredRegisters);
	addContDiv(idItens, '<img src="../images/loadingAnimation.gif"> Aguarde, carregando...');
	}
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
	//new Ajax.InPlaceEditor('id_titulo_detalhe_valor', 'teste.php');
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
	Effect.SwitchOff('id_item_'+retorno);
	setTimeout("call_getFiltredRegisters(true, event);", 1000);
	//call_getFiltredRegisters();
}