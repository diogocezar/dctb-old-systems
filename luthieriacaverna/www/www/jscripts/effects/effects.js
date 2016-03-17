function onOriRelacionada(){
	hideDiv(idBoxOpcoesCO);
	showDiv(idBoxOpcoesCOO);
}

function offOriRelacionada(){
	hideDiv(idBoxOpcoesCOO);
	showDiv(idBoxOpcoesCO);
}

/**
* Fun��o para adicionar um conte�do em uma div.
*/
function addContDiv(id, conteudo){
	div = document.getElementById(id);
	div.innerHTML = conteudo;
}


/**
* Fun��o que esconde um div com determinada id.
*/
function hideDiv(id){
	div = document.getElementById(id);
	//document.getElementById(id).style.border = '';
	div.style.visibility = 'hidden';
	div.style.display = 'none';
	
}

/**
* Fun��o que mostra um div com determinada id.
*/
function showDiv(id){
	div = document.getElementById(id);
	div.style.visibility = 'visible';
	div.style.display = '';
	
}

/**
* Fun��o que esconde os elementos para efeito de loading.
*/
function hide(){
	hideDiv(idContainer);
	showDiv(idLoading);
	//hideDoc();
}

/**
* Fun��o que mostra os elementos e esconde o loading.
*/
function show(){
	showDiv(idContainer);
	hideDiv(idLoading);
	//showDoc();
}

/**
* Fun��o que esconde tudo o que � mostrado no frame filho.
*/
function hideDoc(){
	//var objIframe = parent.frames[1];
	//objIframe.document.body.style.display = 'none';
}

/**
* Fun��o que mostra tudo o que � mostrado no frame filho.
*/
function showDoc(doc){
	//var objIframe = parent.frames[1];
	//objIframe.document.body.style.display = '';
}