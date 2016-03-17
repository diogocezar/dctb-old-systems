function clickRadio(radioObj, newValue){
	if(!radioObj)
		return;
	var radioLength = radioObj.length;
	if(radioLength == undefined) {
		radioObj.checked = (radioObj.value == newValue.toString());
		return;
	}
	for(var i = 0; i < radioLength; i++) {
		radioObj[i].checked = false;
		if(radioObj[i].value == newValue.toString()) {
			radioObj[i].checked = true;
		}
	}
	if(newValue != 'pessoa_fisica'){
		makeDisable('comboPessoaFisica');
		makeEnable ('comboPessoaJuridica');
	}
	else{
		makeEnable ('comboPessoaFisica');
		makeDisable('comboPessoaJuridica');
	}
}

function makeDisable(op){
    var x=document.getElementById(op)
    x.disabled=true
}
function makeEnable(op){
    var x=document.getElementById(op)
    x.disabled=false
}

function clickGerar(numeroparcelas, valortotal, periodicidade, primeirovencimento, form){
	var erro = false;
	
	if(numeroparcelas.value == ""){
		alert(retornaString('número de parcelas'));
		setaFoco(numeroparcelas);
		erro = true;
	}
	if(valortotal.value == ""){
		alert(retornaString('valor total'));
		setaFoco(valortotal);
		erro = true;
	}
	if(primeirovencimento.value == ""){
		alert(retornaString('primeiro vencimento'));
		setaFoco(primeirovencimento);
		erro = true;
	}
	
	if(erro == false){
		call_getParcelas(numeroparcelas.value, valortotal.value, periodicidade.value, primeirovencimento.value);
		form.action = form.action + '&gerar=sim';
	}
	else{
		gerouParcelas = false;
	}
}

/**
* A J A X
*/

/**
* call_getParcelas();
*/
function call_getParcelas(numeroparcelas, valortotal, periodicidade, primeirovencimento){
	numeroparcelas      = url_encode(numeroparcelas);
	valortotal          = url_encode(valortotal);
	periodicidade       = url_encode(periodicidade);
	primeirovencimento  = url_encode(primeirovencimento);
	
	x_getParcelas(numeroparcelas, valortotal, periodicidade, primeirovencimento, return_getParcelas);
}

function return_getParcelas(retorno){
	addContDiv('formParcelas', url_decode(retorno));
	gerouParcelas = true;
}

/**
* call_getParcelasDB();
*/
function call_getParcelasFromDB(conta){
	conta = url_encode(conta);
	x_getParcelasFromDB(conta, return_getParcelasFromDB);
}

function return_getParcelasFromDB(retorno){
	addContDiv('formParcelas', url_decode(retorno));
	gerouParcelas = true;
}

/**
* call_getParcelasDBByDate();
*/
function call_getParcelasFromDBByDate(data){
	data  = url_encode(data);
	x_getParcelasFromDBByDate(data, return_getParcelasFromDBByDate);
}

function return_getParcelasFromDBByDate(retorno){
	addContDiv('container', url_decode(retorno));
}

/**
* call_pagarParcela();
*/
function call_pagarParcela(parcela, conta){
	parcela = url_encode(parcela);
	conta   = url_encode(conta);
	x_pagarParcela(parcela, conta, return_pagarParcela);
}

function return_pagarParcela(retorno){
	call_getParcelasFromDB(url_decode(retorno));
}

/**
* call_pagarParcela();
*/
function call_pagarParcelaByDate(parcela, conta){
	parcela = url_encode(parcela);
	conta   = url_encode(conta);
	x_pagarParcela(parcela, conta, return_pagarParcelaByDate);
}

function return_pagarParcelaByDate(retorno){
	call_getParcelasFromDBByDate(url_decode(retorno));
}

